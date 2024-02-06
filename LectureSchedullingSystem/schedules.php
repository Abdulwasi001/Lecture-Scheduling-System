<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

    // ADD NEW 
    if (isset($_POST['addSch'])) {

        $course = mysqli_real_escape_string($db, $_POST['course']);
        $days = mysqli_real_escape_string($db, $_POST['days']);
        $hall = mysqli_real_escape_string($db, $_POST['hall']);
        $cStart = mysqli_real_escape_string($db, $_POST['cStart']);
        $cEnd = mysqli_real_escape_string($db, $_POST['cEnd']);
        $newStartTime = DateTime::createFromFormat('h:i', $cStart);
        $newEndTime = DateTime::createFromFormat('h:i', $cEnd);

        // get course detail
        $getlevel = mysqli_query($db, "SELECT * FROM courses WHERE code = '$course' "); 
        $cosLevel = mysqli_fetch_array($getlevel); 
        $courseLevel = $cosLevel['level']; 
        $lecturerInCharge = $cosLevel['lecturer'];

        // check if course on the same day
        $checkcourse = mysqli_query($db, "SELECT * FROM schedules WHERE `course` = '$course' AND `days` = '$days' ");
        // check if lecturer is free
        $checklec = mysqli_query($db, "SELECT * FROM schedules WHERE `lecturer` = '$lecturerInCharge' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if lecturer available with time
        $checklectime = mysqli_query($db, "SELECT * FROM schedules WHERE `lecturer` = '$lecturerInCharge' AND `days` = '$days' ");
        $lect = mysqli_fetch_array($checklectime);
        $lecStartTime = DateTime::createFromFormat('h:i', $lect['cStart']);
        $lecEndTime = DateTime::createFromFormat('h:i', $lect['cEnd']);
        
        // check if level is free
        $checklevel = mysqli_query($db, "SELECT * FROM schedules WHERE `level` = '$courseLevel' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if level available with time
        $checklevtime = mysqli_query($db, "SELECT * FROM schedules WHERE `level` = '$courseLevel' AND `days` = '$days' ");
        $levt = mysqli_fetch_array($checklevtime);
        $levStartTime = DateTime::createFromFormat('h:i', $levt['cStart']);
        $levEndTime = DateTime::createFromFormat('h:i', $levt['cEnd']);

        // check if hall available
        $checkhal = mysqli_query($db, "SELECT * FROM schedules WHERE `hall` = '$hall' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if hall available with time
        $checkhaltime = mysqli_query($db, "SELECT * FROM schedules WHERE `hall` = '$hall' AND `days` = '$days' ");
        $hallt = mysqli_fetch_array($checkhaltime);
        $hallStartTime = DateTime::createFromFormat('h:i', $hallt['cStart']);
        $hallEndTime = DateTime::createFromFormat('h:i', $hallt['cEnd']);

        if (mysqli_num_rows($checklec) == 1) {
            header('location:schedules.php?msg=lecbusy');
        } else if ($lecStartTime <= $newStartTime && $newStartTime <= $lecEndTime) {
            header('location:schedules.php?msg=lecbusyy');
        } else if ($lecStartTime > $newStartTime && $newEndTime > $lecStartTime) {
            header('location:schedules.php?msg=lecbusyy');
        } else if (mysqli_num_rows($checklevel) == 1) {
            header('location:schedules.php?msg=levelbusy');
        } else if ($levStartTime <= $newStartTime && $newStartTime <= $levEndTime) {
            header('location:schedules.php?msg=levbusyy');
        } else if ($levStartTime > $newStartTime && $newEndTime > $levStartTime) {
            header('location:schedules.php?msg=levbusyy');
        } else if (mysqli_num_rows($checkhal) == 1) {
            header('location:schedules.php?msg=halloccupy');
        } else if ($hallStartTime <= $newStartTime && $newStartTime <= $hallEndTime) {
            header('location:schedules.php?msg=halloccupyt');
        } else if ($hallStartTime > $newStartTime && $newEndTime > $hallStartTime) {
            header('location:schedules.php?msg=halloccupytt');
        } else if (mysqli_num_rows($checkcourse) == 1) {
            header('location:schedules.php?msg=cos');    
        } else {
            $sql = "INSERT INTO schedules (course, `level`, lecturer, `days`, hall, cStart, cEnd, `status`) VALUES ('$course','$courseLevel', '$lecturerInCharge', '$days', '$hall', '$cStart', '$cEnd', '1')";
            if ($query_run = mysqli_query($db, $sql)) {
                header('location:schedules.php?msg=ad');
            } else {
                echo 'Error'.$sql.'<br>'.$db->error;
            } 
        }
    }

    // UPDATE RECORD 
    if (isset($_POST['updateSch'])) {

        $sID = mysqli_real_escape_string($db, $_POST['sID']);
        $course = mysqli_real_escape_string($db, $_POST['course']);
        $days = mysqli_real_escape_string($db, $_POST['days']);
        $hall = mysqli_real_escape_string($db, $_POST['hall']);
        $cStart = mysqli_real_escape_string($db, $_POST['cStart']);
        $cEnd = mysqli_real_escape_string($db, $_POST['cEnd']);
        $newStartTime = DateTime::createFromFormat('h:i', $cStart);
        $newEndTime = DateTime::createFromFormat('h:i', $cEnd);

        // get course detail
        $getlevel = mysqli_query($db, "SELECT * FROM courses WHERE code = '$course' "); 
        $cosLevel = mysqli_fetch_array($getlevel); 
        $courseLevel = $cosLevel['level']; 
        $lecturerInCharge = $cosLevel['lecturer'];

        // check if lecturer is free
        $checklec = mysqli_query($db, "SELECT * FROM schedules WHERE `lecturer` = '$lecturerInCharge' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if lecturer available with time
        $checklectime = mysqli_query($db, "SELECT * FROM schedules WHERE `lecturer` = '$lecturerInCharge' AND `days` = '$days' ");
        $lect = mysqli_fetch_array($checklectime);
        $lecStartTime = DateTime::createFromFormat('h:i', $lect['cStart']);
        $lecEndTime = DateTime::createFromFormat('h:i', $lect['cEnd']);
        
        // check if level is free
        $checklevel = mysqli_query($db, "SELECT * FROM schedules WHERE `level` = '$courseLevel' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if level available with time
        $checklevtime = mysqli_query($db, "SELECT * FROM schedules WHERE `level` = '$courseLevel' AND `days` = '$days' ");
        $levt = mysqli_fetch_array($checklevtime);
        $levStartTime = DateTime::createFromFormat('h:i', $levt['cStart']);
        $levEndTime = DateTime::createFromFormat('h:i', $levt['cEnd']);

        // check if hall available
        $checkhal = mysqli_query($db, "SELECT * FROM schedules WHERE `hall` = '$hall' AND `days` = '$days' AND `cStart` = '$cStart' ");
        // check if hall available with time
        $checkhaltime = mysqli_query($db, "SELECT * FROM schedules WHERE `hall` = '$hall' AND `days` = '$days' ");
        $hallt = mysqli_fetch_array($checkhaltime);
        $hallStartTime = DateTime::createFromFormat('h:i', $hallt['cStart']);
        $hallEndTime = DateTime::createFromFormat('h:i', $hallt['cEnd']);

        if (mysqli_num_rows($checklec) == 1) {
            header('location:schedules.php?msg=lecbusy');
        } else if ($lecStartTime <= $newStartTime && $newStartTime < $lecEndTime) {
            header('location:schedules.php?msg=lecbusyy');
        } else if ($lecStartTime > $newStartTime && $newEndTime > $lecStartTime) {
            header('location:schedules.php?msg=lecbusyy');
        } else if (mysqli_num_rows($checklevel) == 1) {
            header('location:schedules.php?msg=levelbusy');
        } else if ($levStartTime <= $newStartTime && $newStartTime < $levEndTime) {
            header('location:schedules.php?msg=levbusyy');
        } else if ($levStartTime > $newStartTime && $newEndTime > $levStartTime) {
            header('location:schedules.php?msg=levbusyy');
        } else if (mysqli_num_rows($checkhal) == 1) {
            header('location:schedules.php?msg=halloccupy');
        } else if ($hallStartTime <= $newStartTime && $newStartTime < $hallEndTime) {
            header('location:schedules.php?msg=halloccupyt');
        } else if ($hallStartTime > $newStartTime && $newEndTime > $hallStartTime) {
            header('location:schedules.php?msg=halloccupytt');    
        } else {
            $sql = "UPDATE schedules SET course = '$course', `level` = '$level', `lecturer` = '$lecturer', `days` = '$days', `hall` = '$hall', `cStart` = '$cStart', `cEnd` = '$cEnd' WHERE `sID`  = '$sID' ";
            if ($query_run = mysqli_query($db, $sql)) {
                header('location:schedules.php?msg=up');
            } else {
                echo 'Error'.$sql.'<br>'.$db->error;
            } 
        }
    }

    // UPDATE status
    if (isset($_POST['updateStatus'])) {

        $sID = mysqli_real_escape_string($db, $_POST['sID']);
        $status = mysqli_real_escape_string($db, $_POST['status']);

        $sql = "UPDATE schedules SET `status` = '$status' WHERE `sID` = '$sID' ";
        if ($query_run = mysqli_query($db, $sql)) {
            header('location:schedules.php');
        } else {
            echo 'Error'.$sql.'<br>'.$db->error;
        } 
    }

    // DELETE RECORD
    if (isset($_GET['del'])) {
        $sID = $_GET['del'];
        $query = "DELETE FROM schedules WHERE sID =$sID ";
        if (mysqli_query($db, $query)) {
            header('location:schedules.php?msg=del');
        }
    }

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Popoola Abdulwasiu Biodun">
        <meta name="generator" content="">
        <title>Lecture Schedulling System</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Web Font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
        <style>
            h1, h2, h3, h4, h5, h6, hr, p, a {margin: 0px; padding: 0px;}
            .user-detail img {width: 100px; height: 100px; border-radius: 100%;}
            nav .nav-item span {background: red; padding: 2px 6px; color: white; border-radius: 50%;}
            body {
                padding-top: 0rem;
            }
            body {
            font-size: .875rem;
            }

            .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
            }

            /*
            * Sidebar
            */

            .sidebar {
            position: fixed;
            top: 0;
            /* rtl:raw:
            right: 0;
            */
            bottom: 0;
            /* rtl:remove */
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 48px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            }

            @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
            }

            .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
            }

            .sidebar .nav-link {
            font-weight: 500;
            color: #333;
            }

            .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #727272;
            }

            .sidebar .nav-link.active {
            color: #2470dc;
            }

            .sidebar .nav-link:hover .feather,
            .sidebar .nav-link.active .feather {
            color: inherit;
            }

            .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
            }

            /*
            * Navbar
            */

            .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
            }

            .navbar .navbar-toggler {
            top: .25rem;
            right: 1rem;
            }

            .navbar .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
            }

            .form-control-dark {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .1);
            }

            .form-control-dark:focus {
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
            }
            table span { color: blue; margin-left: 5px; cursor: pointer;}
            table span:hover {color: grey;}
            table a i { color: red; margin-left: 5px;}
            table a i:hover {color: gray;}

        </style>
    </head>
    <body>
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="home.php">Lectuer Schedulling System</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="sign-out.php">Sign out</a>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <?php require('navbar.php'); ?>

                <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                    
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h4 class="h4">Schedules</h4>
                    </div>

                    <!--ADMIN ONLY-->
                    <?php if ($_SESSION['role']=='Admin') { ?>

                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal">ADD NEW</button>

                    <!--ADD NEW RECORD MODAL-->
                    <div class="modal fade" id="add_Record_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ADD NEW </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Course</b></label>
                                                    <select name="course" class="form-control" required>
                                                        <?php
                                                            $s = mysqli_query($db, "SELECT * FROM courses ");
                                                            $row_count = mysqli_num_rows($s);
                                                            if ($row_count) {
                                                                $c = "<option></option>; ";
                                                                while ($row = mysqli_fetch_assoc($s)) {
                                                                    $c .= "<option value='$row[code]'> $row[code] $row[title]</option>";
                                                                }
                                                                echo $c;
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Days</b></label>
                                                    <select name="days" class="form-control" required>
                                                        <option></option>
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Lecture Room</b></label>
                                                    <select name="hall" class="form-control" required>
                                                        <?php
                                                            $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                            $row_count = mysqli_num_rows($hs);
                                                            if ($row_count) {
                                                                $h = "<option></option>; ";
                                                                while ($l = mysqli_fetch_assoc($hs)) {
                                                                    $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                }
                                                                echo $h;
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>From</b></label>
                                                    <input type="time" name="cStart" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>To</b></label>
                                                    <input type="time" name="cEnd" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="addSch" class="btn btn-dark">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END ADD NEW RECORD MODAL-->

                    <!--OPERATION MESSAGE-->
                    <?php
                        // Record added successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='ad') {
                            echo "<div class='text-primary text-center'>Added Successfully!</div>";
                        }
                        // Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='lecbusy') {
                            echo "<div class='text-danger text-center'> Lecturer Not Available, Please Check the Timetable First!</div>";
                        }
                        // Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='lecbusyy') {
                            echo "<div class='text-danger text-center'> Lecturer Not Available, Please Check the Timetable First!</div>";
                        }
                        // Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='levelbusy') {
                            echo "<div class='text-danger text-center'> Students Not Available, Please Check the Timetable First!</div>";
                        }
                        // Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='levbusyy') {
                            echo "<div class='text-danger text-center'> Students Not Available, Please Check the Timetable First!</div>";
                        }
                        //  Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='halloccupy') {
                            echo "<div class='text-danger text-center'> Lecture Room Not Available at that Time, Please Check the Timetable First!</div>";
                        }
                        //  Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='halloccupyt') {
                            echo "<div class='text-danger text-center'> Lecture Room Not Available at that Time, Please Check the Timetable First!</div>";
                        }
                        //  Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='halloccupytt') {
                            echo "<div class='text-danger text-center'> Lecture Room Not Available at that Time, Please Check the Timetable First!</div>";
                        }
                        // Record Updated Successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='up') {
                            echo "<div class='text-primary text-center'> Updated Successfully!</div>";
                        }
                        // Record Deleted successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='del') {
                            echo "<div class='text-danger text-center'>Delete Successfully!</div>";
                        }
                    ?>
                    <!-- END OPERATION MESSAGE-->

                    <div class="table-responsive">
                        <!--MONDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="8" class="bg-dark text-white text-center">MONDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Monday' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>

                                        <a href="schedules.php?del=<?php echo $row['sID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="text" name="course" value="<?php echo $row['course']?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Days</b></label>
                                                                <select name="days" class="form-control" required>
                                                                    <option value="<?php echo $row['days'];?>"><?php echo $row['days'];?></option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Lecture Room</b></label>
                                                                <select name="hall" class="form-control" required>
                                                                    <?php
                                                                        $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                                        $row_count = mysqli_num_rows($hs);
                                                                        if ($row_count) {
                                                                            $h = "<option value='$row[hall]'></option>; ";
                                                                            while ($l = mysqli_fetch_assoc($hs)) {
                                                                                $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                            }
                                                                            echo $h;
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>From</b></label>
                                                                <input type="time" name="cStart" value="<?php echo $row['cStart'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="time" name="cEnd" value="<?php echo $row['cEnd'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateSch" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END MONDAY-->

                        <!--TUESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="8" class="bg-dark text-white text-center">TUESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Tuesday' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>

                                        <a href="schedules.php?del=<?php echo $row['sID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="text" name="course" value="<?php echo $row['course'];?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Days</b></label>
                                                                <select name="days" class="form-control" required>
                                                                    <option value="<?php echo $row['days'];?>"><?php echo $row['days'];?></option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Lecture Room</b></label>
                                                                <select name="hall" class="form-control" required>
                                                                    <?php
                                                                        $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                                        $row_count = mysqli_num_rows($hs);
                                                                        if ($row_count) {
                                                                            $h = "<option value='$row[hall]'></option>; ";
                                                                            while ($l = mysqli_fetch_assoc($hs)) {
                                                                                $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                            }
                                                                            echo $h;
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>From</b></label>
                                                                <input type="time" name="cStart" value="<?php echo $row['cStart'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="time" name="cEnd" value="<?php echo $row['cEnd'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateSch" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END TUESDAY-->

                        <!--WEDNESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="8" class="bg-dark text-white text-center">WEDNESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Wednesday' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>

                                        <a href="schedules.php?del=<?php echo $row['sID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="text" name="course" value="<?php echo $row['course']?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Days</b></label>
                                                                <select name="days" class="form-control" required>
                                                                    <option value="<?php echo $row['days'];?>"><?php echo $row['days'];?></option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Lecture Room</b></label>
                                                                <select name="hall" class="form-control" required>
                                                                    <?php
                                                                        $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                                        $row_count = mysqli_num_rows($hs);
                                                                        if ($row_count) {
                                                                            $h = "<option value='$row[hall]'></option>; ";
                                                                            while ($l = mysqli_fetch_assoc($hs)) {
                                                                                $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                            }
                                                                            echo $h;
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>From</b></label>
                                                                <input type="time" name="cStart" value="<?php echo $row['cStart'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="time" name="cEnd" value="<?php echo $row['cEnd'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateSch" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END WEDNESDAY-->

                        <!--THURSDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="8" class="bg-dark text-white text-center">THURSDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Thursday' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>

                                        <a href="schedules.php?del=<?php echo $row['sID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="text" name="course" value="<?php echo $row['course']?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Days</b></label>
                                                                <select name="days" class="form-control" required>
                                                                    <option value="<?php echo $row['days'];?>"><?php echo $row['days'];?></option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Lecture Room</b></label>
                                                                <select name="hall" class="form-control" required>
                                                                    <?php
                                                                        $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                                        $row_count = mysqli_num_rows($hs);
                                                                        if ($row_count) {
                                                                            $h = "<option value='$row[hall]'></option>; ";
                                                                            while ($l = mysqli_fetch_assoc($hs)) {
                                                                                $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                            }
                                                                            echo $h;
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>From</b></label>
                                                                <input type="time" name="cStart" value="<?php echo $row['cStart'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="time" name="cEnd" value="<?php echo $row['cEnd'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateSch" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END THURSDAY-->

                        <!--FRIDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="8" class="bg-dark text-white text-center">FRIDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Friday' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>

                                        <a href="schedules.php?del=<?php echo $row['sID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="text" name="course" value="<?php echo $row['course'];?>" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Days</b></label>
                                                                <select name="days" class="form-control" required>
                                                                    <option value="<?php echo $row['days'];?>"><?php echo $row['days'];?></option>
                                                                    <option value="Monday">Monday</option>
                                                                    <option value="Tuesday">Tuesday</option>
                                                                    <option value="Wednesday">Wednesday</option>
                                                                    <option value="Thursday">Thursday</option>
                                                                    <option value="Friday">Friday</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Lecture Room</b></label>
                                                                <select name="hall" class="form-control" required>
                                                                    <?php
                                                                        $hs = mysqli_query($db, "SELECT * FROM halls ");
                                                                        $row_count = mysqli_num_rows($hs);
                                                                        if ($row_count) {
                                                                            $h = "<option value='$row[hall]'></option>; ";
                                                                            while ($l = mysqli_fetch_assoc($hs)) {
                                                                                $h .= "<option value='$l[hall_ID]'> $l[hallName]</option>";
                                                                            }
                                                                            echo $h;
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>From</b></label>
                                                                <input type="time" name="cStart" value="<?php echo $row['cStart'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>To</b></label>
                                                                <input type="time" name="cEnd" value="<?php echo $row['cEnd'];?>" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateSch" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END FRIDAY-->
                    </div>
                    <!--END ADMIN ONLY-->

                    <?php } else if ($_SESSION['role']=='L') {?>
                    
                    <!--LECTURER ONLY-->
                    <div class="table-responsive">
                        <!--MONDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">MONDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Monday' AND `lecturer` = '$_SESSION[userID]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal2<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal2<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Status</b></label>
                                                                <select name="status" class="form-control" required>
                                                                    <option></option>
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateStatus" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--TUESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">TUESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Tuesday' AND `lecturer` = '$_SESSION[userID]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal2<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal2<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Status</b></label>
                                                                <select name="status" class="form-control" required>
                                                                    <option></option>
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateStatus" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--WEDNESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">WEDNESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Wednesday' AND `lecturer` = '$_SESSION[userID]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal2<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal2<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Status</b></label>
                                                                <select name="status" class="form-control" required>
                                                                    <option></option>
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateStatus" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--THURSDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">THURSDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Thursday' AND `lecturer` = '$_SESSION[userID]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal2<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal2<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Status</b></label>
                                                                <select name="status" class="form-control" required>
                                                                    <option></option>
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateStatus" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--FRIDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">FRIDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="width: 7%;"></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Friday' AND `lecturer` = '$_SESSION[userID]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal2<?php echo $row['sID'];?>"><i class="fa fa-edit"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal2<?php echo $row['sID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">UPDATE STATUS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="sID" value="<?php echo $row['sID'];?>" class="form-control" required readonly>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for=""><b>Status</b></label>
                                                                <select name="status" class="form-control" required>
                                                                    <option></option>
                                                                    <option value="1">Available</option>
                                                                    <option value="0">Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateStatus" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL-->
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!--END LECTURER ONLY-->

                    <?php } else if ($_SESSION['role']=='S') {?>

                    <!--STUDENT ONLY-->
                    <div class="table-responsive">
                        <!--MONDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">MONDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Monday' AND `level` = '$_SESSION[level]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--TUESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">TUESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Tuesday' AND `level` = '$_SESSION[level]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--WEDNESDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">WEDNESDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Wednesday' AND `level` = '$_SESSION[level]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--THURSDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">THURSDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Thursday' AND `level` = '$_SESSION[level]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--FRIDAY-->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr><th colspan="9" class="bg-dark text-white text-center">FRIDAY</th></tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Level</th>
                                <th>Lectuer</th>
                                <th>Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Friday' AND `level` = '$_SESSION[level]' ORDER BY cStart ASC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['course']; ?></td>
                                    <td> <?php
                                        $getcos = mysqli_query($db, "SELECT * FROM courses WHERE code = '$row[course]' "); 
                                        $costitle = mysqli_fetch_array($getcos); 
                                        echo $costitle['title']; 
                                        ?>
                                    </td>
                                    <td><?php echo $row['level']; ?></td>
                                    <td><?php 
                                        $getlec = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); 
                                        $lec = mysqli_fetch_array($getlec);
                                        echo $lec['fullname'];; 
                                        ?>
                                    </td>
                                    <td><?php 
                                        $gethall = mysqli_query($db, "SELECT * FROM halls WHERE hall_ID = '$row[hall]' "); 
                                        $hall = mysqli_fetch_array($gethall);
                                        echo $hall['hallName']; 
                                        ?>
                                    </td>
                                    <td><?php echo date('h:i A', strtotime($row['cStart'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['cEnd'])); ?></td>
                                    <td>
                                        <?php  if ($row['status']==0) { ?>
                                            <span class="text-danger"><b>Not Available</b></span>
                                        <?php } else if ($row['status']==1) { ?>
                                            <span class="text-success"><b>Available</b></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!--END LECTURER ONLY-->

                    <?php } ?>
                </main>
            </div>
        </div>
        
        


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
