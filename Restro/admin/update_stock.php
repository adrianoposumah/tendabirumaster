<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateProduct'])) {
  // Prevent Posting Blank Values
  if (empty($_POST["prod_qty"])) {
    $err = "Blank Values Not Accepted";
  } else {
    $update = $_GET['update'];

    // Fetch the product details
    $ret = "SELECT * FROM  products WHERE prod_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $update);
    $stmt->execute();
    $res = $stmt->get_result();
    
    // Check if product details are fetched successfully
    if ($res && $prod = $res->fetch_object()) {
      // Calculate the new prod_qty based on the difference
      $userInput = $_POST['prod_qty'];
      $newProdPrice = max(0, $prod->prod_qty - $userInput); // Ensure the new value is non-negative

      // Insert Captured information to a database table
      $postQuery = "UPDATE products SET prod_qty = ? WHERE prod_id = ?";
      $postStmt = $mysqli->prepare($postQuery);

      // Bind parameters
      $rc = $postStmt->bind_param('ss', $newProdPrice, $update);

      // Execute the query
      $postStmt->execute();

      // Declare a variable which will be passed to alert function
      if ($postStmt) {
        $success = "Product Updated" && header("refresh:1; url=stocks.php");
      } else {
        $err = "Please Try Again Or Try Later";
      }
    } else {
      // Handle the case where product details are not fetched
      $err = "Error fetching product details";
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
    $ret = "SELECT * FROM  products WHERE prod_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
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
                <h3>Kelola Stok <?php echo $prod->prod_name; ?></h3>
                <h3 class="btn btn-success">Total Stok : <?php echo $prod->prod_qty; ?></h3>
              </div>
              <hr>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  
                  
                  <div class="form-row">              
                    <div class="col-md-6">
                      <label for="customRange3">Total Stok yang akan diambil : <span class="sliderValue">1</span></label>
                      <div class="rangeCustom">
                        
                          <div class="rangefield">
                            <div class="value left">1</div>
                            <input type="range" name="prod_qty" class="custom-range" min="1" max="<?php echo $prod->prod_qty; ?>" value="1"step="1">
                            <div class="value right"><?php echo $prod->prod_qty; ?></div>  
                          </div>
                      </div>
                    </div>
                  </div>
                
                 
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateProduct" value="Update Produk" class="btn btn-success" value="">
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
<style>
  .rangeCustom {
    /* display: flex; */
    align-items: center;
    justify-content: center;
  }

  .rangefield {
    display: flex;
  }

  .rangeCustom .rangefield .value{
    /* position:absolute; */
    font-size: 18px;
    font-weight: 600;
    color: #20809d;
  }

  .rangeCustom .rangefield .value.left{
  padding-right: 10px;
  }
  .rangeCustom .rangefield .value.right{
  padding-left: 10px;
  }
  .sliderValue {
    background: #20809d;
    padding: 0 10px;
    color: #fff;
    font-weight: 600;
    border-radius: 4px;
  }
  
</style>
<script>
  const slideValue =document.querySelector(".sliderValue");
  const inputSlider =document.querySelector(".custom-range");
  inputSlider.addEventListener("input", () => {
    let value = inputSlider.value;
    slideValue.textContent = value;
  })

</script>
</html>