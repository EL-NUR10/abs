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

    
    if (isset($_POST["submit"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $othername = $_POST["othername"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        //VALIDATION 1 CHECKING FOR SPECIAL CHARACTERS
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $othername = htmlspecialchars($othername);
        $email = filter_var($email,FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($password);
    
        //FETCHING ALREADY REGISTERED EMAIL
        $fetch_email = mysqli_query($connect,"SELECT * FROM `doctor` WHERE email = '$email'");
    
        //VALIDATION 2 CHECKING FOR WRONG INPUTS 
        if (!preg_match('/^[a-zA-Z]+$/u', $firstname) || !preg_match('/^[a-zA-Z]+$/u', $lastname) || !filter_var($email,FILTER_VALIDATE_EMAIL) || mysqli_num_rows($fetch_email) > 0 || !preg_match('/^[a-zA-Z0-9]+$/u', $password) || strlen($password) < 6) {
    
            if (!preg_match('/^[a-zA-Z]+$/u', $firstname)) {
                $firstname_err = "Invalid characters in first name.";
            }
        
            if (!preg_match('/^[a-zA-Z]+$/u', $lastname)) {
                $lastname_err = "Invalid characters in last name.";
            }
        
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email address.";
            }
            if (mysqli_num_rows($fetch_email) > 0) {
                $email_err = "Email already registered.";
            }
        
            if (!preg_match('/^[a-zA-Z0-9]+$/u', $password)) {
                $password_err = "Invalid Password.";
            }
        
        if (strlen($password) < 6) {
            $password_err = "Password must be up to six characters";
        }
    
        } else {
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
    
        $sql = mysqli_query($connect,"INSERT INTO `doctor`(firstname,lastname,othername,email,password) VALUES('$firstname','$lastname','$othername','$email','$password_hash')");
    
        if ($sql = true) {
            echo "
            <script>
                alert('Doctor added successful!');
                window.location.href='view-doctors.php';
            </script>
            ";
        }else {
            echo "<script>
                alert('Signup error:/n". mysqli_error($connect) ."');
            </script>";
        }
            
        }
    
    }
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
                              <h2>Add Doctors</h2>
                           </div>
                        </div>
                     </div>

                     <div class="container">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5">
                <form action="add-doctors.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" name="firstname" class="form-control" id="floatingText" placeholder="First Name" required>
                        <label for="floatingText">First Name</label>
                        <p class="text-danger"><?php echo $firstname_err; ?></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="lastname" class="form-control" id="floatingText" placeholder="Last Name" required>
                        <label for="floatingText">Last Name</label>
                        <p class="text-danger"><?php echo $lastname_err; ?></p>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="text" name="othername" class="form-control" id="floatingText" placeholder="Other Name">
                        <label for="floatingText">Other Name</label>
                        <p class="text-danger"><?php echo $othername_err; ?></p>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Email address</label>
                        <p class="text-danger"><?php echo $email_err; ?></p>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                        <p class="text-danger"><?php echo $password_err; ?></p>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Add</button>
                </form>
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