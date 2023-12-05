<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add supplier
if (isset($_POST['addsupplier'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["supplier_phoneno"]) || empty($_POST["supplier_name"]) || empty($_POST['supplier_email']) || empty($_POST['supplier_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $supplier_name = $_POST['supplier_name'];
    $supplier_phoneno = $_POST['supplier_phoneno'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_password = $_POST['supplier_password']; //Hash This 
    $supplier_id = $_POST['supplier_id'];

    //Insert Captured information to a database table
    $postQuery = "INSERT INTO suppliers (supplier_id, supplier_name, supplier_phoneno, supplier_email, supplier_password) VALUES(?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $supplier_id, $supplier_name, $supplier_phoneno, $supplier_email, $supplier_password);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "supplier Added" && header("refresh:1; url=supplier.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}

require_once('partials/_head.php');
?>

<body>

  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div class="header  pb-8 pt-5 pt-md-8">
     
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>Tambahkan Supplier Baru</h3>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control">
                    <input type="hidden" name="supplier_id" value="<?php echo $cus_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Supplier Phone Number</label>
                    <input type="text" name="supplier_phoneno" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Supplier Email</label>
                    <input type="email" name="supplier_email" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Supplier Password</label>
                    <input type="password" name="supplier_password" class="form-control" value="">
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addsupplier" value="Add Supplier" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>