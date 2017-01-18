<?php
/**
 * Created by PhpStorm.
 * User: Haus-IT
 * Date: 7/6/2016
 * Time: 11:20 AM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "ikp");

$result = $conn->query("SELECT * FROM publications");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Sno":"'  . $rs["sno"] . '",';
    $outp .= '"lastName":"'  . $rs["lname"] . '",';
    $outp .= '"firstName":"'  . $rs["fname"] . '",';
    $outp .= '"Betreuer":"'   . $rs["betreuer"] . '",';
    $outp .= '"endDate":"'. $rs["enddate"] . '",';
    $outp .= '"typeofWork":"'. $rs["typofwork"] . '",';
    $outp .= '"Foerderung":"'. $rs["foerderung"] . '",';
    $outp .= '"Tp":"'. $rs["tp"] . '",';
    $outp .= '"Title":"'. $rs["title"] . '",';
    $outp .= '"Email":"'. $rs["email"] . '",';
    $outp .= '"file":"'. $rs["submission"] . '",';
    $outp .= '"jobId":"'. $rs["jobId"] . '",';
    $outp .= '"Comments":"'. $rs["Comments"] . '",';
    $outp .= '"filePath":"'. $rs["destFilepath"] . '",';
    $outp .= '"Status":"'. $rs["status"] . '",';
    $outp .= '"type":"'. $rs["fileType"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>



