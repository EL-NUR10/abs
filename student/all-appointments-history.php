<?php
session_start();
include("../include/connect.php");


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
                                    <h2>All Appointments History</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light text-center rounded p-4">

                            <?php

                            //Selecting Total appointment from DB
                            $total_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) FROM `appointment` WHERE student_id = $user_id");
                            $total_appt_row = mysqli_fetch_row($total_appt);
                            $total_appt_no = $total_appt_row["0"];


                            //Selecting Pending appointment from DB
                            $pending_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) FROM `appointment` WHERE student_id = $user_id AND appointment_status = 'PENDING'");
                            $pending_appt_row = mysqli_fetch_row($pending_appt);
                            $pending_appt_no = $pending_appt_row["0"];


                            //Selecting Declined appointment from DB
                            $declined_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) FROM `appointment` WHERE student_id = $user_id AND appointment_status = 'declined'");
                            $declined_appt_row = mysqli_fetch_row($declined_appt);
                            $declined_appt_no = $declined_appt_row["0"];


                            //Selecting Approved appointment from DB
                            $approved_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) FROM `appointment` WHERE student_id = $user_id AND appointment_status = 'approved'");
                            $approved_appt_row = mysqli_fetch_row($approved_appt);
                            $approved_appt_no = $approved_appt_row["0"];


                            ?>


                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">Appointment History</h5>
                                                <div class="modal-body">
                                                    <h6 class="text-info">Total Appointments: <?php echo $total_appt_no; ?></h6>
                                                    <div class="accordion" id="appointmentAccordion">

                                                        <!-- Pending Appointments -->
                                                        <div class="card">
                                                            <div class="card-header bg-warning text-white" id="pendingAppointments">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapsePending" aria-expanded="true" aria-controls="collapsePending">
                                                                        Pending Appointments
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapsePending" class="collapse show" data-parent="#appointmentAccordion">
                                                                <div class="card-body">
                                                                    <!-- Display canceled appointment details here -->
                                                                    <p><?php echo $pending_appt_no; ?></p>
                                                                    <!-- Add more details as needed -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Canceled Appointments -->
                                                        <div class="card">
                                                            <div class="card-header bg-danger text-white" id="canceledAppointments">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseCanceled" aria-expanded="true" aria-controls="collapseCanceled">
                                                                        Canceled Appointments
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapseCanceled" class="collapse show" aria-labelledby="canceledAppointments" data-parent="#appointmentAccordion">
                                                                <div class="card-body">
                                                                    <!-- Display canceled appointment details here -->
                                                                    <p><?php echo $declined_appt_no; ?></p>
                                                                    <!-- Add more details as needed -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Approved Appointments -->
                                                        <div class="card">
                                                            <div class="card-header bg-success text-white" id="approvedAppointments">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseApproved" aria-expanded="false" aria-controls="collapseApproved">
                                                                        Approved Appointments
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapseApproved" class="collapse" aria-labelledby="approvedAppointments" data-parent="#appointmentAccordion">
                                                                <div class="card-body">
                                                                    <!-- Display approved appointment details here -->
                                                                    <p><?php echo $approved_appt_no; ?></p>
                                                                    <!-- Add more details as needed -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Add more sections for other types of appointments as needed -->

                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#historyModal">
                                                    See Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Bootstrap Modal -->
                            <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="historyModalLabel">Appointment History</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Patient Name</th>
                                                            <th scope="col">Appointment ID</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Time</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        //Selecting All appointments from DB
                                                        $all_appt = mysqli_query($connect, "SELECT * FROM `appointment` INNER JOIN student ON appointment.student_id = student.student_id WHERE appointment.student_id = $user_id");

                                                        while ($all_appt_row = mysqli_fetch_row($all_appt)) {
                                                            $all_appt_fullname = $all_appt_row["9"] . " " . $all_appt_row["10"];
                                                            $all_appt_appointment_id = $all_appt_row["0"];
                                                            $all_appt_appointment_date = $all_appt_row["4"];
                                                            //Modifying appointment date
                                                            $all_appt_appointment_date = strtotime($all_appt_appointment_date);
                                                            $all_appt_appointment_date = date("D, d-M-Y", $all_appt_appointment_date);

                                                            $all_appt_appointment_time = $all_appt_row["5"];
                                                            //Modifying appointment time
                                                            $all_appt_appointment_time = strtotime($all_appt_appointment_time);
                                                            $all_appt_appointment_time = date("h:i:s a", $all_appt_appointment_time);

                                                            $all_appt_appointment_status = $all_appt_row["6"];
                                                            echo '<tr>';
                                                            echo '
    <td>' . $all_appt_fullname . '</td>
    <td>' . $all_appt_appointment_id . '</td>
    <td>' . $all_appt_appointment_date . '</td>
    <td>' . $all_appt_appointment_time . '</td>
  ';
                                                            switch ($all_appt_appointment_status) {
                                                                case 'PENDING':
                                                                    echo '<td><span class="text-warning">' . $all_appt_appointment_status . '</span></td>';
                                                                    break;

                                                                case 'APPROVED':
                                                                    echo '<td><span class="text-success">' . $all_appt_appointment_status . '</span></td>';
                                                                    break;

                                                                case 'DECLINED':
                                                                    echo '<td><span class="text-danger">' . $all_appt_appointment_status . '</span></td>';
                                                                    break;

                                                                default:
                                                                    # code...
                                                                    break;
                                                            }

                                                            echo '</tr>';
                                                        }

                                                        ?>

                                                    </tbody>
                                                </table>
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