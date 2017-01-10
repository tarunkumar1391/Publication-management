<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
$path = "/srv/ikp_submissions/";
$destFilepath = "";
//define variables
$lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = $file =  $file_size = $file_type = $status= "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO publications (lname, fname, betreuer, enddate, typofwork, foerderung, tp, title, submission, fileSize, fileType,destFilepath, jobId, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssissss", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title, $file, $file_size, $file_type, $destFilepath, $jobid, $status);

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
        echo "This is the path for the file: $file : <b>$destFilepath</b> <br\>";
    } else {
         $destFilepath = $fullPath.$file;
         move_uploaded_file($file_loc,$destFilepath);
         echo "This is the path for the file: $file : <b>$destFilepath</b> <br\>";
     }

    $jobid = "IKP-PUB-" . uniqid();
    $status = "New";


}


if ($stmt->execute()) {
   echo "A new entry has been created successfully!! <br\>";
    echo "<h3>Kindly make a note of your job id: $jobid</h3>";

    echo '<a href="../www/index.html">click here to return!!</a>';
//    header("Location: ../www/index.html");
    
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