<?php
require 'DB/db_con.php';
session_start();

// Fetch orders based on order ID if provided
if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $sql = "SELECT *
        FROM orders
        INNER JOIN orders_details ON orders.order_id = orders_details.order_id
        INNER JOIN products ON orders_details.product_id = products.product_id
        INNER JOIN users ON orders.user_id = users.user_id
        WHERE orders.order_id = :order_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
// Fetch orders based on status if provided
elseif(isset($_GET['status'])) {
    $status = $_GET['status'];
    try {
        $sql = "SELECT *
        FROM orders
        INNER JOIN orders_details ON orders.order_id = orders_details.order_id
        INNER JOIN products ON orders_details.product_id = products.product_id
        INNER JOIN users ON orders.user_id = users.user_id
        WHERE orders_details.order_status = :status";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
<style>
    body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.navbar{
    display: flex;
    align-items: center;
    padding: 5px;
    border: 5px solid red;
}
nav{
    flex: 1;
    text-align: center;
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
.status {
    flex: 1;
    text-align: center;
    font-size: 20px;
}
.status a {
    text-decoration: none;
    color: black; 
}
.status a:hover {
    color: red; 
}
table {
    width: 90%;
    border-collapse: collapse;
    margin: auto;
    display: flex;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 30px;
}
th, td {
    border: 1px solid #767575;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #9f7b7b;
    color: Black;
    text-align: center;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}
tr:hover {
    background-color: #ddd;
}
button {
    background-color: #f05d5d;
    color: #080808;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}
.footer {
    border: 5px solid #000000;
    margin-top: auto;
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
    margin-top: 10px;
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
.btn-close {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        margin-left: 206px;
    }
    .btn-close:hover {
        background-color: crimson;
    }
    .btn-close {
        background-color: #e4b8b8;
        padding: 2px 10px;
    }
</style>
</head>
<body>
<div class="header">
    <div class="container">
        <div class="navbar">
        <div class="logo">
          <img src="images/Logo.png" class= "pic" width="125">
        </div>
            <nav>
            <ul id="MenuItems">
                <li><a href="">Dashboards</a></li>
                <li><a href="">Manage Orders</a></li>
                <li><a href="">Products</a></li>
            </ul>
            </nav>
            <a href="http://localhost/E-commerce/Account.php">
            <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
            </a>
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
</div>

<div class="container">
<?php if (!empty($orders)) : ?>
        <h2 style="text-align: center;">Order ID: <?php echo $orders[0]['order_id']; ?> - Customer: <?php echo $orders[0]['first_name'] . ' ' . $orders[0]['last_name']; ?></h2>
    <?php endif; ?>
    <div class="status">
    <?php if (isset($_GET['order_id'])) : ?>
        <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=Pending">Pending</a> |
        <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=To%20Ship">To Ship</a> |
        <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=To%20Receive">To Receive</a> |
        <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=Completed">Completed</a>
    <?php else : ?>
        <a href="staff_view_order.php?status=Pending">Pending</a> |
        <a href="staff_view_order.php?status=To%20Ship">To Ship</a> |
        <a href="staff_view_order.php?status=To%20Receive">To Receive</a> |
        <a href="staff_view_order.php?status=Completed">Completed</a>
    <?php endif; ?>
</div>


    <?php if (empty($orders)) : ?>
        <p style="text-align: center; margin-top: 20px;">No orders found for the selected status.</p>
    <?php else : ?>
        <a href="http://localhost/E-commerce/staff_dash.php"  class="btn-close" ><i class="fa fa-close"></i> Close</a>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Name</th>
                <th>Date Ordered</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Date Received</th>
                <th>Action</th>
            </tr>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo $order['prod_name']; ?></td>
                    <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                    <td><?php echo $order['date_ordered']; ?></td>
                    <td><?php echo $order['price']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : 'Not received yet'; ?></td>

                    <td>
                        <form action="update_order.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>" >
                            <input type="hidden" name="product_id" value="<?php echo $order['product_id']; ?>">
                            <select name="status"> <!-- Ensure name is 'status' -->
                                <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="To Ship" <?php if ($order['order_status'] == 'To Ship') echo 'selected'; ?>>To Ship</option>
                                <option value="To Receive" <?php if ($order['order_status'] == 'To Receive') echo 'selected'; ?>>To Receive</option>
                                <option value="Completed" <?php if ($order['order_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                            </select>
                            <button type="submit" name="update_order">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
</div>
<!-- Footer section remains unchanged -->
</body>
</html>
