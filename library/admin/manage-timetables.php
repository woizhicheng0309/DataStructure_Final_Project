<?php
// Script to manage timetables
session_start();
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:../adminlogin.php');
}
else {
    if(isset($_POST['add'])) {
        $professorId = $_POST['professorId'];
        $subject = $_POST['subject'];
        $venue = $_POST['venue'];
        $schedule = $_POST['schedule'];

        $sql = "INSERT INTO tbltimetables (ProfessorId, Subject, Venue, Schedule) VALUES (:professorId, :subject, :venue, :schedule)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':professorId', $professorId, PDO::PARAM_STR);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':venue', $venue, PDO::PARAM_STR);
        $query->bindParam(':schedule', $schedule, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Timetable added successfully!";
    }

    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tbltimetables WHERE TimetableId=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Timetable deleted successfully!";
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manage Timetables</title>
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
                <h4 class="header-line">Manage Timetables</h4>
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
                        Add Timetable
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Professor ID</label>
                                <input class="form-control" type="text" name="professorId" required />
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input class="form-control" type="text" name="subject" required />
                            </div>
                            <div class="form-group">
                                <label>Venue</label>
                                <input class="form-control" type="text" name="venue" required />
                            </div>
                            <div class="form-group">
                                <label>Schedule</label>
                                <input class="form-control" type="text" name="schedule" required />
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add Timetable</button>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Timetables List
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Professor ID</th>
                                    <th>Subject</th>
                                    <th>Venue</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM tbltimetables";
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
                                    <td><?php echo htmlentities($result->Subject); ?></td>
                                    <td><?php echo htmlentities($result->Venue); ?></td>
                                    <td><?php echo htmlentities($result->Schedule); ?></td>
                                    <td>
                                        <a href="manage-timetables.php?del=<?php echo htmlentities($result->TimetableId); ?>" onclick="return confirm('Are you sure you want to delete?');">
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