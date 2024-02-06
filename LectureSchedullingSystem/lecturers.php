<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

    //ADD NEW lecturer
    if (isset($_POST['addLec'])) {

        $role = mysqli_real_escape_string($db, $_POST['role']);
        $acesID = mysqli_real_escape_string($db, $_POST['acesID']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $othername = mysqli_real_escape_string($db, $_POST['othername']);
        $fullname = $lastname.' '.$firstname.' '.$othername;
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $contact = mysqli_real_escape_string($db, $_POST['contact']);
        $lowercase = strtolower($lastname);
        $pass = md5($lowercase);

        // check if ID already exist
        $checkID = mysqli_query($db, "SELECT * FROM users WHERE acesID = '$acesID' ");
        // check if email already exist
        $checkemail = mysqli_query($db, "SELECT * FROM users WHERE email = '$email' ");
        // check if contact already exist
        $checkcontact = mysqli_query($db, "SELECT * FROM users WHERE contact = '$contact' ");

        if (mysqli_num_rows($checkID) == 1) {
            header('location:lecturers.php?msg=idex');
        } else if (mysqli_num_rows($checkemail) == 1) {
            header('location:lecturers.php?msg=emailex');
        } else if (mysqli_num_rows($checkcontact) == 1) {
            header('location:lecturers.php?msg=contactex');
        } else {
            $sql = "INSERT INTO users (`role`, acesID, title, fullname, email, contact, pass) VALUES ('$role', '$acesID', '$title', '$fullname', '$email', '$contact', '$pass')";
            if ($query_run = mysqli_query($db, $sql)) {
                header('location:lecturers.php?msg=lcad');
            } else {
                echo 'Error'.$sql.'<br>'.$db->error;
            } 
        }
    }

    //UPDATE RECORD 
    if (isset($_POST['updateLec'])) {

        $userID = mysqli_real_escape_string($db, $_POST['userID']);
        $acesID = mysqli_real_escape_string($db, $_POST['acesID']);
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $contact = mysqli_real_escape_string($db, $_POST['contact']);

        $sql = "UPDATE users SET acesID = '$acesID', title = '$title', fullname = '$fullname', email = '$email', contact = '$contact' WHERE userID = '$userID' ";
        if ($query_run = mysqli_query($db, $sql)) {
            header('location:lecturers.php?msg=recordup');
        } else {
            echo 'Error'.$sql.'<br>'.$db->error;
        } 
    }

    // DELETE RECORD
    if (isset($_GET['del'])) {
        $userID = $_GET['del'];
        $query = "DELETE FROM users WHERE userID=$userID";
        if (mysqli_query($db, $query)) {
            header('location:lecturers.php?msg=del');
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
                        <h4 class="h4">Lecturers</h4>
                    </div>

                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal">Add Lectuer</button>

                    <!--ADD NEW RECORD MODAL-->
                    <div class="modal fade" id="add_Record_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ADD LECTURER </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="role" value="L" class="form-control" readonly>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Staff ID</b></label>
                                                    <input type="text" name="acesID" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Title</b></label>
                                                    <select name="title" class="form-control" required>
                                                        <option></option>
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                        <option value="Dr.">Dr.</option>
                                                        <option value="Prof.">Prof.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Last Name</b></label>
                                                    <input type="text" name="lastname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Fisrt Name</b></label>
                                                    <input type="text" name="firstname" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Other Name</b></label>
                                                    <input type="text" name="othername" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Email Address</b></label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Phone Number</b></label>
                                                    <input type="text" name="contact" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="addLec" class="btn btn-dark">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END ADD NEW RECORD MODAL-->

                    <?php
                        // Record added successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='lcad') {
                            echo "<div class='text-primary text-center'>Record Added Successfully!</div>";
                        }
                        // ID Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='idex') {
                            echo "<div class='text-danger text-center'> Staff ID Already Exists!</div>";
                        }
                        // email Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='emailex') {
                            echo "<div class='text-danger text-center'> Email Address Already Exists!</div>";
                        }
                        // contact Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='contactex') {
                            echo "<div class='text-danger text-center'> Phone Number Already Exists!</div>";
                        }
                        // Record Updated Successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='recordup') {
                            echo "<div class='text-primary text-center'> Record Updated Successfully!</div>";
                        }
                        // Record Deleted successful message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='del') {
                            echo "<div class='text-danger text-center'>Record Delete Successfully!</div>";
                        }
                    ?>
                    <!-- END OPERATION MESSAGE-->

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th>Staff ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course(s)</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM users WHERE `role` = 'L' ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['acesID']; ?></td>
                                    <td><?php echo $row['title'].' '.$row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['contact']; ?></td>
                                    <td>
                                        <?php $gc = mysqli_query($db, "SELECT count(cosID) AS courseCount FROM courses WHERE lecturer = '$row[userID]' "); $c = mysqli_fetch_array($gc); echo $c['courseCount']; ?>    
                                    </td>
                                    <td>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['userID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="lecturers.php?del=<?php echo $row['userID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </td>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['userID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT LECTURER RECORD</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="userID" value="<?php echo $row['userID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Staff ID</b></label>
                                                        <input type="text" name="acesID" value="<?php echo $row['acesID'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Title</b></label>
                                                        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Fullname</b></label>
                                                        <input type="text" name="fullname" value="<?php echo $row['fullname'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Email Address</b></label>
                                                        <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b>Contact</b></label>
                                                        <input type="text" name="contact" value="<?php echo $row['contact'];?>" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateLec" class="btn btn-dark">Update</button>
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

                </main>
            </div>
        </div>
        
        


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
