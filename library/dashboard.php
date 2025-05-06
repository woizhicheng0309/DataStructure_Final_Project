<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:adminlogin.php');
}
else{
    // Fetch total professors
    $sql1 ="SELECT COUNT(*) as totalProfessors FROM tblprofessors";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $result1 = $query1->fetch(PDO::FETCH_OBJ);
    $totalProfessors = $result1->totalProfessors;

    // Fetch total students
    $sql2 ="SELECT COUNT(*) as totalStudents FROM tblstudents";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetch(PDO::FETCH_OBJ);
    $totalStudents = $result2->totalStudents;

    // Fetch total research projects
    $sql3 ="SELECT COUNT(*) as totalProjects FROM tblresearchprojects";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $result3 = $query3->fetch(PDO::FETCH_OBJ);
    $totalProjects = $result3->totalProjects;

    // Fetch total publications
    $sql4 ="SELECT COUNT(*) as totalPublications FROM tblpublications";
    $query4 = $dbh->prepare($sql4);
    $query4->execute();
    $result4 = $query4->fetch(PDO::FETCH_OBJ);
    $totalPublications = $result4->totalPublications;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Dashboard</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>
<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">ADMIN DASHBOARD</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-info back-widget-set text-center">
                    <i class="fa fa-user fa-5x"></i>
                    <h3><?php echo htmlentities($totalProfessors); ?></h3>
                    Total Professors
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-warning back-widget-set text-center">
                    <i class="fa fa-users fa-5x"></i>
                    <h3><?php echo htmlentities($totalStudents); ?></h3>
                    Total Students
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-success back-widget-set text-center">
                    <i class="fa fa-book fa-5x"></i>
                    <h3><?php echo htmlentities($totalProjects); ?></h3>
                    Research Projects
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="alert alert-danger back-widget-set text-center">
                    <i class="fa fa-file-text fa-5x"></i>
                    <h3><?php echo htmlentities($totalPublications); ?></h3>
                    Publications
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
