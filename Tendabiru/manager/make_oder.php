<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['make'])) {
    // Prevent Posting Blank Values
    if (empty($_POST["order_code"]) || empty($_POST["supplier_name"])) {
        $err = "Tidak Menerima Nilai Kosong";
    } else {
        $order_id = $_POST['order_id'];
        $order_code  = $_POST['order_code'];
        $supplier_id = $_POST['supplier_id'];
        $supplier_name = $_POST['supplier_name'];
        $prod_id  = $_GET['prod_id'];
        $prod_name = $_GET['prod_name'];
        $prod_price = 0; // Set a default value

        // Retrieve prod_price from the products table
        $prod_id = $_GET['prod_id'];
        $retrieve_price_query = "SELECT prod_price FROM products WHERE prod_id = ?";
        $retrieve_price_stmt = $mysqli->prepare($retrieve_price_query);
        $retrieve_price_stmt->bind_param('s', $prod_id);
        $retrieve_price_stmt->execute();
        $retrieve_price_stmt->bind_result($prod_price_result);
        $retrieve_price_stmt->fetch();
        $retrieve_price_stmt->close();

        // Use the retrieved value if it exists
        if ($prod_price_result !== null) {
            $prod_price = $prod_price_result;
        }

        $prod_odr_qty = $_POST['prod_odr_qty']; // Updated from prod_qty

        // Insert Captured information to a database table
        $postQuery = "INSERT INTO rpos_orders (prod_odr_qty, order_id, order_code, supplier_id, supplier_name, prod_id, prod_name, prod_price) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);

        // Bind parameters
        $rc = $postStmt->bind_param('ssssssss', $prod_odr_qty, $order_id, $order_code, $supplier_id, $supplier_name, $prod_id, $prod_name, $prod_price);
        $postStmt->execute();

        // Declare a variable which will be passed to the alert function
        if ($postStmt) {
            $success = "Order Submitted" && header("refresh:1; url=payments.php");
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
                            <h3>Please Fill All Fields</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-4">
                                        <label>Supplier Name</label>
                                        <select class="form-control" name="supplier_name" id="custName" onChange="getsupplier(this.value)">
                                            <option value="">Select supplier Name</option>
                                            <?php
                                            // Load All suppliers
                                            $ret = "SELECT * FROM  suppliers ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($cust = $res->fetch_object()) {
                                            ?>
                                                <option><?php echo $cust->supplier_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Supplier ID</label>
                                        <input type="text" name="supplier_id" readonly id="supplierID" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Order Code</label>
                                        <input type="text" name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <?php
                                $prod_id = $_GET['prod_id'];
                                $ret = "SELECT prod_id, prod_code, prod_name, prod_img, prod_desc, prod_price, created_at FROM  products WHERE prod_id = '$prod_id'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Product Price ($)</label>
                                            <input type="text" readonly name="prod_price" value="$ <?php echo $prod->prod_price; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Product Quantity</label>
                                            <input type="text" name="prod_odr_qty" class="form-control" value="">
                                        </div>
                                    </div>
                                <?php } ?>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="make" value="Make Order" class="btn btn-success" value="">
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
