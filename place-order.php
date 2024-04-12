
<?php
session_start();
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selectedItems']) && !empty($_POST['selectedItems'])) {
        $selectedItems = $_POST['selectedItems'];
        $selectedQuantities = $_POST['selectedQuantities'];
        $selectedPrices = $_POST['selectedPrices'];

        $userId = $_SESSION['user_id'];
     
        $stmt = $pdo->prepare("SELECT address_id FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $address = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$address) {
            header("Location: add-address.php");
            exit();
        }

        $addressId = $address['address_id'];

        $pdo->beginTransaction();

        try {
            $dateOrdered = date("Y-m-d H:i:s");
            $order_status = 'Pending';
            $stmt = $pdo->prepare("INSERT INTO orders (date_ordered, order_status, user_id, address_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$dateOrdered, $order_status, $userId, $addressId]);
            $orderId = $pdo->lastInsertId();
        
            $totalPrice = 0;
            foreach ($selectedItems as $index => $itemId) {
                $stmt = $pdo->prepare("SELECT discounted_price, retail_price, stock FROM products WHERE product_id = ?");
                $stmt->execute([$itemId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($product) {
                     // price based on qty
                    $price = ($selectedQuantities[$index] <= 2) ? $product['retail_price'] : $product['discounted_price'];

                    // Fetch the quantity of the item
                    $quantity = $selectedQuantities[$index];
                    
                    // Calculate the subtotal 
                    $subtotal = $price * $quantity;
                    
                    $totalPrice += $subtotal;
            
                    $stmt = $pdo->prepare("INSERT INTO orders_details (quantity, price, order_id, product_id) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$quantity, $price, $orderId, $itemId]);
                    
                    // Update stock
                    $newStock = $product['stock'] - $quantity;
                    $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
                    $stmt->execute([$newStock, $itemId]);
                    
                    // Remove item from the cart
                    $stmt = $pdo->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
                    $stmt->execute([$itemId, $userId]);
                } else {
                    throw new Exception("Product details not found for product ID: $itemId");
                }
            }
            if (array_sum($selectedQuantities) <= 2) {
                $deliveryFee = 50.00; 
                $totalPrice += $deliveryFee;
            }
            $stmt = $pdo->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
            $stmt->execute([$totalPrice, $orderId]);
            
            $pdo->commit();
        
            $_SESSION['success_message'] = "Your order was successfully placed!";
            
            header("Location: my_orders.php");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "An error occurred: " . $e->getMessage() . "<br>";
        }        

    } else {
        header("Location: cart-view.php");
        exit();
    }
} else {
    header("Location: cart-view.php");
    exit();
}
?>
