<?php

  include 'config.php';
  include "includes/templates/header.php";
  include "includes/languages/english.php";
  include "includes/functions/myfunctions.php";



// include navbar everywhere expet some places
if (!isset($noNavbar)) {include "includes/templates/navbar.php";}
