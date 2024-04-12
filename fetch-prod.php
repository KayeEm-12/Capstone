<?php
require 'DB/db_con.php';

if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];

    if ($selectedCategory == '0') {
        $query = $pdo->prepare("SELECT product_id, prod_name, discounted_price, retail_price, photo, stock FROM products");
        $query->execute();
    } else {
        $query = $pdo->prepare("SELECT product_id, prod_name, discounted_price, retail_price, photo, stock FROM products WHERE category_id = ?");
        $query->execute([$selectedCategory]);
    }

    $products = $query->fetchAll(PDO::FETCH_ASSOC);


    foreach ($products as $product) {
        echo '<div class="product-item">';
        echo '<img src="images/upload/' . $product['photo'] . '" alt="Product Photo" class="prod-img">';
        echo '<h3 style="text-align: center;">' . $product['prod_name'] . '</h3>';
        echo '<p>Dsicounted Price: ₱' . number_format($product['discounted_price'], 2) . '</p>';
        echo '<p>Retail Price: ₱' . number_format($product['retail_price'], 2) . '</p>';
        echo '<p>Stock: ' . number_format($product['stock']) . '</p>';
        echo '<button type="button" onclick="addToCart(' . $product['product_id'] . ')"><i class="fa fa-cart-arrow-down"></i> Add To Cart</button>';
        echo '<a href="product_details.php?id=' . $product['product_id'] . '" class="details"><i class="fa fa-eye"></i> Details</a>';
        echo '</div>';
    }
}
?>
