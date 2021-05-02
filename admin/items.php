<?php

session_start();
$pageTitle = 'Items';

if (isset($_SESSION['username'])) {
  // code...
  include 'init.php';
  $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

  if ($action == 'manage') {
  //manage items page
  $stmt = $con->prepare("SELECT items.* ,
                        categories.Name AS Cate_Name,
                        users.username AS Client_Name FROM items
                        INNER JOIN categories ON categories.ID = items.cate_ID
                        INNER JOIN users ON users.userID = items.member_ID");
  $stmt->execute();
  // assign to variables
  $items = $stmt->fetchAll();
  ?>
  <!-- // start manage page -->
   <h2 class="text-center">Manage Items</h2>
   <div class="container">
     <div class="table-responsive">
       <table class="main-table text-center table table-bordered">
         <tr>
           <td>#ID</td>
           <td>Name</td>
           <td>Description</td>
           <td>Price</td>
           <td>Date</td>
           <td>Category</td>
           <td>Username</td>
           <td>Control</td>
         </tr>
         <?php
          foreach ($items as $item) {
            // code...
            echo "<tr>";
             echo "<td>" . $item['item_id'] . "</td>";
             echo "<td>" . $item['name'] . "</td>";
             echo "<td>" . $item['description'] . "</td>";
             echo "<td>" . $item['price'] . "</td>";
             echo "<td>" . $item['add_date'] . "</td>";
             echo "<td>" . $item['Cate_Name'] . "</td>";
             echo "<td>" . $item['Client_Name'] . "</td>";
             echo "<td> <a href='items.php?action=edit&itemid=" . $item['item_id'] . "'
              class = 'btn btn-success'><i class='fa fa-edit'></i> Edit </a>
              <a href='items.php?action=delete&itemid=" . $item['item_id'] . "'
              class = 'btn btn-danger confrim'><i class='fa fa-times'></i> Delete </a>";
              if ($item['approve'] == 0) {
             echo "<a href='items.php?action=approve&itemid=" . $item['item_id'] . "'  class = 'btn btn-info Active'> <i class='fas fa-check'></i> Approve Item</a>";
              }
              if ($item['approve'] == 1) {
             echo "<a href='items.php?action=deny&itemid=" . $item['item_id'] . "'  class = 'btn btn-dark Active'> <i class='fas fa-times-circle'></i> Deny Item</a>";
              }
            echo "</td>";
         echo "</tr>";
          }
         ?>
       </table>
     </div>
   <a href='items.php?action=add' class="btn btn-secondary"> <i class="fa fa-plus"></i> New Item</a>
   </div>

  <?php
// end of maange page
  }  elseif ($action == 'add') { ?>
    <!-- //add item to the page -->
    <h2 class="text-center padding">Add New item</h2>
    <div class="container Category-section">
     <form class="form-horizontal" action="?action=insert" method='POST'>
       <!-- Name filed -->
         <div class="form-group row padding">
          <label class="col-sm-2 control-label">Name</label>
           <div class="col-sm-10 col-md-6">
             <input type="text" name="name" class="form-control" autocomplete="off" required='required' placeholder="Item name">
           </div>
        </div>
        <!-- Description filed -->
          <div class="form-group row padding">
           <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
              <input type="text" name="description" class="form-control" autocomplete="off" required='required' placeholder="Description">
            </div>
         </div>
         <!-- price filed -->
           <div class="form-group row padding">
            <label class="col-sm-2 control-label">Price</label>
             <div class="col-sm-10 col-md-6">
               <input type="text" name="price" class="form-control" autocomplete="off" required='required' placeholder="Price">
             </div>
          </div>
          <!-- country made filed -->
            <div class="form-group row padding">
             <label class="col-sm-2 control-label">Country</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="country_made" class="form-control" autocomplete="off" required='required' placeholder="Item Country made">
              </div>
           </div>
           <!-- Description filed -->
           <div class="form-group row padding">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
              <select name="status">
                <option value="0">...</option>
                <option value="1">New</option>
                <option value="2">Like New</option>
                <option value="3">Used</option>
                <option value="4">Old</option>
              </select>
            </div>
        </div>

            <!-- Member  selection-->
            <div class="form-group row padding">
             <label class="col-sm-2 control-label">Member</label>
              <div class="col-sm-10 col-md-6">
                <select class="" name="member">
                  <option value="0">...</option>
                  <?php
                  $stmt = $con->prepare("SELECT * FROM users");
                  $stmt->execute();
                  $users = $stmt->fetchAll();
                  foreach ($users as $user) {
                  echo "<option value='" . $user['userID'] . "' > " . $user['username'] . " </option> ";
                };
                   ?>
                </select>
              </div>
           </div>
           <!-- Category selection  -->
           <div class="form-group row padding">
            <label class="col-sm-2 control-label">Category</label>
             <div class="col-sm-10 col-md-6">
               <select class="" name="Category">
                 <option value="0">...</option>
                 <?php
                 $stmt2 = $con->prepare("SELECT * FROM Categories");
                 $stmt2->execute();
                 $Categories = $stmt2->fetchAll();
                 foreach ($Categories as $Category) {
                 echo "<option value='" . $Category['ID'] . "' > " . $Category['Name'] . " </option> ";
               };
                  ?>
               </select>
             </div>
          </div>
    <!-- submit filed -->
  <div class="form-group row">
    <div class="col-sm-2"></div>
    <div class="col-sm-6 padding">
    <input type="submit" value="Add Item"= class="btn btn-info">
    </div>
  </div>

     </form>
    </div>
    <?php

    } elseif ($action == 'insert') {
      //start of insert item page

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        echo "<h3 class='text-center'> Item Has Been Added </h3>";
        echo "<div class='container'>";
        // Get vribals from form
        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $price      = $_POST['price'];
        $country    = $_POST['country_made'];
        $status     = $_POST['status'];
        $member     = $_POST['member'];
        $cate       = $_POST['Category'];



         //validate the form
        $formerrors = array();
        if (empty($name)) {
          $formerrors[] =  '<strong> Name </strong> Cant be <strong> Empty </strong>';
        }
        if (empty($desc)) {
          $formerrors[] = ' <strong> description </strong>  Cant be <strong> Empty ';
        }
        if (empty($price)) {
          $formerrors[] = '<strong> price </strong> Cant be <strong> Empty </strong> ';
        }
        //loop into errors
         foreach($formerrors as $error){
           echo '<div class="alert alert-danger">' . $error .  '</div>' ;
         }
         // if there is no errors update the form
         if (empty($formerrors)) {


          //insert user info in database
                $stmt = $con->prepare('INSERT INTO
                                      items(name, description, price, country_made, status, add_date, member_ID ,Cate_ID)
                                      VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zmember, :zcate) ');
                $stmt->execute(array(
                  'zname'     => $name,
                  'zdesc'     => $desc,
                  'zprice'    => $price,
                  'zcountry'  => $country,
                  'zstatus'   => $status,
                  'zmember'   => $member,
                  'zcate'     => $cate
                ));

                 //system update message
                 $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " New account created  </div>";
                 redirctHome($theMsg, 'back');
             } // end of the else
         } // second If end


       else {
        // system message
        $theMsg = "<div class='alert alert-danger text-center'>Wrong UR....... </div>";
        redirctHome($theMsg);
      }
      echo "</div>";
      //end of update new member


    } elseif ($action == 'edit') {
    // edit page
// check if the ID value is existed
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
      // select all data depend  on the ID
      $stmt = $con->prepare('SELECT * FROM items WHERE item_id = ?');
      $stmt->execute(array($itemid));
      $row = $stmt->fetch()
      $rowCount = $stmt->rowCount();
      if ($stmt->rowCount() > 0) { ?>

        <!-- //add Categories to the page -->
        <h2 class="text-center padding">Edit <?php echo "<span class='mycolor1'>" . $row['name'] . "</span>"  ?>  Item</h2>
        <div class="container Category-section">
         <form class="form-horizontal" action="?action=update" method='POST'>
           <!-- Hidden filed -->
           <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
           <!-- Name filed -->
             <div class="form-group row padding">
              <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-10 col-md-6">
                 <input type="text" name="name" class="form-control" autocomplete="off" required='required' placeholder="Item name"
                 value="<?php echo $row['name']; ?>">
               </div>
            </div>
            <!-- Description filed -->
              <div class="form-group row padding">
               <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="description" class="form-control" autocomplete="off" required='required' placeholder="Description"
                   value="<?php echo $row['description']; ?>">
                </div>
             </div>
             <!-- price filed -->
               <div class="form-group row padding">
                <label class="col-sm-2 control-label">Price</label>
                 <div class="col-sm-10 col-md-6">
                   <input type="text" name="price" class="form-control" autocomplete="off" required='required' placeholder="Price"
                   value="<?php echo $row['price']; ?>">
                 </div>
              </div>
              <!-- country made filed -->
                <div class="form-group row padding">
                 <label class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10 col-md-6">
                    <input type="text" name="country_made" class="form-control" autocomplete="off" required='required' placeholder="Item Country made" value="<?php echo $row['country_made']; ?>">
                  </div>
               </div>
               <!-- Description filed -->
                 <div class="form-group row padding">
                  <label class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10 col-md-6">
                    <select name="status">
                      <option value="1" <?php if ($row['status'] == 1) {echo 'selected';} ?> >New</option>
                      <option value="2" <?php if ($row['status'] == 2) {echo 'selected';} ?>>Like New</option>
                      <option value="3" <?php if ($row['status'] == 3) {echo 'selected';} ?>>Used</option>
                      <option value="4" <?php if ($row['status'] == 4) {echo 'selected';} ?>>Old</option>
                    </select>
                  </div>
              </div>

                <!-- Member  selection-->
                <div class="form-group row padding">
                 <label class="col-sm-2 control-label">Member</label>
                  <div class="col-sm-10 col-md-6">
                    <select class="" name="member">
                      <option value="0">...</option>
                      <?php
                      $stmt = $con->prepare("SELECT * FROM users");
                      $stmt->execute();
                      $users = $stmt->fetchAll();
                      foreach ($users as $user) {
                      echo "<option value='" . $user['userID'] . "' ";
                      if ($row['member_ID'] == $user['userID']) {echo 'selected';}
                      echo ">" . $user['username'] .  "</option>";
                    };
                       ?>
                    </select>
                  </div>
               </div>
               <!-- Category selection  -->
               <div class="form-group row padding">
                <label class="col-sm-2 control-label">Category</label>
                 <div class="col-sm-10 col-md-6">
                   <select class="" name="Category">
                     <option value="0">...</option>
                     <?php
                     $stmt2 = $con->prepare("SELECT * FROM Categories");
                     $stmt2->execute();
                     $Categories = $stmt2->fetchAll();
                     foreach ($Categories as $Category) {
                     echo "<option value='" . $Category['ID'] . "'";
                     if ($row['cate_ID'] == $Category['ID']) {echo 'selected';}
                     echo ">" . $Category['Name'] . " </option> ";
                   };
                      ?>
                   </select>
                 </div>
              </div>
        <!-- submit filed -->
      <div class="form-group row">
        <div class="col-sm-6 padding">
        <input type="submit" value="Update item"= class="btn btn-info">
        </div>
      </div>

         </form>
         <?php
         //start manage page
              $stmt = $con->prepare("SELECT
                                       comments.* , users.username AS Member
                                    FROM
                                       comments
                                    INNER JOIN
                                       users
                                    ON
                                       users.userID = comments.user_id
                                    WHERE
                                      item_id = ?");
              $stmt->execute(array($itemid));
              // assign to variables
              $rows = $stmt->fetchAll();
              if (! empty($rows)) {
              ?>
              <!-- // start manage page -->
               <h2 class="text-center">Manage  <?php echo "<span class='mycolor1'>" . $row['name'] . "</span>"  ?> Comments </h2>
               <div class="container">
                 <div class="table-responsive">
                   <table class="main-table text-center table table-bordered">
                     <tr>
                       <td>Comment</td>
                       <td>User name</td>
                       <td>Added date</td>
                       <td>Control</td>
                     </tr>
                     <?php
                      foreach ($rows as $row) {
                        // code...
                        echo "<tr>";
                         echo "<td>" . $row['comment'] . "</td>";
                         echo "<td>" . $row['Member'] . "</td>";
                         echo "<td>" . $row['comment_date'] . "</td>";
                         echo "<td> <a href='comments.php?action=edit&comid=" . $row['c_id'] . "'  class = 'btn btn-success'><i class='fa fa-edit'></i> Edit </a>
                                    <a href='comments.php?action=delete&comid=" . $row['c_id'] . "'  class = 'btn btn-danger confrim'><i class='fa fa-times'></i> Delete </a>";
                                    if ($row['status'] == 0) {
                                   echo "<a href='comments.php?action=approve&comid=" . $row['c_id'] . "'  class = 'btn btn-info Active'> <i class='far fa-thumbs-up'></i> approve </a>";
                                    }

                       echo "</td>";
                       echo "</tr>";
                      }
                     ?>
                   </table>
                 </div>
                 <!-- closeing if Tag -->
        <?php   } ?>
               </div>

      </div>

       <?php
     } else {
       //system update message
       $theMsg = "<h1 class='alert alert-danger text-center'> There Is No Such ID With " . $itemid . "</div>";
       redirctHome($theMsg, 'back');
     }

  } elseif ($action == 'update') {

    echo "<h2 class='text-center'> Update Item </h2>";
    echo "<div class='container'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get vribals from form
      $id         = $_POST['itemid'];
      $name       = $_POST['name'];
      $desc       = $_POST['description'];
      $price      = $_POST['price'];
      $country    = $_POST['country_made'];
      $status     = $_POST['status'];
      $cate       = $_POST['Category'];
      $member     = $_POST['member'];

      //validate the form
      $formerrors = array();
      if (empty($name)) {
        $formerrors[] =  '<strong> name </strong> Cant be <strong> Empty </strong>';
      }
      if (empty($desc)) {
        $formerrors[] = ' <strong> description </strong>  Cant be <strong> Empty ';
      }
      if (empty($price)) {
        $formerrors[] = '<strong> price </strong> Cant be <strong> Empty </strong> ';
      }
      //loop into errors
       foreach($formerrors as $error){
         echo '<div class="alert alert-danger">' . $error .  '</div>' ;
       }
       // if there is no errors update the form
       if (empty($formerrors)) {

         $stmt = $con->prepare('UPDATE items
                                SET
                                  name = ?,
                                  description = ?,
                                  price = ?,
                                  country_made = ?,
                                  status = ?,
                                  member_ID = ? ,
                                  cate_ID  = ?
                                WHERE item_id  = ?');
         $stmt->execute(array($name, $desc ,$price, $country , $status ,$member , $cate ,$id));
         //system update message
         $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " Item updated   </div>";
         redirctHome($theMsg, 'back');

       }



    } else {
      //system update message
      $theMsg = "<h1 class='alert alert-danger text-center'> Error 404 </h1>";
      redirctHome($theMsg, 'back');
    }
    echo "</div>";

  } elseif ($action == 'delete') {
    //delete item page
     echo "<h3 class='text-center'> Delete Item </h3> ";
     echo "<div class='container'> ";
     // check if the ID value is existed
               $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
     // select all data depend  on the ID
                $check = checkItem('item_id' , 'items' ,$itemid);

               if ($check > 0) {
                $stmt = $con->prepare("DELETE from items WHERE item_id = :zitemid");
                $stmt->bindParam(":zitemid", $itemid);
                $stmt->execute();
                // system message
                $theMsg = "<div class='alert alert-danger text-center'> " . $stmt->rowCount() . " Item Has Been Deleted </div>";
                redirctHome($theMsg, 'back');
               } else {
                 echo "This ID doesn't exist";
               }
               echo "</div>";
              // end of the delete page

   } elseif ($action == 'Activate') {
     echo "<h4 class='text-center'> Activate member </h4> ";
     echo "<div class='container'> ";
     // check if the ID value is existed
               $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     // select all data depend  on the ID
                $check = checkItem('userid' , 'users' ,$userid);

               if ($check > 0) {
                $stmt = $con->prepare("UPDATE users SET reg_status = 1 WHERE userID = ?");
                $stmt->execute(array($userid));
                // system message
                $theMsg = "<div class='alert alert-success text-center'> " . $stmt->rowCount() . " Account Has Been Activated </div>";
                redirctHome($theMsg, 'back');
               } else {
                 echo "This ID doesn't exist";
               }
               echo "</div>";
              // end of the Activate page

  } elseif ($action == 'approve') {
    echo "<h4 class='text-center'> Approved Item </h4> ";
    echo "<div class='container'> ";
    // check if the ID value is existed
              $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    // select all data depend  on the ID
               $check = checkItem('item_id' , 'items' ,$itemid);

              if ($check > 0) {
               $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE item_id  = ?");
               $stmt->execute(array($itemid));
               // system message
               $theMsg = "<div class='alert alert-success text-center'> " . $stmt->rowCount() . " Item Has Been Activated </div>";
               redirctHome($theMsg, 'back');

              } else {
                $theMsg = "<div class='alert alert-danger text-center'> Wrong ID </div>";
                redirctHome($theMsg, 'back');
              }
              echo "</div>";
             // end of the Activate page

  } elseif ($action == 'deny') {
    //
    echo "<h4 class='text-center'> Denied Item </h4> ";
    echo "<div class='container'> ";
    // check if the ID value is existed
              $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    // select all data depend  on the ID
               $check = checkItem('item_id' , 'items' ,$itemid);

              if ($check > 0) {
               $stmt = $con->prepare("UPDATE items SET approve = 0 WHERE item_id  = ?");
               $stmt->execute(array($itemid));
               // system message
               $theMsg = "<div class='alert alert-success text-center'> " . $stmt->rowCount() . " Item Has Been Denied </div>";
               redirctHome($theMsg, 'back');

              } else {
                $theMsg = "<div class='alert alert-danger text-center'> Wrong ID </div>";
                redirctHome($theMsg, 'back');
              }

      echo "</div>";
             // end of the Activate page
  }

  include "includes/templates/footer.php";
}
