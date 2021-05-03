<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle; ?></title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js"data-auto-a11y="true"></script>
    <link rel="stylesheet" href="layout/css/backend-style.css">
  </head>
  <body>



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
           {echo '<li class="main-links">
                  <a href="categories.php?pageid=' . $cats['ID'] .'">
                  ' . $cats['Name'] . '
                  </a></li>' ;}
         ?>
         <li>
          <div class="btn-group">
              <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">Hello , <?php echo $_SESSION['user'] ?>. </button>
                <button class="dropdown-item" type="button"><a href="profile.php">Profile</a></button>
                <button class="dropdown-item" type="button"><a href="newitem.php">Add new item</a></button>
                <button class="dropdown-item" type="button"><a href="logout.php">Logout</a></button>
              </div>
          </div>
         </li>
      </ul>
    </div>
  </div>
</nav>
