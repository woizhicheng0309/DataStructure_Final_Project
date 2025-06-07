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
        }        .schedule-table {
            width: 100%;
            margin-top: 15px;
        }
        .category-sidebar {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .category-list li {
            margin-bottom: 10px;
        }
        .category-list a {
            display: block;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        .category-list a:hover, .category-list a.active {
            background: #007bff;
            color: #fff;
            text-decoration: none;
        }
        .faculty-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .faculty-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .faculty-card:hover {
            transform: translateY(-5px);
        }
        .faculty-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .faculty-card-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .faculty-card-info h4 {
            margin: 0 0 5px 0;
            color: #333;
        }
        .faculty-card-info .category {
            color: #007bff;
            font-size: 0.9em;
            font-weight: 500;
        }
        .faculty-card-details {
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .faculty-card-details p {
            margin: 5px 0;
            font-size: 0.9em;
        }
        .faculty-card-details strong {
            color: #555;
        }
        .specialties-tags {
            margin-top: 10px;
        }        .specialty-tag-small {
            display: inline-block;
            padding: 3px 8px;
            margin: 2px;
            background: #e9ecef;
            border-radius: 15px;
            font-size: 0.8em;
        }
        .clickable {
            cursor: pointer;
        }
        .faculty-name:hover {
            color: #007bff;
        }
        .faculty-card-header.clickable:hover {
            background-color: #f8f9fa;
            border-radius: 5px;
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
            
            <div class="row">
                <!-- Category Sidebar -->
                <div class="col-md-3">
                    <div class="category-sidebar">
                        <h4 class="section-title">教師類別</h4>
                        <ul class="category-list">
                            <li><a href="#" data-category="department_head" class="category-link active">系主任</a></li>
                            <li><a href="#" data-category="honorary_chair" class="category-link">榮譽特聘講座</a></li>
                            <li><a href="#" data-category="chair_professor" class="category-link">講座教授</a></li>
                            <li><a href="#" data-category="special_chair" class="category-link">特約講座</a></li>
                            <li><a href="#" data-category="distinguished_professor" class="category-link">特聘教授</a></li>
                            <li><a href="#" data-category="full_time" class="category-link">專任教師</a></li>
                            <li><a href="#" data-category="part_time" class="category-link">兼任教師</a></li>
                            <li><a href="#" data-category="retired" class="category-link">退休老師</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Faculty Display Area -->
                <div class="col-md-9">
                    <div class="faculty-section">
                        <h3 class="section-title" id="category-title">系主任</h3>
                        <div id="faculty-display" class="faculty-grid">
                            <!-- Faculty cards will be loaded here -->
                        </div>
                    </div>
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
    <script src="assets/js/custom.js"></script>    <script>
        // Test if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            console.log('jQuery is loaded, version:', jQuery.fn.jquery);
        }
        
        $(document).ready(function() {
            console.log('Document ready fired');
            
            // Faculty data - will be loaded from database via AJAX
            let facultyData = {};
            
            // Fallback sample data for testing when database is not available
            const sampleFacultyData = {
                'department_head': [
                    {
                        id: 'zhang_san',
                        name: '張三',
                        category: '系主任',
                        extension: '2001',
                        email: 'zhang@fcu.edu.tw',
                        specialties: ['資料科學', '機器學習', '人工智慧'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'honorary_chair': [
                    {
                        id: 'li_si',
                        name: '李四',
                        category: '榮譽特聘講座',
                        extension: '2002',
                        email: 'li@fcu.edu.tw',
                        specialties: ['軟體工程', '系統設計'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'chair_professor': [
                    {
                        id: 'wang_wu',
                        name: '王五',
                        category: '講座教授',
                        extension: '2003',
                        email: 'wang@fcu.edu.tw',
                        specialties: ['計算機網路', '資訊安全'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'special_chair': [
                    {
                        id: 'zhao_liu',
                        name: '趙六',
                        category: '特約講座',
                        extension: '2004',
                        email: 'zhao@fcu.edu.tw',
                        specialties: ['大資料分析', '雲端運算'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'distinguished_professor': [
                    {
                        id: 'sun_qi',
                        name: '孫七',
                        category: '特聘教授',
                        extension: '2005',
                        email: 'sun@fcu.edu.tw',
                        specialties: ['影像處理', '電腦視覺'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'full_time': [
                    {
                        id: 'zhou_ba',
                        name: '周八',
                        category: '專任教師',
                        extension: '2006',
                        email: 'zhou@fcu.edu.tw',
                        specialties: ['演算法', '資料結構'],
                        photo: 'assets/img/faculty/default.jpg'
                    },
                    {
                        id: 'wu_jiu',
                        name: '吳九',
                        category: '專任教師',
                        extension: '2007',
                        email: 'wu@fcu.edu.tw',
                        specialties: ['網頁開發', '資料庫系統'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'part_time': [
                    {
                        id: 'zheng_shi',
                        name: '鄭十',
                        category: '兼任教師',
                        extension: '2008',
                        email: 'zheng@fcu.edu.tw',
                        specialties: ['行動裝置開發', 'UI/UX設計'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ],
                'retired': [
                    {
                        id: 'chen_shiyi',
                        name: '陳十一',
                        category: '退休老師',
                        extension: '-',
                        email: 'chen@fcu.edu.tw',
                        specialties: ['理論計算機科學', '離散數學'],
                        photo: 'assets/img/faculty/default.jpg'
                    }
                ]            };

            const categoryNames = {
                'department_head': '系主任',
                'honorary_chair': '榮譽特聘講座',
                'chair_professor': '講座教授',
                'special_chair': '特約講座',
                'distinguished_professor': '特聘教授',
                'full_time': '專任教師',
                'part_time': '兼任教師',
                'retired': '退休老師'
            };

            // Load faculty data from database
            function loadFacultyData() {
                $.ajax({
                    url: 'api/get_faculty_data.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            facultyData = response.data;
                            console.log('Faculty data loaded from database');
                        } else {
                            console.warn('Database load failed, using sample data');
                            facultyData = sampleFacultyData;
                        }
                        // Load default category after data is ready
                        loadFacultyByCategory('department_head');
                    },
                    error: function() {
                        console.warn('Database connection failed, using sample data');
                        facultyData = sampleFacultyData;
                        // Load default category after data is ready
                        loadFacultyByCategory('department_head');
                    }
                });
            }

            function loadFacultyByCategory(category) {
                const faculty = facultyData[category] || [];
                const container = $('#faculty-display');
                const title = $('#category-title');
                
                title.text(categoryNames[category]);
                container.empty();

                if (faculty.length === 0) {
                    container.html('<p class="text-center">此類別目前無教師資料</p>');
                    return;
                }                faculty.forEach(function(prof) {
                    const specialtyTags = prof.specialties.map(specialty => 
                        `<span class="specialty-tag-small">${specialty}</span>`
                    ).join('');

                    const card = `
                        <div class="faculty-card" data-faculty-id="${prof.id}">
                            <div class="faculty-card-header clickable" onclick="goToFacultyProfile('${prof.id}')">
                                <img src="${prof.photo}" alt="${prof.name}" class="faculty-card-photo">
                                <div class="faculty-card-info">
                                    <h4 class="faculty-name">${prof.name}</h4>
                                    <div class="category">${prof.category}</div>
                                </div>
                            </div>
                            <div class="faculty-card-details">
                                <p><strong>分機：</strong>${prof.extension}</p>
                                <p><strong>信箱：</strong><a href="mailto:${prof.email}">${prof.email}</a></p>
                                <p><strong>研究專長：</strong></p>
                                <div class="specialties-tags">${specialtyTags}</div>
                            </div>
                        </div>
                    `;
                    container.append(card);
                });
            }            // Handle category selection
            $('.category-link').click(function(e) {
                console.log('Category link clicked!');
                e.preventDefault();
                
                // Update active state
                $('.category-link').removeClass('active');
                $(this).addClass('active');
                
                // Load faculty for selected category
                const category = $(this).data('category');
                console.log('Loading category:', category);
                loadFacultyByCategory(category);
            });            // Check if category links exist
            console.log('Found category links:', $('.category-link').length);

            // Initialize faculty data loading
            loadFacultyData();
        });
        
        // Function to navigate to faculty profile page
        function goToFacultyProfile(facultyId) {
            window.location.href = `faculty-profile.php?id=${facultyId}`;
        }
    </script>
</body>
</html> 