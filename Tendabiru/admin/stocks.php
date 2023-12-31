<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $adn = "DELETE FROM  products  WHERE  prod_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=products.php");
  } else {
    $err = "Try Again Later";
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
              Kelola Stok Produk
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Kode Produk</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kuantiti</th>
                    <th scope="col">Actions</th>
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
                        <span class="qty-indicator btn" data-prod-qty="<?php echo $prod->prod_qty; ?>">
                          <?php echo $prod->prod_qty; ?>
                        </span>
                      <td>
                        <a href="update_stock.php?update=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                            Ambil Stok
                          </button>
                        </a>
                        <a href="add_notification.php?update=<?php echo $prod->prod_id; ?>">
                          <button class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                            Kirim Pesan
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
      const prodQty = parseInt(indicator.getAttribute("data-prod-qty"));

      if (prodQty >= 61) {
        indicator.classList.add("bg-success"); // green
      } else if (prodQty >= 31) {
        indicator.classList.add("bg-warning"); // yellow
      } else if (prodQty == 0) {
        indicator.classList.add("bg-dark");
      } else {
        indicator.classList.add("bg-danger"); // red
      }
    });
  });
</script>

</html>