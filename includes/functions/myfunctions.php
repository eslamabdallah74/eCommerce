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
function time_elapsed_string($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
  );
  foreach ($string as $k => &$v) {
      if ($diff->$k) {
          $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
          unset($string[$k]);
      }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function NoStars($stars = 0){
  if($stars==1){
    return '<span class="review">
              <i class="fa fa-star"></i>
          </span>';
  }elseif($stars==2){
    return '<span class="review">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
          </span>';
  }elseif($stars==3){
    return '<span class="review">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
          </span>';
  }elseif($stars==4){
    return '<span class="review">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
          </span>';
  }elseif($stars==5){
    return '<span class="review">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
          </span>';
  }else{
    return '';
  }
}


//function to check item in data base
function checkItem($select ,$from ,$value) {
  global $con;
  $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

  $statment->execute(array($value));

  $count = $statment->rowCount();

  return $count;
}
//redirct function v2.0
function redirctHome($theMsg ,$url = null ,$seconds = 2) {
  if ($url === null) {
    $url = 'index.php';

  } else {

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
      $url = $_SERVER['HTTP_REFERER'];
      $link = 'Previous Page';
    } else {
      $url = "index.php";
    }
  }
  echo  $theMsg;
  header("refresh:$seconds;url=$url");
  exit();
}