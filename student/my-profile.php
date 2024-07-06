<?php
session_start();
include("../include/connect.php");

$new_password_err = null;

if (isset($_SESSION["student_id"])) {

    //LOGGED IN USER ID
    $user_id = $_SESSION["student_id"];

    $sql = mysqli_query($connect, "SELECT * FROM `student` WHERE student_id = $user_id");

    $fetch = mysqli_fetch_assoc($sql);


    $firstname = $fetch["firstname"];
    $lastname = $fetch["lastname"];
    $othername = $fetch["othername"];
    $email = $fetch["email"];
    $matric = $fetch["matric"];

    if (isset($fetch["blood_group"])) {
        $bloodgroup = $fetch["blood_group"];
        $genotype = $fetch["genotype"];
    }


    if (isset($_POST["submit"])) {
        $new_firstname = $_POST["firstname"];
        $new_lastname = $_POST["lastname"];
        $new_othername = $_POST["othername"];
        $new_email = $_POST["email"];
        $new_matric = $_POST["matric"];
        $new_password = $_POST["password"];
        $new_bloodgroup = $_POST["bloodgroup"];
        $new_genotype = $_POST["genotype"];

        if (strlen($new_password) < 6) {
            echo '
                <script>
                  alert("Update not Successful!");
                </script>
            ';
            $new_password_err = "Password value must be up to six(6)";
        } else {
            //hashing updated password
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);



            $updating_profile = mysqli_query($connect, "UPDATE `student` SET `firstname`='$new_firstname',`lastname`='$new_lastname',`othername`='$new_othername',`email`='$new_email',`matric`='$new_matric',`password`='$new_password',`blood_group`='$new_bloodgroup',`genotype`='$new_genotype' WHERE student_id = $user_id");

            if ($updating_profile) {
                echo '
                <script>
                  alert("Update Successful!");
                  window.location.href="my-profile.php";
                </script>
             ';
            }
        }
    }
} else {
    echo "
    <script>
        alert('Oops! You are not logged in!');
        window.location.href='../signin.php';
    </script>
    ";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>ABS - Appointment Booking System</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- site icon -->
    <link rel="icon" href="images/fevicon.png" type="image/png" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- site css -->
    <link rel="stylesheet" href="style.css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- color css -->
    <link rel="stylesheet" href="css/colors.css" />
    <!-- select bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="css/custom.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .personal-card {
            max-width: 800px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .personal-card .card-body {
            padding: 20px;
        }

        .personal-card .card-title {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .info-row h6 {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        .info-row p {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
            /* to make the name bold */
        }

        .truncated {
            max-width: 180px;
            /* Adjust the max-width as needed */
            overflow: hidden;
            /* text-overflow: ellipsis; */
            white-space: wrap;
        }
    </style>

</head>

<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar_blog_1">
                    <div class="sidebar-header">
                        <div class="logo_section">
                            <a href="index.html"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
                        </div>
                    </div>
                    <div class="sidebar_user_info">
                        <div class="icon_setting"></div>
                        <div class="user_profle_side">
                            <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
                            <div class="user_info">
                                <h6><?php echo $firstname . " " . $lastname; ?></h6>
                                <p><span class="online_animation"></span> Online</p>
                                <h6 class="fs-5" style="color: #ff5722; font-weight:600;">Student</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar_blog_2">
                    <h4>General</h4>
                    <ul class="list-unstyled components">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>

                        <li>
                            <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-diamond purple_color"></i> <span>Appointments</span></a>
                            <ul class="collapse list-unstyled" id="element">
                                <li><a href="book-appointment.php">> <span>Book Appointment</span></a></li>
                                <li><a href="appointment-status.php">> <span>Appointment Status</span></a></li>
                                <li><a href="all-appointments-history.php"> <span>All Appointments History</span></a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="contact.php">
                                <i class="fa fa-paper-plane red_color"></i> <span>Contact</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                            <div class="right_topbar">
                                <div class="icon_info">
                                    <ul class="user_profile_dd">
                                        <li>
                                            <a class="dropdown-toggle" data-toggle="dropdown"><span class="name_user"><?php echo $firstname . " " . $lastname; ?></span></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="my-profile.php">My Profile</a>
                                                <a class="dropdown-item" href="logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Profile</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light text-center rounded p-4">

                            <div class="container w-100">
                                <div class="card personal-card">
                                    <div class="card-body w-100">
                                        <h4 class="card-title mb-4">Personal Information</h4>

                                        <div class="info-row">
                                            <h6 class="mb-0">First Name</h6>
                                            <p class="mb-0 text-truncate"><?php echo $firstname; ?></p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Last Name</h6>
                                            <p class="mb-0 text-truncate"><?php echo $lastname; ?></p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Other Name</h6>
                                            <p class="mb-0 text-truncate"><?php echo $othername; ?></p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Matric Number</h6>
                                            <p class="mb-0 text-truncate"><?php echo $matric; ?></p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Email</h6>
                                            <p class="mb-0 truncated"><?php echo $email; ?> </p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Blood Group</h6>
                                            <p class="mb-0 truncated">
                                                <?php
                                                if (empty($bloodgroup)) {
                                                    echo 'Not set';
                                                } else {
                                                    echo $bloodgroup;
                                                }
                                                ?>
                                            </p>
                                        </div>

                                        <div class="info-row">
                                            <h6 class="mb-0">Genotype</h6>
                                            <p class="mb-0 truncated">
                                                <?php
                                                if (empty($genotype)) {
                                                    echo 'Not set';
                                                } else {
                                                    echo $genotype;
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#historyModal">
                                Click here to update profile
                            </button>

                            <!-- Bootstrap Modal -->
                            <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="historyModalLabel">Update Profile</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title text-center">Profile Update</h5>
                                                    <form action="my-profile.php" method="post">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="<?php echo $firstname; ?>" placeholder="First Name" name="firstname" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="<?php echo $lastname; ?>" placeholder="Last Name" name="lastname" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="<?php echo $othername; ?>" placeholder="Other Name" name="othername">
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="<?php echo $matric; ?>" placeholder="Matric/Application ID" name="matric">
                                                        </div>


                                                        <div class="form-group">
                                                            <input type="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email" name="email" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                                                            <p class="text-danger"><?php echo $new_password_err; ?></p>
                                                        </div>

                                                        <div class="form-group">
                                                            <select class="form-control  bg-danger text-white" id="bloodGroup" name="bloodgroup" required>
                                                                <option value="">----Select Blood Group----</option>
                                                                <option value="A+">A+</option>
                                                                <option value="A-">A-</option>
                                                                <option value="B+">B+</option>
                                                                <option value="B-">B-</option>
                                                                <option value="AB+">AB+</option>
                                                                <option value="AB-">AB-</option>
                                                                <option value="O+">O+</option>
                                                                <option value="O-">O-</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <select class="form-control bg-success text-white" id="genotype" name="genotype" required>
                                                                <option value="">----Select Genotype----</option>
                                                                <option value="AA">AA</option>
                                                                <option value="AS">AS</option>
                                                                <option value="SS">SS</option>
                                                                <option value="AC">AC</option>
                                                                <!-- Add more options as needed -->
                                                            </select>
                                                        </div>

                                                        <!-- Add more fields for other profile information -->

                                                        <button type="submit" name="submit" class="btn btn-primary btn-block">Update Profile</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- end dashboard inner -->
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script src="js/animate.js"></script>
        <!-- select country -->
        <script src="js/bootstrap-select.js"></script>
        <!-- owl carousel -->
        <script src="js/owl.carousel.js"></script>
        <!-- chart js -->
        <script src="js/Chart.min.js"></script>
        <script src="js/Chart.bundle.min.js"></script>
        <script src="js/utils.js"></script>
        <script src="js/analyser.js"></script>
        <!-- nice scrollbar -->
        <script src="js/perfect-scrollbar.min.js"></script>
        <script>
            var ps = new PerfectScrollbar('#sidebar');
        </script>
        <!-- custom js -->
        <script src="js/chart_custom_style1.js"></script>
        <script src="js/custom.js"></script>
</body>

</html>