<?php
      session_start();
      if (isset($_SESSION['username'])) {
        // code...
        $pageTitle = 'Dashbored';
        include 'init.php';
        // start Dashboed Page

        //Latest members function
        $latestUsers = 5;
        $theLatestUsers = getLatest("*" , "users" , "userID" , $latestUsers);
        //Latest items function
        $latestItems = 5;
        $theLatestItems = getLatest("*" , "items" , "item_id" , $latestItems);


        ?>
        <div class="container home-stats text-center">
          <h1>Dashbored</h1>
          <div class="row">
            <div class="col-md-3">
              <div class="stat">Total Members <span><a href="members.php"> <?php echo Countitems('userID' , 'users') ?> </a> </span> </div>
            </div>
            <div class="col-md-3">
              <div class="stat">Pending Members <span><a href="members.php?action=manage&page=pending"> <?php echo checkItem('reg_status' , 'users', 0); ?> </a></span> </div>
            </div>
            <div class="col-md-3">
              <div class="stat">Total Items <span><a href="items.php"> <?php echo Countitems('item_id ' , 'items') ?> </a> </span> </div>
            </div>
            <div class="col-md-3">
              <div class="stat">Total Comments <span>  <a href="comments.php"> <?php echo Countitems('c_id ' , 'comments') ?> </a> </span> </div>
            </div>
          </div>
        </div>

        <div class="container latest">
          <div class="row">
            <div class="col-sm-6">
              <div class="panel panel-default">
                <!-- Latest Registerd user Pick -->
                <div class="panel-heading text-center">
                  <i class="fa fa-users col-md-3"></i> Latest <?php echo $latestUsers;  ?>  Registerd Users
                  <span class="toggle-info"> <i class="far fa-minus-square"></i> </span>
                </div>
                <div class="panel-body">
                  <ul class="list-unstyled latest-users">
                  <?php
                foreach ($theLatestUsers as $user) {
                  echo "<li>". $user['fullname'] . '</li>';
                }
                 ?>
               </ul>
               </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="panel panel-default">
                <div class="panel-heading text-center">
                  <i class="fa fa-tag"></i>  Latest <?php echo $latestItems ?>  Items
                  <span class="toggle-info"> <i class="far fa-minus-square"></i> </span>
                </div>
                <div class="panel-body">
                  <ul class="list-unstyled latest-items">
                  <?php
                foreach ($theLatestItems as $item) {
                  echo "<li>". $item['name'] . '</li>';
                }
                 ?>
               </ul>
               </div>
              </div>
            </div>
          </div>
          <!-- Start New Row -->
          <!-- Start comments section -->
          <div class="row padding">
            <div class="col-sm-12">
              <div class="panel panel-default">
                <!-- Latest Registerd user Pick -->
                <div class="panel-heading text-center">
                <i class="fas fa-comments"></i> Latest Comments
                  <span class="toggle-info"> <i class="far fa-minus-square"></i> </span>
                </div>
                <div class="panel-body">
                  <ul class="list-unstyled latest-users">
                    <?php
                    $stmt = $con->prepare("SELECT
                                             comments.* , users.username AS Member
                                          FROM
                                             comments
                                          INNER JOIN
                                             users
                                          ON
                                             users.userID = comments.user_id");
                    $stmt->execute();
                    // assign to variables
                    $rows = $stmt->fetchAll();

                    foreach ($rows as $row ) {
                      echo "<div class='comment-box'>";
                        echo "<h5 class='member-n'>" . $row['Member'] . "</h5>";
                        echo "<p class='member-c'>" . $row['comment'] . "</p>";
                        echo "<h6 class='member-date'> Date : " . $row['comment_date'] . "</h6>" . "<hr>";

                      echo "</div>";
                    }
                     ?>
                  </ul>
               </div>
              </div>
            </div>
          </div>
        </div>

        <?php
        //end Dashbored page
        include "includes/templates/footer.php";
    } else {
      // code...
      header('location: index.php');
      exit();
    };
