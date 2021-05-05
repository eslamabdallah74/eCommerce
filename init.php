<?php
// Error Reporting

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$sessionUser = '';
if (isset($_SESSION['user'])) {
  $sessionUser = $_SESSION['user'];
}


  include 'config.php';
  include "includes/functions/myfunctions.php";
  include "includes/templates/header.php";
  include "includes/fonts.php";
  include "includes/languages/english.php";



// include navbar everywhere expet some places
