<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body>
    <div class="main-wrapper">
        <div class="content-wrapper">
            <div class="content-container">
                <div class="main-page">


                    <section class="section">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <?php
                                                $rollid = $_POST['rollid'];
                                                $classid = $_POST['class'];
                                                $dob = $_POST['dob'];
                                                $_SESSION['rollid'] = $rollid;
                                                $_SESSION['classid'] = $classid;
                                                $_SESSION['dob'] = $dob;
                                                $qery = "SELECT tblstudents.StudentName,tblstudents.RollId,tblstudents.DOB,tblstudents.RegDate,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName,tblclasses.Section,tblclasses.semester from tblstudents join tblclasses on tblclasses.ClassNameNumeric=tblstudents.ClassId where tblstudents.RollId=:rollid and tblstudents.ClassId=:classid and tblstudents.DOB=:dob";
                                                $stmt = $dbh->prepare($qery);
                                                $stmt->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                                $stmt->bindParam(':classid', $classid, PDO::PARAM_STR);
                                                $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
                                                $stmt->execute();
                                                $resultss = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($stmt->rowCount() > 0) {
                                                    foreach ($resultss as $row) {   ?>
                                                        <p><b>Student Name :</b> <?php echo htmlentities($row->StudentName); ?></p>
                                                        <p><b>Student Roll Id :</b> <?php echo htmlentities($row->RollId); ?>
                                                        <p><b>Student Class:</b> <?php echo htmlentities($row->ClassName); ?>&nbsp;<?php echo htmlentities($row->Section); ?>&nbsp; <?php echo htmlentities($row->semester); ?> Sem
                                                        <?php }

                                                        ?>
                                            </div>
                                            <div class="panel-body p-20">

                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SNo.</th>
                                                            <th>Subject Name</th>
                                                            <th>Subject Code</th>
                                                            <th>Subject Type</th>
                                                            <th>Obtained Marks</th>
                                                            <th>Maximum Marks</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php

                                                        $query = "SELECT distinct t.StudentName,t.RollId,t.ClassId,t.marks,t.mmarks,t.dob,SubjectId,tblsubjects.SubjectName,tblsubjects.SubjectCode,tblsubjects.subjecttype from (select sts.StudentName,sts.RollId,sts.ClassId,sts.DOB,tr.marks,
                                                        tr.mmarks,SubjectId from tblstudents as sts join  tblresult as tr on tr.StudentId=sts.RollId and tr.ClassId=sts.ClassId) as t join tblsubjects on tblsubjects.SubjectCode=t.SubjectId where (t.RollId=:rollid and t.ClassId=:classid and t.DOB=:dob)";
                                                        $query = $dbh->prepare($query);
                                                        $query->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                                        $query->bindParam(':classid', $classid, PDO::PARAM_STR);
                                                        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($countrow = $query->rowCount() > 0) {

                                                            foreach ($results as $result) {

                                                        ?>
                                                                <?php
                                                                $g='gec';
                                                                $o='elective';
                                                                if (($result->marks != 0)  || ($result->subjecttype !=$g) || ($result->subjecttype!=$o) ){ ?>

                                                                    <tr>
                                                                        <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                                        <td><?php echo htmlentities($result->SubjectName); ?></td>
                                                                        <td><?php echo htmlentities($result->SubjectCode); ?></td>
                                                                        <td><?php echo htmlentities($result->subjecttype); ?></td>
                                                                        <td><?php echo htmlentities($totalmarks = $result->marks); ?></td>
                                                                        <td><?php echo htmlentities($result->mmarks); ?></td>
                                                                        <?php
                                                                        if (($result->marks) != 0 || ($result->subjecttype !=$g)) {
                                                                            $totalmmarks = $result->mmarks;
                                                                        }; ?>
                                                                    </tr>
                                                                    <?php
                                                                    $totlcount += $totalmarks;
                                                                    $totalmcount += $totalmmarks;
                                                                    $cnt++;
                                                                }
                                                                    ?><?php
                                                            } ?>
                                                                    <tr>
                                                                        <th scope="row" colspan="2">Total Marks</th>
                                                                        <td><b><?php echo htmlentities($totlcount); ?></b>/<b><?php echo htmlentities($totalmcount); ?></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row" colspan="2">Percntage</th>
                                                                        <td><b><?php echo  htmlentities($totlcount * (100) / $totalmcount); ?> %</b></td>
                                                                    </tr>
                                                                    <tr id="mohit">
                                                                        <th scope="row" colspan="2">Download Result</th>
                                                                        <td><b><a onclick="window.print()" style="cursor: pointer;">Download </a> </b></td>
                                                                    </tr>

                                                                <?php } else { ?>
                                                                    <div class="alert alert-warning left-icon-alert" role="alert">
                                                                        <strong>Notice!</strong> Your result has not declared.
                                                                    <?php }
                                                                    ?>
                                                                    </div>
                                                                <?php
                                                            } else { ?>

                                                                    <div class="alert alert-danger left-icon-alert" role="alert">

                                                                    <?php
                                                                    echo htmlentities("Result has not been declared or wrong details are entered.");
                                                                }
                                                                    ?>
                                                                    </div>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <div class="col-sm-6">
                                            <a href="index.php">Back to Home</a>
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

    <script src="js/main.js"></script>
    <style>
        @media print {
            body {
                text-align: center;
                display: flex;
                justify-content: center;
            }

            table,
            tr,
            th,
            td {
                border: 6px solid;
                border-collapse: collapse;
                border-style: groove;
                padding: 10px;
            }

            .col-sm-6,
            #mohit {
                display: none;
            }
        }
    </style>
</body>

</html>