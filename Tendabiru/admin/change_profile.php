<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Update Profile
if (isset($_POST['ChangeProfile'])) {
    $admin_id = $_SESSION['admin_id'];
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $Qry = "UPDATE admin SET admin_name =?, admin_email =? WHERE admin_id =?";
    $postStmt = $mysqli->prepare($Qry);
    
    // Bind parameters
    $postStmt->bind_param('sss', $admin_name, $admin_email, $admin_id);
    
    // Execute the query
    $postStmt->execute();

    // Check if the query was successful
    if ($postStmt->affected_rows > 0) {
        $success = "Account Updated";
        header("refresh:1; url=dashboard.php");
    } else {
        $err = "No changes made or an error occurred";
    }

    // Close the statement
    $postStmt->close();
}

// Change Password
if (isset($_POST['changePassword'])) {
    $admin_id = $_SESSION['admin_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Retrieve current password from the database
    $sql = "SELECT admin_password FROM admin WHERE admin_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $admin_id);
    $stmt->execute();
    $stmt->bind_result($current_password);
    $stmt->fetch();
    $stmt->close();

    if ($old_password != $current_password) {
        $err = "Please Enter Correct Old Password";
    } elseif ($new_password != $confirm_password) {
        $err = "Confirmation Password Does Not Match";
    } else {
        // Update the password
        $update_password = "UPDATE admin SET admin_password = ? WHERE admin_id = ?";
        $stmt = $mysqli->prepare($update_password);
        $stmt->bind_param('ss', $new_password, $admin_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = "Password Changed";
            header("refresh:1; url=dashboard.php");
        } else {
            $err = "Failed to change password. Please try again later.";
        }

        // Close the statement
        $stmt->close();
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
    $admin_id = $_SESSION['admin_id'];
    //$login_id = $_SESSION['login_id'];
    $ret = "SELECT * FROM  admin  WHERE admin_id = '$admin_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center">
        <!-- Mask -->
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10">
              <h1 class="display-2 text-white">Hello <?php echo $admin->admin_name; ?></h1>
              <p class="text-white mt-0 mb-5">...</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <?php
                                if ($admin->admin_img) {
                                echo "<img src='assets/img/$admin->admin_img' class='img-thumbnail' style='border-radius: 50%;'>";
                                } else {
                                echo "<img src='assets/img/products/default.jpg' class='img-thumbnail'>";
                                }
                                ?>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                <div class="d-flex justify-content-between">
                </div>
              </div>
              <div class="card-body pt-0 pt-md-4">
                <div class="row">
                  <div class="col">
                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                      <div>
                      </div>
                      <div>
                      </div>
                      <div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <h3>
                    <?php echo $admin->admin_name; ?></span>
                  </h3>
                  <div class="h5 font-weight-300">
                    <i class="ni location_pin mr-2"></i><?php echo $admin->admin_email; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">My account</h3>
                  </div>
                  <div class="col-4 text-right">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form method="post">
                  <h6 class="heading-small text-muted mb-4">User information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="admin_name" value="<?php echo $admin->admin_name; ?>" id="input-username" class="form-control form-control-alternative" ">
                      </div>
                    </div>
                    <div class=" col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">Email address</label>
                            <input type="email" id="input-email" value="<?php echo $admin->admin_email; ?>" name="admin_email" class="form-control form-control-alternative">
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <input type="submit" id="input-email" name="ChangeProfile" class="btn btn-success form-control-alternative" value="Submit"">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <hr>
                  <form method =" post">
                    <h6 class="heading-small text-muted mb-4">Change Password</h6>
                    <div class="pl-lg-4">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label" for="input-username">Old Password</label>
                            <input type="password" name="old_password" id="input-username" class="form-control form-control-alternative">
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">New Password</label>
                            <input type="password" name="new_password" class="form-control form-control-alternative">
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control form-control-alternative">
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <input type="submit" id="input-email" name="changePassword" class="btn btn-success form-control-alternative" value="Change Password">
                          </div>
                        </div>
                      </div>
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
  require_once('partials/_sidebar.php');
  ?>
</body>

</html>