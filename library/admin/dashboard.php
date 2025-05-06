<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Admin Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('../includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">管理员仪表板</h4>
                
                            </div>

        </div>
             
             <div class="row">

<div class="col-md-3 col-sm-3 col-xs-6">
    <div class="alert alert-info back-widget-set text-center">
        <i class="fa fa-users fa-5x"></i>
        <?php 
        $sqlStudents ="SELECT COUNT(*) as totalStudents FROM 學生";
        $queryStudents = $dbh -> prepare($sqlStudents);
        $queryStudents->execute();
        $resultsStudents=$queryStudents->fetch(PDO::FETCH_OBJ);
        $totalStudents=$resultsStudents->totalStudents;
        ?>
        <h3><?php echo htmlentities($totalStudents);?> </h3>
        學生總人數
    </div>
</div>

<div class="col-md-3 col-sm-3 col-xs-6">
    <div class="alert alert-success back-widget-set text-center">
        <i class="fa fa-user fa-5x"></i>
        <?php 
        $sqlProfessors ="SELECT COUNT(*) as totalProfessors FROM 老師";
        $queryProfessors = $dbh -> prepare($sqlProfessors);
        $queryProfessors->execute();
        $resultsProfessors=$queryProfessors->fetch(PDO::FETCH_OBJ);
        $totalProfessors=$resultsProfessors->totalProfessors;
        ?>
        <h3><?php echo htmlentities($totalProfessors);?> </h3>
        教授總人數
    </div>
</div>

        </div>
            
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('../includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
