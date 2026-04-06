<?php
session_start(); // Yahan bhi pass check karna zaroori hai

// THE BOUNCER: Agar session memory me user_id nahi hai, toh bahar pheko
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">

</head>
<body style="font-family: Arial; padding: 20px;">
    <h2 style="color: green;">Welcome to RaktSetu, <?php echo $_SESSION['name']; ?>!</h2>
    <p>Your VIP Pass is active. This is a secure page.</p>
    
    <hr>
    <h3>Quick Actions:</h3>
<ul>
    <li><a href="post-request.php">Post an Emergency</a></li>
    <li><a href="live-board.php">View Live Board</a></li>
    
    <li><a href="donors.php">View All Donors</a></li> 
    
    <li><a href="logout.php" style="color: red;">Logout</a></li>
</ul>
</body>
</html>