<?php

session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])) {
  // code...
  include 'init.php';
  $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

  if ($action == 'manage') {
    $sort = 'ASC';
    $sort_array = array('ASC', 'DESC');
    if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
      $sort = $_GET['sort'];
    }
    $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
    $stmt2->execute();
    $cates = $stmt2->fetchAll(); ?>

    <div class="container">
      <div class="panel panel-default Main-Category">
        <h3 class="panel-heading text-center"><i class="fas fa-pen-square"></i>  Manage Categories</h3>
        <div class="ordering pull-right text-center">
          <i class="fa fa-sort"></i>
          Ordering:
          <a class="<?php if($sort == 'ASC') {echo "active";} ?>" href="?sort=ASC">Ascending (ASC)</a> /
          <a class="<?php if($sort == 'DESC') {echo "active";} ?>"   href="?sort=DESC">Descending (DESC)</a>
        </div>
        <div class="panel-body">
          <?php foreach ($cates as $cate) {
            echo "<div class='cate'>";
             echo "<div class='hidden-buttons'> ";
              echo "<a href='categories.php?action=edit&cateid=" . $cate['ID'] . "' class='btn btn-sm btn-outline-primary'><i class='fa fa-edit'></i> Edit </a>";
              echo "<a href='categories.php?action=delete&cateid=" . $cate['ID'] . "' class='confrim btn btn-sm btn-outline-danger'><i class='fas fa-window-close'></i> Delete </a>";
             echo "</div>";
              echo "<h3 class=''>" . $cate['Name'] . "</h3>";
              echo "<p>" . $cate['Description'] . "</p>";
              if ($cate['Visibility'] == 1) {echo "<span class='Visibility'> <i class='fa fa-eye'></i> Hidden </span>"; }
              if ($cate['Allow_Comment'] == 1) {echo "<span class='Comment'><i class='fa fa-window-close'></i> Comment Disable </span>"; }
              if ($cate['Allow_Ads'] == 1) {echo "<span class='ads'><i class='fa fa-window-close'></i> Ads Disable </span>"; }
            echo "</div>";
            echo "<hr>";
          } ?>
        </div>
      </div>
      <a class="add-Category btn btn-light" href="categories.php?action=add"> <i class="fa fa-plus"></i> Add New Category </a>
    </div>

<?php
  }  elseif ($action == 'add') { ?>

    <!-- //add Categories to the page -->
    <h2 class="text-center">Add New Category</h2>
    <div class="container Category-section">
     <form class="form-horizontal" action="?action=insert" method='POST'>
       <!-- Name filed -->
         <div class="form-group row">
          <label class="col-sm-2 control-label">Name</label>
           <div class="col-sm-6">
             <input type="text" name="name" class="form-control" autocomplete="off" required='required' placeholder="Categorie name">
           </div>
        </div>
     <!-- description filed -->
    <div class="form-group row padding">
     <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-6">
        <span class="pass-relative">
          <input type="text" name="description" class="form-control" id='description' autocomplete="off" placeholder="The Description">
        </span>
      </div>
   </div>
   <!-- 	Ordering filed -->
  <div class="form-group row">
   <label class="col-sm-2 control-label">Ordering</label>
    <div class="col-sm-6">
      <input type="text" name="ordering" class="form-control" placeholder="The Filed Ordering ">
    </div>
 </div>
 <!-- visibility filed -->
  <div class="form-group row padding">
   <label class="col-sm-2 control-label">Visible</label>
    <div class="col-sm-6">
      <div>
      <input id='vis-yes' type="radio" name="visibility" value="0" checked />
      <label for="vis-yes">Yes</label>
      <input id='vis-no' type="radio" name="visibility" value="1" />
      <label for="vis-no">No</label>
      </div>
    </div>
 </div>
 <!-- Commenting  filed -->
  <div class="form-group row padding">
   <label class="col-sm-2 control-label">Allow Commenting</label>
    <div class="col-sm-6">
      <div>
      <input id='com-yes' type="radio" name="Commenting" value="0" checked />
      <label for="com-yes">Yes</label>
      <input id='com-no' type="radio" name="Commenting" value="1" />
      <label for="com-no">No</label>
      </div>
    </div>
 </div>
 <!-- Ads filed -->
  <div class="form-group row padding">
   <label class="col-sm-2 control-label">Allow Ads</label>
    <div class="col-sm-6">
      <div>
      <input id='ads-yes' type="radio" name="ads" value="0" checked />
      <label for="ads-yes">Yes</label>
      <input id='ads-no' type="radio" name="ads" value="1" />
      <label for="ads-no">No</label>
      </div>
    </div>
 </div>
 <!-- betton filed -->
<div class="form-group row">
  <div class="col-sm-offset-2 col-sm-10">
    <input type="submit" value="Add Category"= class="btn btn-info">
  </div>
</div>

     </form>
    </div>

    <?php
  } elseif ($action == 'insert') {
    // insert new Category

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      echo "<h3 class='text-center'> insert new Category </h3>";
      echo "<div class='container'>";
      // Get vribals from form
      $name = $_POST['name'];
      $desc = $_POST['description'];
      $order = $_POST['ordering'];
      $visi = $_POST['visibility'];
      $comment = $_POST['Commenting'];
      $ads = $_POST['ads'];

       // update Category
         //check if user exists in database
      $check = checkItem("name", "categories" , $name  );
      if ($check == 1) {
        $theMsg = "<div class='alert alert-danger text-center'> Sorry This Category Exists </div>";
        redirctHome($theMsg , 'back');
      } else {

        //insert Category info in database
              $stmt = $con->prepare('INSERT INTO
                                            categories(name, 	Description , Ordering , Visibility, Allow_Comment, Allow_Ads )
                                            VALUES(:zname , :zdesc, :zorder, :zvisible , :zcomment , :zads  )');
              $stmt->execute(array(
                'zname' => $name,
                'zdesc' => $desc,
                'zorder' => $order,
                'zvisible' => $visi,
                'zcomment' => $comment,
                'zads' => $ads
              ));
               //system update message
               $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " New account created  </div>";
               redirctHome($theMsg, 'back');
           } // end of the else

    } else {
      // system message
      $theMsg = "<div class='alert alert-danger text-center'>Wrong URL </div>";
      redirctHome($theMsg);
    }
    echo "</div>";
    //end of update new member

  } elseif ($action == 'edit') {
    // check if the ID value is existed
              $cateid = isset($_GET['cateid']) && is_numeric($_GET['cateid']) ? intval($_GET['cateid']) : 0;
    // select all data depend  on the ID
              $stmt = $con->prepare('SELECT * FROM categories WHERE ID = ?');
              $stmt->execute(array($cateid));
              $cate = $stmt->fetch();
              $rowCount = $stmt->rowCount();
              if ($stmt->rowCount() > 0) { ?>

                <!-- //Edit Categories to the page -->
                <h2 class="text-center">Edit Category</h2>
                <div class="container Category-section">
                 <form class="form-horizontal" action="?action=update" method='POST'>
                   <input type="hidden" name="cateid" value="<?php echo $cateid ?>">
                   <!-- Name filed -->
                     <div class="form-group row">
                      <label class="col-sm-2 control-label">Name</label>
                       <div class="col-sm-6">
                         <input type="text" name="name" class="form-control" a required='required' placeholder="Categorie name" value="<?php echo $cate['Name']?>">
                       </div>
                    </div>
                 <!-- description filed -->
                <div class="form-group row padding">
                 <label class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-6">
                    <span class="pass-relative">
                      <input type="text" name="description" class="form-control" id='description' placeholder="The Description" value="<?php echo $cate['Description']?>">
                    </span>
                  </div>
               </div>
               <!-- 	Ordering filed -->
              <div class="form-group row">
               <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-6">
                  <input type="text" name="ordering" class="form-control" placeholder="The Filed Ordering " value="<?php echo $cate['Ordering']?>">
                </div>
             </div>
             <!-- visibility filed -->
              <div class="form-group row padding">
               <label class="col-sm-2 control-label">Visible</label>
                <div class="col-sm-6">
                  <div>
                  <input id='vis-yes' type="radio" name="visibility" value="0" <?php if($cate['Visibility'] == 0) {echo "checked";}?> />
                  <label for="vis-yes">Yes</label>
                  <input id='vis-no' type="radio" name="visibility" value="1" <?php if($cate['Visibility'] == 1) {echo "checked";}?> />
                  <label for="vis-no">No</label>
                  </div>
                </div>
             </div>
             <!-- Commenting  filed -->
              <div class="form-group row padding">
               <label class="col-sm-2 control-label">Allow Commenting</label>
                <div class="col-sm-6">
                  <div>
                  <input id='com-yes' type="radio" name="Commenting" value="0" <?php if($cate['Allow_Comment'] == 0) {echo "checked";}?>/>
                  <label for="com-yes">Yes</label>
                  <input id='com-no' type="radio" name="Commenting" value="1" <?php if($cate['Allow_Comment'] == 1) {echo "checked";}?>/>
                  <label for="com-no">No</label>
                  </div>
                </div>
             </div>
             <!-- Ads filed -->
              <div class="form-group row padding">
               <label class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-6">
                  <div>
                  <input id='ads-yes' type="radio" name="ads" value="0" <?php if($cate['Allow_Ads'] == 0) {echo "checked";}?>/>
                  <label for="ads-yes">Yes</label>
                  <input id='ads-no' type="radio" name="ads" value="1" <?php if($cate['Allow_Ads'] == 1) {echo "checked";}?>/>
                  <label for="ads-no">No</label>
                  </div>
                </div>
             </div>
             <!-- betton filed -->
            <div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save"= class="btn btn-info">
              </div>
            </div>

                 </form>
                </div>

               <?php
             } else {
               //system update message
               $theMsg = "<div class='alert alert-danger text-center'> There Is No Such ID With " . $cateid . "</div>";
               redirctHome($theMsg, 'back');
             }

  } elseif ($action == 'update') {
    //update Category
    echo "<h2 class='text-center'> Update Category </h2>";
    echo "<div class='container'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get vribals from form
      $id    = $_POST['cateid'];
      $name  = $_POST['name'];
      $desc  = $_POST['description'];
      $order = $_POST['ordering'];

      $visible = $_POST['visibility'];
      $comment = $_POST['Commenting'];
      $ads     = $_POST['ads'];


       // if there is no errors update the form
         $stmt = $con->prepare('UPDATE
                                      categories
                                SET
                                      Name = ?,
                                      Description = ?,
                                      Ordering = ?,
                                      Visibility = ?,
                                      Allow_Comment = ?,
                                      Allow_Ads = ?
                               WHERE
                                      ID = ?');
         $stmt->execute(array($name, $desc ,$order ,$visible, $comment , $ads , $id));
         //system update message
         $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " Category updated   </div>";
         redirctHome($theMsg, 'categories.php');


    } else {
      //system update message
      $theMsg = "<h1 class='alert alert-danger text-center'> Error 404 </h1>";
      redirctHome($theMsg, 'back');
    }
    echo "</div>";

  } elseif ($action == 'delete') {

    echo "<h3 class='text-center'> Delete Category </h3> ";
    echo "<div class='container'> ";
    // check if the ID value is existed
              $cateid = isset($_GET['cateid']) && is_numeric($_GET['cateid']) ? intval($_GET['cateid']) : 0;
    // select all data depend  on the ID
               $check = checkItem('ID' , 'categories', $cateid);
              if ($check > 0) {
               $stmt = $con->prepare("DELETE from categories WHERE ID = :zid");
               $stmt->bindParam(":zid", $cateid);
               $stmt->execute();
               // system message
               $theMsg = "<div class='alert alert-danger text-center'> " . $stmt->rowCount() . " Account Has Been Deleted </div>";
               redirctHome($theMsg, 'back');
              } else {
                echo "This ID doesn't exist";
              }
              echo "</div>";
             // end of the delete page

  }

  include "includes/templates/footer.php";

} else {
  header('location: dashbored.php');
  exit();
}
