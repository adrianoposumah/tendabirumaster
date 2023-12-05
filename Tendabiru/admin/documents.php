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
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="row chat-body mb-4 mt-3 pt-5 pb-5">
                            <div class="col-xl-3 col-lg-6">
                            <div class="mb-4 mb-xl-0">
                                <div class="bubble-text">
                                <span class="name">Laporan Penggunaan Stok Bulanan</span>
                                <span class="date">-</span>
                                <div class="message">
                                    <a class="btn btn-success">Download</a>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                            <div class="mb-4 mb-xl-0">
                                
                                <div class="bubble-text">
                                <span class="name">Laporan Daftar Produk
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                </span>
                                <span class="date">-</span>
                                <div class="message">
                                    <a class="btn btn-success">Download                                    
                                    </a>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                            <div class="mb-4 mb-xl-0">
                                
                                <div class="bubble-text">
                                <span class="name">Laporan Pemesanan
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                </span>
                                <span class="date">-</span>
                                <div class="message">
                                    <a class="btn btn-success" href="order_document.php">Download</a>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                            <div class="mb-4 mb-xl-0">
                                
                                <div class="bubble-text">
                                <span class="name">Laporan Nanti Dipikir
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                    ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎‎ ‎ ‎ ‎ ‎ ‎  
                                </span>
                                <span class="date">-</span>
                                <div class="message">
                                    <a class="btn btn-success">Download</a>
                                </div>
                            </div>
                            </div>
                            </div>
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
            height: 140px;
            background-color: #DFF9FF;
            border-radius: 15px;
            padding: 15px;
        }

        .name {
            font-weight: bold;
        }

        .date {
            font-size: 12px;
        }

        .message {
            clear: both;
            margin-top: 10px;
            color: #fff;
            
        }
        .message a {
            margin-top: 10px;
            float:right;
        }
        .chat-body {
            margin-left: 10px;
        }
</style>

</html>