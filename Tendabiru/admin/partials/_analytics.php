<?php
//1. suppliers
$query = "SELECT COUNT(*) FROM `suppliers` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($suppliers);
$stmt->fetch();
$stmt->close();

//2. Orders
$query = "SELECT COUNT(*) FROM `rpos_orders` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Products
$query = "SELECT COUNT(*) FROM `products` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($products);
$stmt->fetch();
$stmt->close();

//4.Sales
$query = "SELECT SUM(prod_qty) FROM `products` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();

//5.Daily Usage
$query = "SELECT SUM(daily_qty) FROM `daily_usage` WHERE DATE(daily_date) = CURDATE()";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($dailyqty);
$stmt->fetch();
$stmt->close();

//6.Weekly Stock Out
$query = "SELECT SUM(daily_qty) FROM `daily_usage` WHERE daily_date >= CURDATE() - INTERVAL 7 DAY AND daily_date <= CURDATE()";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($weeklyout);
$stmt->fetch();
$stmt->close();

//5.Weekly Stock In
$query = "SELECT SUM(prod_odr_qty) FROM `rpos_orders` WHERE created_at >= CURDATE() - INTERVAL 7 DAY AND created_at <= CURDATE()";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($weeklyin);
$stmt->fetch();
$stmt->close();
