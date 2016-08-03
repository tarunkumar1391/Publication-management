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
    $outp .= '{"Sno":"'  . $rs["s.no"] . '",';
    $outp .= '"firstName":"'  . $rs["fname"] . '",';
    $outp .= '"lastName":"'  . $rs["lname"] . '",';
    $outp .= '"Betreuer":"'   . $rs["betreuer"] . '",';
    $outp .= '"endDate":"'. $rs["enddate"] . '",';
    $outp .= '"typeofWork":"'. $rs["typofwork"] . '",';
    $outp .= '"Foerderung":"'. $rs["foerderung"] . '",';
    $outp .= '"Tp":"'. $rs["tp"] . '",';
    $outp .= '"Title":"'. $rs["title"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>



