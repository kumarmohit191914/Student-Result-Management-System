<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {

        $cid = $_GET['classid'];
        $sql = "DELETE FROM tblclasses where ClassNameNumeric=:cid ";
        $sql1="DELETE FROM tblsubjectcombination where ClassId=:cid";
        $sql2="DELETE FROM tblstudents where ClassId=:cid";
        $sql3="DELETE FROM tblresult where ClassId=:cid";
        $sql4="DELETE FROM tblsubjects where ClassId=:cid";
        $query = $dbh->prepare($sql);
        $query1 = $dbh->prepare($sql1);
        $query2 = $dbh->prepare($sql2);
        $query3 = $dbh->prepare($sql3);
        $query4 = $dbh->prepare($sql4);

        
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query1->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query2->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query3->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query4->bindParam(':cid', $cid, PDO::PARAM_STR);


        $query->execute();
        $query1->execute();
        $query2->execute();
        $query3->execute();
        $query4->execute();

        ?>
                <script>
                    alert('Class Deleted Succesfully.');
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
        <title>SMS Admin Delete Class</title>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
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
                                    <h2 class="title">Delete Student Class</h2>
                                </div>

                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="#">Classes</a></li>
                                        <li class="active">Delete Class</li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Delete Student Class info</h5>
                                                </div>
                                            </div>
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>

                                            <form method="post">
                                                <?php
                                                $cid = intval($_GET['classid']);
                                                $sql = "SELECT * from tblclasses where ClassNameNumeric=:cid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {   ?>
                                                        <div class="form-group has-success">
                                                            <label for="success" class="control-label">ClassID</label>
                                                            <div class="">
                                                                <input type="text" name="classnamenumeric" value="<?php echo htmlentities($result->ClassNameNumeric); ?>" class="form-control" required="required" id="success">
                                                            </div>
                                                        </div>


                                                <?php }
                                                } ?>
                                                <div class="form-group has-success">
                                                    <div class="">
                                                        <button type="submit" name="update" class="btn btn-success btn-labeled">Delete<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    </div>
                                            </form>


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
        <script src="js/prism/prism.js"></script>
        <script src="js/main.js"></script>
    </body>

    </html>
<?php  } ?>