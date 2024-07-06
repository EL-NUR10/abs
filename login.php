<?php
session_start();
include("include/connect.php");


if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Retrieving email from the doctor's table based on the email
    $result = mysqli_query($connect, "SELECT * FROM `doctor` WHERE email = '$email'");

    // Retrieving email from the doctor's table based on the email
    $result2 = mysqli_query($connect, "SELECT * FROM `student` WHERE email = '$email'");
    
    // Retrieving email from the admin's table based on the email provided
    $result3 = mysqli_query($connect, "SELECT * FROM `admin` WHERE email = '$email'");
    
    if (mysqli_num_rows($result) > 0 || mysqli_num_rows($result2) > 0 || mysqli_num_rows($result3) > 0) {

    //IF doctor's email is valid
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDB = $row['password'];

    // Use password_verify to check if entered password matches the hashed password
        if (password_verify($password, $hashedPasswordFromDB)) {
            // Passing the doctor_id to the dashboard
            $_SESSION["doctor_id"] = $row["doctor_id"];
            
            // Redirect to the doctor's dashboard
            
                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='doctor/dashboard.php';                    
                </script>
                ";
                
        } else {
            // Password is incorrect
            $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 right-0" role="alert">
            <strong>Incorrect password!</strong> 
         </div>';
        }

        }



//IF student's email is valid
        if (mysqli_num_rows($result2) > 0) {
            $row = mysqli_fetch_assoc($result2);
            $hashedPasswordFromDB = $row['password'];

    // Use password_verify to check if entered password matches the hashed password
        if (password_verify($password, $hashedPasswordFromDB)) {
            // Passing the student_id to the dashboard
            $_SESSION["student_id"] = $row["student_id"];

            // Redirect to the student's dashboard
                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='student/dashboard.php';                    
                </script>
                ";
            //  exit();
                
        } else {
            // Password is incorrect
            $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 right-0" role="alert">
            <strong>Incorrect password!</strong> 
         </div>';
        }


        }

        //IF admin's email is valid
        if (mysqli_num_rows($result3) > 0) {
            $row = mysqli_fetch_assoc($result3);
            $PasswordFromDB = $row['password'];

    // Verify to check if password is correct
        if ($password === $PasswordFromDB) {
            // Passing the admin_id to the dashboard
            $_SESSION["admin_id"] = $row["admin_id"];
            
            // Redirect to the admin's dashboard
            
                echo "
                <script>
                    alert('Login successful!');
                    window.location.href='admin/dashboard.php';                    
                </script>
                ";
                die();
                
        } else {
            // Password is incorrect
            $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 right-0" role="alert">
            <strong>Incorrect password!</strong> 
         </div>';
        }

        }


        

        
    } else {
        // User not found
        $alert = '<div class="alert alert-danger alert-dismissible fade show position-absolute top-0 right-0" role="alert">
        <strong>User not found!</strong> 
     </div>
     ';
    }
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
      <title>HMS - Login to your dashboard</title>
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
      <!-- calendar file css -->
      <link rel="stylesheet" href="js/semantic.min.css" />
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
               <?php if (isset($alert)) {
                        echo $alert;
                     } ?>
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <h1 class="text-white" style="font-size: 50px;">ABS</h1> 
                     </div>
                  </div>
                  <div class="login_form">
                     <form action="login.php" method="post">
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Email Address</label>
                              <input type="email" name="email" placeholder="E-mail" required/>
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" name="password" placeholder="Password" required/>
                           </div>
                           <div class="field">
                              
                              
                           </div>
                           <div class="field margin_0">
                              <button type="submit" name="submit" class="main_bt">Sign In</button>
                              <p class="d-inline float-right">
                                 Don't have an account?
                                 <a class="text-danger text-decoration-none" href="./register.php">Sign Up</a>
                              </p>

                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
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
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
   </body>
</html>