
<?php
// session_start();

require 'DB/db_con.php';
require 'count-cart.php';

//echo "SELECT * FROM orders WHERE user_id = ".$_SESSION['user_id'];

if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $query = $pdo->prepare("SELECT product_id, prod_name, prod_price, photo, stock 
                            FROM products WHERE category_id = ?");
    $query->execute([$cart_id]);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
}
$total = $pdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];

if (isset($_GET['status'])) {
    $status = $_GET['status'];
   
    if ($status === "to_ship") {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status IN ('To Ship')");
        $stmt->execute([$_SESSION['user_id']]);
    } else if ($status === "to_receive") {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status IN ('To Receive')");
        $stmt->execute([$_SESSION['user_id']]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status = ?");
        $stmt->execute([$_SESSION['user_id'], $status]);
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
    <!-- <style>
        .order-wrapper{
            min-height: calc(100% - 255px);
            .order-container{
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin: 0 3rem;
                min-height: calc(100vh - 239px);
                .profile-container{
                    width: 250px; 
                    padding-top: 5rem;
                    .profile{
                        display: flex;
                        align-items: center;
                        flex-direction: column;
                        img {
                            width: 100px; 
                            height: auto;
                        }
                    }
                    .username {
                        font-weight: bold;
                        margin-bottom: 5px; 
                    }
                    .logout {
                        text-align: center; 
                        a {
                            text-decoration: none;
                            color: #000000;
                            font-weight: bold;
                        }
                        a:hover {
                            color: red;
                        }
                    }
                }
                .account{
                    display: flex;
                    flex-direction: column;
                    margin-top: 1rem;
                    margin-left: 3rem;
                    .dropdown{
                        margin-bottom: 10px;
                        position: relative;
                        img{
                            width: 20px; 
                            margin-right: 5px;
                        }
                        .dropdown-content{
                            display: none; 
                            /* border: 1px solid #ccc; */
                            border-radius: 5px;
                            padding: 10px;
                            margin-left: 25px;
                            a{
                                color: black; 
                                text-decoration: none; 
                                padding: 5px 0; 
                                &:hover {
                                    color: red; 
                                }
                            }
                        }
                        &:hover .dropdown-content {
                            display: block;
                            color: red; 
                        }
                    }
                }
                .order-details{
                    flex: 1;
                    .stats{
                        .status{
                            flex: 1;
                            text-align: center;
                            font-size: 20px;
                            margin-bottom: 1rem;
                            margin-top: 1rem;
                            a{
                                text-decoration: none;
                                color: black; 
                                font-weight: bold;
                                
                            }
                            a:hover{
                                color: red; 
                            }
                            a.active{
                                color: red; 
                            }
                        }                
                    }
                    
                    .order{
                        border: 1px solid #ccc;
                        margin-bottom: 10px;
                        padding: 50px;
                        border: 2px solid gray;
                        box-shadow: #555;
                        .order-item {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 10px;
                            img {
                                width: 100px;
                                margin-right: 10px;
                            }
                            .product-details {
                                display: flex;
                                .product-name {
                                    font-weight: bold;
                                }
                                
                            }
                            .subtotal {
                                margin-left: auto; 
                                font-weight: bold;
                            } 
                        }
                        .delivery-fee {
                            display: flex;
                            justify-content: flex-end;
                            align-items: center;
                            margin-top: 20px;
                            font-weight: bold;
                        }
                        .total-price {
                            display: flex;
                            justify-content: flex-end; 
                            align-items: center;
                            margin-top: 20px;
                            font-weight: bold;
                        }
                    }
                }
            }

        }
    </style> -->
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/customer_dash.php">
                <img src="images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
            <ul>
                <li><a href="customer_dash.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
                <form method="post" action="search.php" class= "search">
                    <input type="search" class="form-control" name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" placeholder="Search here..." required=""/>
                    <button type="submit" class="btn btn-success" name="search">Search</button>
            </form>
                <!-- <form class="search" method="GET" action="">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
                    <button type="submit">Search</button>
                </form> -->
            </ul>
        </nav>
        <div class="setting-sec">
            <!-- <a href="http://localhost/E-commerce/Account.php">
            <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
            </a> -->   
            <div class="cart-sec">
                <a href="http://localhost/E-commerce/cart-view.php">
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                    <img src="images/cart.png" width="30px" height="30px">
                </a>
            </div>
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
    <!-- Navigation for order status -->
    <div class="order-wrapper">   
        <div class="order-container">
            <div class="profile-container">
                <?php
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                    if (!empty($username)) {
                        echo '<div class="profile">';
                        echo '<img src="images/account.png" alt="User Photo">';
                        echo '<div class="username">' . $username . '</div>';
                        echo '<div class="logout"><a href="login_form.php">Logout</a></div>';
                        echo '</div>';
                    }
                ?>
                <div class="account">
                    <div class="dropdown">
                        <img src="images/account.png" alt="Account Icon">
                        <span>My Account</span>
                        <div class="dropdown-content">
                            <a href="Account.php"><i class="fa fa-pencil"></i> Edit Profile</a></br>
                            <!-- <a href="Account.php">Profile</a></br> -->
                            <a href="address"><i class="fa-solid fa-location-dot"></i>  Addresses</a></br>
                            <a href="change-pass.php"><i class="fa fa-edit"></i>Change Password</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <img src="images/purchase.png" alt="Purchase Icon">
                        <span>My Purchase</span>
                        <div class="dropdown-content">
                            <a href="my_orders.php">My Orders</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-details">
                <div class="stats">
                    <div class="status">
                    <a class="<?php echo ($status == 'pending') ? 'active' : ''; ?>" href="my_orders.php?status=pending">Pending</a> |
                    <a class="<?php echo ($status == 'toship') ? 'active' : ''; ?>" href="my_orders.php?status=toship">To Ship</a> |
                    <a class="<?php echo ($status == 'toreceive') ? 'active' : ''; ?>" href="my_orders.php?status=toreceive">To Receive</a> |
                    <a class="<?php echo ($status == 'completed') ? 'active' : ''; ?>" href="my_orders.php?status=completed">Completed</a>

                    </div>

                </div>
                <?php if (empty($orders)) : ?>
                        <div> <p style="display: flex; justify-content: center;  margin-top: 20px; font-weight: bold;">No orders found for the selected status.</p></div>
                <?php else : ?>
                <?php
                    foreach ($orders as $order) {
                        echo '<div class="order">';
                        echo "Date Ordered: " . $order['date_ordered'] . "<br>";

                        $stmt = $pdo->prepare("SELECT orders_details.*, products.prod_name, products.photo 
                                                FROM orders_details 
                                                JOIN products
                                                ON orders_details.product_id = products.product_id 
                                                WHERE orders_details.order_id = ?");
                        $stmt->execute([$order['order_id']]);
                        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Calculate the total price of the order
                        $totalPrice = 0;
                        foreach ($orderDetails as $detail) {
                            $totalPrice += $detail['quantity'] * $detail['price'];
                        }

                        // Calculate delivery fee for this order
                        $deliveryFee = 0;
                        if ($order['delivery_option'] === 'delivery' && $totalPrice < 2000) {
                            $deliveryFee = 50.00;
                        }

                        // Calculate the total price including delivery fee for this order
                        $totalPrice += $deliveryFee;


                        foreach ($orderDetails as $detail) {
                            echo '<div class="order-item">';
                            echo '<img src="images/upload/' . $detail['photo'] . '" alt="Product Photo">';
                            echo '<div class="product-details">';
                            echo '<div class="product-name">' . $detail['prod_name'] . ' <br> Qty: ' . $detail['quantity'] . '</div>';
                            echo '<div class="product-price">Price:  ₱' . $detail['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="subtotal"> ₱' . ($detail['quantity'] * $detail['price']) . '</div>';
                            echo '</div>';
                        }
                        // Display delivery fee
                        echo '<div class="delivery-fee" >Delivery Fee: ₱' . number_format($deliveryFee, 2) . '</div>';
                        echo '<div class="total-price">Total:  ₱' . number_format($totalPrice, 2) . '</div>'; 
                        
                        if ($order['order_status'] === "To Receive") {
                            echo '<form action="order_received.php" method="post">';
                            echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
                            echo '<button type="submit" name="order_received">Order Received</button>';
                            echo '</form>';
                        }
                        echo '</div>'; 
                        
                        // echo "<hr>"; // Add a horizontal rule between orders
                    }
                ?>
            </div>
        </div>
        <?php endif; ?>     
    </div>
    </div>
    
    <!--footer-->

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
        var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
        // MenuItems.style.maxHeight = "0px";
        // function menutoggle() {
        //     if (MenuItems.style.maxHeight === "0px") {
        //         MenuItems.style.maxHeight = "200px";
        //     } else {
        //         MenuItems.style.maxHeight = "0px";
        //     }
        // }
        
    </script>
</body>
</html>