<?php

if(isset($_POST['userEmail']) && isset($_POST['userPasswd'])){

    define('DB_NAME', 'ikp');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    $uemail = $_POST['userEmail'];
    $passwd = $_POST['userPasswd'];
    $uname = substr($uemail,0, strpos($uemail, '@'));
    $sql = "SELECT * FROM auth where email = '$uemail' and password = '$passwd'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        // while($row = $result->fetch_assoc()) {
        //   echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        session_start();
        $_SESSION['name']=$uname;
        //Storing the name of user in SESSION variable.
        header("location: home.php");

    } else {
        echo "Kindly check your credentials and try again!!!";
    }
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>IKP-Haus IT Management</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">

    <!-- Your custom styles (optional) -->
    <link href="../css/main.css" rel="stylesheet">



</head>

<body >

<div class="container-fluid">
    <div class="row">
        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar navbar-dark bg-primary">
            <!--Navbar Brand-->
            <a class="navbar-brand" href="#">Institut fur kern physik- Haus IT</a>
            <!--Links-->

        </nav>
        <!--/.Navbar-->
    </div>
    <div class="row">
        <div style="height: 100vh">
            <div class="flex-center">
                <div class="container">
                    <h1 >Welcome to Publication Management</h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login">
                        Login
                    </button>
                </div>
                <div>

                </div>

            </div>
        </div>



        <!-- Modal Login -->
        <div class="modal fade modal-ext" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <!--Content-->
                <div class="modal-content">

                    <!--Header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3><i class="fa fa-user"></i> Login</h3>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <form role="form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                            <div class="md-form">
                                <i class="fa fa-envelope prefix"></i>
                                <input type="email" id="form2" name="userEmail" class="form-control" required>
                                <label for="form2">Your email</label>
                            </div>

                            <div class="md-form">
                                <i class="fa fa-lock prefix"></i>
                                <input type="password" id="form3" name= "userPasswd" class="form-control" required>
                                <label for="form3">Your password</label>
                            </div>
                            <div class="text-xs-center">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                <button type="reset" class="btn btn-danger btn-lg">Reset</button>
                            </div>
                        </form>

                    </div>

                    <!--Footer-->
                    <!--                        <div class="modal-footer">-->
                    <!--                            <div class="options">-->
                    <!--                                <p>Not a member? <a href="#">Sign Up</a></p>-->
                    <!--                                <p>Forgot <a href="#">Password?</a></p>-->
                    <!--                            </div>-->
                    <!--                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <!--                        </div>-->
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>

    <div class="row"><!--footer-->
        <nav class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="navbar-header">
                    <h4 class="navbar-brand">All rights reserved @ Institut für kern physik</h4>
                </div>
            </div>
        </nav>
    </div>

</div>





<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="../scripts/js/jquery-3.1.1.min.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="../scripts/js/tether.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../scripts/js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="../scripts/js/mdb.min.js"></script>


</body>

</html>