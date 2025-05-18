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
    <title>管理學生</title>
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
                    <h4 class="header-line">管理學生</h4>
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
                            學生列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addStudentForm" class="form-inline" method="post" action="">
                                    <div class="form-group">
                                        <label for="student_id">學生ID:</label>
                                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">名字:</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="class">班級:</label>
                                        <input type="text" class="form-control" id="class" name="class" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="department">系所:</label>
                                        <input type="text" class="form-control" id="department" name="department" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchStudentForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_student_id">學生ID:</label>
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
                                            <th>學生編號</th>
                                            <th>名字</th>
                                            <th>班級</th>
                                            <th>系所</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTbody">
                                    <?php
                                    // 查詢所有學生資料
                                    $stmt = $dbh->query("SELECT * FROM 學生");
                                    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($students) > 0) {
                                        foreach ($students as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['學生學號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['姓名']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['班級']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['系所']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center">請使用上方按鈕新增、查詢學生資料</td></tr>';
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

        // 修改功能腳本（同步更新資料庫）
        function createEditButton(tr) {
            var btn = document.createElement('button');
            btn.className = 'btn btn-primary btn-xs edit-btn';
            btn.style.marginRight = '8px';
            btn.innerHTML = '<i class="fa fa-edit"></i> 修改';
            btn.onclick = function() {
                // 取得目前資料
                var tds = tr.getElementsByTagName('td');
                var studentId = tds[0].innerText;
                var name = tds[1].innerText;
                var className = tds[2].innerText;
                var department = tds[3].innerText;
                // 將資料填入表單
                document.getElementById('student_id').value = studentId;
                document.getElementById('name').value = name;
                document.getElementById('class').value = className;
                document.getElementById('department').value = department;
                document.getElementById('addFormContainer').style.display = 'block';
                document.getElementById('showAddForm').style.display = 'none';
                // 編輯狀態標記
                document.getElementById('addStudentForm').setAttribute('data-editing', 'true');
                document.getElementById('addStudentForm').setAttribute('data-edit-index', tr.rowIndex);
            };
            return btn;
        }

        // 刪除功能腳本（同步刪除資料庫）
        function createDeleteButton(tr) {
            var btn = document.createElement('button');
            btn.className = 'btn btn-danger btn-xs delete-btn';
            btn.style.marginLeft = '0px';
            btn.innerHTML = '<i class="fa fa-trash-o"></i> 刪除';
            btn.onclick = function() {
                if(confirm('確定要刪除這位學生嗎？')) {
                    var studentId = tr.cells[0].innerText;
                    var formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('student_id', studentId);
                    fetch('manage-students-api.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('刪除成功！');
                            tr.parentNode.removeChild(tr);
                            // 重新編號
                            var tbody = document.getElementById('studentsTbody');
                            Array.from(tbody.children).forEach(function(row, idx) {
                                if(row.children.length && !row.children[0].hasAttribute('colspan')) row.children[0].innerText = idx+1;
                            });
                        } else {
                            alert('刪除失敗：' + (data.msg || ''));
                        }
                    });
                }
            };
            return btn;
        }

        // 新增學生資料並即時顯示在表格，並同步寫入資料庫
        var addForm = document.getElementById('addStudentForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var studentId = document.getElementById('student_id').value;
            var name = document.getElementById('name').value;
            var className = document.getElementById('class').value;
            var department = document.getElementById('department').value;
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            var editIndex = addForm.getAttribute('data-edit-index');
            var formData = new FormData();
            formData.append('student_id', studentId);
            formData.append('name', name);
            formData.append('class', className);
            formData.append('department', department);
            formData.append('action', isEditing ? 'edit' : 'add');
            fetch('manage-students-api.php', {
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
                    location.reload(); // 重新整理頁面顯示最新資料
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

        // 查詢學生功能 (僅查詢本頁已新增的資料)
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
                    // 滾動到該學生資料列
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
                    resultHtml = '<div class="alert alert-success">找到學生：<br>' +
                        '編號: ' + tds[0].innerText + '<br>' +
                        '學生ID: ' + tds[1].innerText + '<br>' +
                        '名字: ' + tds[2].innerText + '<br>' +
                        'Class: ' + tds[3].innerText + '<br>' +
                        'Department: ' + tds[4].innerText + '</div>';
                    break;
                }
            }
            if (!found) {
                resultHtml = '<div class="alert alert-danger">該學生不存在</div>';
            }
            document.getElementById('searchResult').innerHTML = resultHtml;
        };

        // 頁面載入時自動綁定現有資料列的修改/刪除事件
        function bindTableRowButtons() {
            var tbody = document.getElementById('studentsTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        var studentId = tds[0].innerText;
                        var name = tds[1].innerText;
                        var className = tds[2].innerText;
                        var department = tds[3].innerText;
                        document.getElementById('student_id').value = studentId;
                        document.getElementById('name').value = name;
                        document.getElementById('class').value = className;
                        document.getElementById('department').value = department;
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        document.getElementById('addStudentForm').setAttribute('data-editing', 'true');
                        document.getElementById('addStudentForm').setAttribute('data-edit-index', tr.rowIndex);
                    };
                }
                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if(confirm('確定要刪除這位學生嗎？')) {
                            var studentId = tr.cells[0].innerText;
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('student_id', studentId);
                            fetch('manage-students-api.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('刪除成功！');
                                    tr.parentNode.removeChild(tr);
                                    // 重新編號
                                    Array.from(tbody.children).forEach(function(row, idx) {
                                        if(row.children.length && !row.children[0].hasAttribute('colspan')) row.children[0].innerText = row.children[0].innerText;
                                    });
                                } else {
                                    alert('刪除失敗：' + (data.msg || ''));
                                }
                            });
                        }
                    };
                }
            });
        }
        // 頁面載入時立即綁定
        bindTableRowButtons();
    </script>
</body>
</html>
<?php } ?>
