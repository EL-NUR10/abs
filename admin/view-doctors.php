<?php 
session_start();
include("../include/connect.php");

$firstname_err = null;
$lastname_err = null;
$othername_err = null;
$email_err = null;
$password_err = null;


if (isset($_SESSION["admin_id"])) {

    //LOGGED IN USER ID
    $user_id = $_SESSION["admin_id"];
    
    $sql = mysqli_query($connect,"SELECT * FROM `admin` WHERE admin_id = $user_id");
    
    $fetch = mysqli_fetch_assoc($sql);
    
    
    $fullname = $fetch["fullname"];
    $email = $fetch["email"];

    // Including Module for editing Doctor information
    include("./edit-doctor.php"); 

 }else {
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
                        <h6><?php echo $fullname;?></h6>
                           <p><span class="online_animation"></span> Online</p>
                           <h6 class="fs-5" style="color: #ff5722; font-weight:600;">Admin</h6>
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
                        <a href="#apps" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-object-group blue2_color"></i> <span>Doctors</span></a>
                        <ul class="collapse list-unstyled" id="apps">
                           <li><a href="add-doctors.php"> <span>Add Doctors</span></a></li>
                           <li><a href="view-doctors.php"> <span>View Doctors</span></a></li>
                        </ul>
                     </li>

                     <li><a href="patient.php"><i class="fa fa-briefcase blue1_color"></i> <span>Patient</span></a></li>

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
                                    <a class="dropdown-toggle" data-toggle="dropdown"><span class="name_user"><?php echo $fullname;?></span></a>
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
                              <h2>View Doctors</h2>
                           </div>
                        </div>
                     </div>

                     <div class="container mt-5">
<div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
//Selecting Registered Doctors
$reg_doc = mysqli_query($connect,"SELECT * FROM `doctor`");
    

                while ($reg_doc_fetch = mysqli_fetch_assoc($reg_doc)) {
                    $doctor_id = $reg_doc_fetch["doctor_id"];
                    $doctor_firstname = $reg_doc_fetch["firstname"];
                    $doctor_lastname = $reg_doc_fetch["lastname"];
                    $doctor_othername = $reg_doc_fetch["othername"] ?? null;
                    $doctor_email = $reg_doc_fetch["email"];
                    $doctor_password = $reg_doc_fetch["password"];
                    $doctor_specialization = $reg_doc_fetch["specialization"] ?? 'Not set';
                    
                    echo '
                                <tr>
                                    <td>'.$doctor_firstname . " " . $doctor_lastname ." ".$doctor_othername.' </td>
                                    <td>'. $doctor_email  .'</td>
                                    <td>'. $doctor_specialization  .'</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-target="#changePasswordModal'.$doctor_id.'" data-toggle="modal">Edit</button>
                                        <a href="delete-doctor.php?doctor_id='. $doctor_id .'" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                    
                                </tr>
                            ';                           
                            

                            echo '
                            <!-- Modal for changing Doctor Password  -->
                            <div class="modal fade" id="changePasswordModal'.$doctor_id.'" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form action="view-doctors.php" method="POST">
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="doctor_id" class="form-control" id="floatingText" value="'.$doctor_id .'" required>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="firstname" class="form-control" id="floatingText" value="'.$doctor_firstname .'" required>
                                    <label for="floatingText">First Name</label>
                                    <p class="text-danger"> '.$firstname_err.'</p>
                                </div>
            
                                <div class="form-floating mb-3">
                                    <input type="text" name="lastname" class="form-control" id="floatingText" value="'.$doctor_lastname .'" required>
                                    <label for="floatingText">Last Name</label>
                                    <p class="text-danger">'.$lastname_err.'</p>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" name="othername" class="form-control" id="floatingText" value="'.$doctor_othername .'">
                                    <label for="floatingText">Other Name</label>
                                    <p class="text-danger"> '.$othername_err.'</p>
                                </div>
            
            
                                <div class="form-floating mb-4">
                                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="New Password" required>
                                    <label for="floatingPassword">Password</label>
                                    <p class="text-danger">'.$password_err.'</p>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Save</button>
                            </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                    <!--End of  Modal for changing Doctor Password -->            
                            
                            ';
                            
                
                }    
              ?>


            </tbody>
        </table>
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