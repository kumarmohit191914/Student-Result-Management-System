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
        $subjectname = $_POST['subjectname'];
        $subjectcode = $_POST['subjectcode'];
        $maximummarks = $_POST['maximummarks'];
        $credits = $_POST['credits'];
        $subjecttype=$_POST['subjecttype'];
        $class=$_POST['class'];
        $status=1;

        $result = mysqli_query($conn, "SELECT * FROM tblsubjects WHERE SubjectCode='$subjectcode' and ClassId='$class'");
        $num_rows = mysqli_num_rows($result);

        if ($num_rows) {
?>
            <script>
                alert("Subject already exists with same SubjectCode.")
            </script>
    <?php
        } else {


            $sql = "INSERT INTO  tblsubjects(SubjectName,SubjectCode,maximummarks,credits,subjecttype,ClassId) VALUES(:subjectname,:subjectcode,:maximummarks,:credits,:subjecttype,:class)";
            $sql1="INSERT INTO tblsubjectcombination(ClassId,SubjectId,status) values(:class,:subjectcode,:status)";

            $query = $dbh->prepare($sql);
            $query1 = $dbh->prepare($sql1);


            $query->bindParam(':subjectname', $subjectname, PDO::PARAM_STR);
            $query->bindParam(':subjectcode', $subjectcode, PDO::PARAM_STR);
            $query->bindParam(':maximummarks', $maximummarks, PDO::PARAM_STR);
            $query->bindParam(':credits',$credits,PDO::PARAM_STR);
            $query->bindParam(':subjecttype',$subjecttype,PDO::PARAM_STR);
            $query->bindParam(':class',$class,PDO::PARAM_STR);


            $query1->bindParam(':subjectcode', $subjectcode, PDO::PARAM_STR);
            $query1->bindParam(':class',$class,PDO::PARAM_STR);
            $query1->bindParam(':status',$status,PDO::PARAM_STR);



            $query->execute();
            $query1->execute();

            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                ?>
                <script>
                    alert('Subject Created Succesfully.');
                </script>
                <?php
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
        <title>SMS Admin Subject Creation </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('includes/topbar.php'); ?>
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar.php'); ?>

                    <div class="main-page">

                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Scheme Creation</h2>

                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Scheme</li>
                                        <li class="active">Create Scheme</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Create Subject</h5>
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
                                                    <label for="default" class="col-sm-2 control-label">Class</label>
                                                    <div class="col-sm-10">
                                                        <select name="class" class="form-control" id="default" required="required" selected>
                                                            
                                                            <option value="">Select Class</option>
                                                            <?php $sql = "SELECT * from tblclasses";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <option value="<?php echo htmlentities($result->ClassNameNumeric); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; <?php echo htmlentities($result->Section); ?> <?php echo htmlentities($result->semester); ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Subject Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="subjectname" class="form-control" id="default" placeholder="Subject Name" required="required">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Subject Code</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="subjectcode" class="form-control" id="default" placeholder="Subject Code" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Subject Type</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" name="subjecttype" value="core" required="required" checked=""> Core
                                                        <input type="radio" name="subjecttype" value="practical" required="required"> Practical 
                                                        <input type="radio" name="subjecttype" value="elective" required="required"> Elective
                                                        <input type="radio" name="subjecttype" value="gec" required="required"> GEC
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">Maximum Marks</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="maximummarks" class="form-control" id="default" placeholder="Maximum Marks" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="default" class="col-sm-2 control-label">No. Of Credits</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="credits" class="form-control" id="default" placeholder="No. Of Credits" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
            </div>
            <script src="js/jquery/jquery-2.2.4.min.js"></script>
            <script src="js/bootstrap/bootstrap.min.js"></script>
            <script src="js/pace/pace.min.js"></script>
            <script src="js/lobipanel/lobipanel.min.js"></script>
            <script src="js/iscroll/iscroll.js"></script>
            <script src="js/prism/prism.js"></script>
            <script src="js/select2/select2.min.js"></script>
            <script src="js/main.js"></script>
            <script>
                $(function($) {
                    $(".js-states").select2();
                    $(".js-states-limit").select2({
                        maximumSelectionLength: 2
                    });
                    $(".js-states-hide").select2({
                        minimumResultsForSearch: Infinity
                    });
                });
            </script>
    </body>

    </html>
<?PHP } ?>