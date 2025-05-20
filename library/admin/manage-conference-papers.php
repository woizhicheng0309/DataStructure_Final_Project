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
    <title>管理會議論文</title>
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
                <h4 class="header-line">管理會議論文</h4>
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
                        會議論文列表
                        <div class="pull-right">
                            <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                            <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                            <form id="addConferencePaperForm" class="form-inline">
                                <div class="form-group">
                                    <label for="paper_id">論文標號</label>
                                    <input type="text" class="form-control" id="paper_id" name="論文標號" required>
                                </div>
                                <div class="form-group">
                                    <label for="conference_name">會議名稱</label>
                                    <input type="text" class="form-control" id="conference_name" name="會議名稱" required>
                                </div>
                                <div class="form-group">
                                    <label for="conference_location">會議地點</label>
                                    <input type="text" class="form-control" id="conference_location" name="會議地點" required>
                                </div>
                                <div class="form-group">
                                    <label for="publish_date">發佈日期</label>
                                    <input type="date" class="form-control" id="publish_date" name="發佈日期" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">作者</label>
                                    <input type="text" class="form-control" id="author" name="作者" required>
                                </div>
                                <button type="submit" class="btn btn-primary">儲存</button>
                                <button type="button" class="btn btn-default" id="cancelAddForm">取消</button>
                            </form>
                        </div>
                        <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                            <form id="searchConferencePaperForm" class="form-inline">
                                <div class="form-group">
                                    <label for="search_paper_id">論文標號</label>
                                    <input type="text" class="form-control" id="search_paper_id" name="search_paper_id">
                                </div>
                                <button type="submit" class="btn btn-info">查詢</button>
                                <button type="button" class="btn btn-default" id="cancelSearchForm">取消</button>
                            </form>
                            <div id="searchResult" style="margin-top:10px;"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="conferencePapersTable">
                                <thead>
                                    <tr>
                                        <th>論文標號</th>
                                        <th>會議名稱</th>
                                        <th>會議地點</th>
                                        <th>發佈日期</th>
                                        <th>作者</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody id="conferencePapersTbody">
                                <?php
                                $stmt = $dbh->query("SELECT * FROM 會議論文");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($rows) > 0) {
                                    foreach ($rows as $row) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['論文標號']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['會議名稱']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['會議地點']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['發佈日期']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['作者']) . '</td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                        echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">請使用上方按鈕新增、查詢會議論文資料</td></tr>';
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
    document.getElementById('addConferencePaperForm').reset();
    document.getElementById('addConferencePaperForm').removeAttribute('data-editing');
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
    var tbody = document.getElementById('conferencePapersTbody');
    Array.from(tbody.children).forEach(function(tr) {
        var editBtn = tr.querySelector('.edit-btn');
        var deleteBtn = tr.querySelector('.delete-btn');
        if (editBtn) {
            editBtn.onclick = function() {
                var tds = tr.getElementsByTagName('td');
                document.getElementById('paper_id').value = tds[0].innerText;
                document.getElementById('conference_name').value = tds[1].innerText;
                document.getElementById('conference_location').value = tds[2].innerText;
                document.getElementById('publish_date').value = tds[3].innerText;
                document.getElementById('author').value = tds[4].innerText;
                document.getElementById('addFormContainer').style.display = 'block';
                document.getElementById('showAddForm').style.display = 'none';
                document.getElementById('addConferencePaperForm').setAttribute('data-editing', 'true');
                document.getElementById('addConferencePaperForm').setAttribute('data-old-paper-id', tds[0].innerText);
            };
        }
        if (deleteBtn) {
            deleteBtn.onclick = function() {
                if(confirm('確定要刪除這筆會議論文資料嗎？')) {
                    var paperId = tr.cells[0].innerText;
                    var formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('論文標號', paperId);
                    fetch('manage-conference-papers-api.php', {
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
var addForm = document.getElementById('addConferencePaperForm');
addForm.onsubmit = function(e) {
    e.preventDefault();
    var paperId = document.getElementById('paper_id').value;
    var conferenceName = document.getElementById('conference_name').value;
    var conferenceLocation = document.getElementById('conference_location').value;
    var publishDate = document.getElementById('publish_date').value;
    var author = document.getElementById('author').value;
    var isEditing = addForm.getAttribute('data-editing') === 'true';
    var formData = new FormData();
    formData.append('論文標號', paperId);
    formData.append('會議名稱', conferenceName);
    formData.append('會議地點', conferenceLocation);
    formData.append('發佈日期', publishDate);
    formData.append('作者', author);
    if (isEditing) {
        formData.append('action', 'edit');
        formData.append('old_論文標號', addForm.getAttribute('data-old-paper-id'));
    } else {
        formData.append('action', 'add');
    }
    fetch('manage-conference-papers-api.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(isEditing ? '修改成功！' : '新增成功！');
            addForm.reset();
            addForm.removeAttribute('data-editing');
            addForm.removeAttribute('data-old-paper-id');
            document.getElementById('addFormContainer').style.display = 'none';
            document.getElementById('showAddForm').style.display = 'inline-block';
            location.reload();
        } else {
            alert((isEditing ? '修改' : '新增') + '失敗：' + (data.msg || ''));
        }
    });
};
document.getElementById('searchConferencePaperForm').onsubmit = function(e) {
    e.preventDefault();
    var searchPaperId = document.getElementById('search_paper_id').value.trim();
    var rows = document.querySelectorAll('#conferencePapersTbody tr');
    var found = false;
    var resultHtml = '';
    rows.forEach(function(row) {
        row.classList.remove('search-highlight');
        Array.from(row.children).forEach(function(td) { td.style.backgroundColor = ''; });
    });
    for (var i = 0; i < rows.length; i++) {
        var tds = rows[i].getElementsByTagName('td');
        if (tds.length && tds[0].innerText === searchPaperId) {
            found = true;
            rows[i].scrollIntoView({behavior: 'smooth', block: 'center'});
            rows[i].classList.add('search-highlight');
            Array.from(tds).forEach(function(td) { td.style.backgroundColor = '#ffe066'; });
            setTimeout(function(row, tds){
                row.classList.remove('search-highlight');
                Array.from(tds).forEach(function(td) { td.style.backgroundColor = ''; });
            }, 2000, rows[i], tds);
            resultHtml = '<div class="alert alert-success">找到會議論文：<br>' +
                '論文標號: ' + tds[0].innerText + '<br>' +
                '會議名稱: ' + tds[1].innerText + '<br>' +
                '會議地點: ' + tds[2].innerText + '<br>' +
                '發佈日期: ' + tds[3].innerText + '<br>' +
                '作者: ' + tds[4].innerText + '</div>';
            break;
        }
    }
    if (!found) {
        resultHtml = '<div class="alert alert-danger">查無此會議論文記錄</div>';
    }
    document.getElementById('searchResult').innerHTML = resultHtml;
};
</script>
</body>
</html>
<?php } ?>
