<?php

$dbuser = "root";
$dbpass = "123";
$host = "localhost";
$dbname = "srms1";
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $studentname = $_POST['fullanme'];
        $roolid = $_POST['rollid'];
        $studentemail = $_POST['emailid'];
        $gender = $_POST['gender'];
        $classid = $_POST['class'];
        $dob = $_POST['dob'];
        $status = 1;


        $result = mysqli_query($conn, "SELECT * FROM tblstudents WHERE RollId='$roolid' and ClassId='$classid'");
        $num_rows = mysqli_num_rows($result);

        if ($num_rows) {
?>
            <script>
                alert("Student already exists.")
            </script>
    <?php
        } else {
        $sql = "INSERT INTO  tblstudents(StudentName,RollId,StudentEmail,Gender,ClassId,DOB,Status) VALUES(:studentname,:roolid,:studentemail,:gender,:classid,:dob,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':roolid', $roolid, PDO::PARAM_STR);
        $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':classid', $classid, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Student added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <!-- <link rel="stylesheet" href="css/main.css" media="screen"> -->
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="" style="background-color:aliceblue;">
    <div class="main-wrapper">

        <div class="">
            <div class="row">
                <h1 align="center">Student Result Management System</h1>
                <div class="col-lg-6 visible-lg-block">

                    <section class="section">
                        <div class="row mt-40">
                            <div class="col-md-10 col-md-offset-1 pt-50">

                                <div class="row mt-30 ">
                                    <div class="col-md-11">
                                        <div class="panel" style="margin-top: 50px;">
                                            <div class="panel-heading">
                                                <div class="panel-title text-center">
                                                    <h4>For Students</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body p-20">
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-6 py-5" style="font-size:15px;padding-left
                                                        :50px;">Search your result</label>
                                                        <div class="col-sm-6">
                                                            <a href="find-result.php"> <u style="font-size:17px;color:blue;text-decoration:none;">Click here</u></a>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class="section">
                        <div class="row mt-40">
                            <div class="col-md-10 col-md-offset-1 pt-50">

                                <div class="row mt-30 ">
                                    <div class="col-md-11">
                                        <div class="panel" style="width:400px; height: 450px;margin-top:50px;">
                                            <div class="panel-heading">
                                                <div class="panel-title text-center">
                                                    <h4>Student Register</h4>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label" >Full Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="fullanme" class="form-control" id="fullanme" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Roll Id</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="rollid" class="form-control" id="rollid" maxlength="6" required="required" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Email id</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="emailid" class="form-control" id="email" required="required" autocomplete="off">
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Gender</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" name="gender" value="Male" required="required" checked="">Male <input type="radio" name="gender" value="Female" required="required">Female <input type="radio" name="gender" value="Other" required="required">Other
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Class</label>
                                                    <div class="col-sm-10">
                                                        <select name="class" class="form-control" id="default" required="required">
                                                            <option value="">Select Class</option>
                                                            <?php $sql = "SELECT * from tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->ClassNameNumeric); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; <?php echo htmlentities($result->Section); ?>&nbsp; <?php echo htmlentities($result->semester); ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="date" class="col-sm-2 control-label">DOB</label>
                                                    <div class="col-sm-10">
                                                        <input type="date" name="dob" class="form-control" id="date">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">

                                                    
                                                    <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-labeled pull-right" style="height:35px">
                                        <a href="index.php" style="color:white;text-decoration:none;">Home</a></button>
                                </div>

                                                        <button type="submit" name="submit" class=" btn btn-labeled btn-success btn-label-right">Submit</button>
                                                        
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function() {

        });
    </script>
</body>

</html>
<?php } ?>