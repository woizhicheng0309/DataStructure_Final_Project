<?php
// Script to manage publications
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:../adminlogin.php');
}
else {
    if(isset($_POST['add'])) {
        $publicationId = $_POST['publicationId'];
        $professorId = $_POST['professorId'];
        $type = $_POST['type'];
        $title = $_POST['title'];
        $publicationDate = $_POST['publicationDate'];
        $description = $_POST['description'];

        $sql = "INSERT INTO tblpublications (PublicationId, ProfessorId, Type, Title, PublicationDate, Description) VALUES (:publicationId, :professorId, :type, :title, :publicationDate, :description)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':publicationId', $publicationId, PDO::PARAM_STR);
        $query->bindParam(':professorId', $professorId, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':publicationDate', $publicationDate, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Publication added successfully!";
    }

    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblpublications WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Publication deleted successfully!";
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Publications</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('../includes/header.php');?>
<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Publications</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if($_SESSION['msg'] != "") { ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                        <?php $_SESSION['msg'] = ""; ?>
                    </div>
                <?php } ?>
                <?php if($_SESSION['delmsg'] != "") { ?>
                    <div class="alert alert-danger">
                        <strong>Deleted!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                        <?php $_SESSION['delmsg'] = ""; ?>
                    </div>
                <?php } ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Add Publication
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Publication ID</label>
                                <input class="form-control" type="text" name="publicationId" required />
                            </div>
                            <div class="form-group">
                                <label>Professor ID</label>
                                <input class="form-control" type="text" name="professorId" required />
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <input class="form-control" type="text" name="type" />
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title" required />
                            </div>
                            <div class="form-group">
                                <label>Publication Date</label>
                                <input class="form-control" type="date" name="publicationDate" />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add Publication</button>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Publications List
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Publication ID</th>
                                    <th>Professor ID</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Publication Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM tblpublications";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->PublicationId); ?></td>
                                    <td><?php echo htmlentities($result->ProfessorId); ?></td>
                                    <td><?php echo htmlentities($result->Type); ?></td>
                                    <td><?php echo htmlentities($result->Title); ?></td>
                                    <td><?php echo htmlentities($result->PublicationDate); ?></td>
                                    <td>
                                        <a href="manage-publications.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete?');">
                                            <button class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php $cnt++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/footer.php');?>
<script src="../assets/js/jquery-1.10.2.js"></script>
<script src="../assets/js/bootstrap.js"></script>
<script src="../assets/js/custom.js"></script>
</body>
</html>
<?php } ?>