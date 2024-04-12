<?php
require 'DB/db_con.php';

// Fetch count of pending Orders
$query_pending = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'Pending'";
$result_pending = mysqli_query($conn, $query_pending);
$pending_count = mysqli_fetch_assoc($result_pending)['numrows'];

// Fetch count of ToShip Orders
$query_toShip = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'ToShip'";
$result_toShip = mysqli_query($conn, $query_toShip);
$toShip_count = mysqli_fetch_assoc($result_toShip)['numrows'];

// Fetch count of ToReceived Orders
$query_toReceived = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'ToReceived'";
$result_toReceived = mysqli_query($conn, $query_toReceived);
$toReceived_count = mysqli_fetch_assoc($result_toReceived)['numrows'];

// Fetch count of Completed Orders
$query_completed = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'Completed'";
$result_completed = mysqli_query($conn, $query_completed);
$completed_count = mysqli_fetch_assoc($result_completed)['numrows'];

// Output counts for pending, toShip, toReceived, and completed orders
echo json_encode(array(
    'pending' => $pending_count,
    'toShip' => $toShip_count,
    'toReceived' => $toReceived_count,
    'completed' => $completed_count
));
?>
