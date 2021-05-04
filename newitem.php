  <?php
  session_start();
  $pageTitle = 'Create New Item';

  include "init.php"; // import files
  if (isset($_SESSION['user'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST")  {

      $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
      $country    = filter_var($_POST['country_made'], FILTER_SANITIZE_STRING);
      $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
      $Category   = filter_var($_POST['Category'], FILTER_SANITIZE_NUMBER_INT);

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
              'zcate'     => $Category,
              'zmember'   => $_SESSION['uid']

            ));
             //system update message
             echo "<div class='container alert alert-success'>item added</div>";
    }

  ?>
  <h1 class="text-center">Create New Item</h1>
  <div class="information">
    <div class="container">
      <div class="card">
        <ul class="list-group list-group-flush">
          <li class="list-group-item main">Create New item</li>
          <li class="list-group-item">
            <div class="row">
              <div class="col-md-8">
                <!-- //add item to the page -->
                <h2 class="text-center padding">Add New item</h2>
                <div class="container Category-section">
                 <form class="form-horizontal" action=" <?php echo $_SERVER['PHP_SELF'] ?> " method='POST'>
                   <!-- Name filed -->
                     <div class="form-group row padding">
                      <label class="col-sm-2 control-label">Name</label>
                       <div class="col-sm-10 col-md-9">
                         <input data-class='.live-name' type="text" name="name" class="form-control live" autocomplete="off" required='required' placeholder="Item name">
                       </div>
                    </div>
                    <!-- Description filed -->
                      <div class="form-group row padding">
                       <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-9">
                          <input data-class='.live-desc' type="text" name="description" class="form-control live" autocomplete="off" required='required' placeholder="Description">
                        </div>
                     </div>
                     <!-- price filed -->
                       <div class="form-group row padding">
                        <label class="col-sm-2 control-label">Price</label>
                         <div class="col-sm-10 col-md-9">
                           <input data-class='.live-price' type="text" name="price" class="form-control live" autocomplete="off" required='required' placeholder="Price">
                         </div>
                      </div>
                      <!-- country made filed -->
                        <div class="form-group row padding">
                         <label class="col-sm-2 control-label">Country</label>
                          <div class="col-sm-10 col-md-9">
                            <input type="text" name="country_made" class="form-control" autocomplete="off" required='required' placeholder="Item Country made">
                          </div>
                       </div>
                       <div class="form-group row padding">
                         <label class="col-sm-2 control-label">Status</label>
                         <div class="col-sm-10 col-md-9">
                           <select name="status" class="form-select" aria-label="Default select example">
                             <option value="0" selected>Open this to select item status</option>
                             <option value="1">New</option>
                             <option value="2">Like New</option>
                             <option value="3">Used</option>
                             <option value="4">Old</option>
                           </select>
                         </div>
                       </div>
                       <!-- Category selection  -->
                       <div class="form-group row padding">
                        <label class="col-sm-2 control-label">Category</label>
                         <div class="col-sm-10 col-md-9">
                           <select name="Category"  class="form-select" aria-label="Default select example">
                             <option value="0">Open this to select Category</option>
                             <?php
                             $stmt2 = $con->prepare("SELECT * FROM categories");
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
            </div>
              <div class="col-md-4">
                 <div class='thumbnail-profile live-preview'>
                   <span class='price-tag-profile'>$<span class="live-price">Price</span></span>
                   <img src='https://cdn.iconscout.com/icon/premium/png-256-thumb/new-product-1801175-1529389.png' alt ='' />
                   <div class='caption'>
                     <h3 class='item-name live-name'>Item Name </h3>
                     <p class='item-description live-desc'>Description</p>
                   </div>
                 </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
          </li>
        </ul>
      </div>
    </div>

  <?php } else {
    header('location: login.php');
    exit();
  }
   ?>

  <?php
  include "includes/templates/footer.php";
