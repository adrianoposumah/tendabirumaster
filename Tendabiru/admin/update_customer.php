<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add supplier
if (isset($_POST['updatesupplier'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["supplier_phoneno"]) || empty($_POST["supplier_name"]) || empty($_POST['supplier_email']) || empty($_POST['supplier_password'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $supplier_name = $_POST['supplier_name'];
    $supplier_phoneno = $_POST['supplier_phoneno'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_password = sha1(md5($_POST['supplier_password'])); //Hash This 
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE suppliers SET supplier_name =?, supplier_phoneno =?, supplier_email =?, supplier_password =? WHERE  supplier_id =?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $supplier_name, $supplier_phoneno, $supplier_email, $supplier_password, $update);
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
    $update = $_GET['update'];
    $ret = "SELECT * FROM  suppliers WHERE supplier_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
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
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>supplier Name</label>
                      <input type="text" name="supplier_name" value="<?php echo $cust->supplier_name; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>supplier Phone Number</label>
                      <input type="text" name="supplier_phoneno" value="<?php echo $cust->supplier_phoneno; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>supplier Email</label>
                      <input type="email" name="supplier_email" value="<?php echo $cust->supplier_email; ?>" class="form-control" value="">
                    </div>
                    <div class="col-md-6">
                      <label>supplier Password</label>
                      <input type="password" name="supplier_password" class="form-control" value="">
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updatesupplier" value="Update supplier" class="btn btn-success" value="">
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
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>