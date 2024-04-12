<?php
require 'DB/db_con.php';

if(isset($_POST['verification_code'])) {
    $verification_code = $_POST['verification_code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_code = ?");
    $stmt->execute([$verification_code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        $stmt = $pdo->prepare("UPDATE users SET status = 'verified' WHERE verification_code = ?");
        $stmt->execute([$verification_code]);
        header("location: login_form.php");
        exit();
    } else {
        $error_message = "Incorrect verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Code</title>
</head>
<body>
    <h2>Verification Code</h2>
    <?php if(isset($error_message)) echo '<p style="color: red;">' . $error_message . '</p>'; ?>
    <form method="post" action="verify_code.php"> 
        <label for="verification_code">Enter verification code:</label>
        <input type="text" id="verification_code" name="verification_code" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
