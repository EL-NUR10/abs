<?php
session_start();
include("../include/connect.php");


if (isset($_SESSION["doctor_id"])) {

   //LOGGED IN USER ID
   $user_id = $_SESSION["doctor_id"];

   $sql = mysqli_query($connect, "SELECT * FROM `doctor` WHERE doctor_id = $user_id");

   $fetch = mysqli_fetch_assoc($sql);

   $firstname = $fetch["firstname"];
   $lastname = $fetch["lastname"];
   $othername = $fetch["othername"];
   $fullname = $firstname . ' ' . $lastname . ' ' . $othername;
   $email = $fetch["email"];
} else {
   echo "
    <script>
        alert('Oops! You are not logged in!');
        window.location.href='../login.php';
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
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
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
                        <h6><?php echo $fullname; ?></h6>
                        <p><span class="online_animation"></span> Online</p>
                        <h6 class="fs-5" style="color: #ff5722; font-weight:600;">Doctor</h6>
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
                        <li><a href="new-appointments.php">> <span>New Appointments</span></a></li>
                        <li><a href="approved-appointments.php">> <span>Approved Appointments</span></a></li>
                        <li><a href="cancelled-appointments.php"> <span>Cancelled Appointments</span></a></li>
                        <li><a href="all-appointment-history.php"> <span>All Appointments History</span></a></li>
                     </ul>
                  </li>

                  <li>
                     <a href="contact.php">
                        <i class="fa fa-paper-plane red_color"></i> <span>Contact</span></a>
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
                                 <a class="dropdown-toggle" data-toggle="dropdown"><span class="name_user"><?php echo $fullname; ?></span></a>
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
                           <h2>Dashboard</h2>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="card mb-3">
                           <div class="card-body">
                              <?php

                              //Fetching number of pending appointment per status
                              $pending_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) AS pending_appt_total FROM `appointment` WHERE appointment_status = 'PENDING'");
                              $pending_appt_fetch = mysqli_fetch_assoc($pending_appt);
                              $pending_appt_total = $pending_appt_fetch["pending_appt_total"];

                              //Fetching number of approved appointment per status
                              $approved_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) AS approved_appt_total FROM `appointment` WHERE appointment_status = 'approved'");
                              $approved_appt_fetch = mysqli_fetch_assoc($approved_appt);
                              $approved_appt_total = $approved_appt_fetch["approved_appt_total"];

                              //Fetching number of declined appointment per status
                              $declined_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) AS declined_appt_total FROM `appointment` WHERE appointment_status = 'declined'");
                              $declined_appt_fetch = mysqli_fetch_assoc($declined_appt);
                              $declined_appt_total = $declined_appt_fetch["declined_appt_total"];

                              //Fetching number of total appointment per status
                              $total_appt = mysqli_query($connect, "SELECT COUNT(appointment_id) AS total_appt_total FROM `appointment`");
                              $total_appt_fetch = mysqli_fetch_assoc($total_appt);
                              $total_appt_total = $total_appt_fetch["total_appt_total"];
                              ?>
                              <h5 class="card-title"> Total New Appointments</h5>
                              <p class="card-text"><?php echo $pending_appt_total; ?></p>
                              <a href="./new-appointments.php" class="btn btn-warning text-white">View Details</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card mb-3">
                           <div class="card-body">
                              <h5 class="card-title">Total Approved Appointments</h5>
                              <p class="card-text"><?php echo $approved_appt_total; ?></p>
                              <a href="./approved-appointments.php" class="btn btn-success">View Details</a>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="card mb-3">
                           <div class="card-body">
                              <h5 class="card-title"> Cancelled Appointments</h5>
                              <p class="card-text"><?php echo $declined_appt_total; ?></p>
                              <a href="./cancelled-appointments.php" class="btn btn-danger">View Details</a>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="card mb-3">
                           <div class="card-body">
                              <h5 class="card-title"> Total Appointments</h5>
                              <p class="card-text"><?php echo $total_appt_total; ?></p>
                              <a href="./all-appointment-history.php" class="btn btn-primary">View Details</a>
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