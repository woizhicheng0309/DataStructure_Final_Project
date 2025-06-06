<!-- Removed the title '大学系网' from the top left and moved the '登出' button to the top right -->
<nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <!-- Removed the title -->
    </div>
    <div class="header-right" style="text-align: right;">
        <a href="/Online-Library-Management-System-PHP/library/index.php" class="btn btn-danger" title="登出">登出</a>
    </div>
</nav>
<!-- Updated navigation menu to always display the title -->
<nav class="navbar navbar-inverse set-radius-zero" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="dashboard.php">
                <h1 style="color: black; font-size: 24px;">逢甲大學資訊系網</h1>
            </a>
        </div>
    </div>
</nav>
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse">
                    <?php
                    if (isset($_SESSION['alogin'])) {
                        // 管理員登入後顯示的功能
                        echo '<ul id="menu-top" class="nav navbar-nav navbar-right">';
                        echo '<li><a href="dashboard.php">儀表板</a></li>';
                        echo '<li><a href="manage-professors.php">管理老師</a></li>';
                        echo '<li><a href="manage-students.php">管理學生</a></li>';
                        echo '<li><a href="manage-mentored-awards.php">管理學生參賽</a></li>';
                        echo '<li><a href="manage-publications.php">管理論文</a></li>';
                        echo '<li><a href="manage-book-papers.php">管理專書論文</a></li>';
                        echo '<li><a href="manage-conference-papers.php">管理會議論文</a></li>';
                        echo '<li><a href="manage-journal-papers.php">管理期刊論文</a></li>';
                        echo '<li><a href="manage-timetable.php">管理老師課表</a></li>';
                        echo '<li><a href="manage-internal-experiences.php">管理教師校內經歷</a></li>';
                        echo '<li><a href="manage-external-experiences.php">管理老師校外經歷</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>