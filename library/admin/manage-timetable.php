
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
    <title>管理老師課表</title>
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
                <h4 class="header-line">管理老師課表</h4>
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
                        老師課表列表
                        <div class="pull-right">
                            <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                            <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                            <form id="addTimetableForm" class="form-inline">
                                <div class="form-group">
                                    <label for="teacher_id">老師編號</label>
                                    <input type="text" class="form-control" id="teacher_id" name="老師編號" required>
                                </div>
                                <div class="form-group">
                                    <label for="class_time">上課時間</label>
                                    <input type="text" class="form-control" id="class_time" name="上課時間" required>
                                </div>
                                <div class="form-group">
                                    <label for="classroom">上課教室</label>
                                    <input type="text" class="form-control" id="classroom" name="上課教室" required>
                                </div>
                                <button type="submit" class="btn btn-primary">儲存</button>
                                <button type="button" class="btn btn-default" id="cancelAddForm">取消</button>
                            </form>
                        </div>
                        <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                            <form id="searchTimetableForm" class="form-inline">
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
                            <table class="table table-striped table-bordered table-hover" id="timetableTable">
                                <thead>
                                    <tr>
                                        <th>老師編號</th>
                                        <th>上課時間</th>
                                        <th>上課教室</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody id="timetableTbody">
                                <?php
                                $stmt = $dbh->query("SELECT * FROM 老師課表");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($rows) > 0) {
                                    foreach ($rows as $row) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['上課時間']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['上課教室']) . '</td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                        echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4" class="text-center">請使用上方按鈕新增、查詢老師課表資料</td></tr>';
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
    document.getElementById('addTimetableForm').reset();
    document.getElementById('addTimetableForm').removeAttribute('data-editing');
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
function bindTableRowButtons() {
    var tbody = document.getElementById('timetableTbody');
    Array.from(tbody.children).forEach(function(tr) {
        var editBtn = tr.querySelector('.edit-btn');
        var deleteBtn = tr.querySelector('.delete-btn');
        if (editBtn) {
            editBtn.onclick = function() {
                var tds = tr.getElementsByTagName('td');
                document.getElementById('teacher_id').value = tds[0].innerText;
                document.getElementById('class_time').value = tds[1].innerText;
                document.getElementById('classroom').value = tds[2].innerText;
                document.getElementById('addFormContainer').style.display = 'block';
                document.getElementById('showAddForm').style.display = 'none';
                document.getElementById('addTimetableForm').setAttribute('data-editing', 'true');
                document.getElementById('addTimetableForm').setAttribute('data-old-teacher-id', tds[0].innerText);
                document.getElementById('addTimetableForm').setAttribute('data-old-class-time', tds[1].innerText);
            };
        }
        if (deleteBtn) {
            deleteBtn.onclick = function() {
                if(confirm('確定要刪除這筆課表資料嗎？')) {
                    var teacherId = tr.cells[0].innerText;
                    var classTime = tr.cells[1].innerText;
                    var formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('老師編號', teacherId);
                    formData.append('上課時間', classTime);
                    fetch('manage-timetable-api.php', {
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
var addForm = document.getElementById('addTimetableForm');
addForm.onsubmit = function(e) {
    e.preventDefault();
    var teacherId = document.getElementById('teacher_id').value;
    var classTime = document.getElementById('class_time').value;
    var classroom = document.getElementById('classroom').value;
    var isEditing = addForm.getAttribute('data-editing') === 'true';
    var formData = new FormData();
    formData.append('老師編號', teacherId);
    formData.append('上課時間', classTime);
    formData.append('上課教室', classroom);
    if (isEditing) {
        formData.append('action', 'edit');
        formData.append('old_老師編號', addForm.getAttribute('data-old-teacher-id'));
        formData.append('old_上課時間', addForm.getAttribute('data-old-class-time'));
    } else {
        formData.append('action', 'add');
    }
    fetch('manage-timetable-api.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(isEditing ? '修改成功！' : '新增成功！');
            addForm.reset();
            addForm.removeAttribute('data-editing');
            addForm.removeAttribute('data-old-teacher-id');
            addForm.removeAttribute('data-old-class-time');
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
            location.reload();
        } else {
            alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || ''));
        }
    });
};
document.getElementById('searchTimetableForm').onsubmit = function(e) {
    e.preventDefault();
    var searchTeacherId = document.getElementById('search_teacher_id').value.trim();
    var rows = document.querySelectorAll('#timetableTbody tr');
    var found = false;
    var resultHtml = '';
    rows.forEach(function(row) {
        row.classList.remove('search-highlight');
        Array.from(row.children).forEach(function(td) { td.style.backgroundColor = ''; });
    });
    for (var i = 0; i < rows.length; i++) {
        var tds = rows[i].getElementsByTagName('td');
        if (tds.length && tds[0].innerText === searchTeacherId) {
            found = true;
            rows[i].scrollIntoView({behavior: 'smooth', block: 'center'});
            rows[i].classList.add('search-highlight');
            Array.from(tds).forEach(function(td) { td.style.backgroundColor = '#ffe066'; });
            setTimeout(function(row, tds){
                row.classList.remove('search-highlight');
                Array.from(tds).forEach(function(td) { td.style.backgroundColor = ''; });
            }, 2000, rows[i], tds);
            resultHtml = '<div class="alert alert-success">找到課表記錄：<br>' +
                '老師編號: ' + tds[0].innerText + '<br>' +
                '上課時間: ' + tds[1].innerText + '<br>' +
                '上課教室: ' + tds[2].innerText + '</div>';
            break;
        }
    }
    if (!found) {
        resultHtml = '<div class="alert alert-danger">查無此課表記錄</div>';
    }
    document.getElementById('searchResult').innerHTML = resultHtml;
};
</script>
</body>
</html>
<?php } ?>
