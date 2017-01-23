<?php
require 'config.php';
require './phpmailer/PHPMailerAutoload.php';

$destFilepath = "";
//define variables
$lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = $email = $file =  $file_size = $file_type = $status=  $jobid = $comm="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO publications (lname, fname, betreuer, enddate, typofwork, foerderung, tp, title, email, submissionComments, submission, fileSize, fileType,destFilepath, jobId, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssissss", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title,$email, $comm, $file, $file_size, $file_type, $destFilepath, $jobid, $status);

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
    $comm = isset($_POST['comm']) ? input($_POST['comm']) : "0";
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

    echo '<html><head><link rel="stylesheet" href="../css/bootstrap.min.css">';
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
              <script src="../scripts/js/bootstrap.min.js"></script></html></head>';
    echo '<body><div class="container"><div class="page-header">
                <h3>IKP - Publication Management System</h3>
            </div>
        <div class="container-fluid">';
    echo '<div  class="well form-search form-horizontal"  >';
    echo '<div class="form-group">';
    echo '<label class="control-label col-md-8 col-lg-8" ><h4>Kindly make a note of your job id: '. $jobid .'</h4></label>';
    echo "</div></div>";
    echo '<div class="container-fluid"><a href="../www/trackjob.html">click here to make a new submission!!</a></div>';
    echo "</div></body></html>";

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
                        job id to check the status of your submission in the link: '.'Regards,IKP';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '<div class="container"><label>A confirmation email has been sent. In case of any discrepancy kindly contact us : haus-it@ikp.tu-darmstadt.de</label></div> ';
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