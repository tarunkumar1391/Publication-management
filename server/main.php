<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = $file =  $file_size = $file_type = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO publications (lname, fname, betreuer, enddate, typofwork, foerderung, tp, title, submission, fileSize, fileType) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 
                        ?, ?, ?)");
$stmt->bind_param("sssssssssis", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title, $file, $file_size, $file_type  );

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

    $file = rand(1000,100000)."-".$_FILES['fileSubmission']['name'];
    $file_loc = $_FILES['fileSubmission']['tmp_name'];
    $file_size = $_FILES['fileSubmission']['size'];
    $file_type = $_FILES['fileSubmission']['type'];
    $destination="uploads/".$file;
    move_uploaded_file($file_loc, $destination );


}


if ($stmt->execute()) {
   echo "A new entry has been created successfully!! ".'\n' ;
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