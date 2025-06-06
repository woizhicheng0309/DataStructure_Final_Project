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
    <title>管理老師校外經歷</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .search-highlight td { background-color: #ffe066 !important; }
    </style>
</head>
<body>
    <?php include('../includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">管理老師校外經歷</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            校外經歷列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addExperienceForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="teacher_id">老師編號</label>
                                        <input type="text" class="form-control" id="teacher_id" name="老師編號" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_name">機構名稱</label>
                                        <input type="text" class="form-control" id="organization_name" name="機構名稱" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">職位</label>
                                        <input type="text" class="form-control" id="position" name="職位" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" class="btn btn-default" id="cancelAddForm">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchExperienceForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_teacher_id">老師編號</label>
                                        <input type="text" class="form-control" id="search_teacher_id" name="search_teacher_id">
                                    </div>
                                    <button type="submit" class="btn btn-info">查詢</button>
                                    <button type="button" class="btn btn-default" id="cancelSearchForm">取消</button>
                                </form>
                                <div id="searchResult" style="margin-top:10px;"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="experiencesTable">
                                    <thead>
                                        <tr>
                                            <th>老師編號</th>
                                            <th>機構名稱</th>
                                            <th>職位</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="experiencesTbody">
                                        <?php
                                        $stmt = $dbh->query("SELECT * FROM 老師校外經歷 ORDER BY 老師編號, 機構名稱");
                                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($rows) > 0) {
                                            foreach ($rows as $row) {
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['機構名稱']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['職位']) . '</td>';
                                                echo '<td>';
                                                echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                                echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<tr><td colspan="4" class="text-center">請使用上方按鈕新增、查詢經歷資料</td></tr>';
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
    // --- Form Visibility Toggles ---
    document.getElementById('showAddForm').onclick = function() {
        document.getElementById('addFormContainer').style.display = 'block';
        this.style.display = 'none';
    };
    document.getElementById('cancelAddForm').onclick = function() {
        const form = document.getElementById('addExperienceForm');
        document.getElementById('addFormContainer').style.display = 'none';
        document.getElementById('showAddForm').style.display = 'inline-block';
        form.reset();
        form.removeAttribute('data-editing');
        form.removeAttribute('data-old-teacher-id');
        form.removeAttribute('data-old-organization-name');
    };
    document.getElementById('showSearchForm').onclick = function() {
        document.getElementById('searchFormContainer').style.display = 'block';
        this.style.display = 'none';
        document.getElementById('showAddForm').style.display = 'inline-block';
    };
    document.getElementById('cancelSearchForm').onclick = function() {
        document.getElementById('searchFormContainer').style.display = 'none';
        document.getElementById('showSearchForm').style.display = 'inline-block';
        document.getElementById('searchResult').innerHTML = '';
    };

    // --- Bind Edit and Delete buttons on table rows ---
    function bindTableRowButtons() {
        const tbody = document.getElementById('experiencesTbody');
        Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
            const editBtn = tr.querySelector('.edit-btn');
            const deleteBtn = tr.querySelector('.delete-btn');
            
            if (editBtn) {
                editBtn.onclick = function() {
                    const tds = tr.getElementsByTagName('td');
                    const teacherId = tds[0].innerText;
                    const orgName = tds[1].innerText;
                    const position = tds[2].innerText;
                    
                    const form = document.getElementById('addExperienceForm');
                    document.getElementById('teacher_id').value = teacherId;
                    document.getElementById('organization_name').value = orgName;
                    document.getElementById('position').value = position;
                    
                    form.setAttribute('data-editing', 'true');
                    form.setAttribute('data-old-teacher-id', teacherId);
                    form.setAttribute('data-old-organization-name', orgName);
                    
                    document.getElementById('addFormContainer').style.display = 'block';
                    document.getElementById('showAddForm').style.display = 'none';
                };
            }

            if (deleteBtn) {
                deleteBtn.onclick = function() {
                    if (confirm('確定要刪除這筆經歷嗎？')) {
                        const teacherId = tr.cells[0].innerText;
                        const orgName = tr.cells[1].innerText;
                        
                        const formData = new FormData();
                        formData.append('action', 'delete');
                        formData.append('老師編號', teacherId);
                        formData.append('機構名稱', orgName);
                        
                        fetch('manage-external-experiences-api.php', { method: 'POST', body: formData })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert('刪除成功！');
                                tr.remove();
                            } else {
                                alert('刪除失敗：' + (data.msg || '未知錯誤'));
                            }
                        });
                    }
                };
            }
        });
    }
    bindTableRowButtons(); // Bind for existing rows

    // --- Handle Add/Edit Form Submission ---
    const addForm = document.getElementById('addExperienceForm');
    addForm.onsubmit = function(e) {
        e.preventDefault();
        const isEditing = addForm.getAttribute('data-editing') === 'true';
        const formData = new FormData(addForm);
        
        if (isEditing) {
            formData.append('action', 'edit');
            formData.append('old_老師編號', addForm.getAttribute('data-old-teacher-id'));
            formData.append('old_機構名稱', addForm.getAttribute('data-old-organization-name'));
        } else {
            formData.append('action', 'add');
        }

        fetch('manage-external-experiences-api.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert(isEditing ? '修改成功！' : '新增成功！');
                location.reload(); // Easiest way to show updated table
            } else {
                alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || '未知錯誤'));
            }
        });
    };

    // --- Handle Search Form Submission (Client-Side) ---
    document.getElementById('searchExperienceForm').onsubmit = function(e) {
        e.preventDefault();
        const searchId = document.getElementById('search_teacher_id').value.trim();
        const rows = document.querySelectorAll('#experiencesTbody tr');
        let found = false;
        let resultHtml = '';
        
        rows.forEach(row => {
            row.classList.remove('search-highlight');
        });

        if (!searchId) return;

        for (let row of rows) {
            const tds = row.getElementsByTagName('td');
            if (tds.length && tds[0].innerText.includes(searchId)) {
                found = true;
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.classList.add('search-highlight');
                
                setTimeout(() => {
                    row.classList.remove('search-highlight');
                }, 2500);
            }
        }
        
        if (found) {
            resultHtml = `<div class="alert alert-success">找到老師編號: ${searchId}</div>`;
        } else {
            resultHtml = `<div class="alert alert-danger">未找到老師編號: ${searchId}</div>`;
        }
        document.getElementById('searchResult').innerHTML = resultHtml;
    };
    </script>
</body>
</html>
<?php } ?>