<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

    $currentTime = date('Y-m-d h:i A');
    $expireTime = date('Y-m-d h:i A', strtotime(('24 hours')));

    //ADD NEW lecturer
    if (isset($_POST['sendMsg'])) {

        $senderID = mysqli_real_escape_string($db, $_POST['senderID']);
        $target = mysqli_real_escape_string($db, $_POST['target']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $msg = mysqli_real_escape_string($db, $_POST['msg']);
        $sent_day = mysqli_real_escape_string($db, $_POST['sent_day']);
        $expired = mysqli_real_escape_string($db, $_POST['expired']);
        $doc = $_FILES["doc"]["name"];
		$tempname = $_FILES["doc"]["tmp_name"];	
		$folder = "documents/".$doc;

        $sql = "INSERT INTO anounces (senderID, `target`, title, msg, doc, sent_day, expired) VALUES ('$senderID', '$target', '$title', '$msg', '$doc', '$sent_day', '$expired')";
        if ($query_run = mysqli_query($db, $sql)) {
            move_uploaded_file($tempname, $folder);
            header('location:announcement.php?msg=adn');
        } else {
            echo 'Error'.$sql.'<br>'.$db->error;
        } 
    }

    // DELETE RECORD
    if (isset($_GET['del'])) {
        $anoID = $_GET['del'];
        $query = "DELETE FROM anounces WHERE anoID=$anoID";
        if (mysqli_query($db, $query)) {
            header('location:announcement.php?msg=del');
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
            h1, h2, h3, h4, h5, h6, p, a {margin: 0px; padding: 0px;}
            .user-detail img {width: 100px; height: 100px; border-radius: 100%;}
            table span { color: blue; margin-left: 5px; cursor: pointer;}
            table span:hover {color: grey;}
            table a i { color: red; margin-left: 10px;}
            table a i:hover {color: gray;}
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
                        <h4 class="h4">Announcement</h4>
                    </div>

                    <?php if ($_SESSION['role']=='Admin' OR $_SESSION['role']=='L') { ?>
                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal">To Student</button>

                    <!--SEND MESSAGE TO STUDENTS MODAL-->
                    <div class="modal fade" id="add_Record_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">SEND MESSAGE TO STUDENTS</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="sent_day" value="<?php echo $currentTime;?>" 
                                            class="form-control" required>
                                            <input type="hidden" name="expired" value="<?php echo $expireTime;?>" 
                                            class="form-control" required>
                                            <input type="hidden" name="senderID" value="<?php echo $_SESSION['userID'];?>" class="form-control" required>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Level</b></label>
                                                    <select name="target" class="form-control" required>
                                                        <option></option>
                                                        <option value="100">100 Level</option>
                                                        <option value="200">200 Level</option>
                                                        <option value="300">300 Level</option>
                                                        <option value="400">400 Level</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Title</b></label>
                                                    <input type="text" name="title" maxlength="100" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Message</b></label>
                                                    <textarea name="msg" cols="30" rows="10" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Document</b></label>
                                                    <input type="file" name="doc" accept=".pdf, .doc, .docx, .xls, .pptx, .ppt" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="sendMsg" class="btn btn-dark">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END SEND MESSAGE TO STUDENTS MODAL-->
                    <?php } ?>

                    <?php if ($_SESSION['role']=='Admin') { ?>
                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal2">To Lecture</button>

                    <!--SEND MESSAGE TO LECTURER MODAL-->
                    <div class="modal fade" id="add_Record_Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">SEND MESSAGE TO LECTURER</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="sent_day" value="<?php echo $currentTime;?>" 
                                            class="form-control" required>
                                            <input type="hidden" name="expired" value="<?php echo $expireTime;?>" 
                                            class="form-control" required>
                                            <input type="hidden" name="senderID" value="<?php echo $_SESSION['userID'];?>" class="form-control" required>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Lectuer</b></label>
                                                    <select name="target" class="form-control" required>
                                                        <?php
                                                            $s = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                                            $row_count = mysqli_num_rows($s);
                                                            if ($row_count) {
                                                                $c = "<option></option>; ";
                                                                while ($row = mysqli_fetch_assoc($s)) {
                                                                    $c .= "<option value='$row[userID]'> $row[fullname]</option>";
                                                                }
                                                                echo $c;
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Title</b></label>
                                                    <input type="text" name="title" maxlength="100" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Message</b></label>
                                                    <textarea name="msg" cols="30" rows="10" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Document</b></label>
                                                    <input type="file" name="doc" accept=".pdf, .doc, .docx, .xls, .pptx, .ppt" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="sendMsg" class="btn btn-dark">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END SEND MESSAGE TO LECTURER MODAL-->
                    <?php } ?>

                    <!--OPERATION MESSAGE-->
                    <?php
                        // Record added successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='adn') {
                            echo "<div class='text-primary text-center'>Message Sent</div>";
                        }
                        // Record Deleted successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='del') {
                            echo "<div class='text-danger text-center'>Delete Successful!</div>";
                        }
                    ?>
                    <!-- END OPERATION MESSAGE-->

                    <!-- SENT BY ADMIN -->
                    <?php if ($_SESSION['role']=='Admin') { ?>
                    <div class="table-responsive">
                        <div class="text-center"><h5>Announcements</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th>Date</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM anounces ORDER BY anoID DESC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['sent_day']; ?></td>
                                    <td>
                                        <?php $gesender = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[senderID]' "); $sender = mysqli_fetch_array($gesender); echo $sender['fullname']; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($row['target'] == '100' OR $row['target'] == '200' OR $row['target'] == '300' OR $row['target'] == '400' ) {
                                                echo $row['target'].' '.'Level Students';
                                            } else {
                                                $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[target]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; 
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['expired'] == $currentTime) {
                                                $updateStatus = mysqli_query($db, "UPDATE anounces SET `status` = 1 WHERE `anoID` = '$row[anoID]' ");
                                            }
                                        
                                            if ($row['status']==1) { ?>
                                                <span class="text-danger"><b>Expired</b></span>
                                        <?php } else if ($row['status']==0) { ?>
                                                <span class="text-success"><b>Active</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['anoID'];?>"><i class="fa fa-eye"></i></span>
                                        <a href="announcement.php?del=<?php echo $row['anoID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['anoID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">READ MESSAGE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class='text-primary mb-3'>From: </span>
                                                    <h6><?php echo $sender['fullname']; ?></h6> <hr>
                                                    <span class='text-primary mb-3 mt-3'>Title: </span>
                                                    <h6><?php echo $row['title'];?></h6> <hr>
                                                    <span class='text-primary mt-3'>Message: </span>
                                                    <h6><?php echo $row['msg'];?></h6>
                                                    <?php if ($row['doc'] != '') { ?>
                                                        <a class="btn btn-dark mt-3" href="download.php?doc=<?php echo $row['doc'] ?>">Download</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <?php } ?>
                    <!-- END SENT BY ADMIN -->

                    <!-- SENT BY LECTURER -->
                    <!-- RECEIVED -->
                    <?php if ($_SESSION['role']=='L') { ?>
                    <div class="table-responsive">
                        <div class="text-center"><h5>Announcements Received (Inbox)</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th>Date</th>
                                <th>Sender</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM anounces WHERE `target` = '$_SESSION[userID]' ORDER BY anoID DESC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['sent_day']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[senderID]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; ?>
                                    </td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['expired'] == $currentTime) {
                                                $updateStatus = mysqli_query($db, "UPDATE anounces SET `status` = 1 WHERE `anoID` = '$row[anoID]' ");
                                            }
                                        
                                            if ($row['status']==1) { ?>
                                                <span class="text-danger"><b>Expired</b></span>
                                        <?php } else if ($row['status']==0) { ?>
                                                <span class="text-success"><b>Active</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['anoID'];?>"><i class="fa fa-eye"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['anoID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">READ MESSAGE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class='text-primary mb-3'>From: </span>
                                                    <h6><?php echo $c['fullname']; ?></h6> <hr>
                                                    <span class='text-primary mb-3 mt-3'>Title: </span>
                                                    <h6><?php echo $row['title'];?></h6> <hr>
                                                    <span class='text-primary mt-3'>Message: </span>
                                                    <h6><?php echo $row['msg'];?></h6>
                                                    <?php if ($row['doc'] != '') { ?>
                                                        <a class="btn btn-dark mt-3" href="download.php?doc=<?php echo $row['doc'] ?>">Download</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <!-- SENT -->
                    <div class="table-responsive">
                        <div class="text-center"><h5>Announcements Sent (Outbox)</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th>Date</th>
                                <th>Receiver</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM anounces WHERE `senderID` = '$_SESSION[userID]' ORDER BY anoID DESC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['sent_day']; ?></td>
                                    <td><?php echo $row['target'].' '.'Level Students'; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['expired'] == $currentTime) {
                                                $updateStatus = mysqli_query($db, "UPDATE anounces SET `status` = 1 WHERE `anoID` = '$row[anoID]' ");
                                            }
                                        
                                            if ($row['status']==1) { ?>
                                                <span class="text-danger"><b>Expired</b></span>
                                        <?php } else if ($row['status']==0) { ?>
                                                <span class="text-success"><b>Active</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['anoID'];?>"><i class="fa fa-eye"></i></span>
                                        <a href="announcement.php?del=<?php echo $row['anoID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['anoID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">READ MESSAGE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class='text-primary mb-3'>To: </span>
                                                    <h6><?php echo $row['target'].' '.'Level Students'; ?></h6> <hr>
                                                    <span class='text-primary mb-3 mt-3'>Title: </span>
                                                    <h6><?php echo $row['title'];?></h6> <hr>
                                                    <span class='text-primary mt-3'>Message: </span>
                                                    <h6><?php echo $row['msg'];?></h6>
                                                    <?php if ($row['doc'] != '') { ?>
                                                        <a class="btn btn-dark mt-3" href="download.php?doc=<?php echo $row['doc'] ?>">Download</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <?php } ?>
                    <!-- END SENT BY LECTURER -->

                    <!-- STUDENT VIEW -->
                    <?php if ($_SESSION['role']=='S') { ?>
                    <div class="table-responsive">
                        <div class="text-center"><h5>Announcements</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th>Date</th>
                                <th>Sender</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM anounces WHERE `target` = '$_SESSION[level]' ORDER BY anoID DESC ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['sent_day']; ?></td>
                                    <td>
                                        <?php $gsender2 = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[senderID]' "); $sender2 = mysqli_fetch_array($gsender2); echo $sender2['fullname']; ?>
                                    </td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td>
                                        <?php 
                                            if ($row['expired'] == $currentTime) {
                                                $updateStatus = mysqli_query($db, "UPDATE anounces SET `status` = 1 WHERE `anoID` = '$row[anoID]' ");
                                            }
                                        
                                            if ($row['status']==1) { ?>
                                                <span class="text-danger"><b>Expired</b></span>
                                        <?php } else if ($row['status']==0) { ?>
                                                <span class="text-success"><b>Active</b></span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['anoID'];?>"><i class="fa fa-eye"></i></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['anoID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">READ MESSAGE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class='text-primary mb-3'>From: </span>
                                                    <h6><?php echo $sender2['fullname']; ?></h6> <hr>
                                                    <span class='text-primary mb-3 mt-3'>Title: </span>
                                                    <h6><?php echo $row['title'];?></h6> <hr>
                                                    <span class='text-primary mt-3'>Message: </span>
                                                    <h6><?php echo $row['msg'];?></h6>
                                                    <?php if ($row['doc'] != '') { ?>
                                                        <a class="btn btn-dark mt-3" href="download.php?doc=<?php echo $row['doc'] ?>">Download</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <?php } ?>
                    <!-- END STUDENT VIEW -->

                </main>
            </div>
        </div>
        
        


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
