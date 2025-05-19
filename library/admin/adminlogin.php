<?php
// Updated admin login page to align with the new specification
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
include('../includes/config.php');
if(isset($_POST['login']))
{
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT * FROM tbladmin WHERE Username=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username',$username,PDO::PARAM_STR);
    $query->bindParam(':password',$password,PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        $_SESSION['alogin']=$_POST['username'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else{
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Login</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">管理員登入</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            登入表單
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>輸入用戶名</label>
                                    <input class="form-control" type="text" name="username" required />
                                </div>
                                <div class="form-group">
                                    <label>輸入密碼</label>
                                    <input class="form-control" type="password" name="password" required />
                                </div>
                                <button type="submit" name="login" class="btn btn-info">登入</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
