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
      echo '<div class="col-sm-6 col-md-3">';
        echo "<div class='thumbnail'>";
          echo "<span class='price-tag'>$" . $item['price'] . "</span>";
          echo "<img src='https://cdn.iconscout.com/icon/premium/png-256-thumb/phone-setting-6-831060.png' alt ='' />";
          echo "<div class='caption'>";
            echo "<h3 class='item-name';><a href='items.php?itemid=" . $item['item_id'] . "'>" . $item['name'] . "</a></h3>";
            echo "<p class='item-description'>" . $item['description'] . "</p>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    } ?>
  </div>

</div>

<!-- end the page -->
<?php include "includes/templates/footer.php";?>
