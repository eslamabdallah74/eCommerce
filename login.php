<?php
session_start();
$noNavbar = '';
if (isset($_SESSION['user'])) {
  // code...
  header("location: profile.php");
  exit();
};
$pageTitle = 'Entrance';

include "init.php"; // import files


// check if the user coming from http reqest
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// code...
if (isset($_POST['login'])) {

  $username   = $_POST['username'];
  $password   = $_POST['passowrd'];
  $hashedPass = sha1($password);
  // check (1) If the user is reg in database
  $stmt = $con->prepare('SELECT userID ,username , password
                        FROM  users
                        WHERE username = ?
                        AND   password = ? ');
  $stmt->execute(array($username , $hashedPass));
  $get = $stmt->fetch();
  $rowCount = $stmt->rowCount();
  // if count = 1 it means the database has a record for this username
  if ($rowCount > 0) {
    // code...
    $_SESSION['user'] = $username; // session name
    $_SESSION['uid']  = $get['userID']; // Register User ID in Session

    header('location: profile.php'); // redirect to dashbored page
    exit();
   }
   // 2sec if closing tag (sigup form)
  } else {
    echo "<div class='container'>";
    // Get vribals from form
    $user = $_POST['username'];
    $pass = $_POST['password1'];
    $ConfirmPass = $_POST['password2'];
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $hashpass = sha1($_POST['password1']);
    //validate the form
    $formerrors = array();
    if (empty($user)) {
      $formerrors[] =  '<strong> Username </strong> Cant be <strong> Empty </strong>';
    }
    if (empty($email)) {
      $formerrors[] = ' <strong> Email </strong>  Cant be <strong> Empty ';
    }
    if (empty($name)) {
      $formerrors[] = '<strong> Fullname </strong> Cant be <strong> Empty </strong> ';
    }
    if (empty($pass) || (empty($ConfirmPass))) {
      $formerrors[] = '<strong> Password </strong> Cant be <strong> Empty </strong> ';
    }
    if ($pass != $ConfirmPass) {
      $formerrors[] = '<strong> Password </strong> Doesnt <strong> match </strong> ';
    }
    //loop into errors
     foreach($formerrors as $error){
       echo '<div class="alert alert-danger">' . $error .  '</div>' ;
     }
     // if there is no errors update the form
     if (empty($formerrors)) {
       //check if user exists in database
    $check = checkItem("username" , "users" , $user);
    if ($check == 1) {
      echo "<div class='alert alert-danger text-center'> Sorry This Username Exists </div>";
      header("refresh:2;url=members.php?action=add");
    } else {

      //insert user info in database
            $stmt = $con->prepare('INSERT INTO
                                          users(username, password , email , fullname, reg_status ,Date )
                                          VALUES(:zuser , :zpass, :zmail, :zname , 1 ,now()) ');
            $stmt->execute(array(
              'zuser' => $user,
              'zpass' => $hashpass,
              'zmail' => $email,
              'zname' => $name
            ));
             //system update message
             $theMsg = "<div class='alert alert-light text-center'> " . $stmt->rowCount() . " account created </div>";
             redirctHome($theMsg, 'back');
         } // end of the else
     }

  }
// 1st if closing tag
}
?>


<div class="container login-page">
  <div class="margin-top">
    <h1 class="text-center"> <span class="selected" data-class='login'>Login</span> | <span data-class="signup">Signup</span> </h1>
    <!-- start login form -->
    <form class="login" action=" <?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <input class="form-control fixC text-center" type="text" name="username" autocomplete="on" placeholder="Username" required="required">
      <input class="form-control fixC text-center" type="password" name="passowrd" autocomplete="off" placeholder="Password" required="required">
      <button name="login" type="submit" class="btn btn-primary">Login</button>
    </form>
    <!-- start signup form -->
    <form class="signup" action=" <?php echo $_SERVER['PHP_SELF'] ?>"  method="post">
      <input class="form-control fixC text-center" type="text" name="username" autocomplete="off" placeholder="Username">
      <input class="form-control fixC text-center" type="text" name="fullname" autocomplete="off" placeholder="Full Name">
      <input class="form-control fixC text-center" type="password" name="password1" autocomplete="off" placeholder="Password" >
      <input class="form-control fixC text-center" type="password" name="password2" autocomplete="off" placeholder="Confirm Password" >
      <input class="form-control fixC text-center" type="email" name="email" autocomplete="off" placeholder="Email" >

      <button name="signup" type="sumbit" class="btn btn-success">signup</button>
    </form>
  </div>
  <div class="the-errors text-center padding">
    <?php
    if (!empty($formErrors)) {
      foreach ($formErrors as $error) {
      echo "<p class='alert alert-primary'><b>" . $error . "</b></p>";
      }
    }
     ?>
  </div>
</div>

<!-- end of the login page -->
<?php include "includes/templates/footer.php"; ?>
