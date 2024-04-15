<?php
require 'DB/db_con.php';

try {
    $sql = "SELECT o.order_id, o.order_status, u.first_name, a.barangay, a.street
    FROM orders o
    INNER JOIN users u ON o.user_id = u.user_id
    INNER JOIN address a ON o.address_id = a.address_id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
</head>
<style>
.order-container{
    min-height:60vh;
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

.order-container{
    .container{
      max-width: 100%;
      height: max-content;
      position: relative;
      display: flex;
      justify-content: center;
      top: 10%;
      right: 0%;
      width: 100%;
      height: 100%;
      margin: 0 auto;
      .ebadge-wrapper{
        margin-top: 100px;
        .row1{
          flex-grow: 1;
          display: flex;
          align-items: center;
          gap: 5rem;
          
          .small-box-1 {
            background: #81d381;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
            &:nth-child(1) {
              background-color: rgb(76, 245, 61);
            }
            &:nth-child(2) {
              background-color: rgb(20, 122, 239);
            }
            &:nth-child(3) {
              background-color: rgb(233, 236, 31);
            }
            .badge{
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 20px;
              margin-bottom: 20px;
              .inner{
                text-align: center;
                h3{
                  font-size: 36px;
                  margin: 0;
                  color: #333;
                }
                p{
                  margin: 0px;
                  color: black;
                }
              }
              .icon {
                font-size: 48px;
                color: black;
              }
            }
          }
        }
      }
    }
  }
</style>
<body>

    <div class="staff-container">
        <div class="navbar">
            <div class="logo">
            <img src="images/Logo.png" class= "pic" width="125">
            </div>
            <nav id="menuItems">
                <ul>
                    <li><a href="staff_dash.php">Dashboards</a></li>
                    <!-- <li><a href="staff_view_order.php">View Orders</a></li> -->
                    <li><a href="">Products</a></li>
                </ul>
                </nav>
                
            <div class="setting-sec">
                <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
                <!-- <img src="images/profile-icon.png" width="30px" height="30px" class="icon"> -->
                </a>
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <div class="order-container">
        <div class="container">
            <div class="ebadge-wrapper">
                <div class="row1">
                    <!-- Pending -->
                    <div class="small-box-1" data-status="Pending">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="inner">
                                <h3 class="pending-orders-count">0</h3>
                                <p>Pending Orders</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- To Ship -->
                    <div class="small-box-1" data-status="ToShip">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <div class="inner">
                                <h3 class="toShip-orders-count">0</h3>
                                <p>To Ship Orders</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- To Received -->
                    <div class="small-box-1" data-status="ToReceive">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <div class="inner">
                                <h3 class="toReceive-orders-count">0</h3>
                                <p>To Receive Orders</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>

                    <!-- Completed -->
                    <div class="small-box-1" data-status="Completed">
                        <div class="badge">
                            <div class="icon">
                                <i class="fa-solid fa-users-slash"></i>
                            </div>
                            <div class="inner">
                                <h3 class="completed-orders-count">0</h3>
                                <p>Completed Orders</p>
                            </div>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="order-list">
        <div class="container">
            <div class="list-wrapper">
                <div class="list-title">
                    <h2 style="text-align: center;">ORDER LIST</h2>
                </div>
                <table id="ordersTable">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Deetails</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td>
                                <?php echo $order['order_id']; ?>
                            </td>
                            <td>
                                <?php echo $order['first_name']; ?> <br>
                                <?php echo $order['street']; ?> <span> </span> <?php echo $order['barangay']; ?> 
                            </td>
                            <td><?php echo $order['order_status']; ?></td>
                            <td>
                                <a href="staff_view_order.php?order_id=<?php echo $order['order_id']; ?>"><button class="view-button" data-id="<?php echo $order['order_id']; ?>">View</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
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
<!-- js for toggle menu -->
<script>

var menuItems = document.getElementById("menuItems");
    function menutoggle() {
        menuItems.classList.toggle("show");
    }
</script>


<script>
       $(document).ready(function() {

            function fetchEventDetails(status) {
                if (status) {
                    $.ajax({
                        url: 'user-order_fetch.php',
                        type: 'GET',
                        data: { status: status },
                        success: function(response) {
                            $('#ordersTable tbody').html(response);
                        },
                        error: function() {
                            console.log('Error occurred while fetching order details.');
                        }
                    });
                }
            }

            // Function to fetch and update user counts
            function fetchEventCounts() {
                $.ajax({
                    url: 'order_filtering.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.pending-orders-count').text(response.Pending);
                        $('.toShip-orders-count').text(response.ToShip);
                        $('.toReceive-orders-count').text(response.ToReceive); 
                        $('.completed-orders-count').text(response.Completed);
                    },
                    error: function() {
                        console.log('Error occurred while fetching order counts.');
                    }
                });
            }


            // for "More Info" buttons
            $('.small-box-1').click(function() {
                var status = $(this).data('status');
                fetchEventDetails(status);
            });

            // Initial fetch for user counts
            fetchEventCounts();

        });

    </script>

</html>
</body>
