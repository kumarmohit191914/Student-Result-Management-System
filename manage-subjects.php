<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Manage Subjects</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>
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
                                    <h2 class="title">Manage Scheme</h2>

                                </div>

                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Subjects</li>
                                        <li class="active">Manage Scheme</li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <section class="section">
                            <div class="container-fluid">



                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <!-- <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>View Subjects Info</h5>
                                                </div>
                                            </div> -->
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="panel-body p-20">
                                                <!-- <form action="" method="POST" style="padding-left:5px;">
                                                    <label for="searchbysubjectcode" style="font-size: 1.1rem;">Search By ClassId</label>
                                                    <input type="text" name="mohit" id="searchbysubjectcode" autosubmit style="height:5vh;">
                                                </form> -->
                                                <form action="" method="POST" style="padding-left:5px;width:200px;display:inline-block;">
                                                    <label for="">Search By Class Name</label>
                                                
                                                <select name="mohit" class="form-control clid" id="classid" required="required">
                                                        <option value="">Select Class</option>
                                                        <?php $sql = "SELECT * from tblclasses ORDER BY ClassName";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                <option value="<?php echo htmlentities($result->ClassNameNumeric); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; <?php echo htmlentities($result->Section); ?> <?php echo htmlentities($result->semester); ?> Sem</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary" style="margin:10px;">Search</button>
                                                </form>
                                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>SNo.</th>
                                                            <th>Class Name</th>
                                                            <th>Subject Name</th>
                                                            <th>Subject Code</th>
                                                            <th>Creation Date</th>
                                                            <th>Updation Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php

                                                        $si = $_POST['mohit'];
                                                        if (isset($_POST['mohit'])) {
                                                            $sql = "SELECT * from tblsubjects where ClassId=:si";
                                                            $query = $dbh->prepare($sql);
                                                            $query->bindParam(':si', $si);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt = 1;
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                                    <tr>
                                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                                        <td><?php echo htmlentities($result->ClassId); ?></td>
                                                                        <td><?php echo htmlentities($result->SubjectName); ?></td>
                                                                        <td><?php echo htmlentities($result->SubjectCode); ?></td>
                                                                        <td><?php echo htmlentities($result->Creationdate); ?></td>
                                                                        <td><?php echo htmlentities($result->UpdationDate); ?></td>
                                                                        <td>
                                                                            <a class="btn btn-primary" href="edit-subject.php?subjectid=<?php echo htmlentities($result->SubjectCode); ?>&classid=<?php echo htmlentities($result->ClassId);?>">Edit</a>



                                                                            <a class="btn btn-success" href="delete_subject.php?subjectid=<?php echo htmlentities($result->SubjectCode); ?>&classid=<?php echo htmlentities($result->ClassId);?>">Delete</a>


                                                                        </td>
                                                                    </tr>
                                                        <?php $cnt = $cnt + 1;
                                                                }
                                                            }
                                                        } ?>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable({
                    "scrollY": "300px",
                    "scrollCollapse": true,
                    "paging": false
                });

                $('#example3').DataTable();
            });
        </script>
    </body>

    </html>
<?php } ?>