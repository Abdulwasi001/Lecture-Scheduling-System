<?php
    session_start();
    //connection
    require('connect.php');

    if (isset($_POST['lssLogin'])) {
        $acesID = mysqli_real_escape_string($db, $_POST['acesID']);
        $pass = mysqli_real_escape_string($db, $_POST['pass']);
        $passwordHash = md5($pass);

        $query = "SELECT * FROM users WHERE acesID = '$acesID' AND pass = '$passwordHash' ";
        $result = mysqli_query($db, $query);

        while ($row = $result->fetch_assoc()){
                
            $userID = $row['userID']; $role = $row['role']; $acesID = $row['acesID'];
            $title = $row['title']; $fullname = $row['fullname']; $contact = $row['contact']; 
            $email = $row['email']; $level = $row['level'];
        }

        if ($result->num_rows == 0) {
            header('location:sign-in.php?msg=invalid');

        } else if ($result->num_rows == 1) {
            header("Location: home.php");
                
            $_SESSION['lssloggedID'] = true; $_SESSION['userID'] = $userID;
            $_SESSION['role'] = $role; $_SESSION['acesID'] = $acesID; $_SESSION['title'] = $title; 
            $_SESSION['fullname'] = $fullname; $_SESSION['contact'] = $contact; 
            $_SESSION['email'] = $email; $_SESSION['level'] = $level;  
        }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
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
            .login-box {width: 30%; margin: 10% auto;}
            .form-group {margin-bottom: 15px;}
            .input-box {display: inline-block; width: 100%;}
            .input-box i {width: 10%; text-align: center; padding: 12px; background: black; color: white;}
            .input-box input { width: 90%; float: right; border: 0px; outline: 0px; padding: 8px; background: rgb(233, 229, 229);}
            .form-box button {width: 100%;}
            .form-group label {font-size: 17px;}
            @media (max-width: 769px) {.login-box {width: 80%;}}
        </style>
    </head>
    <body>
        
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Lecture Schedulling System</a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid">
           <div class="login-box">
                <?php 
                    // invalid sign-in detail
                    if (isset($_GET['msg']) AND $_GET['msg']=='invalid') {
                        echo "<div class='text-danger text-center'>Invalid Login Detail!</div>";
                    } 
                    // password change successful
                    if (isset($_GET['msg']) AND $_GET['msg']=='pass_success') {
                        echo "<div class='text-primary text-center'>Password Changed Successful, Kindly Sign-In with the New Password.</div>";
                    } 
                ?>
                <div class="form-box">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for=""><b>User ID</b></label>
                            <div class="input-box">
                                <i class="fa fa-user"></i>
                                <input type="text" name="acesID" placeholder="Enter User ID" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""><b>Password</b></label>
                            <div class="input-box">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="pass" placeholder="Enter Password" required>
                            </div>   
                        </div>
                        <button type="submit" name="lssLogin" class="btn btn-dark">SIGN IN</button>
                    </form>
                </div>
           </div>
        </main>


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
