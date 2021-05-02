<?php
session_start();
$pageTitle = 'Show Items';
include "init.php"; // import files
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
// select all data depend  on the ID
$stmt = $con->prepare('SELECT items.* ,
                       users.username,
                       categories.Name
                       FROM items
                       INNER JOIN users ON users.userID = items.member_ID
                       INNER JOIN categories ON categories.ID = items.cate_ID
                       WHERE item_id = ?');
$stmt->execute(array($itemid));
$count = $stmt->rowCount();
if ($count > 0) {

$row = $stmt->fetch()
?>
<h1 class="text-center"><?php echo $row['name'] ?></h1>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <img src='https://cdn.iconscout.com/icon/premium/png-256-thumb/running-shoes-2420790-2057644.png' alt ='' />
    </div>
    <div class="col-md-9 items-info">
      <div class="row">
        <div class="col-md-3">
          <h4> <i class="fas fa-audio-description"></i> Description</h4>
        </div>
        <div class="col-md-9">
          <h5> <?php echo $row['description'] ?> </h5>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <h4>  <i class="fas fa-dollar-sign"></i> Price</h4>
        </div>
        <div class="col-md-9">
          <h5> $<?php echo $row['price'] ?> </h5>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <h4> <i class="fas fa-globe-americas"></i> Made in</h4>
        </div>
        <div class="col-md-9">
          <h5> <?php echo $row['country_made'] ?> </h5>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <h4> <i class="far fa-clock"></i> Added at</h4>
        </div>
        <div class="col-md-9">
          <h5> <?php echo $row['add_date'] ?> </h5>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <h4> <i class="fas fa-address-card"></i> Added by </h4>
        </div>
        <div class="col-md-9">
          <h5> <a href="categories.php?pageid=<?php echo $row['cate_ID']; ?>"> <?php echo $row['username'] ?> </a></h5>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <h4> <i class="fas fa-th-list"></i> Category</h4>
        </div>
        <div class="col-md-9">
          <h5> <a href="categories.php?pageid=<?php echo $row['cate_ID']; ?>"> <?php echo $row['Name'] ?> </a></h5>
        </div>
      </div>


    </div>
  </div>
  <hr>
  <!-- end of the container -->
</div>
<!-- add comments -->
<?php if(isset($_SESSION['user'])) { ?>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-3">
        <h4>Add comment</h4>
        <form class="" action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $row['item_id'] ?>" method="post">
          <textarea name="comment" rows="8" cols="80"></textarea>
          <input class="btn btn-danger"type="submit" name="" value="add">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
          $itemid  = $row['item_id'];
          $userid  = $row['username'];
          if (! empty($comment)) {
            $stmt = $con->prepare("INSERT INTO
                                    comments(comment, status ,comment_date ,item_id ,user_id)
                                    VALUES(:zcomment, 0 , NOW(), :zitemid ,:zuserid)");
            $stmt->execute(array(
              'zcomment' => $comment,
              'zitemid' => $itemid,
              'zuserid' => $userid
            ));
            // comment added
            if ($stmt) {
              echo "<div class='alert alert-danger'Added</div>";
            }
          }
        }
         ?>
      </div>
    </div>
  <?php } else {
        echo "<div class='container'>";
          echo "<a class='btn btn-danger' href='login.php'>Login to add comment </a>";
        echo "</div>";
        } ?>
    <div class="container">
      <hr>
    <div class="row">
      <div class="col-md-3">
        User Image
      </div>
      <div class="col-md-9">
        User comment
      </div>
    </div>
  </div>
</div>
<?php
} else {
  echo "<div class='alert alert-danger text-center'>Wrong ID </div>";
}


include "includes/templates/footer.php";
