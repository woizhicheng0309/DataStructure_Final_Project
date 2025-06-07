<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Get faculty ID from URL parameter
$facultyId = isset($_GET['id']) ? $_GET['id'] : '';

// Initialize faculty data
$facultyData = null;
$error = '';

if (!empty($facultyId)) {
    try {
        // 獲取教師基本資料
        $stmt = $dbh->prepare("SELECT * FROM faculty_members WHERE faculty_id = :faculty_id AND status = 'active'");
        $stmt->execute([':faculty_id' => $facultyId]);
        $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($faculty) {
            // 獲取專長
            $specialtyStmt = $dbh->prepare("SELECT specialty FROM faculty_specialties WHERE faculty_id = :faculty_id");
            $specialtyStmt->execute([':faculty_id' => $facultyId]);
            $specialties = $specialtyStmt->fetchAll(PDO::FETCH_COLUMN);
            
            // 獲取學歷
            $educationStmt = $dbh->prepare("SELECT * FROM faculty_education WHERE faculty_id = :faculty_id ORDER BY display_order ASC");
            $educationStmt->execute([':faculty_id' => $facultyId]);
            $education = $educationStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 獲取經歷
            $experienceStmt = $dbh->prepare("SELECT * FROM faculty_experience WHERE faculty_id = :faculty_id ORDER BY display_order ASC");
            $experienceStmt->execute([':faculty_id' => $facultyId]);
            $experience = $experienceStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 獲取課程
            $coursesStmt = $dbh->prepare("SELECT * FROM faculty_courses WHERE faculty_id = :faculty_id AND is_current = 1");
            $coursesStmt->execute([':faculty_id' => $facultyId]);
            $courses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 獲取著作
            $publicationsStmt = $dbh->prepare("SELECT * FROM faculty_publications WHERE faculty_id = :faculty_id ORDER BY year DESC, display_order ASC");
            $publicationsStmt->execute([':faculty_id' => $facultyId]);
            $publications = $publicationsStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 獲取獲獎記錄
            $awardsStmt = $dbh->prepare("SELECT * FROM faculty_awards WHERE faculty_id = :faculty_id ORDER BY year DESC, display_order ASC");
            $awardsStmt->execute([':faculty_id' => $facultyId]);
            $awards = $awardsStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 組織資料
            $facultyData = [
                'name' => $faculty['name'],
                'name_en' => $faculty['name_en'],
                'category' => $faculty['category'],
                'extension' => $faculty['extension'] ?: '-',
                'email' => $faculty['email'],
                'office' => $faculty['office'],
                'specialties' => $specialties,
                'photo' => $faculty['photo'] ?: 'assets/img/faculty/default.jpg',
                'research_interests' => $faculty['research_interests'],
                'personal_website' => $faculty['personal_website'],
                'education' => $education,
                'experience' => $experience,
                'courses' => array_column($courses, 'course_name'),
                'publications' => $publications,
                'awards' => $awards
            ];
        } else {
            $error = '找不到指定的教師資料';
        }
    } catch (PDOException $e) {
        $error = '資料庫連接錯誤，使用測試資料';
        // 使用原本的測試資料作為後備
    }
}

// 如果資料庫查詢失敗或沒有資料，使用測試資料
if (!$facultyData) {
    // 測試資料 - 當資料庫不可用時的後備資料
    $sampleFacultyData = [
    'zhang_san' => [
        'name' => '張三',
        'category' => '系主任',
        'extension' => '2001',
        'email' => 'zhang@fcu.edu.tw',
        'office' => '資電館 501',
        'specialties' => ['資料科學', '機器學習', '人工智慧'],
        'photo' => 'assets/img/faculty/default.jpg',
        'education' => [
            'Ph.D. in Computer Science, Stanford University',
            'M.S. in Computer Science, MIT',
            'B.S. in Computer Science, 國立台灣大學'
        ],
        'experience' => [
            '逢甲大學資訊工程學系 系主任 (2020-現在)',
            '逢甲大學資訊工程學系 教授 (2015-2020)',
            '逢甲大學資訊工程學系 副教授 (2010-2015)'
        ],
        'research_interests' => '主要研究領域包括機器學習、深度學習、資料探勘、人工智慧應用等。近年來專注於將AI技術應用於醫療診斷、智慧製造等領域。',
        'courses' => [
            '資料結構',
            '演算法',
            '機器學習',
            '人工智慧導論'
        ],
        'publications' => [
            'Machine Learning Applications in Healthcare, IEEE Transactions on Medical Imaging, 2023',
            'Deep Learning for Smart Manufacturing, Journal of Manufacturing Systems, 2022',
            'Data Mining Techniques for Business Intelligence, ACM Computing Surveys, 2021'
        ],
        'awards' => [
            '2023年 教育部教學卓越獎',
            '2022年 科技部傑出研究獎',
            '2021年 逢甲大學優良教師獎'
        ]
    ],
    'li_si' => [
        'name' => '李四',
        'category' => '榮譽特聘講座',
        'extension' => '2002',
        'email' => 'li@fcu.edu.tw',
        'office' => '資電館 502',
        'specialties' => ['軟體工程', '系統設計'],
        'photo' => 'assets/img/faculty/default.jpg',
        'education' => [
            'Ph.D. in Software Engineering, Carnegie Mellon University',
            'M.S. in Computer Science, UC Berkeley'
        ],
        'experience' => [
            '逢甲大學資訊工程學系 榮譽特聘講座 (2018-現在)',
            'Google 資深軟體工程師 (2010-2018)'
        ],
        'research_interests' => '專精於大型系統架構設計、軟體工程方法論、敏捷開發等領域。',
        'courses' => [
            '軟體工程',
            '系統分析與設計',
            '專案管理'
        ],
        'publications' => [
            'Scalable System Architecture Design, ACM Transactions on Software Engineering, 2023',
            'Agile Development Methodologies, IEEE Software, 2022'
        ],        'awards' => [
            '2023年 ACM傑出貢獻獎',
            '2022年 IEEE Fellow'
        ]
    ]
    // Add more faculty data as needed
];

    // 從測試資料中選擇對應的教師資料
    $facultyData = isset($sampleFacultyData[$facultyId]) ? $sampleFacultyData[$facultyId] : null;
}

// Get faculty info or show error
if (!$facultyData) {
    header('Location: faculty.php');
    exit;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo htmlspecialchars($facultyData['name']); ?> - 逢甲大學資訊系系網</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .profile-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }
        .profile-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .profile-info h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        .profile-info .category {
            font-size: 1.2em;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .contact-info {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .contact-info p {
            margin: 8px 0;
            font-size: 1.1em;
        }
        .section-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .specialty-tag {
            display: inline-block;
            background: #e9ecef;
            padding: 8px 16px;
            margin: 5px;
            border-radius: 25px;
            font-size: 0.9em;
        }
        .back-btn {
            margin-bottom: 20px;
        }
        .list-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .list-item:last-child {
            border-bottom: none;
        }
        .publication-item {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #007bff;
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
    
    <div class="profile-header">        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="<?php echo htmlspecialchars($facultyData['photo']); ?>" alt="<?php echo htmlspecialchars($facultyData['name']); ?>" class="profile-photo">
                </div>
                <div class="col-md-9">
                    <div class="profile-info">
                        <h1><?php echo htmlspecialchars($facultyData['name']); ?></h1>
                        <?php if (isset($facultyData['name_en'])): ?>
                        <h2 style="font-size: 1.2em; opacity: 0.8;"><?php echo htmlspecialchars($facultyData['name_en']); ?></h2>
                        <?php endif; ?>
                        <div class="category"><?php echo htmlspecialchars($facultyData['category']); ?></div>
                        <div class="contact-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><i class="fa fa-phone"></i> 分機：<?php echo htmlspecialchars($facultyData['extension']); ?></p>
                                    <p><i class="fa fa-envelope"></i> 信箱：<a href="mailto:<?php echo htmlspecialchars($facultyData['email']); ?>" style="color: white;"><?php echo htmlspecialchars($facultyData['email']); ?></a></p>
                                </div>
                                <div class="col-md-6">
                                    <?php if (isset($facultyData['office'])): ?>
                                    <p><i class="fa fa-map-marker"></i> 辦公室：<?php echo htmlspecialchars($facultyData['office']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-wrapper">
        <div class="container">
            <div class="back-btn">
                <a href="faculty.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> 返回教師列表</a>
            </div>
            
            <div class="row">
                <div class="col-md-8">                    <!-- Research Interests -->
                    <div class="section-card">
                        <h3 class="section-title">研究興趣</h3>
                        <p><?php echo htmlspecialchars($facultyData['research_interests']); ?></p>
                    </div>
                    
                    <!-- Education -->
                    <?php if (isset($facultyData['education'])): ?>
                    <div class="section-card">
                        <h3 class="section-title">學歷</h3>
                        <?php foreach ($facultyData['education'] as $edu): ?>
                        <div class="list-item">
                            <i class="fa fa-graduation-cap"></i> <?php echo htmlspecialchars(is_array($edu) ? $edu['degree'] . ' in ' . $edu['major'] . ', ' . $edu['school'] : $edu); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Experience -->
                    <?php if (isset($facultyData['experience'])): ?>
                    <div class="section-card">
                        <h3 class="section-title">經歷</h3>
                        <?php foreach ($facultyData['experience'] as $exp): ?>
                        <div class="list-item">
                            <i class="fa fa-briefcase"></i> <?php echo htmlspecialchars(is_array($exp) ? $exp['position'] . ', ' . $exp['organization'] : $exp); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Publications -->
                    <?php if (isset($facultyData['publications'])): ?>
                    <div class="section-card">
                        <h3 class="section-title">近期發表</h3>
                        <?php foreach ($facultyData['publications'] as $pub): ?>
                        <div class="publication-item">
                            <?php echo htmlspecialchars(is_array($pub) ? $pub['title'] : $pub); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-4">                    <!-- Specialties -->
                    <div class="section-card">
                        <h3 class="section-title">專長領域</h3>
                        <?php foreach ($facultyData['specialties'] as $specialty): ?>
                        <span class="specialty-tag"><?php echo htmlspecialchars($specialty); ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Courses -->
                    <?php if (isset($facultyData['courses'])): ?>
                    <div class="section-card">
                        <h3 class="section-title">授課科目</h3>
                        <?php foreach ($facultyData['courses'] as $course): ?>
                        <div class="list-item">
                            <i class="fa fa-book"></i> <?php echo htmlspecialchars($course); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Awards -->
                    <?php if (isset($facultyData['awards'])): ?>
                    <div class="section-card">
                        <h3 class="section-title">獲獎紀錄</h3>
                        <?php foreach ($facultyData['awards'] as $award): ?>
                        <div class="list-item">
                            <i class="fa fa-trophy"></i> <?php echo htmlspecialchars(is_array($award) ? $award['award_name'] : $award); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
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
