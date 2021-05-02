<?php
 /*
=============================================
== Mange members section....
==ADDIN / REMOVING / DELETING MEMBERS.....
==============================================
 */
      $pageTitle = 'Members';
       session_start();
       if (isset($_SESSION['username'])) {
         // code...
         include 'init.php';
         $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

         if ($action == 'manage') {
           $query ='';
           if (isset($_GET['page']) && $_GET['page'] == 'pending') {
             $query = 'AND reg_status = 0';
           }

           $stmt = $con->prepare("SELECT * FROM users WHERE groupID != 1 $query");
           $stmt->execute();
           // assign to variables
           $rows = $stmt->fetchAll();
           ?>
           <!-- // start manage page -->
            <h2 class="text-center">Manage Members</h2>
            <div class="container">
              <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                  <tr>
                    <td>#ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Full name</td>
                    <td>Regusterd date</td>
                    <td>Control</td>
                  </tr>
                  <?php
                   foreach ($rows as $row) {
                     // code...
                     echo "<tr>";
                      echo "<td>" . $row['userID'] . "</td>";
                      echo "<td>" . $row['username'] . "</td>";
                      echo "<td>" . $row['email'] . "</td>";
                      echo "<td>" . $row['fullname'] . "</td>";
                      echo "<td>" . $row['Date'] . "</td>";
                      echo "<td> <a href='members.php?action=edit&userid=" . $row['userID'] . "'  class = 'btn btn-success'><i class='fa fa-edit'></i> Edit </a>
                                 <a href='members.php?action=delete&userid=" . $row['userID'] . "'  class = 'btn btn-danger confrim'><i class='fa fa-times'></i> Delete </a>";
                                 if ($row['reg_status'] == 0) {
                                echo "<a href='members.php?action=Activate&userid=" . $row['userID'] . "'  class = 'btn btn-info Active'> <i class='far fa-thumbs-up'></i> Active </a>";
                                 }
                                 if ($row['reg_status'] == 1) {
                                echo "<a href='members.php?action=Deactivate&userid=" . $row['userID'] . "'  class = 'btn btn-dark Deactivate'> <i class='far fa-thumbs-down'></i> Deactivate </a>";
                                 }

                    echo "</td>";
                    echo "</tr>";
                   }
                  ?>
                </table>
              </div>
            <a href='members.php?action=add' class="btn btn-secondary"> <i class="fa fa-plus"></i>New Member</a>
            </div>

      <?php   } elseif ($action == 'add') {
           // close php tag and start html
           ?>

           <!-- //add members to the page -->
           <h2 class="text-center">Add New Member</h2>
           <div class="container">
            <form class="form-horizontal" action="?action=insert" method='POST'>
              <!-- username filed -->
                <div class="form-group row">
                 <label class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-6">
                    <input type="text" name="username" class="form-control" autocomplete="off" required='required' placeholder="Type your username">
                  </div>
               </div>
            <!-- password filed -->
           <div class="form-group row">
            <label class="col-sm-2 control-label">Password</label>
             <div class="col-sm-6">
               <span class="pass-relative">
                 <input type="password" name="password" class="form-control password" id='password' autocomplete="off" placeholder="Type your password" required='required'>
                 <i class="fa fa-eye fa-2x showPass" id='showPass' onmouseover="mouseoverPass();" onmouseout="mouseoutPass();"></i>
               </span>
             </div>
          </div>
          <!-- fullname filed -->
         <div class="form-group row">
          <label class="col-sm-2 control-label">Full Name</label>
           <div class="col-sm-6">
             <input type="text" name="fullname" class="form-control" required='required' placeholder="Type your full name">
           </div>
        </div>  <!-- email filed -->
         <div class="form-group row">
          <label class="col-sm-2 control-label">Email</label>
           <div class="col-sm-6">
             <input type="email" name="email" class="form-control" required='required' placeholder="Type your email">
           </div>
        </div>
        <!-- betton filed -->
       <div class="form-group row">
         <div class="col-sm-offset-2 col-sm-10">
           <input type="submit" value="Add Member"= class="btn btn-info">
         </div>
      </div>

            </form>
           </div>
          <?php
        } elseif ($action == 'insert') {
          // insert member page

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h3 class='text-center'> Member Has Been Added </h3>";
            echo "<div class='container'>";
            // Get vribals from form
            $user = $_POST['username'];
            $pass = sha1($_POST['password']);
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $hashpass = sha1($_POST['password']);
            //validate the form
            $formerrors = array();
            if (empty($user)) {
              $formerrors[] =  '<strong> Username </strong> Cant be <strong> Empty </strong>';
            }
            if (empty($email)) {
              $formerrors[] = ' <strong> Email </strong>  Cant be <strong> Empty ';
            }
            if (empty($name)) {
              $formerrors[] = '<strong> Fullname </strong> Cant be <strong> Empty </strong> ';
            }
            //loop into errors
             foreach($formerrors as $error){
               echo '<div class="alert alert-danger">' . $error .  '</div>' ;
             }
             // if there is no errors update the form
             if (empty($formerrors)) {
               //check if user exists in database
            $check = checkItem("username" , "users" , $user);
            if ($check == 1) {
              echo "<div class='alert alert-danger text-center'> Sorry This Username Exists </div>";
              header("refresh:2;url=members.php?action=add");
            } else {

              //insert user info in database
                    $stmt = $con->prepare('INSERT INTO
                                                  users(username, password , email , fullname, reg_status ,Date )
                                                  VALUES(:zuser , :zpass, :zmail, :zname , 1 ,now()) ');
                    $stmt->execute(array(
                      'zuser' => $user,
                      'zpass' => $hashpass,
                      'zmail' => $email,
                      'zname' => $name
                    ));
                     //system update message
                     $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " New account created  </div>";
                     redirctHome($theMsg, 'back');
                 } // end of the else
             }
          } else {
            // system message
            $theMsg = "<div class='alert alert-danger text-center'>Wrong URL </div>";
            redirctHome($theMsg);
          }
          echo "</div>";
          //end of update new member

        } elseif ($action == 'edit') { // edit page
// check if the ID value is existed
          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
// select all data depend  on the ID
          $stmt = $con->prepare('SELECT * FROM users WHERE userID = ? LIMIT 1');
          $stmt->execute(array($userid));
          $row = $stmt->fetch();
          $rowCount = $stmt->rowCount();
          if ($stmt->rowCount() > 0) { ?>

               <h2 class="text-center">Edit Member</h2>
               <div class="container">
                <form class="form-horizontal" action="?action=update" method='POST'>
                  <input type="hidden" name="userID" value="<?php echo $userid ?>">
                  <!-- username filed -->
                    <div class="form-group row">
                     <label class="col-sm-2 control-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['username']; ?>" required='required'>
                      </div>
                   </div>

                <!-- password filed -->
               <div class="form-group row">
                <label class="col-sm-2 control-label">Password</label>
                 <div class="col-sm-10">
                   <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
                   <input type="password" name="newpassword" class="form-control" autocomplete="off">
                 </div>
              </div>
              <!-- fullname filed -->
             <div class="form-group row">
              <label class="col-sm-2 control-label">Full Name</label>
               <div class="col-sm-10">
                 <input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname']; ?>" required='required'>
               </div>
            </div>  <!-- email filed -->
             <div class="form-group row">
              <label class="col-sm-2 control-label">Email</label>
               <div class="col-sm-10">
                 <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required='required'>
               </div>
            </div>
            <!-- betton filed -->
           <div class="form-group row">
             <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="save"= class="btn btn-info">
             </div>
          </div>

                </form>
               </div>


           <?php
         } else {
           //system update message
           $theMsg = "<h1 class='alert alert-danger text-center'> There Is No Such ID With " . $userid . "</div>";
           redirctHome($theMsg, 'back');
         }
         //update page
       } elseif ($action == 'update') {

         echo "<h2 class='text-center'> Update Member </h2>";
         echo "<div class='container'>";
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           // Get vribals from form
           $id = $_POST['userID'];
           $user = $_POST['username'];
           $name = $_POST['fullname'];
           $email = $_POST['email'];


           $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

           //validate the form
           $formerrors = array();
           if (empty($user)) {
             $formerrors[] =  '<strong> Username </strong> Cant be <strong> Empty </strong>';
           }
           if (empty($email)) {
             $formerrors[] = ' <strong> Email </strong>  Cant be <strong> Empty ';
           }
           if (empty($name)) {
             $formerrors[] = '<strong> Fullname </strong> Cant be <strong> Empty </strong> ';
           }
           //loop into errors
            foreach($formerrors as $error){
              echo '<div class="alert alert-danger">' . $error .  '</div>' ;
            }
            // if there is no errors update the form
            if (empty($formerrors)) {
              // if the username exits
              $stmt2 = $con->prepare("SELECT * FROM users WHERE username = ? AND userID != ?");
              $stmt2->execute(array($user,$id));
              $count = $stmt2->rowCount();
              if ($count == 1) {

                $theMsg = "<div class='alert alert-danger text-center'> Sorry this username exist </div>";
                redirctHome($theMsg, 'back');

              } else {

                //update
                $stmt = $con->prepare('UPDATE users SET username = ?, email = ?, fullname = ?, password = ? WHERE userID = ?');
                $stmt->execute(array( $user, $email ,$name ,$pass, $id));
                //system update message
                $theMsg = "<div class='alert alert-info text-center'> " . $stmt->rowCount() . " Account updated   </div>";
                redirctHome($theMsg, 'back');
              }

            }

         } else {
           //system update message
           $theMsg = "<h1 class='alert alert-danger text-center'> Error 404 </h1>";
           redirctHome($theMsg, 'back');
         }
         echo "</div>";

       } elseif ($action == 'delete') {   //delete member page
         echo "<h3 class='text-center'> Delete member </h3> ";
         echo "<div class='container'> ";
         // check if the ID value is existed
                   $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
         // select all data depend  on the ID
                    $check = checkItem('userid' , 'users' ,$userid);

                   if ($check > 0) {
                    $stmt = $con->prepare("DELETE from users WHERE userID = :zuser");
                    $stmt->bindParam(":zuser", $userid);
                    $stmt->execute();
                    // system message
                    $theMsg = "<div class='alert alert-danger text-center'> " . $stmt->rowCount() . " Account Has Been Deleted </div>";
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

       } elseif ($action == "Deactivate") {
         echo "<h4 class='text-center'> Deactivated member </h4> ";
         echo "<div class='container'> ";
         // check if the ID value is existed
                   $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
         // select all data depend  on the ID
                    $check = checkItem('userid' , 'users' ,$userid);

                   if ($check > 0) {
                    $stmt = $con->prepare("UPDATE users SET reg_status = 0 WHERE userID = ?");
                    $stmt->execute(array($userid));
                    // system message
                    $theMsg = "<div class='alert alert-success text-center'> " . $stmt->rowCount() . " Account Has Been Deactivated </div>";
                    redirctHome($theMsg, 'back');
                   } else {
                     echo "This ID doesn't exist";
                   }
                   echo "</div>";
                  // end of the Deactivate page
       }

         include "includes/templates/footer.php";
     } else {
       // code...
       header('location: index.php');
       exit();
     };
