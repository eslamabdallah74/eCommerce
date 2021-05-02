<?php
 /*
=============================================
== Mange Comments section....
==ADDIN / REMOVING / DELETING Comments.....
==============================================
 */
      $pageTitle = 'Comments';
       session_start();
       if (isset($_SESSION['username'])) {
         // code...
         include 'init.php';
         $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

         if ($action == 'manage') {
      //start manage page
           $stmt = $con->prepare("SELECT
                                    comments.* , items.name AS Item_Name ,users.username AS Member
                                   FROM
                                    comments
                                  INNER JOIN
                                    items
                                  ON
                                    items.item_id = comments.item_id
                                  INNER JOIN
                                    users
                                  ON
                                    users.userID = comments.user_id");
           $stmt->execute();
           // assign to variables
           $rows = $stmt->fetchAll();
           ?>
           <!-- // start manage page -->
            <h2 class="text-center">Manage comments</h2>
            <div class="container">
              <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                  <tr>
                    <td>#ID</td>
                    <td>Comment</td>
                    <td>Item Name</td>
                    <td>User name</td>
                    <td>Added date</td>
                    <td>Control</td>
                  </tr>
                  <?php
                   foreach ($rows as $row) {
                     // code...
                     echo "<tr>";
                      echo "<td>" . $row['c_id'] . "</td>";
                      echo "<td>" . $row['comment'] . "</td>";
                      echo "<td>" . $row['Item_Name'] . "</td>";
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
            </div>
<?php
        } elseif ($action == 'edit') { // edit page
// check if the ID value is existed
          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
// select all data depend  on the ID
          $stmt = $con->prepare('SELECT * FROM comments WHERE c_id = ?');
          $stmt->execute(array($comid));
          $row = $stmt->fetch();
          $rowCount = $stmt->rowCount();
          if ($stmt->rowCount() > 0) { ?>

               <h2 class="text-center">Edit Comment</h2>
               <div class="container">
                <form class="form-horizontal" action="?action=update" method='POST'>
                  <input type="hidden" name="comid" value="<?php echo $comid ?>">
                  <!-- Comment filed -->
                    <div class="form-group row">
                     <label class="col-sm-2 control-label">Comment</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="comment"> <?php echo $row['comment'] ?> </textarea>
                      </div>
                   </div>

            <!-- betton filed -->
           <div class="form-group row">
             <div class="col-md-4 col-sm-offset-4 col-sm-10">
               <input type="submit" value="save" class="btn btn-info">
             </div>
          </div>

                </form>
               </div>


           <?php
         } else {
           //system update message
           $theMsg = "<h1 class='alert alert-danger text-center'> There Is No Such ID With " . $userid . "</h1>";
           redirctHome($theMsg, 'back');
         }
         //update page
       } elseif ($action == 'update') {

         echo "<h2 class='text-center'> Update Comment </h2>";
         echo "<div class='container'>";
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Get vribals from form
           $comid    =   $_POST['comid'];
           $comment  =   $_POST['comment'];


              $stmt = $con->prepare('UPDATE comments SET comment = ? WHERE c_id = ?');
              $stmt->execute(array( $comment, $comid));
              //system update message
              $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " Comment updated   </div>";
              redirctHome($theMsg, 'back');


         } else {
           //system update message
           $theMsg = "<h1 class='alert alert-danger text-center'> Error 404 </h1>";
           redirctHome($theMsg, 'back');
         }
         echo "</div>";

       } elseif ($action == 'delete') {   //delete member page
         echo "<h3 class='text-center'> Delete Comment </h3> ";
         echo "<div class='container'> ";
         // check if the ID value is existed
                   $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
         // select all data depend  on the ID
                    $check = checkItem('c_id' , 'comments' ,$comid);

                   if ($check > 0) {
                    $stmt = $con->prepare("DELETE from comments WHERE c_id = :zcid");
                    $stmt->bindParam(":zcid", $comid);
                    $stmt->execute();
                    // system message
                    $theMsg = "<div class='alert alert-danger text-center'> " . $stmt->rowCount() . " Comment Has Been Deleted </div>";
                    redirctHome($theMsg, 'back');
                   } else {
                     echo "This ID doesn't exist";
                   }
                   echo "</div>";
                  // end of the delete page

       } elseif ($action == 'approve') {
         echo "<h4 class='text-center'> Approve Comment </h4> ";
         echo "<div class='container'> ";
         // check if the ID value is existed
                   $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
         // select all data depend  on the ID
                    $check = checkItem('c_id' , 'comments' ,$comid);

                   if ($check > 0) {
                    $stmt = $con->prepare("UPDATE Comments SET status = 1 WHERE c_id = ?");
                    $stmt->execute(array($comid));
                    // system message
                    $theMsg = "<div class='alert alert-success text-center'> " . $stmt->rowCount() . " Comment Has Been Approved </div>";
                    redirctHome($theMsg, 'back');
                   } else {
                     echo "This ID doesn't exist";
                   }
                   echo "</div>";
                  // end of the Activate page

       }

         include "includes/templates/footer.php";
     } else {
       // code...
       header('location: index.php');
       exit();
     };
