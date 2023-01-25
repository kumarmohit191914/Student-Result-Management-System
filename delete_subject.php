<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['Update'])) {
        $sid = $_GET['subjectid'];
        $cid=$_GET['classid'];
        $sql = "DELETE from tblsubjects where SubjectCode=:sid and ClassId=:cid";
        $sql1="DELETE from tblsubjectcombination where SubjectId=:sid and ClassId=:cid";
        
        $query = $dbh->prepare($sql);
        $query1 = $dbh->prepare($sql1);

        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query1->bindParam(':sid', $sid, PDO::PARAM_STR);

        
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query1->bindParam(':cid', $cid, PDO::PARAM_STR);

        $query->execute();
        $query1->execute();

        ?>
                <script>
                    alert('Subject Deleted Succesfully.');
                </script>
                <?php
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin Update Subject </title>
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
                                    <h2 class="title">Delete Subject</h2>

                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Subjects</li>
                                        <li class="active">Delete Subject</li>
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
                                                <h5>Delete Subject</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">

                                                <?php
                                                $sid = $_GET['subjectid'];
                                                $cid = $_GET['classid'];

                                                $sql = "SELECT * from tblsubjects where SubjectCode=:sid and ClassId=:cid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                                $query->bindParam(':cid', $cid, PDO::PARAM_STR);

                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {   ?>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Subject Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="subjectname" value="<?php echo htmlentities($result->SubjectName); ?>" class="form-control" id="default" placeholder="Subject Name" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Subject Code</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="subjectcode" class="form-control" value="<?php echo htmlentities($result->SubjectCode); ?>" id="default" placeholder="Subject Code" required="required">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Subject Type</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="subjecttype" class="form-control" value="<?php echo htmlentities($result->subjecttype); ?>" id="default" placeholder="Credits" required="required">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Maximum Marks</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="maximummarks" class="form-control" value="<?php echo htmlentities($result->maximummarks); ?>" id="default" placeholder="Subject Code" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Credits</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="credits" class="form-control" value="<?php echo htmlentities($result->credits); ?>" id="default" placeholder="Credits" required="required">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                <?php }
                                                } ?>


                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="Update" class="btn btn-primary" >Delete</button>
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