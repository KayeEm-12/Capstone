<?php

session_start();

include 'DB/db_con.php';

$output = array();

try {
    if (isset($_SESSION['user_id']) && strcasecmp($_SESSION['role'], 'customer') === 0) {
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT cart.*, products.prod_name, products.discounted_price, products.retail_price, products.photo FROM cart
        INNER JOIN products ON cart.product_id = products.product_id
        WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        

        $output = $cartItems;
    } else {
        $output['error'] = true;
        $output['message'] = 'Invalid request - Role not set or not customer';
    }
} catch (PDOException $e) {
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

echo json_encode($output);
?>
