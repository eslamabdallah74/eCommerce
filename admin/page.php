<?php
 // Categories => [Manage | Edit | Update| Insert | Delete ]

 $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
// page switch
 if ($action == 'manage') {
   // code...
   echo "Welcome To manage page";
   echo "<a href='?action=edit'> Edit+ </a>";
 } elseif ($action == 'edit') {
   // code...
   echo "Welcome To Edit page";
   echo "<a href='?action=update'> Update+ </a>";
 }  elseif ($action == 'update') {
    // code...
    echo "Welcome To update page";
  }
