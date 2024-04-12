<?php
require '../DB/db_con.php';

$category = $_POST['category'];

try {
    if ($category == 0) {
        $sql = "SELECT products.*, category.category_name
                FROM products
                INNER JOIN category ON products.category_id = category.category_id";
    } else {
        $sql = "SELECT products.*, category.category_name
                FROM products
                INNER JOIN category ON products.category_id = category.category_id
                WHERE products.category_id = :category";
    }

    $stmt = $pdo->prepare($sql);

    if ($category != 0) {
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    }

    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("PDOException: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<tr>
    <th>Product Name</th>
    <!-- <th>Type Code</th> -->
    <th>Discounted Price</th>
    <th>Retail Price</th>
    <th>Description</th>
    <!-- <th>Category</th>  -->
    <!-- <th>Stock</th> -->
    <th>Photo</th>
    <th>Action</th>
</tr>

<?php
foreach ($products as $product) {
    echo '<tr>';
    echo '<td>' . $product['prod_name'] . '</td>';
    echo '<td>' . $product['discounted_price'] . '</td>';
    echo '<td>' . $product['retail_price'] . '</td>';
    echo '<td>' . $product['prod_desc'] . '</td>';
    echo '<td><img src="../images/upload/' . $product['photo'] . '" alt="Product Photo" style="max-width: 100px; max-height: 100px;"></td>';
    echo '<td><a href="http://localhost/E-commerce/admin/edit-prod.php?product_id=' . $product['product_id'] . '" class="edit-button"><i class="fa fa-edit"></i>Edit</a></td>';
    echo '</tr>';
}
?>

