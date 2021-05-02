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
    $formErrors = array();
    if (isset($_POST['username'])) {
      $FilterdUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        if (strlen($FilterdUser) < 5 ) {
          $formErrors[] = 'Username must be lager than four Letters';
        }
    }

    if (isset($_POST['password1']) && isset($_POST['password2']) ) {
      $pass1 = sha1($_POST['password1']);
      $pass2 = sha1($_POST['password2']);
      if ($pass1 !== $pass2) {
        $formErrors[] = 'Password Is Not Matching';
      }
    }

    if (isset($_POST['email'])) {
      $FilterdEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (filter_var($FilterdEmail, FILTER_SANITIZE_EMAIL) != true ) {
          $formErrors[] = 'Email Is Not Valid';
        }
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
      <input class="form-control text-center" type="text" name="username" autocomplete="on" placeholder="Username" required="required">
      <input class="form-control text-center" type="password" name="passowrd" autocomplete="off" placeholder="Password" required="required">
      <button name="login" type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    <!-- start signup form -->
    <form class="signup" action=" <?php echo $_SERVER['PHP_SELF'] ?>"  method="post">
      <input class="form-control text-center" type="text" name="username" autocomplete="off" placeholder="Username" required="required">
      <input class="form-control text-center" type="text" name="fullname" autocomplete="off" placeholder="Full Name">
      <input class="form-control text-center" type="password" name="password1" autocomplete="off" placeholder="Password" required="required">
      <input class="form-control text-center" type="password" name="password2" autocomplete="off" placeholder="Confirm Password" required="required">
      <input class="form-control text-center" type="email" name="email" autocomplete="off" placeholder="Email" required="required">

      <button name="signup" type="sumbit" class="btn btn-primary">signup</button>
    </form>
  </div>
  <div class="the-errors text-center padding">
    <?php
    if (!empty($formErrors)) {
      foreach ($formErrors as $error) {
      echo "<p class='alert alert-danger'><b>" . $error . "</b></p>";
      }
    }
     ?>
  </div>
</div>

<!-- end of the login page -->
<?php include "includes/templates/footer.php"; ?>
