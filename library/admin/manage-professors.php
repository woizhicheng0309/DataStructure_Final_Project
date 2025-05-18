<?php
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0) 
{   
header('location:index.php');
}
else{
if (!isset($_SESSION['delmsg'])) {
    $_SESSION['delmsg'] = "";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>管理老師</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .search-highlight td {
            background-color: #ffe066 !important;
        }
    </style>
</head>
<body>
    <!------MENU SECTION START-->
    <?php include('../includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">管理老師</h4>
                </div>
            </div>
            <div class="row">
                <?php if($_SESSION['delmsg']!="") { ?>
                <div class="col-md-6">
                    <div class="alert alert-success">
                        <strong>Success :</strong> <?php echo htmlentities($_SESSION['delmsg']);?>
                        <?php echo htmlentities($_SESSION['delmsg']="");?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            老師列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addStudentForm" class="form-inline" method="post" action="">
                                    <div class="form-group">
                                        <label for="student_id">老師編號:</label>
                                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">姓名:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">信箱:</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="extension">分機:</label>
                                        <input type="text" class="form-control" id="extension" name="extension" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="education">學歷:</label>
                                        <input type="text" class="form-control" id="education" name="education" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="schedule">課表時間:</label>
                                        <input type="text" class="form-control" id="schedule" name="schedule" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="specialty">專長:</label>
                                        <input type="text" class="form-control" id="specialty" name="specialty" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">類別:</label>
                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchStudentForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_student_id">老師編號:</label>
                                        <input type="text" class="form-control" id="search_student_id" name="search_student_id" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">查詢</button>
                                    <button type="button" id="cancelSearchForm" class="btn btn-default">取消</button>
                                </form>
                                <div id="searchResult" style="margin-top:10px;"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="studentsTable">
                                    <thead>
                                        <tr>
                                            <th>老師編號</th>
                                            <th>姓名</th>
                                            <th>信箱</th>
                                            <th>分機</th>
                                            <th>學歷</th>
                                            <th>課表時間</th>
                                            <th>專長</th>
                                            <th>類別</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTbody">
                                    <?php
                                    // 查詢所有老師資料
                                    $stmt = $dbh->query("SELECT * FROM 老師");
                                    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($teachers) > 0) {
                                        foreach ($teachers as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['姓名']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['信箱']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['分機']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['學歷']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['課表時間']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['專長']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['類別']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="9" class="text-center">請使用上方按鈕新增、查詢老師資料</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('../includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="../assets/js/custom.js"></script>
    <script>
        document.getElementById('showAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancelAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
        };

        // 綁定現有資料列的修改/刪除事件
        function bindTableRowButtons() {
            var tbody = document.getElementById('studentsTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        document.getElementById('student_id').value = tds[0].innerText;
                        document.getElementById('name').value = tds[1].innerText;
                        document.getElementById('email').value = tds[2].innerText;
                        document.getElementById('extension').value = tds[3].innerText;
                        document.getElementById('education').value = tds[4].innerText;
                        document.getElementById('schedule').value = tds[5].innerText;
                        document.getElementById('specialty').value = tds[6].innerText;
                        document.getElementById('category').value = tds[7].innerText;
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        document.getElementById('addStudentForm').setAttribute('data-editing', 'true');
                        document.getElementById('addStudentForm').setAttribute('data-edit-index', tr.rowIndex);
                    };
                }
                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if(confirm('確定要刪除這位老師嗎？')) {
                            var teacherId = tr.cells[0].innerText;
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('teacher_id', teacherId);
                            fetch('manage-professors-api.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('刪除成功！');
                                    tr.parentNode.removeChild(tr);
                                } else {
                                    alert('刪除失敗：' + (data.msg || ''));
                                }
                            });
                        }
                    };
                }
            });
        }
        bindTableRowButtons();

        // 新增/修改老師時同步資料庫
        var addForm = document.getElementById('addStudentForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var teacherId = document.getElementById('student_id').value;
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var extension = document.getElementById('extension').value;
            var education = document.getElementById('education').value;
            var schedule = document.getElementById('schedule').value;
            var specialty = document.getElementById('specialty').value;
            var category = document.getElementById('category').value;
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            var formData = new FormData();
            formData.append('teacher_id', teacherId);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('extension', extension);
            formData.append('education', education);
            formData.append('schedule', schedule);
            formData.append('specialty', specialty);
            formData.append('category', category);
            formData.append('action', isEditing ? 'edit' : 'add');
            fetch('manage-professors-api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(isEditing ? '修改成功！' : '新增成功！');
                    addForm.reset();
                    addForm.removeAttribute('data-editing');
                    addForm.removeAttribute('data-edit-index');
                    document.getElementById('addFormContainer').style.display = 'none';
                    document.getElementById('showAddForm').style.display = 'inline-block';
                    location.reload();
                } else {
                    alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || ''));
                }
            });
        };

        document.getElementById('showSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'block';
            this.style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
        };
        document.getElementById('cancelSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'none';
            document.getElementById('showSearchForm').style.display = 'inline-block';
        };

        // 查詢老師功能 (僅查詢本頁已新增的資料)
        document.getElementById('searchStudentForm').onsubmit = function(e) {
            e.preventDefault();
            var searchId = document.getElementById('search_student_id').value.trim();
            var rows = document.querySelectorAll('#studentsTbody tr');
            var found = false;
            var resultHtml = '';
            // 先移除所有高亮
            rows.forEach(function(row) {
                row.classList.remove('search-highlight');
                Array.from(row.children).forEach(function(td) {
                    td.style.backgroundColor = '';
                });
            });
            for (var i = 0; i < rows.length; i++) {
                var tds = rows[i].getElementsByTagName('td');
                if (tds.length && tds[0].innerText === searchId) {
                    found = true;
                    // 滾動到老師資料列
                    rows[i].scrollIntoView({behavior: 'smooth', block: 'center'});
                    // 高亮整列
                    rows[i].classList.add('search-highlight');
                    Array.from(tds).forEach(function(td) {
                        td.style.backgroundColor = '#ffe066';
                    });
                    setTimeout(function(row, tds){
                        row.classList.remove('search-highlight');
                        Array.from(tds).forEach(function(td) { td.style.backgroundColor = ''; });
                    }, 2000, rows[i], tds);
                    resultHtml = '<div class="alert alert-success">找到老師：<br>' +
                        '編號: ' + tds[0].innerText + '<br>' +
                        '老師ID: ' + tds[1].innerText + '<br>' +
                        '名字: ' + tds[2].innerText + '<br>' +
                        'Class: ' + tds[3].innerText + '<br>' +
                        'Department: ' + tds[4].innerText + '</div>';
                    break;
                }
            }
            if (!found) {
                resultHtml = '<div class="alert alert-danger">該老師不存在</div>';
            }
            document.getElementById('searchResult').innerHTML = resultHtml;
        };
    </script>
</body>
</html>
<?php } ?>
