<?php
session_start();
?>
<?php
if(!isset($_SESSION['name']))
{
    header("location: admin.php");
}
$name=$_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IKP-Publication Management </title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../scripts/js/angular.min.js"></script>
    <script src="../scripts/js/ui-bootstrap-tpls-2.0.0.min.js"></script>
    <script src="../scripts/js/angular-animate.min.js"></script>


    <script src="../scripts/js/control.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="../scripts/js/jquery-3.1.1.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../scripts/js/tether.min.js"></script>
    <script src="../scripts/js/bootstrap.min.js"></script>



</head>
<body ng-app="myApp" >
<div class="container-fluid"><!--main body container-->
    <div class="row"><!--header-->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid ">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Haus-It Management</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="home.php">Home</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo "$name";?></a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="row"><!--Nav + body content-->
        <div class="col-md-2 col-lg-2 navbg">
            <ul class="nav nav-pills nav-stacked">
                <li class = "active"><a data-toggle="tab" href="#viewEntries">View</a></li>
                <li><a data-toggle="tab" href="#modifyEntries">Update</a></li>

            </ul>
        </div>
        <div class="col-mg-10 col-lg-10">
            <div class="tab-content">

                <!-- Viewing-->
                <div id="viewEntries" class="tab-pane fade in active" >
                    <form class="form" role="form"> <!-- search field(incomplete) size="78"-->

                        <div class="form-group ">
                            <input type="text" class="form-control"  type="text"  placeholder="Search... " ng-model="pubSearch">
                        </div>

                    </form>
                    <div class="table-responsive ">
                        <table class="table table-hover" ng-controller = "pubController" >
                            <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Name</th>
                                <th>Betreuer</th>
                                <th>End date</th>
                                <th>Type of Work</th>
                                <th>Förderung</th>
                                <th>TP</th>
                                <th>Title</th>
                                <th>File path</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody >
                            <tr ng-repeat="entry in entries | filter: pubSearch" ng-class="{danger: entry.Status ==='New',info: entry.Status ==='In Progress',success: entry.Status ==='Completed',warning: entry.Status ==='Intervention Required'}">
                                <td>{{entry.Sno}}</td>
                                <td> {{entry.firstName}} {{entry.lastName}}</td>
                                <td>{{entry.Betreuer}}</td>
                                <td>{{entry.endDate}}</td>
                                <td>{{entry.typeofWork}}</td>
                                <td>{{entry.Foerderung}}</td>
                                <td>{{entry.Tp}}</td>
                                <td>{{entry.Title}}</td>
                                <td>{{entry.filePath}}</td>
                                <td>{{entry.Status}}</td>

                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- Updating-->
                <div id="modifyEntries" class="tab-pane fade">
                    <div class="table-responsive" ng-controller = "pubmodController">
                        <div class="form-group ">
                            <input type="text" class="form-control"  type="text"  placeholder="Search... " ng-model="pubSearch">
                        </div>
                        <table class="table table-hover" >
                            <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Job Id</th>
                                <th>Name </th>
                                <th>Type of Work</th>
                                <th>Title</th>
                                <th>File</th>
                                <th>File path</th>
                                <th>Status</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody >
                            <!--<tr ng-repeat="entry in entries | filter: pubSearch" ng-click = "rowClick(entry);">-->
                            <tr ng-repeat="entry in entries | filter: pubSearch" data-toggle="modal" data-target="#myModal" ng-click = "open('lg');" ng-class="{danger: entry.Status ==='New',info: entry.Status ==='In Progress',success: entry.Status ==='Completed',warning: entry.Status ==='Intervention Required'}">
                                <td>{{entry.Sno}}</td>
                                <td>{{entry.jobId}}</td>
                                <td>{{entry.firstName}} {{entry.lastName}}</td>
                                <td>{{entry.typeofWork}}</td>
                                <td>{{entry.Title}}</td>
                                <td>{{entry.file}}</td>
                                <td>{{entry.filePath}}</td>
                                <td>{{entry.Status}}</td>
                                <td>{{entry.Comments}}</td>

                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

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

</body>
</html>