<?php
session_start();
$pageTitle = 'SHOPIPA';
include "init.php"; // import files
?>
<!-- start the page -->

<div class="container">
  <h1 class='text-center'> Category items </h1>
  <div class="row">
    <?php foreach (getItems('cate_ID' , $_GET['pageid']) as $item) {
      echo "<div class='col-md-6'>";
        echo "<div class='thumbnail'>";
          echo "<span class='price-tag'>$" . $item['price'] . "</span>";
          echo "<img class='cate-img' src='layout/images/item.png' alt ='prodect-img' />";
          echo "<div class='caption'>";
            echo "<h3 class='item-name';>" . $item['name']. "</h3>";
            echo  "<p class='card-text' style='max-height:100px;overflow: auto;min-height:100px'>" . $item['description'] . "</p>";
            echo "<a class='show-item' href='items.php?itemid=" . $item['item_id'] . "'>See the item</a>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    } ?>
  </div>

</div>

<!-- end the page -->
<?php include "includes/templates/footer.php";?>
