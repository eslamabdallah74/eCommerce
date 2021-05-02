<?php
//Title function
 function getTitle() {
  global $pageTitle;
  if (isset($pageTitle)){
    echo $pageTitle;
  } else {
    echo "Default";
  }
} // function not working ... error code = Uncaught Error: Call to undefined function getTitle()


//redirct function v2.0
function redirctHome($theMsg ,$url = null ,$seconds = 2) {
  if ($url === null) {
    $url = 'dashbored.php';

  } else {

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
      $url = $_SERVER['HTTP_REFERER'];
      $link = 'Previous Page';
    } else {
      $url = "dashbored.php";
      $link = 'dashbored';
    }
  }
  echo  $theMsg;
  echo "<div class='alert alert-info text-center'> You will be redircted to $url after $seconds seconds .... </div> ";
  header("refresh:$seconds;url=$url");
  exit();
}

//function to check item in data base
function checkItem($select ,$from ,$value) {
  global $con;
  $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

  $statment->execute(array($value));

  $count = $statment->rowCount();

  return $count;
}

// count items & members
function Countitems($item , $table) {
  global $con;
  $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
  $stmt2->execute();
  return $stmt2->fetchColumn();
}

// Get Latest Items function
// function to get latest items and Users
function getLatest($select ,$table ,  $order, $limit = 5) {
  global $con;
  $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $getStmt->execute();
  $rows = $getStmt->fetchAll();
  return $rows;

}
