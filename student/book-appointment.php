<?php
session_start();
include("../include/connect.php");


// checking for current date
$today = date("Y-m-d");

// checking and automatically declining appointment when date is passed
$deletingAppointment = mysqli_query($connect, "SELECT * FROM `appointment` WHERE appointment_status = 'PENDING' AND DATE(appointment_date) < '$today'");

if (mysqli_num_rows($deletingAppointment) > 0) {
    while ($row = mysqli_fetch_assoc($deletingAppointment)) {
        $appt_id = $row["appointment_id"];
        $changeApptStatus = mysqli_query($connect, "UPDATE `appointment` SET appointment_status = 'DECLINED' WHERE appointment_id = '$appt_id'");
    }
}

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

    $user_fullname = "$firstname $lastname $othername";
    $user_email = "$email";


    if (isset($_POST["submit"])) {
        // Nigeria Timezone
        date_default_timezone_set("AFRICA/LAGOS");

        $phone_number = $_POST["phone_number"];
        $appointment_date = $_POST["appointment_date"];
        $appointment_time = $_POST["appointment_time"];

        $appointment_time = strtotime($appointment_time);
        $appointment_time = date("H:i:s", $appointment_time);


        $prefix = "APPT";
        $uniqueId = substr(uniqid(), 6, 4); //Use a portion of the uniqid

        $appointment_id = $prefix . $user_id . $uniqueId;

        $selecting = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id AND appointment_status = 'PENDING'");

        // checking maximum number of appointment
        $selectingMaxAppt = mysqli_query($connect, "SELECT * FROM `appointment` WHERE DATE(appointment_date) = '$appointment_date'");

        // checking if appointment date less than current date
        $todaysDate = strtotime("Now");
        $todaysDate = date("Y-m-d", $todaysDate);

        $todaysDate = date("Y-m-d");  // Get today's date
        $todaysTime = strtotime("Now");
        $todaysTime = date("H:i a", $todaysTime);  // Get the current time in 24-hour format

        $appointment_date = $_POST['appointment_date'];  // Assume this is provided via POST
        $appointment_time = $_POST['appointment_time'];  // Assume this is provided via POST


        if (mysqli_num_rows($selectingMaxAppt) > 20 || $appointment_date < $todaysDate || ($appointment_date == $todaysDate && $appointment_time <= $todaysTime)) {
            if (mysqli_num_rows($selectingMaxAppt) > 20) {
                echo "
        <script>
            alert('Maximum number of appointment for this date reached! Please book for another date');
        </script>
    ";
            }
            if ($appointment_date < $todaysDate) {
                echo "
        <script>
            alert('Please book for an appointment greater than today!');
        </script>
    ";
            }

            if ($appointment_date == $todaysDate && $appointment_time <= $todaysTime) {
                echo "
        <script>
            alert('Time not available!');
        </script>
    ";
            }
        } else {
            // checking for an already existing appointment
            if (mysqli_num_rows($selecting) > 0) {
                echo "
        <script>
            alert('Your previous appointment status is still pending! You cannot book for another appointment.');
        </script>
        ";
            } else {

                $sql1 = mysqli_query($connect, "INSERT INTO `appointment` (appointment_id,fullname,email,phone_number,appointment_date,appointment_time,appointment_status,student_id) VALUES('$appointment_id','$user_fullname','$user_email','$phone_number','$appointment_date','$appointment_time','PENDING',$user_id)");

                if ($sql1) {
                    echo "
        <script>
            alert('Appointment booked successfully!');
            window.location.href='appointment-status.php';
        </script>
        ";
                } else {
                    $error_message = mysqli_error($connect);
                    echo "
            <script>
                alert('Error in Booking Appointment: $error_message');
            </script>
        ";
                }
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
        .appointment-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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
                                    <h2>Book Appointment</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="appointment-form">
                            <h2 class="text-center mb-4">Fill the Form</h2>

                            <form action="book-appointment.php" method="post">
                                <div class="form-group mb-3">
                                    <input type="text" name="fullname" value="<?php echo "$user_fullname"; ?>" class="form-control" placeholder="Full Name" id="fullName" name="fullName" disabled required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email" name="email" value="<?php echo "$user_email"; ?>" class="form-control" placeholder="Email" id="email" name="email" disabled required>
                                </div>

                                <div class="form-group mb-3">
                                    <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" id="phone" name="phone" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="appointmentDate">Preferred Appointment Date:</label>
                                    <input type="date" class="form-control" name="appointment_date" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="appointmentDate">Preferred Appointment Time:</label>
                                    <select class="form-control bg-white text-muted" id="bloodGroup" name="appointment_time" required>
                                        <option value="">----Select Appointment Time----</option>
                                        <option value="08:00 am">08:00am</option>
                                        <option value="11:00 am">11:00am</option>
                                        <option value="01:00 pm">01:00pm</option>
                                    </select>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary btn-block">Click to schedule</button>
                            </form>
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