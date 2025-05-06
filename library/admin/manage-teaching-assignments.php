<?php
// Script to manage teaching assignments
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:../adminlogin.php');
}
else {
    if(isset($_POST['add'])) {
        $assignmentId = $_POST['assignmentId'];
        $professorId = $_POST['professorId'];
        $courseName = $_POST['courseName'];
        $classroom = $_POST['classroom'];
        $schedule = $_POST['schedule'];

        $sql = "INSERT INTO tblteachingassignments (AssignmentId, ProfessorId, CourseName, Classroom, Schedule) VALUES (:assignmentId, :professorId, :courseName, :classroom, :schedule)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':assignmentId', $assignmentId, PDO::PARAM_STR);
        $query->bindParam(':professorId', $professorId, PDO::PARAM_STR);
        $query->bindParam(':courseName', $courseName, PDO::PARAM_STR);
        $query->bindParam(':classroom', $classroom, PDO::PARAM_STR);
        $query->bindParam(':schedule', $schedule, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Teaching assignment added successfully!";
    }

    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblteachingassignments WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Teaching assignment deleted successfully!";
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Teaching Assignments</title>
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
                <h4 class="header-line">Manage Teaching Assignments</h4>
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
                        Add Teaching Assignment
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Assignment ID</label>
                                <input class="form-control" type="text" name="assignmentId" required />
                            </div>
                            <div class="form-group">
                                <label>Professor ID</label>
                                <input class="form-control" type="text" name="professorId" required />
                            </div>
                            <div class="form-group">
                                <label>Course Name</label>
                                <input class="form-control" type="text" name="courseName" required />
                            </div>
                            <div class="form-group">
                                <label>Classroom</label>
                                <input class="form-control" type="text" name="classroom" />
                            </div>
                            <div class="form-group">
                                <label>Schedule</label>
                                <input class="form-control" type="text" name="schedule" />
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add Assignment</button>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Teaching Assignments List
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Assignment ID</th>
                                    <th>Professor ID</th>
                                    <th>Course Name</th>
                                    <th>Classroom</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM tblteachingassignments";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($result->AssignmentId); ?></td>
                                    <td><?php echo htmlentities($result->ProfessorId); ?></td>
                                    <td><?php echo htmlentities($result->CourseName); ?></td>
                                    <td><?php echo htmlentities($result->Classroom); ?></td>
                                    <td><?php echo htmlentities($result->Schedule); ?></td>
                                    <td>
                                        <a href="manage-teaching-assignments.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete?');">
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