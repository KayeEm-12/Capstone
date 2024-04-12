<?php
require __DIR__ . '/../DB/db_con.php';

if(isset($_POST)) {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO category (category_name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_name]);

    if ($stmt->execute()) {
        header("location: http://localhost/E-commerce/admin/category.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

