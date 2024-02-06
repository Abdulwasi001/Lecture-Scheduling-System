<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

    //ADD NEW 
    if (isset($_POST['addHall'])) {

        $hallName = mysqli_real_escape_string($db, $_POST['hallName']);

        // check if ID already exist
        $checkname = mysqli_query($db, "SELECT * FROM halls WHERE hallName = '$hallName' ");

        if (mysqli_num_rows($checkname) == 1) {
            header('location:lecture-rooms.php?msg=ex');
        } else {
            $sql = "INSERT INTO halls (hallName) VALUES ('$hallName')";
            if ($query_run = mysqli_query($db, $sql)) {
                header('location:lecture-rooms.php?msg=ad');
            } else {
                echo 'Error'.$sql.'<br>'.$db->error;
            } 
        }
    }

    //UPDATE RECORD 
    if (isset($_POST['updateHall'])) {

        $hall_ID = mysqli_real_escape_string($db, $_POST['hall_ID']);
        $hallName = mysqli_real_escape_string($db, $_POST['hallName']);

        $sql = "UPDATE halls SET hallName = '$hallName' WHERE hall_ID = '$hall_ID' ";
        if ($query_run = mysqli_query($db, $sql)) {
            header('location:lecture-rooms.php?msg=up');
        } else {
            echo 'Error'.$sql.'<br>'.$db->error;
        } 
    }

    // DELETE RECORD
    if (isset($_GET['del'])) {
        $hall_ID = $_GET['del'];
        $query = "DELETE FROM halls WHERE hall_ID=$hall_ID";
        if (mysqli_query($db, $query)) {
            header('location:lecture-rooms.php?msg=del');
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
                        <h4 class="h4">Lecture Rooms</h4>
                    </div>

                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#add_Record_Modal">Add Lecture Room</button>

                    <!--ADD NEW RECORD MODAL-->
                    <div class="modal fade" id="add_Record_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ADD LECTURE ROOM </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for=""><b>Hall Name</b></label>
                                                    <input type="text" name="hallName" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="addHall" class="btn btn-dark">Save</button>
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
                        // hall name Already Exist message 
                        if (isset($_GET['msg']) AND $_GET['msg']=='ex') {
                            echo "<div class='text-danger text-center'> Hall Name Already Exists!</div>";
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
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th style="width: 10%;"></th>
                                <th>Hall Name</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
                                $sn = 1;
                                $query = mysqli_query($db, "SELECT * FROM halls ");
                                while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                <td><?php echo $sn++; ?></td>
                                    <td><?php echo $row['hallName']; ?></td>
                                    <th>
                                        <span data-bs-toggle="modal" data-bs-target="#edit_Record_Modal<?php echo $row['hall_ID'];?>"><i class="fa fa-edit"></i></span> 
                                        <a href="lecture-rooms.php?del=<?php echo $row['hall_ID']; ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash-o"></i> </a></td>
                                    </th>
                                </tr>
                            <?php ?>
                                <!-- EDIT RECORD MODAL-->
                                <div class="modal fade" id="edit_Record_Modal<?php echo $row['hall_ID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT LECTURER ROOM </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="hall_ID" value="<?php echo $row['hall_ID'];?>" class="form-control" required readonly>
                                                    <div class="form-group">
                                                        <label for=""><b>Hall Name</b></label>
                                                        <input type="text" name="hallName" value="<?php echo $row['hallName'];?>" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateHall" class="btn btn-dark">Update</button>
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
