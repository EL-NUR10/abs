<?php
include ("include/connect.php");

$firstname_err = null;
$lastname_err = null;
$othername_err = null;
$email_err = null;
$matric_err = null;
$password_err = null;

if (isset($_POST['submit'])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $othername = $_POST["othername"];
    $email = $_POST["email"];
    $matric = $_POST["matricno"];
    $password = $_POST["password"];

    //VALIDATION
    $firstname = htmlspecialchars($firstname);
    $lastname = htmlspecialchars($lastname);
    $othername = htmlspecialchars($othername);
    $email = filter_var($email,FILTER_SANITIZE_EMAIL); 
    $matric = htmlspecialchars($matric);
    $password = htmlspecialchars($password);

   

    $password_length = strlen($password);

    //FETCHING ALREADY REGISTERED EMAIL
    $fetch_email = mysqli_query($connect,"SELECT * FROM `student` WHERE email = '$email'");

    //FETCHING ALREADY REGISTERED MATRIC NUMBER
    $fetch_matric = mysqli_query($connect,"SELECT * FROM `student` WHERE matric = '$matric'");

     
    //VALIDATION 2
   if (!preg_match('/^[a-zA-Z]+$/u', $firstname) || !preg_match('/^[a-zA-Z]+$/u', $lastname) || !preg_match('/^[a-zA-Z]+$/u', $othername) || !filter_var($email,FILTER_VALIDATE_EMAIL) || mysqli_num_rows($fetch_email) > 0 || mysqli_num_rows($fetch_matric) > 0 || !preg_match('/^[a-zA-Z0-9]+$/u', $matric) || !preg_match('/^[a-zA-Z0-9]+$/u', $password) || $password_length < 6) {
    
    if (!preg_match('/^[a-zA-Z]+$/u', $firstname)) {
        $firstname_err = "Invalid characters in first name.";
    }

    if (!preg_match('/^[a-zA-Z]+$/u', $lastname)) {
        $lastname_err = "Invalid characters in last name.";
    }

    if (!preg_match('/^[a-zA-Z]+$/u', $othername)) {
        $othername_err = "Invalid characters in Other name.";
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email address.";
    }

    if (mysqli_num_rows($fetch_email) > 0) {
        $email_err = "Email already registered.";
    }

    if (!preg_match('/^[a-zA-Z0-9]+$/u', $matric)) {
        $matric_err = "Invalid Matric Number.";
    }

    if (mysqli_num_rows($fetch_matric) > 0) {
        $matric_err = "Matric Number already registered.";
    }

    if (!preg_match('/^[a-zA-Z0-9]+$/u', $password)) {
        $password_err = "Invalid Password.";
    }

if ($password_length < 6) {
    $password_err = "Password must be up to six characters";
}
    
   }else {
    $password_hash = password_hash($password,PASSWORD_DEFAULT);
    $sql = mysqli_query($connect,"INSERT INTO `student`(firstname,lastname,othername,email,matric,password) VALUES('$firstname','$lastname','$othername','$email','$matric','$password_hash')");

    if ($sql) {
        echo "<script>
            alert('Signup successful!');
            window.location.href='login.php';
        </script>";
        exit();
    }else {
        $connect_error = mysqli_error($connect);
        echo "<script>
            alert('Signup error:". $connect_error ."');
        </script>";
    }
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
      <title>HMS - Create an account</title>
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
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <h1 class="text-white" style="font-size: 50px;">ABS</h1> 
                     </div>
                  </div>
                  <div class="login_form">
                     <form action="register.php" method="post">
                        <fieldset>
                           <div class="field">
                              <label class="label_field">First Name</label>
                              <input type="text" name="firstname"/>
                              <p class="text-danger"><?php echo $firstname_err; ?></p>
                           </div>

                           <div class="field">
                              <label class="label_field">Last Name</label>
                              <input type="text" name="lastname"/>
                              <p class="text-danger"><?php echo $lastname_err; ?></p>
                           </div>

                           <div class="field">
                              <label class="label_field">Other Name</label>
                              <input type="text" name="othername"/>
                              <p class="text-danger"><?php echo $othername_err; ?></p>
                           </div>

                           <div class="field">
                              <label class="label_field">Email Address</label>
                              <input type="email" name="email"/>
                              <p class="text-danger"><?php echo $email_err; ?></p>
                           </div>

                           <div class="field">
                              <label class="label_field">Matric Number</label>
                              <input type="text" name="matricno"/>
                              <p class="text-danger"><?php echo $matric_err; ?></p>
                           </div>

                           <div class="field">
                           <label class="label_field">Password</label>
                              <input type="password" name="password"/>
                              <p class="text-danger"><?php echo $password_err; ?></p>
                           </div>
                           

                           <div class="field margin_0">
                              <button type="submit" name="submit" class="main_bt">Sign Up</button>
                              <p class="d-inline float-right">
                                 Already have an account?
                                 <a class="text-danger text-decoration-none" href="./login.php">Sign in</a>
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