<?php
// VIP pass check karne/banane ke liye session_start zaroori hai
session_start(); 
require 'db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Email ke basis pe user ko database me dhoondho
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch ka matlab data nikal kar array me rakhna

    // 2. Agar user mil gaya AUR uska password match ho gaya
    if ($user && password_verify($password, $user['password_hash'])) {
        
        // VIP Pass issue karo! (Server ki memory me user ka naam aur ID save karo)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        
        // User ko andar (Dashboard) bhej do
        header("Location: dashboard.php");
        exit(); // Code yahan rok do, niche ka execute mat karo
    } else {
        // Agar match nahi hua toh error
        $error = "<h3 style='color:red;'>Invalid Email or Password!</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - RaktSetu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="font-family: Arial; padding: 20px;">
    <h2>Login to your Account</h2>
    <?php if(isset($error)) echo $error; ?>
    
    <form method="POST" action="login.php">
        <label>Email ID:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login" style="padding: 10px; background-color: #5cb85c; color: white; border: none;">Login</button>
    </form>
</body>
</html>