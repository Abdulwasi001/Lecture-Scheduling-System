<?php
    // connection
    require('connect.php');
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
            nav form a {text-decoration: none; color: white;}
            nav form a:hover {color: grey;}
            body {padding-top: 3.5rem; min-height: 0rem}
        </style>
    </head>
    <body>
        
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Lecture Schedulling System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    </ul>
                    <form class="d-flex">
                        <a href="sign-in.php"><i class="fa fa-sign-in"></i> Sign In</a>
                    </form>
                </div>
            </div>
        </nav>

        <main class="container">
            <?php if (isset($_GET['level'])) {?>
                <div class="mt-4 text-center"><h5><?php echo $_GET['level']; ?> Level Lecture Schedule</h5></div>
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
                            $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Monday' AND `level` = '$_GET[level]' ORDER BY cStart ASC ");
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
                            $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Tuesday' AND `level` = '$_GET[level]' ORDER BY cStart ASC ");
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
                            $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Wednesday' AND `level` = '$_GET[level]' ORDER BY cStart ASC ");
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
                            $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Thursday' AND `level` = '$_GET[level]' ORDER BY cStart ASC ");
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
                            $query = mysqli_query($db, "SELECT * FROM schedules WHERE `days` = 'Friday' AND `level` = '$_GET[level]' ORDER BY cStart ASC ");
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


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
