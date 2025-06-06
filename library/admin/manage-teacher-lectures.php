<?php
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0) 
{   
    header('location:index.php');
}
else{
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>管理老師演講</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .search-highlight td {
            background-color: #ffe066 !important;
        }
    </style>
</head>
<body>
    <?php include('../includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">管理老師演講</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            老師演講列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addLectureForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="teacher_id">老師編號</label>
                                        <input type="text" class="form-control" id="teacher_id" name="老師編號" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lecture_name">演講名稱</label>
                                        <input type="text" class="form-control" id="lecture_name" name="演講名稱" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">地點</label>
                                        <input type="text" class="form-control" id="location" name="地點" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">日期</label>
                                        <input type="date" class="form-control" id="date" name="日期" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchLectureForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_teacher_id">老師編號:</label>
                                        <input type="text" class="form-control" id="search_teacher_id" name="search_teacher_id" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">查詢</button>
                                    <button type="button" id="cancelSearchForm" class="btn btn-default">取消</button>
                                </form>
                                <div id="searchResult" style="margin-top:10px;"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="lectureTable">
                                    <thead>
                                        <tr>
                                            <th>老師編號</th>
                                            <th>演講名稱</th>
                                            <th>地點</th>
                                            <th>日期</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lectureTbody">
                                    <?php
                                    // 假設演講資料表名稱為 '老師演講'
                                    $stmt = $dbh->query("SELECT * FROM 老師演講");
                                    $lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($lectures) > 0) {
                                        foreach ($lectures as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['演講名稱']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['地點']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['日期']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center">請使用上方按鈕新增、查詢演講資料</td></tr>';
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
    <?php include('../includes/footer.php');?>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
    <script>
        document.getElementById('showAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancelAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
            document.getElementById('addLectureForm').reset();
            document.getElementById('addLectureForm').removeAttribute('data-editing');
        };

        document.getElementById('showSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancelSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'none';
            document.getElementById('showSearchForm').style.display = 'inline-block';
        };

        var addForm = document.getElementById('addLectureForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var formData = new FormData(addForm);
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            
            var action = isEditing ? 'edit' : 'add';
            formData.append('action', action);

            if (isEditing) {
                formData.append('old_老師編號', addForm.getAttribute('data-old-teacher-id'));
                formData.append('old_演講名稱', addForm.getAttribute('data-old-lecture-name'));
            }

            fetch('manage-teacher-lectures-api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(isEditing ? '修改成功！' : '新增成功！');
                    location.reload(); 
                } else {
                    alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || '未知錯誤'));
                }
            });
        };

        document.getElementById('searchLectureForm').onsubmit = function(e) {
            e.preventDefault();
            var searchId = document.getElementById('search_teacher_id').value.trim();
            var rows = document.querySelectorAll('#lectureTbody tr');
            var found = false;
            var resultHtml = '';
            
            rows.forEach(function(row) {
                row.classList.remove('search-highlight');
            });

            for (var i = 0; i < rows.length; i++) {
                var tds = rows[i].getElementsByTagName('td');
                if (tds.length && tds[0].innerText === searchId) {
                    found = true;
                    rows[i].scrollIntoView({behavior: 'smooth', block: 'center'});
                    rows[i].classList.add('search-highlight');
                    setTimeout(function(row) {
                        row.classList.remove('search-highlight');
                    }, 2000, rows[i]);
                    // 只需高亮，不顯示額外訊息，保持與 student 頁面一致
                }
            }

            if (!found) {
                document.getElementById('searchResult').innerHTML = '<div class="alert alert-danger">查無此老師的演講記錄</div>';
            } else {
                 document.getElementById('searchResult').innerHTML = '<div class="alert alert-success">已高亮顯示搜尋結果</div>';
            }
        };

        function bindTableRowButtons() {
            var tbody = document.getElementById('lectureTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        document.getElementById('teacher_id').value = tds[0].innerText;
                        document.getElementById('lecture_name').value = tds[1].innerText;
                        document.getElementById('location').value = tds[2].innerText;
                        document.getElementById('date').value = tds[3].innerText;
                        
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        
                        addForm.setAttribute('data-editing', 'true');
                        addForm.setAttribute('data-old-teacher-id', tds[0].innerText);
                        addForm.setAttribute('data-old-lecture-name', tds[1].innerText);
                    };
                }

                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if (confirm('確定要刪除這筆演講資料嗎？')) {
                            var tds = tr.getElementsByTagName('td');
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('老師編號', tds[0].innerText);
                            formData.append('演講名稱', tds[1].innerText); // 假設組合主鍵

                            fetch('manage-teacher-lectures-api.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('刪除成功！');
                                    tr.parentNode.removeChild(tr);
                                } else {
                                    alert('刪除失敗：' + (data.msg || '未知錯誤'));
                                }
                            });
                        }
                    };
                }
            });
        }
        
        bindTableRowButtons();
    </script>
</body>
</html>
<?php } ?>