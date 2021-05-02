<?php
      session_start();
      $noNavbar = '';
      if (isset($_SESSION['username'])) {
        header("location: dashbored.php");
        exit();
      };
      $pageTitle = 'Login';

      include "init.php"; // import files


// check if the user coming from http reqest
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // code...
   $username = $_POST['user'];
   $password = $_POST['pass'];
   $hashedPass = sha1($password);
   // check (1) If the user is reg in database
   $stmt = $con->prepare('SELECT userID ,username , password
                          FROM users
                          WHERE username = ?
                          AND password = ?
                          AND groupID = 1
                          LIMIT 1');
   $stmt->execute(array($username , $hashedPass ));
   $row = $stmt->fetch();
   $rowCount = $stmt->rowCount();
   // if count = 1 it means the database has a record for this username
   if ($rowCount > 0) {
     // code...
     $_SESSION['username'] = $username; // session name
     $_SESSION['ID'] = $row['userID']; // session id
     header('location: dashbored.php'); // redirect to dashbored page
     exit();
   }
 }

?>
<!-- code to prevnt referch alert -->
<!-- <script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script> -->
<!-- end of the code -->




  <form class="login" method="Post" action=" <?php echo $_SERVER['PHP_SELF'] ?>">
    <h4 class="text-center"><strong> Admin Login </strong></h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="Login"/>
  </form>
