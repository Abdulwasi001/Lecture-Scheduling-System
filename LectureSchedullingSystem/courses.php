<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

    //ADD NEW 
    if (isset($_POST['addCos'])) {

        $code = mysqli_real_escape_string($db, $_POST['code']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $unit = mysqli_real_escape_string($db, $_POST['unit']);
        $level = mysqli_real_escape_string($db, $_POST['level']);
        $lecturer = mysqli_real_escape_string($db, $_POST['lecturer']);

        // check if code already exist
        $checkc = mysqli_query($db, "SELECT * FROM courses WHERE code = '$code' ");
        // check if code already exist
        $checkt = mysqli_query($db, "SELECT * FROM courses WHERE code = '$code' ");

        if (mysqli_num_rows($checkc) == 1) {
            header('location:courses.php?msg=ex');
        } else if (mysqli_num_rows($checkt) == 1) {
            header('location:courses.php?msg=tex');
        } else {
            $sql = "INSERT INTO courses (code, title, unit, `level`, lecturer) VALUES ('$code', '$title', '$unit', '$level', '$lecturer')";
            if ($query_run = mysqli_query($db, $sql)) {
                header('location:courses.php?msg=ad');
            } else {
                echo 'Error'.$sql.'<br>'.$db->error;
            } 
        }
    }

    //UPDATE RECORD 
    if (isset($_POST['updateCos'])) {

        $cosID  = mysqli_real_escape_string($db, $_POST['cosID']);
        $code = mysqli_real_escape_string($db, $_POST['code']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $unit = mysqli_real_escape_string($db, $_POST['unit']);
        $level = mysqli_real_escape_string($db, $_POST['level']);
        $lecturer = mysqli_real_escape_string($db, $_POST['lecturer']);

        $sql = "UPDATE courses SET code = '$code', title = '$title', unit = '$unit', `level` = '$level', lecturer = '$lecturer' WHERE cosID  = '$cosID' ";
        if ($query_run = mysqli_query($db, $sql)) {
            header('location:courses.php?msg=up');
        } else {
            echo 'Error'.$sql.'<br>'.$db->error;
        } 
    }

    // DELETE RECORD
    if (isset($_GET['del'])) {
        $cosID = $_GET['del'];
        $query = "DELETE FROM courses WHERE cosID =$cosID ";
        if (mysqli_query($db, $query)) {
            header('location:courses.php?msg=del');
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
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="home.php">Lecture Schedulling System</a>
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
                        <h4 class="h4">Courses</h4>
                    </div>
                    <!--ADMIN ONLY-->
                    <?php if ($_SESSION['role']=='Admin') { ?>

                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal">Add Course</button>

                    <!--ADD NEW RECORD MODAL-->
                    <div class="modal fade" id="add_Record_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ADD COURSE </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Course Code</b></label>
                                                    <input type="text" name="code" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Course Title</b></label>
                                                    <input type="text" name="title" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Course Unit</b></label>
                                                    <input type="number" name="unit" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Level</b></label>
                                                    <select name="level" class="form-control" required>
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
                                                    <label for=""><b>Lectuer</b></label>
                                                    <select name="lecturer" class="form-control" required>
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
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="addCos" class="btn btn-dark">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END ADD NEW RECORD MODAL-->

                    <?php
                        // Record added successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='ad') {
                            echo "<div class='text-primary text-center'>Added Successfully!</div>";
                        }
                        // Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='ex') {
                            echo "<div class='text-danger text-center'> Course Code Already Exists!</div>";
                        }
                        //  Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='tex') {
                            echo "<div class='text-danger text-center'> Course Title Already Exists!</div>";
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
                        <!-- 100 level course-->
                        <div class="text-center"><h5>100 Level Courses</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Lecturer-In-Charge</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `level` = '100' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; ?>    
                                    </td>
                                    <th>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['cosID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="courses.php?del=<?php echo $row['cosID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </th>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['cosID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT COURSE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="cosID" value="<?php echo $row['cosID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Code</b></label>
                                                        <input type="text" name="code" value="<?php echo $row['code'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Title</b></label>
                                                        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Unit</b></label>
                                                        <input type="number" name="unit" value="<?php echo $row['unit'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Level</b></label>
                                                        <select name="level" class="form-control" required>
                                                            <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?> Level</option>
                                                            <option value="100">100 Level</option>
                                                            <option value="200">200 Level</option>
                                                            <option value="300">300 Level</option>
                                                            <option value="400">400 Level</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Lecturer-In-Charge</b></label>
                                                        
                                                        <select name="lecturer" class="form-control">
                                                            <?php
                                                                $s = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                                                $row_count = mysqli_num_rows($s);
                                                                if ($row_count) {
                                                                    $c = "<option value='$row[lecturer]'></option>; ";
                                                                    while ($r = mysqli_fetch_assoc($s)) {
                                                                        $c .= "<option value='$r[userID]'> $r[fullname]</option>";
                                                                    }
                                                                    echo $c;
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateCos" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL--> 
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END 100 level course-->

                        <!-- 200 level course-->
                        <div class="text-center"><h5>200 Level Courses</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Lecturer-In-Charge</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `level` = '200' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; ?>    
                                    </td>
                                    <th>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['cosID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="courses.php?del=<?php echo $row['cosID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </th>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['cosID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT COURSE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="cosID" value="<?php echo $row['cosID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Code</b></label>
                                                        <input type="text" name="code" value="<?php echo $row['code'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Title</b></label>
                                                        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Unit</b></label>
                                                        <input type="number" name="unit" value="<?php echo $row['unit'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Level</b></label>
                                                        <select name="level" class="form-control" required>
                                                            <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?> Level</option>
                                                            <option value="100">100 Level</option>
                                                            <option value="200">200 Level</option>
                                                            <option value="300">300 Level</option>
                                                            <option value="400">400 Level</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Lecturer-In-Charge</b></label>
                                                        
                                                        <select name="lecturer" class="form-control">
                                                            <?php
                                                                $s = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                                                $row_count = mysqli_num_rows($s);
                                                                if ($row_count) {
                                                                    $c = "<option value='$row[lecturer]'></option>; ";
                                                                    while ($r = mysqli_fetch_assoc($s)) {
                                                                        $c .= "<option value='$r[userID]'> $r[fullname]</option>";
                                                                    }
                                                                    echo $c;
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateCos" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL--> 
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END 200 level course-->

                        <!-- 300 level course-->
                        <div class="text-center"><h5>300 Level Courses</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Lecturer-In-Charge</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `level` = '300' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; ?>    
                                    </td>
                                    <th>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['cosID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="courses.php?del=<?php echo $row['cosID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </th>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['cosID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT COURSE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="cosID" value="<?php echo $row['cosID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Code</b></label>
                                                        <input type="text" name="code" value="<?php echo $row['code'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Title</b></label>
                                                        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Unit</b></label>
                                                        <input type="number" name="unit" value="<?php echo $row['unit'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Level</b></label>
                                                        <select name="level" class="form-control" required>
                                                            <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?> Level</option>
                                                            <option value="100">100 Level</option>
                                                            <option value="200">200 Level</option>
                                                            <option value="300">300 Level</option>
                                                            <option value="400">400 Level</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Lecturer-In-Charge</b></label>
                                                        
                                                        <select name="lecturer" class="form-control">
                                                            <?php
                                                                $s = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                                                $row_count = mysqli_num_rows($s);
                                                                if ($row_count) {
                                                                    $c = "<option value='$row[lecturer]'></option>; ";
                                                                    while ($r = mysqli_fetch_assoc($s)) {
                                                                        $c .= "<option value='$r[userID]'> $r[fullname]</option>";
                                                                    }
                                                                    echo $c;
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateCos" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL--> 
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END 300 level course-->

                        <!-- 400 level course-->
                        <div class="text-center"><h5>400 Level Courses</h5></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Lecturer-In-Charge</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `level` = '400' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT * FROM users WHERE userID = '$row[lecturer]' "); $c = mysqli_fetch_array($gc); echo $c['fullname']; ?>    
                                    </td>
                                    <th>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['cosID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="courses.php?del=<?php echo $row['cosID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </th>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['cosID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT COURSE </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="cosID" value="<?php echo $row['cosID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Code</b></label>
                                                        <input type="text" name="code" value="<?php echo $row['code'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Title</b></label>
                                                        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Unit</b></label>
                                                        <input type="number" name="unit" value="<?php echo $row['unit'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Level</b></label>
                                                        <select name="level" class="form-control" required>
                                                            <option value="<?php echo $row['level'];?>"><?php echo $row['level'];?> Level</option>
                                                            <option value="100">100 Level</option>
                                                            <option value="200">200 Level</option>
                                                            <option value="300">300 Level</option>
                                                            <option value="400">400 Level</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Lecturer-In-Charge</b></label>
                                                        
                                                        <select name="lecturer" class="form-control">
                                                            <?php
                                                                $s = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                                                $row_count = mysqli_num_rows($s);
                                                                if ($row_count) {
                                                                    $c = "<option value='$row[lecturer]'></option>; ";
                                                                    while ($r = mysqli_fetch_assoc($s)) {
                                                                        $c .= "<option value='$r[userID]'> $r[fullname]</option>";
                                                                    }
                                                                    echo $c;
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateCos" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT RECORD MODAL--> 
                            <?php } ?>
                            </tbody>
                        </table>
                        <!-- END 400 level course-->
                    </div>
                    <!--END ADMIN ONLY-->

                    <?php } else if ($_SESSION['role']=='L') {?>
                    
                    <!--LECTURER ONLY-->
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Level</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `lecturer` = '$_SESSION[userID]' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td><?php echo $row['level']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!--END LECTURER ONLY-->

                    <?php } else if ($_SESSION['role']=='S') {?>

                    <!--STUDENT ONLY-->
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM courses WHERE `level` = '$_SESSION[level]' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!--END STUDENT ONLY-->
                    <?php } ?>

                </main>
            </div>
        </div>
        
        


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
