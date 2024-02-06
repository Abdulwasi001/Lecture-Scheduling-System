
                <nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <div class="text-center user-detail">
                            <img src="img/student.png" alt="Image">
                            <div class="">
                                <h5><?php echo $_SESSION['title']; ?></h5>
                                <h5><?php echo $_SESSION['fullname']; ?></h5>
                                <h6><?php echo $_SESSION['email']; ?></h6>
                                <h6><?php echo $_SESSION['contact']; ?></h6>
                                <h6><?php if ($_SESSION['role']=='S') { echo $_SESSION['level'].' '.'Level'; }  ?> </h6>
                            </div>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link"  href="home.php"> Dashboard</a>
                            </li>
                            <?php if ($_SESSION['role']=='Admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="lecturers.php"> Lecturers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="students.php"> Students</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="lecture-rooms.php"> Lecture Rooms</a>
                            </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" href="courses.php"> Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="schedules.php"> Schedules</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="announcement.php"> Announcement 
                                    <?php if ($_SESSION['role']=='L') { 
                                        $glec = mysqli_query($db, "SELECT count(anoID) AS lecCount FROM anounces WHERE `target` = '$_SESSION[userID]' AND `status` = '0' "); $lec = mysqli_fetch_array($glec);
                                        if ($lec['lecCount'] > 0) { ?> <span> <?php echo $lec['lecCount']; ?></span> 
                                    <?php } } elseif ($_SESSION['role']=='S') { 
                                        $gstu = mysqli_query($db, "SELECT count(anoID) AS stuCount FROM anounces WHERE `target` = '$_SESSION[level]' AND `status` = '0' "); $stu = mysqli_fetch_array($gstu);
                                        
                                        if ($stu['stuCount'] > 0) { ?> <span> <?php echo $stu['stuCount']; ?></span> 
                                    <?php } } ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="return confirm('Do you want to sign out?')" href="sign-out.php"> Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>