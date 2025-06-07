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
    <title>管理老師校內經歷</title>
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
                    <h4 class="header-line">管理老師校內經歷</h4>
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
                            老師校內經歷管理
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addExperienceForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="teacherId">老師編號:</label>
                                        <input type="text" class="form-control" id="teacherId" name="teacherId" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="department">部門:</label>
                                        <input type="text" class="form-control" id="department" name="department" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">職位:</label>
                                        <input type="text" class="form-control" id="position" name="position" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchExperienceForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_teacher_id">老師編號:</label>
                                        <input type="text" class="form-control" id="search_teacher_id" name="search_teacher_id">
                                    </div>
                                    <button type="submit" class="btn btn-primary">查詢</button>
                                    <button type="button" id="cancelSearchForm" class="btn btn-default">取消</button>
                                </form>
                                <div id="searchResult" style="margin-top:10px;"></div>
                            </div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>老師編號</th>
                                        <th>部門</th>
                                        <th>職位</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody id="experiencesTbody">
                                    <!-- 動態生成資料列 -->
                                </tbody>
                            </table>
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

        var addForm = document.getElementById('addExperienceForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var teacherId = document.getElementById('teacherId').value;
            var department = document.getElementById('department').value;
            var position = document.getElementById('position').value;
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            var formData = new FormData();
            formData.append('teacherId', teacherId);
            formData.append('department', department);
            formData.append('position', position);
            formData.append('action', isEditing ? 'edit' : 'add');
            fetch('manage-internal-experiences-api.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(isEditing ? '修改成功！' : '新增成功！');
                    addForm.reset();
                    addForm.removeAttribute('data-editing');
                    document.getElementById('addFormContainer').style.display = 'none';
                    document.getElementById('showAddForm').style.display = 'inline-block';
                    location.reload();
                } else {
                    alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || ''));
                }
            });
        };

        function bindTableRowButtons() {
            var tbody = document.getElementById('experiencesTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        document.getElementById('teacherId').value = tds[0].innerText;
                        document.getElementById('department').value = tds[1].innerText;
                        document.getElementById('position').value = tds[2].innerText;
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        addForm.setAttribute('data-editing', 'true');
                    };
                }
                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if(confirm('確定要刪除這項經歷嗎？')) {
                            var teacherId = tr.cells[0].innerText;
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('teacherId', teacherId);
                            fetch('manage-internal-experiences-api.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert('刪除成功！');
                                    tr.parentNode.removeChild(tr);
                                    var tbody = document.getElementById('experiencesTbody');
                                    Array.from(tbody.children).forEach(function(row, idx) {
                                        if(row.children.length && !row.children[0].hasAttribute('colspan')) row.children[0].innerText = idx+1;
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
        bindTableRowButtons();
    </script>
</body>
</html>
<?php } ?>
