<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

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
              Select On Any Product To Make An Order
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>Gambar</b></th>
                    <th scope="col"><b>Kode Produk</b></th>
                    <th scope="col"><b>Nama</b></th>
                    <th scope="col"><b>Kuantiti</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  products ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        if ($prod->prod_img) {
                          echo "<img src='assets/img/products/$prod->prod_img' height='60' width='60 class='img-thumbnail'>";
                        } else {
                          echo "<img src='assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                        }

                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td>
                        <span class="qty-indicator btn" data-prod-price="<?php echo $prod->prod_qty; ?>">
                          <?php echo $prod->prod_qty; ?>
                        </span>
                    
                      <td>
                        <a href="make_oder.php?prod_id=<?php echo $prod->prod_id; ?>&prod_name=<?php echo $prod->prod_name; ?>&prod_qty=<?php echo $prod->prod_qty; ?>">
                          <button class="btn btn-sm btn-warning">
                            <i class="fas fa-cart-plus"></i>
                            Place Order
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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
<style>
  .qty-indicator {
   
    padding: 4px 0px;
    width: 50px;
    color: #fff;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const qtyIndicators = document.querySelectorAll(".qty-indicator");

    qtyIndicators.forEach(function (indicator) {
      const prodPrice = parseInt(indicator.getAttribute("data-prod-price"));

      if (prodPrice >= 61) {
        indicator.classList.add("bg-success"); // green
      } else if (prodPrice >= 31) {
        indicator.classList.add("bg-warning"); // yellow
      } else if (prodPrice == 0) {
        indicator.classList.add("bg-dark");
      } else {
        indicator.classList.add("bg-danger"); // red
      }
    });
  });
</script>

</html>