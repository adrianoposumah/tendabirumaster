<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

// Initialize $total
$total = 0;

if (isset($_POST['pay'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $pay_code = $_POST['pay_code'];
        $order_code = $_GET['order_code'];
        $supplier_id = $_GET['supplier_id'];
        $pay_amt  = $_POST['pay_amt'];
        $pay_method = $_POST['pay_method'];
        $pay_id = $_POST['pay_id'];

        $order_status = $_GET['order_status'];

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, supplier_id, pay_amt, pay_method) VALUES(?,?,?,?,?,?)";
        $upQry = "UPDATE rpos_orders SET order_status =? WHERE order_code =?";

        $postStmt = $mysqli->prepare($postQuery);
        $upStmt = $mysqli->prepare($upQry);

        //bind parameters
        $rc = $postStmt->bind_param('ssssss', $pay_id, $pay_code, $order_code, $supplier_id, $pay_amt, $pay_method);
        $rc = $upStmt->bind_param('ss', $order_status, $order_code);

        $postStmt->execute();
        $upStmt->execute();

        // Fetch the order details
        $gettotal = "SELECT * FROM  rpos_orders WHERE order_code ='$order_code' ";
        $stmt = $mysqli->prepare($gettotal);
        $stmt->execute();
        $res = $stmt->get_result();

        // Check if there are results before entering the loop
        if ($res->num_rows > 0) {
            while ($order = $res->fetch_object()) {
                // Calculate total within the loop
                $total += $order->prod_price * $order->prod_odr_qty;

                // Update the prod_qty in the products table
                $updateProdQtyQuery = "UPDATE products SET prod_qty = prod_qty + ? WHERE prod_id = ?";
                $updateProdQtyStmt = $mysqli->prepare($updateProdQtyQuery);

                // Assuming $order->prod_id is the unique identifier for the product
                $prod_id = $order->prod_id;
                $prod_odr_qty = $order->prod_odr_qty;

                // Check if $prod_id and $prod_odr_qty are not null before proceeding
                if ($prod_id !== null && $prod_odr_qty !== null) {
                    // Bind parameters
                    $updateProdQtyStmt->bind_param('ss', $prod_odr_qty, $prod_id);
                    $updateProdQtyStmt->execute();

                    // Check if the query was successful
                    if ($updateProdQtyStmt->affected_rows > 0) {
                        $success = "Paid, and product quantity updated";
                    } else {
                        $err = "Paid, but failed to update product quantity";
                    }
                } else {
                    $err = "Paid, but failed to retrieve valid product details";
                }

                // Close the statement
                $updateProdQtyStmt->close();
            }

            header("refresh:1; url=receipts.php");
        } else {
            $err = "No order details found";
        }
    }
}

$getordercode = $_GET['order_code'];
$gettotal = "SELECT * FROM  rpos_orders WHERE order_code ='$getordercode' ";
$stmt = $mysqli->prepare($gettotal);
$stmt->execute();
$res = $stmt->get_result();

// Check if there are results before entering the loop
if ($res->num_rows > 0) {
    while ($order = $res->fetch_object()) {
        // Calculate total within the loop
        $total += $order->prod_price * $order->prod_odr_qty;
    }
} else {
    $err = "No order details found";
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
        <div class="header pb-8 pt-5 pt-md-8">
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
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Payment ID</label>
                                        <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Payment Code</label>
                                        <input type="text" name="pay_code" value="<?php echo $mpesaCode; ?>"
                                            class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Amount ($)</label>
                                        <input type="text" name="pay_amt" readonly value="<?php echo $total; ?>"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Payment Method</label>
                                        <select class="form-control" name="pay_method">
                                            <option selected>Cash</option>
                                            <option>Paypal</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="pay" value="Pay Order" class="btn btn-success"
                                            value="">
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
