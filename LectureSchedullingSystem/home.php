<?php
    session_start();

    // connection
    require('connect.php');

    if(!isset($_SESSION['lssloggedID'])){ header('location:sign-in.php');}

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
            h1, h2, h3, h4, h5, h6, hr, p, a {margin: 0px; padding: 0px;}
            a {text-decoration: none;}
            .user-detail img {width: 100px; height: 100px; border-radius: 100%;}
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
                        <h4 class="h4">Home</h4>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="home.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/home.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Home</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <?php if ($_SESSION['role']=='Admin') { ?>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="lecturers.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/lecturer.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Lecturers</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="students.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/student.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Students</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="lecture-rooms.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/hall.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Lecture Halls</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="courses.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/course.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Courses</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="schedules.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/scheduled.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Schedules</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-md-4 col-lg-4 mb-1">
                            <a href="announcement.php">
                                <div class="card main-box">
                                <div class="card-body">
                                    <div class="no-gutters align-items-center text-center">
                                    <img src="img/announce.png" width="100px" height="100px" alt="Image">
                                    <p class="text-300 mt-3"><h6 class="text-dark">Announcements</h6></p>
                                    </div>
                                </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </main>
            </div>
        </div>
        
        


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
