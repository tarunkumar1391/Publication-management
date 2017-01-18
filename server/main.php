<?php
require 'config.php';
require './phpmailer/PHPMailerAutoload.php';

$destFilepath = "";
//define variables
$lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = $email = $file =  $file_size = $file_type = $status=  $jobid ="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO publications (lname, fname, betreuer, enddate, typofwork, foerderung, tp, title, email, submission, fileSize, fileType,destFilepath, jobId, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssissss", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title,$email, $file, $file_size, $file_type, $destFilepath, $jobid, $status);

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $lname = isset($_POST['lname']) ? input($_POST['lname']) : "0";
    $fname = isset($_POST['fname']) ? input($_POST['fname']) : "0";
    $betreuer = isset($_POST['betreuer']) ? input($_POST['betreuer']) : "0";
    $enddate = isset($_POST['enddate']) ? input($_POST['enddate']) : "0";
    $typofwork = isset($_POST['typofwork']) ? input($_POST['typofwork']) : "0";
    $foerderung = isset($_POST['foerderung']) ? input($_POST['foerderung']) : "0";
    $tp = isset($_POST['tp']) ? input($_POST['tp']) : "0";
    $title = isset($_POST['title']) ? input($_POST['title']) : "0";
    $email = isset($_POST['email']) ? input($_POST['email']) : "0";
    $file = $_FILES['fileSubmission']['name'];
    $file_loc = $_FILES['fileSubmission']['tmp_name'];
    $file_size = $_FILES['fileSubmission']['size'];
    $file_type = $_FILES['fileSubmission']['type'];
//    $destination="uploads/".$file;
//    move_uploaded_file($file_loc, $destination );

    $year = date("Y");
    $worktype = $typofwork;
    $group = $foerderung;

//    if(!file_exists($path.$year)){
//        mkdir($path.$year,0777,true);
//
//        if(!file_exists($path.$year.'/'.$worktype)){
//            mkdir($path.$year.'/'.$worktype,0777,true);
//
//            if(!file_exists($path.$year.'/'.$worktype.'/'.$group)){
//                mkdir($path.$year.'/'.$worktype.'/'.$group,0777,true);
//                $destFilepath = $path.$year.'/'.$worktype.'/'.$group.'/'.$file;
//                move_uploaded_file($file_loc,$final_dest);
//                echo "This is the path for the file: $file : $destFilepath";
//
//            }
//        }
//
//    } else if(file_exists($path.$year)) {
//
//
//
//        if(file_exists($path.$year.'/'.$worktype)){
//
//            if(file_exists($path.$year.'/'.$worktype.'/'.$group)){
//
//                $destFilepath = $path.$year.'/'.$worktype.'/'.$group.'/'.$file;
//                move_uploaded_file($file_loc,$destFilepath);
//                echo "This is the path for the file: $file : $destFilepath";
//            }
//        }
//
//
//    }
    $fullPath = $path.$year.'/'.$worktype.'/'.$group.'/';

     if(!file_exists($fullPath)) {
         mkdir($fullPath,0777,true);
        $destFilepath = $fullPath.$file;
        move_uploaded_file($file_loc,$destFilepath);

    } else {
         $destFilepath = $fullPath.$file;
         move_uploaded_file($file_loc,$destFilepath);

     }

    $jobid = "IKP-PUB-" . uniqid();
    $status = "New";


}


if ($stmt->execute()) {
   echo "A new entry has been created successfully!! <br\>";
    echo "<h3>Kindly make a note of your job id: $jobid</h3>";
    echo '<a href="../www/index.html">click here to return!!</a>';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'linix.ikp.physik.tu-darmstadt.de';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'tramdas';                 // SMTP username
    $mail->Password = 'tarun_1391';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('tramdas@ikp.tu-darmstadt.de', 'Tarun Kumar');
    $mail->addAddress($email);

    $mail->Subject = 'IKP: Publication submission';
    $mail->Body    = 'Hello,
                        This is to confirm that we have received your submission. Your job id is <b>'. $jobid . '</b>. Use this 
                        job id to check the status of your submission in the link: ';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<h4>An email has been sent with your job id</h4>';
    }
    
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
}

//if( true === $stmt){
//    die('execute() failed: ' . htmlspecialchars($stmt->error));
//}
    //

//printf ("New records created successfully", $stmt->error);


$stmt->close();
$conn->close();
?>