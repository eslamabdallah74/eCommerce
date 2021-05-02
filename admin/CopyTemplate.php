<?php

session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])) {
  // code...
  include 'init.php';
  $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

  if ($action == 'manage') {
    echo "Welcome";
  }  elseif ($action == 'add') {

  } elseif ($action == 'insert') {

  } elseif ($action == 'edit') {

  } elseif ($action == 'update') {

  } elseif ($action == 'delete') {

  } elseif ($action == 'active') {

  }
  include "includes/templates/footer.php";

} else {
  header('location: dashbored.php');
  exit();
}
