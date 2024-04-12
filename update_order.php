<?php
require 'DB/db_con.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    try {
        // Update only the particular order's status in the orders_details table
        $sql = "UPDATE orders_details SET order_status = :new_status WHERE order_id = :order_id AND product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':new_status', $new_status);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $_POST['product_id']); 
        $stmt->execute();

        // Redirect back to the page where the order was viewed
        header("Location: staff_view_order.php?order_id=$order_id");
        exit();
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // Redirect back to the page if accessed directly without POST request
    header("Location: index.php");
    exit();
}
?>
