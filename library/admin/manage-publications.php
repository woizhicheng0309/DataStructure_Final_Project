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
    <title>管理論文</title>
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
    <?php include('../includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">管理論文</h4>
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
                            論文列表
                            <div class="pull-right">
                                <button id="showAddForm" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增</button>
                                <button id="showSearchForm" class="btn btn-info btn-sm"><i class="fa fa-search"></i> 查詢</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="addFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="addPublicationForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="paper_no">論文標號</label>
                                        <input type="text" class="form-control" id="paper_no" name="論文標號" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="publication_id">論文編號</label>
                                        <input type="text" class="form-control" id="publication_id" name="論文編號" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="publish_date">發表日期</label>
                                        <input type="date" class="form-control" id="publish_date" name="發表日期" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">論文標題</label>
                                        <input type="text" class="form-control" id="title" name="論文標題" required style="width:200px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher_id">老師編號</label>
                                        <input type="text" class="form-control" id="teacher_id" name="老師編號" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">儲存</button>
                                    <button type="button" class="btn btn-default" id="cancelAddForm">取消</button>
                                </form>
                            </div>
                            <div id="searchFormContainer" style="display:none; margin-bottom:20px;">
                                <form id="searchPublicationForm" class="form-inline">
                                    <div class="form-group">
                                        <label for="search_paper_no">論文標號</label>
                                        <input type="text" class="form-control" id="search_paper_no" name="search_paper_no">
                                    </div>
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
                                <table class="table table-striped table-bordered table-hover" id="publicationsTable">
                                    <thead>
                                        <tr>
                                            <th>論文標號</th>
                                            <th>論文編號</th>
                                            <th>發表日期</th>
                                            <th>論文標題</th>
                                            <th>老師編號</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="publicationsTbody">
                                    <?php
                                    // 查詢所有論文資料
                                    $stmt = $dbh->query("SELECT * FROM 論文");
                                    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($publications) > 0) {
                                        foreach ($publications as $row) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['論文標號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['論文編號']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['發表日期']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['論文標題']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['老師編號']) . '</td>';
                                            echo '<td>';
                                            echo '<button class="btn btn-primary btn-xs edit-btn"><i class="fa fa-edit"></i> 修改</button> ';
                                            echo '<button class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center">請使用上方按鈕新增、查詢論文資料</td></tr>';
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
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
    $(document).ready(function() {
        // 新增/修改表單顯示與取消
        $('#showAddForm').click(function() {
            $('#addFormContainer').show();
            $(this).hide();
        });
        $('#cancelAddForm').click(function() {
            $('#addFormContainer').hide();
            $('#showAddForm').show();
            $('#addPublicationForm')[0].reset();
            $('#addPublicationForm').removeAttr('data-editing');
        });

        // 查詢表單顯示與取消
        $('#showSearchForm').click(function() {
            $('#searchFormContainer').show();
            $(this).hide();
            $('#showAddForm').show();
        });
        $('#cancelSearchForm').click(function() {
            $('#searchFormContainer').hide();
            $('#showSearchForm').show();
        });

        // 修改功能腳本（同步更新資料庫）
        function bindTableRowButtons() {
            var tbody = document.getElementById('publicationsTbody');
            Array.from(tbody.children).forEach(function(tr) {
                var editBtn = tr.querySelector('.edit-btn');
                var deleteBtn = tr.querySelector('.delete-btn');
                if (editBtn) {
                    editBtn.onclick = function() {
                        var tds = tr.getElementsByTagName('td');
                        document.getElementById('paper_no').value = tds[0].innerText;
                        document.getElementById('publication_id').value = tds[1].innerText;
                        document.getElementById('publish_date').value = tds[2].innerText;
                        document.getElementById('title').value = tds[3].innerText;
                        document.getElementById('teacher_id').value = tds[4].innerText;
                        document.getElementById('addFormContainer').style.display = 'block';
                        document.getElementById('showAddForm').style.display = 'none';
                        document.getElementById('addPublicationForm').setAttribute('data-editing', 'true');
                        document.getElementById('addPublicationForm').setAttribute('data-edit-index', tr.rowIndex);
                    };
                }
                if (deleteBtn) {
                    deleteBtn.onclick = function() {
                        if(confirm('確定要刪除這筆論文資料嗎？')) {
                            var paperNo = tr.cells[0].innerText;
                            var formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('論文標號', paperNo);
                            fetch('manage-publications-api.php', {
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

        // 新增/修改論文資料並即時顯示在表格，並同步寫入資料庫
        var addForm = document.getElementById('addPublicationForm');
        addForm.onsubmit = function(e) {
            e.preventDefault();
            var paperNo = document.getElementById('paper_no').value;
            var publicationId = document.getElementById('publication_id').value;
            var publishDate = document.getElementById('publish_date').value;
            var title = document.getElementById('title').value;
            var teacherId = document.getElementById('teacher_id').value;
            var isEditing = addForm.getAttribute('data-editing') === 'true';
            var formData = new FormData();
            formData.append('論文標號', paperNo);
            formData.append('論文編號', publicationId);
            formData.append('發表日期', publishDate);
            formData.append('論文標題', title);
            formData.append('老師編號', teacherId);
            formData.append('action', isEditing ? 'edit' : 'add');
            fetch('manage-publications-api.php', {
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

        // 查詢功能
        $('#searchPublicationForm').submit(function(e) {
            e.preventDefault();
            var searchPaperNo = $('#search_paper_no').val().trim();
            var searchTeacherId = $('#search_teacher_id').val().trim();
            var rows = $('#publicationsTbody tr');
            var found = false;
            var resultHtml = '';
            rows.removeClass('search-highlight');
            rows.find('td').css('backgroundColor', '');
            rows.each(function() {
                var tds = $(this).find('td');
                if ((searchPaperNo && tds.eq(0).text() === searchPaperNo) ||
                    (searchTeacherId && tds.eq(4).text() === searchTeacherId)) {
                    found = true;
                    $(this)[0].scrollIntoView({behavior: 'smooth', block: 'center'});
                    $(this).addClass('search-highlight');
                    tds.css('backgroundColor', '#ffe066');
                    setTimeout(function(row, tds){
                        row.removeClass('search-highlight');
                        tds.css('backgroundColor', '');
                    }, 2000, $(this), tds);
                    resultHtml = '<div class="alert alert-success">找到論文記錄：<br>' +
                        '論文標號: ' + tds.eq(0).text() + '<br>' +
                        '論文編號: ' + tds.eq(1).text() + '<br>' +
                        '發表日期: ' + tds.eq(2).text() + '<br>' +
                        '論文標題: ' + tds.eq(3).text() + '<br>' +
                        '老師編號: ' + tds.eq(4).text() + '</div>';
                    return false;
                }
            });
            if (!found) {
                resultHtml = '<div class="alert alert-danger">查無此論文記錄</div>';
            }
            $('#searchResult').html(resultHtml);
        });
    });
    </script>
</body>
</html>
<?php } ?>
