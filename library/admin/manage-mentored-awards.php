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
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
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
                                <form id="addStudentForm" class="form-inline" method="post" action="">
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
                                        <tr>
                                            <td colspan="7" class="text-center">請使用上方按鈕新增、查詢學生參賽資料</td>
                                        </tr>
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
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <script>
        document.getElementById('showAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancelAddForm').onclick = function() {
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
        };

        // 修改功能腳本
        function createEditButton(tr) {
            var btn = document.createElement('button');
            btn.className = 'btn btn-primary btn-xs edit-btn';
            btn.style.marginRight = '8px'; // 增加右側間距
            btn.innerHTML = '<i class="fa fa-edit"></i> 修改';
            btn.onclick = function() {
                // 取得目前資料
                var tds = tr.getElementsByTagName('td');
                var teamId = tds[0].innerText;
                var memberId = tds[1].innerText;
                var teacherId = tds[2].innerText;
                var awardId = tds[3].innerText;
                var competitionName = tds[4].innerText;
                var category = tds[5].innerText;
                // 將資料填入表單
                document.getElementById('team_id').value = teamId;
                document.getElementById('member_id').value = memberId;
                document.getElementById('teacher_id').value = teacherId;
                document.getElementById('award_id').value = awardId;
                document.getElementById('competition_name').value = competitionName;
                document.getElementById('category').value = category;
                document.getElementById('addFormContainer').style.display = 'block';
                document.getElementById('showAddForm').style.display = 'none';
                // 編輯狀態標記
                document.getElementById('addStudentForm').setAttribute('data-editing', 'true');
                document.getElementById('addStudentForm').setAttribute('data-edit-index', tr.rowIndex);
            };
            return btn;
        }

        // 刪除功能腳本
        function createDeleteButton(tr) {
            var btn = document.createElement('button');
            btn.className = 'btn btn-danger btn-xs delete-btn';
            btn.style.marginLeft = '0px';
            btn.innerHTML = '<i class="fa fa-trash-o"></i> 刪除'; // 改用舊版垃圾桶圖示
            btn.onclick = function() {
                if(confirm('確定要刪除這位學生參賽資料嗎？')) {
                    tr.parentNode.removeChild(tr);
                    // 重新編號
                    var tbody = document.getElementById('studentsTbody');
                    Array.from(tbody.children).forEach(function(row, idx) {
                        if(row.children.length && !row.children[0].hasAttribute('colspan')) row.children[0].innerText = idx+1;
                    });
                }
            };
            return btn;
        }

        // 新增學生參賽資料並即時顯示在表格
        var addForm = document.getElementById('addStudentForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var teamId = document.getElementById('team_id').value;
            var memberId = document.getElementById('member_id').value;
            var teacherId = document.getElementById('teacher_id').value;
            var awardId = document.getElementById('award_id').value;
            var competitionName = document.getElementById('competition_name').value;
            var category = document.getElementById('category').value;
            var tbody = document.getElementById('studentsTbody');
            // 編輯狀態
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            var editIndex = addForm.getAttribute('data-edit-index');
            if(isEditing && editIndex) {
                // 修改現有列
                var tr = tbody.rows[editIndex-1];
                tr.cells[0].innerText = teamId;
                tr.cells[1].innerText = memberId;
                tr.cells[2].innerText = teacherId;
                tr.cells[3].innerText = awardId;
                tr.cells[4].innerText = competitionName;
                tr.cells[5].innerText = category;
                // 重建操作欄
                var actionTd = tr.cells[6];
                actionTd.innerHTML = '';
                actionTd.appendChild(createEditButton(tr));
                actionTd.appendChild(createDeleteButton(tr));
                // 清除編輯狀態
                addForm.removeAttribute('data-editing');
                addForm.removeAttribute('data-edit-index');
            } else {
                // 移除預設提示列
                var defaultRow = document.querySelector('#studentsTbody tr td[colspan]');
                if(defaultRow) tbody.removeChild(defaultRow.parentNode);
                // 新增資料列
                var tr = document.createElement('tr');
                tr.innerHTML = '<td>' + teamId + '</td>' +
                               '<td>' + memberId + '</td>' +
                               '<td>' + teacherId + '</td>' +
                               '<td>' + awardId + '</td>' +
                               '<td>' + competitionName + '</td>' +
                               '<td>' + category + '</td>' +
                               '<td></td>';
                // 加入修改按鈕
                tr.cells[6].appendChild(createEditButton(tr));
                tr.cells[6].appendChild(createDeleteButton(tr));
                tbody.appendChild(tr);
            }
            // 重新編號
            Array.from(tbody.children).forEach(function(row, idx) {
                if(row.children.length && !row.children[0].hasAttribute('colspan')) row.children[0].innerText = idx+1;
            });
            // 清空表單並隱藏
            this.reset();
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
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
    </script>
</body>
</html>
<?php } ?>
