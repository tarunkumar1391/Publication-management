<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ikp";
//define variables
$lname = $fname = $betreuer = $enddate = $typofwork = $foerderung = $tp = $title = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO publications (fname, lname, betreuer, enddate, typofwork, foerderung, tp, title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $lname, $fname, $betreuer, $enddate, $typofwork, $foerderung, $tp, $title);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// set parameters and execute
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $lname = isset($_POST['lname']) ? $_POST['lname'] : "0";
    $fname = isset($_POST['fname']) ? $_POST['fname'] : "0";
    $betreuer = isset($_POST['betreuer']) ? $_POST['betreuer'] : "0";
    $enddate = isset($_POST['enddate']) ? $_POST['enddate'] : "0";
    $typofwork = isset($_POST['typofwork']) ? $_POST['typofwork'] : "0";
    $foerderung = isset($_POST['foerderung']) ? $_POST['foerderung'] : "0";
    $tp = isset($_POST['tp']) ? $_POST['tp'] : "0";
    $title = isset($_POST['title']) ? $_POST['title'] : "0";



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