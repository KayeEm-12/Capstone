<?php
session_start();
require 'DB/db_con.php';

// var_dump($_POST['selectedItems']);
if(isset($_POST['selectedItems'])) {
    $selectedItems = $_POST['selectedItems'];

    $selectedProducts = array();
    $total = 0;

    foreach ($selectedItems as $itemId) {
        $stmt = $pdo->prepare("SELECT cart.*, products.prod_name, products.discounted_price, products.retail_price, products.photo 
        FROM cart 
        INNER JOIN products ON cart.product_id = products.product_id 
        WHERE cart.cart_id = :cart_id");

        $stmt->execute(['cart_id' => $itemId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $price = ($product['quantity'] <= 2) ? $product['retail_price'] : $product['discounted_price'];

            $subtotal = $price * $product['quantity'];
            $total += $subtotal;

            $product['price'] = $price;
            $product['subtotal'] = $subtotal;

            $selectedProducts[] = $product;
        }
    }
    // Calculate delivery fee based on the total amount
    $deliveryFee = 0;
    if ($total < 2000) {
        $deliveryFee = 50.00; 
    }

    $total += $deliveryFee;
    } else {
        header("Location: cart-view.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}
table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
}
th, td {
    padding: 10px;
    border-bottom: 3px solid red;
    border-top: 3px solid red;
    text-align: Center;
    background-color: #cfcfcf;
}
.navbar{
    display: flex;
    align-items: center;
    padding: 5px;
    /* border: 2px solid black */
}
nav{
    flex: 1;
    text-align: center;
    font-size: 20px;
}
nav ul{
    display: inline-block;
    list-style-type: none;
    
}
nav ul li{
    display: inline-block;
    margin-right: 20px;
    font-size: bold;
}
a{
    text-decoration: none;
    color: #000000;
    font-weight: bold;
}
.form-control {
    width: 20px;
}
img.icon {
    margin: 0 20px;
}
i.fa-solid.fa-user {
    font-size: 28px;
    margin-right: 10px;
    color: black;
}
button {
    background-color: #ff4f00;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    outline: none;
    padding: 10px;
    margin-bottom: 20px;
    margin-top: 10px;
    margin-left: 78%;
    font-weight: bold;
}
button:hover {
    background-color: #036dbd; 
}
footer {
    /* border: 5px solid #000000; */
    width: 100%;
}   
.footer-col-1 img {
    width: 180px;
    bottom: 20px;
}
.footer-col-2{
    text-align: center;
    font-weight: bold;
}
.row {
    display: flex; 
    justify-content: space-evenly;
}
.menu-icon{
    width: 30px;
    margin-left: 20px;
    display: none;
}
/*--media qyuery for menu---*/

@media only screen and (max-width: 800px){
    nav ul{
        position: absolute;
        top: 70px;
        left: 0;
        background: #e4b8b8;
        width: 100%;
        overflow: hidden;
        transition: max-height 0.5s;
    }
    nav ul li{
        display: block;
        margin-right: 50px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    nav ul li a{
        color: #000000;
        font-weight: bold;
    }
    .menu-icon{
        display: block;
        cursor: pointer;
    }
}

/* media query for less than 600 screen size */
@media only screen and (max-width: 600px){
    .row{
        text-align: center;
    }
    .col-2, .col-3, .col-4{
        flex-basis: 100%;
    }
}
</style>
</head>
<div class="navbar">
    <div class="logo">
        <img src="images/Logo.png" width="125">
    </div>
    <nav>
    <ul id="MenuItems">
        <li><a href="http://localhost/E-commerce/customer_dash.php">Home</a></li>
        <li><a href="">Products</a></li>
        <li><a href="">My Orders</a></li>
        <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
    </ul>
    </nav>
    <a href="http://localhost/E-commerce/Account.php">
    <i class="fa-solid fa-user"></i>
    <!-- <img src="images/profile-icon.png" width="30px" height="30px" class="icon"> -->
    </a>
    <img src="images/cart.png" width="30px" height="30px">
    <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
</div>

<body>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($selectedProducts as $product): ?>
            <tr>
                <td><img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" style="max-width: 50px; max-height: 50px;"></td>
                <td><?php echo isset($product['prod_name']) ? $product['prod_name'] : ''; ?></td>
                <td><?php echo isset($product['prod_price']) ? $product['prod_price'] : ''; ?></td>
                <td><?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?></td>
                <td class="subtotal"><?php echo isset($product['subtotal']) ? number_format($product['subtotal'], 2) : ''; ?></td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="4" style="text-align: right;"><strong>Delivery Fee:</strong></td>
                <td><?php echo number_format($deliveryFee, 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td id="total"><?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
<form action="place-order.php" method="POST">
    <button type="submit">Place Order</button>
    <?php foreach ($selectedProducts as $product): ?>
        <input type="hidden" name="selectedItems[]" value="<?php echo $product['product_id']; ?>">
        <input type="hidden" name="selectedQuantities[]" value="<?php echo $product['quantity']; ?>">
        <input type="hidden" name="selectedPrices[]" value="<?php echo isset($price) ? $price : ''; ?>">
        
    <?php endforeach; ?>
</form>
    
    <footer>
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
            <img src="images/logo2.png" width="100px" height="60px">
            </div>
            <div class="footer-col-2">
            <p>&copy; <?php echo date('Y'); ?> 4M Minimart Online Store. All rights reserved.</p>
            </div>
        </div>
    </div>
    </footer>
<script>
    var MenuItems = document.getElementById("MenuItems");
    
    MenuItems.style.maxHeight = "0px";

    function menutoggle() {
        if (MenuItems.style.maxHeight =="0px")
        {
            MenuItems.style.maxHeight = "300px";
        }
        else{
            MenuItems.style.maxHeight = "0px";
        }
    }
</script>
</body>
</html>
