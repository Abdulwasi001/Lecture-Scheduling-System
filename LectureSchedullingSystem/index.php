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
        <style>
            nav form a {text-decoration: none; color: white;}
            nav form a:hover {color: grey;}
            body {padding-top: 3.5rem; background-image: url("img/bgs.png"); background-repeat: no-repeat;  background-size: 100% 800px;}
            .main-box {text-align: center; margin: 10% auto; width: 40%;}
            .main-box h1 {
                color: #fff;
                font-size: 40px;
                text-shadow: 4px 4px 8px rgba(0, 0, 0, 1);
            }
            @media (max-width: 768px){
                body {
                    background-size: 100% 800px;
                }
                .main-box {
                    width: 90%;
                }
                .main-box h1 {
                    font-size: 30px;
                }
            }
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

        <main class="">
            <div class="main-box">
                <h1>Welcome to <br> Lecture Schedulling System</h1>
                <form action="get_schedule.php" method="get">
                    <div class="input-box">
                        <div class="row">
                            <div class="col-10">
                                <select name="level" class="form-control" required>
                                    <option></option>
                                    <option value="100">100 Level</option>
                                    <option value="200">200 Level</option>
                                    <option value="300">300 Level</option>
                                    <option value="400">400 Level</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        
                        
                    </div>
                </form>
            </div>
        </main>


        <script src="js/bootstrap.bundle.min.js"></script>
    </body>
</html>
