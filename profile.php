<?php
session_start();
$pageTitle = 'Profile';

include "init.php"; // import files
if (isset($_SESSION['user'])) {

$getUser = $con->prepare('SELECT * FROM users WHERE username = ?');

$getUser->execute(array($sessionUser));

$info = $getUser->fetch();


?>
<h1 class="text-center">My Profile</h1>
<div class="information">
  <div class="container">
    <div class="card">
      <ul class="list-group list-group-flush">
        <li class="list-group-item main">Information</li>
        <li class="list-group-item">
          <div class="row">

          <div class="col-md-3">
          <span class="user-info"><i class="fas fa-lock-open"></i> Login name <br> </span> 
          </div>
          <div class="col-md-3"><span class="user-info2"><?php echo $info['username']; ?></span></div>

         <div class="col-md-3">
          <span class="user-info"><i class="far fa-envelope"></i> Email <br> </span> 
          </div>
          <div class="col-md-3"><span class="user-info2"><?php echo $info['email']; ?></span></div>   

          <div class="col-md-3">
          <span class="user-info"><i class="fas fa-user"></i> Fullname <br> </span> 
          </div>
          <div class="col-md-3"><span class="user-info2"><?php echo $info['fullname']; ?></span></div>   

          <div class="col-md-3">
          <span class="user-info"><i class="far fa-clock"></i> registered date <br> </span> 
          </div>
          <div class="col-md-3"><span class="user-info2"><?php echo $info['Date']; ?></span></div>
          </div>
  
        </li>
      </ul>
    </div>
    <div class="card">
      <ul class="list-group list-group-flush">
        <li class="list-group-item main">Items</li>
        <li class="list-group-item">
          <div class="row">
            <?php
            if (! empty(getItems('member_ID' ,$info['userID']))) {
            foreach (getItems('member_ID' , $info['userID']) as $item) {
              echo "<div class='col-md-3'>";
               echo "<div class='thumbnail'><a class='show-item' href='items.php?itemid=" . $item['item_id'] . "'></a>";
                 echo "<span class='price-tag'>$" . $item['price'] . "</span>";
                 echo "<img src='https://cdn.iconscout.com/icon/premium/png-256-thumb/phone-setting-6-831060.png' alt ='' />";
                 echo "<div class='caption'>";
                  echo "<h3 class='item-name';>" . $item['name']. "</h3>";
                  echo "<p class='item-description'>" . $item['description'] . "</p>";
                 echo "</div>";
                echo "</div>";
             echo "</div>";
              }
            } else {
              echo "<span class='container'>There is no Items. <a href='newitem.php'>Make a New Item. </a> </span>";
            }
            ?>
          </div>
         </li>
      </ul>
    </div>
    <div class="card">
      <ul class="list-group list-group-flush">
        <li class="list-group-item main">Comments</li>
        <li class="list-group-item">
          <?php
          $stmt = $con->prepare("SELECT * FROM comments WHERE user_id = ?");
          $stmt->execute(array($info['userID']));
          // assign to variables
          $comments = $stmt->fetchAll();
          if (! empty($comments)) {
            foreach ($comments as $comment){
              echo "<p class='comment'> - " . $comment['comment'] . "</p>";
            }
          } else {
            echo "There is no coments.";
          }

           ?>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php } else {
  header('location: login.php');
  exit();
}
 ?>

<?php
include "includes/templates/footer.php";
