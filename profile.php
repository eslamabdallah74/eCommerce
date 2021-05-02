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
        <span class="user-info"><i class="fas fa-lock"></i> Login name <br> </span> <span class="user-info2"><?php echo $info['username']; ?></span> <br>
        <span class="user-info"><i class="fas fa-envelope"></i> Email <br> </span> <span class="user-info2"><?php echo $info['email']; ?></span> <br>
        <span class="user-info"><i class="fas fa-user"></i> Fullname <br> </span> <span class="user-info2"> <?php echo $info['fullname']; ?> </span> <br>
        <span class="user-info"><i class="fas fa-clock"></i> Date of registeration <br> </span> <span class="user-info2"><?php echo $info['Date']; ?></span>
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
              echo '<div class="col-sm-6 col-md-3">';
                echo "<div class='thumbnail-profile'>";
                  echo "<span class='price-tag-profile'>$" . $item['price'] . "</span>";
                  echo "<img src='https://cdn.iconscout.com/icon/premium/png-256-thumb/running-shoes-2420790-2057644.png' alt ='' />";
                  echo "<div class='caption'>";
                    echo "<h3 class='item-name text-center';><a href='items.php?itemid=" . $item['item_id'] . "'>" . $item['name'] . "</a></h3>";
                    echo "<p class='item-description text-center'>" . $item['description'] . "</p>";
                    echo "<div class='date'>" . $item['add_date'] . "</div>";
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
