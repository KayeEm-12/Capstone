<?php
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    try {
        $sql = "UPDATE orders SET order_status = :status WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Redirect back to the page where the form was submitted
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
