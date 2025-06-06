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
    <title>管理老師計劃</title>
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
                    <h4 class="header-line">管理老師計劃</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            老師計劃列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addPlanForm" class="form-inline">
                                    <div class="form-group">
                                        <label>計劃編號</label>
                                        <input type="text" class="form-control" id="plan_id" name="計劃編號" required>
                                    </div>
                                    <div class="form-group">
                                        <label>分類</label>
                                        <input type="text" class="form-control" id="category" name="分類" required>
                                    </div>
                                    <div class="form-group">
                                        <label>研究主題</label>
                                        <input type="text" class="form-control" id="topic" name="研究主題" required>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                        <label>開始日期</label>
                                        <input type="date" class="form-control" id="start_date" name="研究開始日期" required>
                                    </div>
                                    <div class="form-group">
                                        <label>結束日期</label>
                                        <input type="date" class="form-control" id="end_date" name="研究結束日期" required>
                                    </div>
                                    <div class="form-group">
                                        <label>資助機構</label>
                                        <input type="text" class="form-control" id="institution" name="資助機構" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchPlanForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_plan_id">計劃編號:</label>
                                        <input type="text" class="form-control" id="search_plan_id" name="search_plan_id" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">查詢</button>
                                    <button type="button" id="cancelSearchForm" class="btn btn-default">取消</button>
                                </form>
                                <div id="searchResult" style="margin-top:10px;"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="teacherPlansTable">
                                    <thead>
                                        <tr>
                                            <th>計劃編號</th>
                                            <th>分類</th>
                                            <th>研究主題</th>
                                            <th>研究開始日期</th>
                                            <th>研究結束日期</th>
                                            <th>資助機構</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="teacherPlansTbody">
                                    <?php
                                    // 假設老師計劃的資料表名稱為 '老師計劃'
                                    $stmt = $dbh->query("SELECT * FROM `老師計劃`");
                                    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($plans) > 0) {
                                        foreach ($plans as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['計劃編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['分類']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['研究主題']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['研究開始日期']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['研究結束日期']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['資助機構']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center">請使用上方按鈕新增、查詢老師計劃資料</td></tr>';
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
            document.getElementById('addPlanForm').reset();
            document.getElementById('addPlanForm').removeAttribute('data-editing');
        };

        document.getElementById('showSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancelSearchForm').onclick = function() {
            document.getElementById('searchFormContainer').style.display = 'none';
            document.getElementById('showSearchForm').style.display = 'inline-block';
        };

        var addForm = document.getElementById('addPlanForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var formData = new FormData(addForm);
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            
            formData.append('action', isEditing ? 'edit' : 'add');

            // 修改時，主鍵是 plan_id，通常不可變更，但為確保API能找到正確記錄，可以傳遞
            // 如果 plan_id 本身可以被修改，則需要傳遞 old_plan_id
            
            fetch('manage-teacher-plans-api.php', {
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

        document.getElementById('searchPlanForm').onsubmit = function(e) {
            e.preventDefault();
            var searchId = document.getElementById('search_plan_id').value.trim();
            var rows = document.querySelectorAll('#teacherPlansTbody tr');
            var found = false;
            
            document.getElementById('searchResult').innerHTML = '';
            rows.forEach(function(row) {
                row.classList.remove('search-highlight');
            });

            if (!searchId) return;

            for (var i = 0; i < rows.length; i++) {
                var tds = rows[i].getElementsByTagName('td');
                if (tds.length && tds[0].innerText === searchId) {
                    found = true;
                    rows[i].scrollIntoView({behavior: 'smooth', block: 'center'});
                    rows[i].classList.add('search-highlight');
                    setTimeout(function(row) {
                        row.classList.remove('search-highlight');
                    }, 2000, rows[i]);
                }
            }

            if (!found) {
                document.getElementById('searchResult').innerHTML = '<div class="alert alert-danger">查無此計劃記錄</div>';
            } else {
                 document.getElementById('searchResult').innerHTML = '<div class="alert alert-success">已高亮顯示搜尋結果</div>';
            }
        };

        function bindTableRowButtons() {
            var tbody = document.getElementById('teacherPlansTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        document.getElementById('plan_id').value = tds[0].innerText;
                        document.getElementById('category').value = tds[1].innerText;
                        document.getElementById('topic').value = tds[2].innerText;
                        document.getElementById('start_date').value = tds[3].innerText;
                        document.getElementById('end_date').value = tds[4].innerText;
                        document.getElementById('institution').value = tds[5].innerText;
                        
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        
                        addForm.setAttribute('data-editing', 'true');
                        // 讓 plan_id 在編輯時不可修改
                        document.getElementById('plan_id').readOnly = true;
                    };
                }

                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if (confirm('確定要刪除這筆計劃資料嗎？')) {
                            var planId = tr.cells[0].innerText;
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('計劃編號', planId);

                            fetch('manage-teacher-plans-api.php', {
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
        
        // 當取消或新增/修改後，恢復 plan_id 的可寫狀態
        document.getElementById('cancelAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
            document.getElementById('addPlanForm').reset();
            addForm.removeAttribute('data-editing');
            document.getElementById('plan_id').readOnly = false;
        };
        document.getElementById('showAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'block';
            this.style.display = 'none';
            document.getElementById('addPlanForm').reset();
            addForm.removeAttribute('data-editing');
            document.getElementById('plan_id').readOnly = false;
        };

        bindTableRowButtons();
    </script>
</body>
</html>
<?php } ?>