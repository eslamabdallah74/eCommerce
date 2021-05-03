<?php
    session_start();
    $pageTitle = 'SHOPIPA';

    include "init.php"; // import files
    $stmt   = $con->prepare('SELECT categories.* 
                      From categories
                      ORDER BY Ordering ASC
                      LIMIT 3');
    $stmt->execute();
    $count  = $stmt->rowCount();
    $row    = $stmt->fetchAll();
?>
<div class="container categories">
  <h2>Recent categories</h2>
  <span class="line"></span>
  <div class="row">
  <?php 
    foreach($row as $items){
      $stmt   = $con->prepare('SELECT items.* 
      From items
      WHERE cate_ID = ?');
      $stmt->execute(array($items['ID']));
      $count  = $stmt->rowCount();
    echo '<div class="col-md-4">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top img-thumbnail" src="layout/images/foods.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">'.$items['Name'].'</h5>
            <p class="card-text">'.$items['Description'].'</p>
            <p class="card-text"> Numbers of items are : '.$count.'</p>
            <a href="categories.php?pageid='.$items['ID'].'" class="btn btn-primary">See All items</a>
          </div>
        </div>
      </div>';
    }
 ?>
  </div>
  <hr>
  <div class="recent-items">
    <h2>Recent Items</h2>
    <span class="line"></span>
    <div class="row">
    <?php 
          $stmt   = $con->prepare('SELECT items.*
          From items
          WHERE status = 1
          ORDER BY item_id DESC
          LIMIT 6');
          $stmt->execute(array());
          $count  = $stmt->rowCount();
          $items  = $stmt->fetchAll();
    foreach($items as $item){
      echo '<div class="col-md-4">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top img-thumbnail" src="layout/images/foods.jpg" alt="Card image cap">
            <div class="card-body">
              <div style="height:20px">'.NoStars($item['rating']).'</div>
              <h5 class="card-title">'.$item['name'].'</h5>
              <span class="price">'.$item['price'].'$</span>
              <p class="card-text" style="max-height:100px;overflow: auto;min-height:100px">'.$item['description'].'</p>
              <a href="items.php?itemid='. $item['item_id'] . '" class="btn btn-primary">See item</a> <span class="date">'.time_elapsed_string($item['add_date']).'</span>
            </div>
          </div>
        </div>';
    }
  ?>
    </div>
  </div>
</div>
<?php
    include "includes/templates/footer.php";
?>
