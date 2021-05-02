<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle; ?></title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js"data-auto-a11y="true"></script>
    <link rel="stylesheet" href="layout\css\backend-style.css">
  </head>
  <body>

<div class="upper-bar">
  <div class="container">
    <!-- <div class="designed-by"> Designed By
      <a class="#" href="https://www.facebook.com/profile.php?id=100021391685332" target="_blank"> Eslam Abdallah </a>
    </div> -->
    <?php
    if (isset($_SESSION['user'])) {

      echo "<span class='welcome-user'>" . $_SESSION['user'] . "</span>";
      echo "<a href='logout.php' id='profile'> logout </a>";
      echo "<a href='newitem.php' id='profile'> New item </a>";
      echo "<a href='profile.php' id='profile'> Profile </a>";



      // $userStatus = checkUserStatus($_SESSION['user']);
      // if ($userStatus == 1) {
      //   // user is not actived
      // }
    } else {
     ?>
    <a href="login.php" class="btn btn-danger">
      <span class="login">Login / Signup</span>
    </a>
  <?php } ?>
  </div>
</div>

<!-- Start navbar -->
<nav class=''>
  <div class="nav-wrapper">
    <div class="container">
      <a href="index.php" class="brand-logo">SHOPIPA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-mobile" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul id="nav-mobile" class="right hide-on-med-and-down">

        <?php
          foreach (getcate() as $cats )
           {echo '<li>
                  <a href="categories.php?pageid=' . $cats['ID'] .'">
                  ' . $cats['Name'] . '
                  </a></li>' ;}
         ?>
      </ul>
    </div>
  </div>
</nav>
