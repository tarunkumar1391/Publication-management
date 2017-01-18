<?php
session_start();
?>
<?php
if(isset($_SESSION['name']))
{
    //unset($_SESSION['name']);
    session_unset();
    session_destroy();
    //header("location: index.php");
}
echo '<h1>You have been successfully logout</h1>';
header("location: admin.php");
?>