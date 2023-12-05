<?php
$admin_id = $_SESSION['admin_id'];
//$login_id = $_SESSION['login_id'];
$ret = "SELECT * FROM  admin  WHERE admin_id = '$admin_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($admin = $res->fetch_object()) {

?>
<?php
$currentFile = $_SERVER['REQUEST_URI'];
$isDashboard = (strpos($currentFile, 'dashboard.php') !== false);
$isProducts = (strpos($currentFile, 'products.php') !== false);
$isStaffs = (strpos($currentFile, 'staff.php') !== false);
$isStocks = (strpos($currentFile, 'stocks.php') !== false);
$isSupplier = (strpos($currentFile, 'supplier.php') !== false);
$isOrders = (strpos($currentFile, 'orders.php') !== false);
$isOrdersR = (strpos($currentFile, 'orders_reports.php') !== false);
$isPayments = (strpos($currentFile, 'payments.php') !== false);
$isPaymentR = (strpos($currentFile, 'payments_reports.php') !== false);
$isDaily = (strpos($currentFile, 'daily-usage.php') !== false);
$isNotif = (strpos($currentFile, 'notification.php') !== false);
$isChangeProfile = (strpos($currentFile, 'change_profile.php') !== false);
$isMakeOrder = (strpos($currentFile, 'make_oder.php') !== false);
$isUpdateStock = (strpos($currentFile, 'update_stock.php') !== false);
$isAddProduct = (strpos($currentFile, 'add_product.php') !== false);
$isPayOrder = (strpos($currentFile, 'pay_order.php') !== false);
$isReceipt = (strpos($currentFile, 'receipts.php') !== false);

if ($isDashboard) {
    $pageText = 'Dashboard';
} elseif ($isProducts) {
    $pageText = 'Products';
} elseif ($isStaffs) {
    $pageText = 'Staffs';
} elseif ($isStocks) {
    $pageText = 'Stocks';
} elseif ($isSupplier) {
    $pageText = 'Supplier';
} elseif ($isOrders) {
    $pageText = 'Orders';
} elseif ($isOrdersR) {
    $pageText = 'Orders Reports';
} elseif ($isPaymentR) {
    $pageText = 'Payments Report';
} elseif ($isDaily) {
    $pageText = 'Daily Usage';
} elseif ($isNotif) {
    $pageText = 'Notifications';
} elseif ($isChangeProfile) {
    $pageText = 'Profile';
} elseif ($isPayments) {
    $pageText = 'Payments';
} elseif ($isMakeOrder) {
    $pageText = 'Make Orders';
} elseif ($isUpdateStock) {
    $pageText = 'Take Stock';
} elseif ($isAddProduct) {
    $pageText = 'Add Product';
} elseif ($isPayOrder) {
    $pageText = 'Pay Order';
} elseif ($isReceipt) {
    $pageText = 'Receipts';
}
else {
    $pageText = 'Undefined Page';
}
?>

    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="<?php echo $currentFile; ?>">Pages / <?php echo $pageText; ?></a>
            <!-- Form -->

            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span>
                                <?php
                                if ($admin->admin_img) {
                                echo "<img src='assets/img/$admin->admin_img' height='60' width='60 class='img-thumbnail' style='border-radius: 50%;'>";
                                } else {
                                echo "<img src='assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                                }
                                ?>
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold"><?php echo $admin->admin_name; ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="change_profile.php" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>