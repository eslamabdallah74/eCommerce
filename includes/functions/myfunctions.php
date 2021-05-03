<?php
// Get  categories function
// function to get categories from database
  function getcate() {
  global $con;
  $getcats = $con->prepare("SELECT * FROM categories ORDER BY ID ASC ");
  $getcats->execute();
  $cats = $getcats->fetchAll();
  return $cats;
}
// Get  items function
// function to get items from database
  function getItems($where , $value) {
  global $con;
  $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_id DESC ");
  $getItems->execute(array($value));
  $items = $getItems->fetchAll();
  return $items;
}
// check the user is actived or not
function checkUserStatus($user) {
  global $con;
  // check (1) If the user is reg in database
  $stmtx = $con->prepare('SELECT  username , reg_status
                      FROM  users
                      WHERE username = ?
                      AND   reg_status = 0 ');
  $stmtx->execute(array($user));
  $status = $stmtx->rowCount();
  return $status;
}
//redirct function v2.0
function redirctHome($theMsg ,$url = null ,$seconds = 2) {
  if ($url === null) {
    $url = 'index.php';

  } else {

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
      $url = $_SERVER['HTTP_REFERER'];
    } else {
      $url = "index.php";
    }
  }
  echo  $theMsg;
  echo "<div class='alert alert-info text-center'> You will be redircted .... </div> ";
  header("refresh:$seconds;url=$url");
  exit();
}
