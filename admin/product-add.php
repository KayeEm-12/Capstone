<?php
require __DIR__ . '/../DB/db_con.php';

function getCategories($pdo) {
    $sql = "SELECT category_id, category_name FROM category";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_name = $_POST['prod_name'];
    $discounted_price = $_POST['discounted_price'];
    $retail_price = $_POST['retail_price'];
    $type_code = $_POST['type_code'];
    $prod_desc = $_POST['prod_desc'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category'];

    $prod_name = ucwords(strtolower($prod_name)); 
    $prod_desc = ucwords(strtolower($prod_desc));

    
    $filename = $_FILES['photo']['name'];
    $tempFilePath = $_FILES['photo']['tmp_name'];
    $targetDirectory = "../images/upload/";
    $targetFilePath = $targetDirectory . $filename;

    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
    $sql = "INSERT INTO products (prod_name, discounted_price, retail_price, type_code, prod_desc, stock, photo, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$prod_name, $discounted_price, $retail_price, $type_code, $prod_desc, $stock, $filename, $category_id]);

    if ($stmt->rowCount() > 0) {
        header("location: http://localhost/E-commerce/admin/products.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $pdo = null;
}else {
    echo "Error uploading the file.";
}
}
?>
