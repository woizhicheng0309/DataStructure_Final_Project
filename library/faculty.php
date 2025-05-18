<?php
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
    <title>教師資料 - 逢甲大學資訊系系網</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
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
            <a class="navbar-brand" href="index.php">逢甲大學資訊系系網</a>
        </div>
        <div class="header-right" style="text-align: right;">
            <a href="admin/adminlogin.php" class="btn btn-primary" title="管理員登入">管理員登入</a>
        </div>
    </nav>
    <!-- MENU SECTION END-->
    
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">教師資料</h4>
                </div>
            </div>
            
            <!-- FACULTY INFORMATION START -->
            <div class="row">
                <!-- Faculty Profile Section -->
                <div class="col-md-12 faculty-section">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="assets/img/faculty/default.jpg" alt="教師照片" class="faculty-photo">
                        </div>
                        <div class="col-md-9">
                            <h2 class="section-title">教師資料</h2>
                            <div id="faculty-info">
                                <!-- Faculty information will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Experience Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">經歷</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>校內經歷</h4>
                            <div id="internal-experience">
                                <!-- Internal experience will be loaded here -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>校外經歷</h4>
                            <div id="external-experience">
                                <!-- External experience will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Papers Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">論文發表</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <h4>會議論文</h4>
                            <div id="conference-papers">
                                <!-- Conference papers will be loaded here -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4>期刊論文</h4>
                            <div id="journal-papers">
                                <!-- Journal papers will be loaded here -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4>專書論文</h4>
                            <div id="book-papers">
                                <!-- Book papers will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Awards Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">帶領學生參賽獲獎記錄</h3>
                    <div id="awards">
                        <!-- Awards will be loaded here -->
                    </div>
                </div>

                <!-- Patents Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">核准專利</h3>
                    <div id="patents">
                        <!-- Patents will be loaded here -->
                    </div>
                </div>

                <!-- Speeches Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">演講記錄</h3>
                    <div id="speeches">
                        <!-- Speeches will be loaded here -->
                    </div>
                </div>

                <!-- Projects Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">研究計劃</h3>
                    <div id="projects">
                        <!-- Projects will be loaded here -->
                    </div>
                </div>

                <!-- Specialties Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">專長領域</h3>
                    <div id="specialties">
                        <!-- Specialties will be loaded here -->
                    </div>
                </div>

                <!-- Schedule Section -->
                <div class="col-md-12 faculty-section">
                    <h3 class="section-title">課表</h3>
                    <div id="schedule">
                        <table class="table table-bordered schedule-table">
                            <thead>
                                <tr>
                                    <th>時間</th>
                                    <th>星期一</th>
                                    <th>星期二</th>
                                    <th>星期三</th>
                                    <th>星期四</th>
                                    <th>星期五</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Schedule will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- FACULTY INFORMATION END -->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html> 