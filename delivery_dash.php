<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
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
}   footer {
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
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/customer_dash.php">
                <img src="images/Logo.png" width="125">
            </a>
        </div>
        <nav>
        <ul id="MenuItems">
            <li><a href="delivery_dash.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="my_orders.php">My Orders</a></li>
            <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
            <!-- <li><a href="">Account</a></li> -->
        </ul>
        </nav>
        <a href="http://localhost/E-commerce/Account.php">
        <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
        </a>
        <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
<!-- --end-- -->

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
    var MenuItems = document.getElementById("MenuItems");
    
    MenuItems.style.maxHeight = "0px";

    function menutoggle() {
        if (MenuItems.style.maxHeight =="0px")
        {
            MenuItems.style.maxHeight = "200px";
        }
        else{
            MenuItems.style.maxHeight = "0px";
        }
    }
</script>
</body>
</html>