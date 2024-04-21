
<?php 

require '../DB/db_con.php';

  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

//   try {
//     $sql = "SELECT o.order_id, o.order_status, u.first_name, a.barangay, a.street
//     FROM orders o
//     INNER JOIN users u ON o.user_id = u.user_id
//     INNER JOIN address a ON o.address_id = a.address_id";
    
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute();
//     $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     $stmt = null;

// } catch (PDOException $e) {
//     die("Error: " . $e->getMessage());
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
<style>

.small-box-1 {
    background: #81d381;
    width: 100%;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    margin-bottom: 20px;
}
.small-box-2 {
    background: #afaff5;
    width: 100%;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    margin-bottom: 20px;
}
.small-box-3 {
    background: yellow;
    width: 100%;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    margin-bottom: 20px;
}
.inner {
    text-align: center;
}
.inner h3 {
    font-size: 36px;
    margin: 0;
    color: #333;
}
.inner p {
    margin: 10px 0 0;
    color: black;
}
.icon {
    font-size: 48px;
    color: black;
    margin-left: 60px;
}
.row1{
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    min-height: 61.5vh;
}
</style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/admin/admin_dash.php">
                <img src="../images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
        <ul>
        <li><a href="http://localhost/E-commerce/admin/admin_dash.php">Dashboards</a></li>
            <li><a href="http://localhost/E-commerce/admin/manage_order.php">Manage Orders</a></li>
            <li><a href="http://localhost/E-commerce/admin/products.php">Manage Products</a></li>
            <li><a href="http://localhost/E-commerce/admin/category.php">Manage Categories</a></li>
            <li><a href="http://localhost/E-commerce/admin/user.php">Manage Users</a></li>
            <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
            <!-- <li><a href="http://localhost/E-commerce/Account.php">Account</a></li> -->
        </ul>
        </nav>
        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
            <i class="fa-solid fa-user"></i>
            <!-- <img src="../images/profile-icon.png" width="30px" height="30px" class="icon"> -->
            </a>
        <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
<!-- end -->
<div class="row1">
    <!-- Total Orders -->
    <div class="col-lg-3 col-xs-6">
    <div class="small-box-1">
    <div class="inner">
        <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM orders");
            $stmt->execute();
            $orow = $stmt->fetch();
            echo "<h3>".$orow['numrows']."</h3>";
        ?>
        <p>Total Orders</p>
    </div>
    <div class="icon">
        <i class="fa fa-shopping-cart"></i>
    </div>
    <a href="http://localhost/E-commerce/admin/manage_order.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    </div>

    <!-- Total Products -->
    <div class="col-lg-3 col-xs-6">
    <div class="small-box-2">
    <div class="inner">
        <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM products");
            $stmt->execute();
            $prow = $stmt->fetch();
            echo "<h3>".$prow['numrows']."</h3>";
        ?>
        <p>Total Products</p>
    </div>
    <div class="icon">
        <i class="fa fa-barcode"></i>
    </div>
    <a href="http://localhost/E-commerce/admin/products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-xs-6">
    <div class="small-box-3">
    <div class="inner">
        <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM category");
            $stmt->execute();
            $crow = $stmt->fetch();
            echo "<h3>".$crow['numrows']."</h3>";
        ?>
        <p>Total Categories</p>
    </div>
    <div class="icon">
        <i class="fa fa-list-alt"></i>
    </div>
    <a href="http://localhost/E-commerce/admin/category.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    </div>
</div>

<!--footer-->
<footer>
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
            <img src="../images/logo2.png" width="100px" height="60px">
            </div>
            <div class="footer-col-2">
            <p>&copy; <?php echo date('Y'); ?> 4M Minimart Online Store. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- js for toggle menu -->
<script>

    var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
    // MenuItems.style.maxHeight = "0px";
    // function menutoggle() {
    //     if (MenuItems.style.maxHeight =="0px")
    //     {
    //         MenuItems.style.maxHeight = "300px";
    //     }
    //     else{
    //         MenuItems.style.maxHeight = "0px";
    //     }
    // }
</script>
</html>
</body>