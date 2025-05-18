<?php
// Removed user login functionality and replaced with a public-facing page
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>逢甲大學資訊系系網</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 28px;
            font-weight: bold;
            color: #003366 !important;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        .navbar-brand img {
            height: 60px;
            width: auto;
            margin-right: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            object-fit: contain;
        }
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0;
        }
        .navbar-default .navbar-brand {
            color: #003366 !important;
        }
        .navbar-default .navbar-brand:hover {
            color: #0056b3 !important;
        }
        .hero-section {
            background: url('../Images/Feng Chia University background.jpg') no-repeat center center;
            background-size: cover;
            padding: 100px 0;
            position: relative;
            color: white;
            text-align: center;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .hero-title {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .hero-subtitle {
            font-size: 1.5em;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .cta-button {
            padding: 15px 30px;
            font-size: 1.2em;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .feature-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        .feature-box {
            text-align: center;
            padding: 30px;
            margin-bottom: 30px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .feature-icon {
            font-size: 2.5em;
            color: #007bff;
            margin-bottom: 20px;
        }
        .feature-title {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #333;
        }
        .feature-text {
            color: #666;
            line-height: 1.6;
        }
        .faculty-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .faculty-photo {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .section-title {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .experience-item, .paper-item, .award-item, .patent-item, .speech-item, .project-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .specialty-tag {
            display: inline-block;
            padding: 5px 15px;
            margin: 5px;
            background: #e9ecef;
            border-radius: 20px;
        }
        .schedule-table {
            width: 100%;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!------MENU SECTION START-->
    <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                <img src="../Images/IECS icon.png" alt="逢甲大學資訊系" class="img-responsive">
            </a>
        </div>
        <div class="header-right" style="text-align: right;">
            <a href="admin/adminlogin.php" class="btn btn-primary" title="管理員登入">管理員登入</a>
        </div>
    </nav>
    <!-- MENU SECTION END-->
    
    <!-- HERO SECTION START -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">歡迎來到逢甲大學資訊系系網</h1>
                <p class="hero-subtitle">探索我們的優秀師資陣容</p>
                <a href="faculty.php" class="btn btn-lg cta-button">瀏覽教師資源</a>
            </div>
        </div>
    </section>
    <!-- HERO SECTION END -->

    <!-- FEATURE SECTION START -->
    <section class="feature-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fa fa-graduation-cap feature-icon"></i>
                        <h3 class="feature-title">優秀師資</h3>
                        <p class="feature-text">匯集各領域專業教師，提供最優質的教學與研究指導</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fa fa-book feature-icon"></i>
                        <h3 class="feature-title">豐富資源</h3>
                        <p class="feature-text">提供完整的學術資源，包含論文、專利、研究計劃等資訊</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fa fa-users feature-icon"></i>
                        <h3 class="feature-title">學術交流</h3>
                        <p class="feature-text">促進師生互動，創造優質的學術交流環境</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FEATURE SECTION END --> 
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
