<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Cancel Order
require_once('partials/_head.php');
require_once('partials/_analytics.php');
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
        <div  class="header  pb-8 pt-5 pt-md-8">
         
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
                            <h3 class="mb-0">Recent Payments</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Staff</th>
                                        <th scope="col">Produk</th>
                                        <th scope="col">Kuantiti</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  daily_usage ORDER BY `daily_date` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($daily = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $daily->daily_id; ?></th>
                                            <td><?php echo $daily->daily_staff; ?></td>
                                            <td><?php echo $daily->product_name; ?></td>
                                            <td><?php echo $daily->daily_qty; ?></td>
                                            <td>$ <?php echo $daily->daily_date; ?></td>
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

</html>