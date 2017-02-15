<?php
/**
 * Created by PhpStorm.
 * User: tkumar
 * Date: 9/5/16
 * Time: 2:10 PM
 */
if (isset($_POST['jobId'])) {

define('DB_NAME', 'ikp');
define('DB_USER', 'root');
define('DB_PASSWORD', 's4eTHE0801');
define('DB_HOST', 'localhost');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// escape the post data to prevent injection attacks
$jobid= mysqli_real_escape_string($conn, $_POST['jobId']);

$sql = "SELECT sno,jobId,fname,lname,typofwork,title,status,updateComments FROM `publications` WHERE `jobId` LIKE '$jobid'";
$result=mysqli_query($conn, $sql);
       // check if the query returned a result
    if (!$result) {
        echo '<html><head><link rel="stylesheet" href="../css/bootstrap.min.css">';
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
              <script src="../scripts/js/bootstrap.min.js"></script></html></head>';
        echo '<body><div class="container"><div class="page-header">
                <h3>IKP - Publication Tracking</h3>
            </div>
        <div class="container">';
        echo '<div class="alert alert-danger"><strong>Error! </strong>The tracking/Job id entered is invalid, Please try again with a valid id.
             </div>';
        echo "</div></div>";
        echo '<div class="container"> <a href="../trackjob.html">click here to return!!</a></div>';
        echo "</body></html>";
    } else{
        // result to output the table
        echo '<html><head><link rel="stylesheet" href="../css/bootstrap.min.css">';
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
              <script src="../scripts/js/bootstrap.min.js"></script></html></head>';
        echo '<body><div class="container"><div class="page-header">
                <h3>IKP - Publication Tracking</h3>
            </div>
        <div class="container">';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo "<tr>
          <th>job id</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Type of work</th>
          <th>Title</th>
          <th>status</th>
          <th>Comments</th>
          </tr>";
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            echo "<tr><td>";
            echo $row['jobId'];
            echo "</td><td>";
            echo $row['fname'];
            echo "</td><td>";
            echo $row['lname'];
            echo "</td><td>";
            echo $row['typofwork'];
            echo "</td><td>";
            echo $row['title'];
            echo "</td><td>";
            echo $row['status'];
            echo "</td><td>";
            echo $row['updateComments'];
            echo "</td></tr>";
        }
        echo "</div></table>";
        echo "<a href='../trackjob.html'>click here to track a new submission!!</a></div>";
        echo "</div></body></html>";
    }

    mysqli_close($conn);
} // end submitted

// not submitted to output the form

?>

