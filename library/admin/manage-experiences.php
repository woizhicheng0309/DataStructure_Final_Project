<?php
// Script to manage experiences
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:../adminlogin.php');
}
else {
    if(isset($_POST['add'])) {
        $professorId = $_POST['professorId'];
        $type = $_POST['type'];
        $position = $_POST['position'];
        $organization = $_POST['organization'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $sql = "INSERT INTO tblexperiences (ProfessorId, Type, Position, Organization, StartDate, EndDate) VALUES (:professorId, :type, :position, :organization, :startDate, :endDate)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':professorId', $professorId, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->bindParam(':position', $position, PDO::PARAM_STR);
        $query->bindParam(':organization', $organization, PDO::PARAM_STR);
        $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Experience added successfully!";
    }

    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblexperiences WHERE ExperienceId=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Experience deleted successfully!";
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Experiences</title>
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
                <h4 class="header-line">Manage Experiences</h4>
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
                        Add Experience
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Professor ID</label>
                                <input class="form-control" type="text" name="professorId" required />
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <input class="form-control" type="text" name="type" required />
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" type="text" name="position" required />
                            </div>
                            <div class="form-group">
                                <label>Organization</label>
                                <input class="form-control" type="text" name="organization" required />
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" type="date" name="startDate" required />
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input class="form-control" type="date" name="endDate" />
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add Experience</button>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Experiences List
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Professor ID</th>
                                    <th>Type</th>
                                    <th>Position</th>
                                    <th>Organization</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM tblexperiences";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->ProfessorId); ?></td>
                                    <td><?php echo htmlentities($result->Type); ?></td>
                                    <td><?php echo htmlentities($result->Position); ?></td>
                                    <td><?php echo htmlentities($result->Organization); ?></td>
                                    <td><?php echo htmlentities($result->StartDate); ?></td>
                                    <td><?php echo htmlentities($result->EndDate); ?></td>
                                    <td>
                                        <a href="manage-experiences.php?del=<?php echo htmlentities($result->ExperienceId); ?>" onclick="return confirm('Are you sure you want to delete?');">
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