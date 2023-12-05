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
                            <a href="orders.php" class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> <i class="fas fa-utensils"></i>
                                Make A New Order
                            </a>
                        </div>
                        <div class="row chat-body mb-4">
                                <?php
                                            $ret = "SELECT * FROM  notification ORDER BY `notification_date` DESC  ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($notification = $res->fetch_object()) {
                                            ?>
                                    <div class="col-xl-3 col-lg-6">
                                    <div class="mb-4 mb-xl-0">
                                        <h4><?php echo $notification->product_name; ?></h4>
                                        <div class="bubble-text">
                                        <span class="name"><?php echo $notification->name; ?></span>
                                        <span class="date"><?php echo $notification->notification_date; ?></span>
                                        <div class="message">
                                            <?php echo $notification->message; ?>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <?php } ?>
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
        .bubble-text {
            max-width: 300px;
            background-color: #DFF9FF;
            border-radius: 15px;
            padding: 15px;
        }

        .name {
            font-weight: bold;
        }

        .date {
            float: right;
            font-size: 12px;
        }

        .message {
            clear: both;
            margin-top: 10px;
        }
        .chat-body {
            margin-left: 10px;
        }
</style>

</html>