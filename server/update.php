<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$sno = $lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = $status= $jobid = $comments="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("UPDATE publications SET lname=?, fname=?,  betreuer=?, enddate=?, typofwork=?, foerderung=?, tp=?, title=? , status=?, Comments=? WHERE sno=?");
$stmt->bind_param("ssssssssssi", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title,$status,$comments,$sno);

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $sno = isset($_POST['sno']) ? input($_POST['sno']) : "0";
    $lname = isset($_POST['lname']) ? input($_POST['lname']) : "0";
    $fname = isset($_POST['fname']) ? input($_POST['fname']) : "0";
    $betreuer = isset($_POST['betreuer']) ? input($_POST['betreuer']) : "0";
    $enddate = isset($_POST['enddate']) ? input($_POST['enddate']) : "0";
    $typofwork = isset($_POST['typofwork']) ? input($_POST['typofwork']) : "0";
    $foerderung = isset($_POST['foerderung']) ? input($_POST['foerderung']) : "0";
    $tp = isset($_POST['tp']) ? input($_POST['tp']) : "0";
    $title = isset($_POST['title']) ? input($_POST['title']) : "0";
    $status = isset($_POST['status']) ? input($_POST['status']) : "0";
    $jobid = isset($_POST['jobid']) ? input($_POST['jobid']) : "0";
    $comments = isset($_POST['comments']) ? input($_POST['comments']) : "0";



}


if ($stmt->execute()) {

    echo "The entry ". $sno ." has been updated successfully!! ".'\n' ;
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