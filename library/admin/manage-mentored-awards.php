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
    <title>管理學生參賽</title>
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
                    <h4 class="header-line">管理學生參賽</h4>
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
                            學生參賽列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addStudentForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="team_id">隊伍編號:</label>
                                        <input type="text" class="form-control" id="team_id" name="team_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="member_id">組員學號:</label>
                                        <input type="text" class="form-control" id="member_id" name="member_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_id">老師編號:</label>
                                        <input type="text" class="form-control" id="teacher_id" name="teacher_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="award_id">獲獎記錄編號:</label>
                                        <input type="text" class="form-control" id="award_id" name="award_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="competition_name">比賽名字:</label>
                                        <input type="text" class="form-control" id="competition_name" name="competition_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">參賽類別:</label>
                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" id="cancelAddForm" class="btn btn-default">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchStudentForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_team_id">隊伍編號:</label>
                                        <input type="text" class="form-control" id="search_team_id" name="search_team_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="search_teacher_id">老師編號:</label>
                                        <input type="text" class="form-control" id="search_teacher_id" name="search_teacher_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="search_award_id">獲獎記錄編號:</label>
                                        <input type="text" class="form-control" id="search_award_id" name="search_award_id">
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
                                            <th>隊伍編號</th>
                                            <th>組員學號</th>
                                            <th>老師編號</th>
                                            <th>獲獎記錄編號</th>
                                            <th>比賽名字</th>
                                            <th>參賽類別</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTbody">
                                    <?php
                                    // 查詢所有學生參賽資料
                                    $stmt = $dbh->query("SELECT * FROM 學生參賽");
                                    $awards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($awards) > 0) {
                                        foreach ($awards as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['隊伍編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['組員學號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['獲獎記錄編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['比賽名字']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['參賽類別']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center">請使用上方按鈕新增、查詢學生參賽資料</td></tr>';
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                            document.getElementById('team_id').value = tds[0].innerText;
                            document.getElementById('member_id').value = tds[1].innerText;
                            document.getElementById('teacher_id').value = tds[2].innerText;
                            document.getElementById('award_id').value = tds[3].innerText;
                            document.getElementById('competition_name').value = tds[4].innerText;
                            document.getElementById('category').value = tds[5].innerText;
                            document.getElementById('addFormContainer').style.display = 'block';
                            document.getElementById('showAddForm').style.display = 'none';
                            document.getElementById('addStudentForm').setAttribute('data-editing', 'true');
                            document.getElementById('addStudentForm').setAttribute('data-edit-index', tr.rowIndex);
                        };
                    }
                    if (deleteBtn) {
                        deleteBtn.onclick = function() {
                            if(confirm('確定要刪除這筆學生參賽資料嗎？')) {
                                var teamId = tr.cells[0].innerText;
                                var memberId = tr.cells[1].innerText;
                                var formData = new FormData();
                                formData.append('action', 'delete');
                                formData.append('team_id', teamId);
                                formData.append('member_id', memberId);
                                fetch('./manage-mentored-awards-api.php', {
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
                                })
                                .catch(err => {
                                    alert('網路或伺服器錯誤：' + err);
                                });
                            }
                        };
                    }
                });
            }
            bindTableRowButtons();

            // 新增/修改學生參賽資料時同步資料庫
            var addForm = document.getElementById('addStudentForm');
            addForm.onsubmit = function(e) {
                e.preventDefault();
                var teamId = document.getElementById('team_id').value;
                var memberId = document.getElementById('member_id').value;
                var teacherId = document.getElementById('teacher_id').value;
                var awardId = document.getElementById('award_id').value;
                var competitionName = document.getElementById('competition_name').value;
                var category = document.getElementById('category').value;
                var isEditing = addForm.getAttribute('data-editing') === 'true';
                var formData = new FormData();
                formData.append('team_id', teamId);
                formData.append('member_id', memberId);
                formData.append('teacher_id', teacherId);
                formData.append('award_id', awardId);
                formData.append('competition_name', competitionName);
                formData.append('category', category);
                formData.append('action', isEditing ? 'edit' : 'add');
                fetch('./manage-mentored-awards-api.php', {
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
                        alert((isEditing ? '修改失敗: ' : '新增失敗: ') + (data.msg || '') + '\n' + (data.errorInfo ? JSON.stringify(data.errorInfo) : ''));
                    }
                })
                .catch(err => {
                    alert('網路或伺服器錯誤：' + err);
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

            // 查詢學生參賽功能 (僅查詢本頁已新增的資料)
            document.getElementById('searchStudentForm').onsubmit = function(e) {
                e.preventDefault();
                var searchTeamId = document.getElementById('search_team_id').value.trim();
                var searchTeacherId = document.getElementById('search_teacher_id').value.trim();
                var searchAwardId = document.getElementById('search_award_id').value.trim();
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
                    if (tds.length && (
                        (searchTeamId && tds[0].innerText === searchTeamId) ||
                        (searchTeacherId && tds[2].innerText === searchTeacherId) ||
                        (searchAwardId && tds[3].innerText === searchAwardId)
                    )) {
                        found = true;
                        // 滾動到該學生參賽資料列
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
                        resultHtml = '<div class="alert alert-success">找到學生參賽記錄：<br>' +
                            '隊伍編號: ' + tds[0].innerText + '<br>' +
                            '組員學號: ' + tds[1].innerText + '<br>' +
                            '老師編號: ' + tds[2].innerText + '<br>' +
                            '獲獎記錄編號: ' + tds[3].innerText + '<br>' +
                            '比賽名字: ' + tds[4].innerText + '<br>' +
                            '參賽類別: ' + tds[5].innerText + '</div>';
                        break;
                    }
                }
                if (!found) {
                    resultHtml = '<div class="alert alert-danger">該參賽記錄不存在</div>';
                }
                document.getElementById('searchResult').innerHTML = resultHtml;
            };
        });
    </script>
</body>
</html>
<?php } ?>
