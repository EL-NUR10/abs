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
                                    <h2>Status Checker</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light text-center rounded p-4">


                            <?php
                            // Fetching the user's appointment status
                            $appointment_query = mysqli_query($connect, "SELECT * FROM `appointment` WHERE student_id = $user_id ORDER BY booking_time DESC LIMIT 1");

                            if ($appointment_query) {
                                $appointment_row = mysqli_fetch_assoc($appointment_query);

                                $appointment_id = $appointment_row["appointment_id"] ?? null;
                                $appointment_status = $appointment_row["appointment_status"] ?? null;
                                $appointment_date = $appointment_row["appointment_date"] ?? null;
                                $appointment_date = strtotime($appointment_date) ?? null;
                                $appointment_date = date("d, D M Y", $appointment_date) ?? null;
                                $appointment_time = $appointment_row["appointment_time"] ?? null;
                                $appointment_time = strtotime($appointment_time) ?? null;
                                $appointment_time = date("h:i:s a", $appointment_time) ?? null;
                            }

                            switch ($appointment_status) {
                                case 'PENDING':
                                    echo '
       <div class="container" style="margin-top: 50px;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Your Appointment is Pending!</h5>
          <p class="card-text">
            Your appointment has been booked and current status is pending. Check your appointment status regularly to know if it is approved or not.
          </p>
          <button class="btn btn-warning text-white" data-toggle="modal" data-target="#pendingModal">
            View Appointment Details
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="pendingModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Appointment ID: ' . $appointment_id . ' </p>
        <p>Date: ' . $appointment_date . '</p>
        <p>Time: ' . $appointment_time . '</p>
      </div>
      <div class="modal-footer">
        <a href="process-cancel-appointment.php?appointment_id=' . $appointment_id . '" class="btn btn-danger">Cancel Appointment</a>
      </div>
    </div>
  </div>
</div>
<!--End of  Bootstrap Modal -->


       ';
                                    break;


                                case 'APPROVED':
                                    echo '
          <div class="container" style="margin-top: 50px;">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center">Your Appointment is Approved!</h5>
                  <p class="card-text">
                    Your appointment has been approved. We look forward to seeing you on your scheduled date.
                  </p>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal">
                    View Appointment Details
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        
        <!-- Bootstrap Modal -->
        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <p>Appointment ID: ' . $appointment_id . ' </p>
              <p>Date: ' . $appointment_date . '</p>
              <p>Time: ' . $appointment_time . '</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!--End of  Bootstrap Modal -->
        
          ';
                                    break;


                                case 'DECLINED':
                                    echo '
            <div class="container" style="margin-top: 50px;">
            <div class="row justify-content-center">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title text-center">Your Appointment is Not Approved</h5>
                    <p class="card-text">
                      We regret to inform you that your appointment request has not been approved. If you have any questions or concerns, please contact us.
                    </p>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#declinedModal">
                      View Details
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Bootstrap Modal -->
          <div class="modal fade" id="declinedModal" tabindex="-1" role="dialog" aria-labelledby="declinedModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="declinedModalLabel">Declined Appointment Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Appointment ID: ' . $appointment_id . ' </p>
                  <p>Date: ' . $appointment_date . '</p>
                  <p>Time: ' . $appointment_time . '</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
                      
            ';
                                    break;


                                default:
                                    echo '
        <div class="container" style="margin-top: 50px;">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-center">You have not initiated any Appointment yet</h5>
                <p class="card-text">
                  Kindly book for an appointment if you would love to meet our doctors.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>            
        ';
                                    break;
                            }

                            ?>
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