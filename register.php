<?php
// 1. Apna engine start karo (DRY principle applied)
require 'db.php';

// 2. Check karo kya user ne 'Register' button dabaya hai?
if (isset($_POST['submit'])) {
    
    // Form ke dabbe ($_POST) me se data nikalo
    $name = $_POST['name'];
    $email = $_POST['email'];
    $blood_group = $_POST['blood_group'];
    
    // Password ko secure (Hash) karo
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // By default har naya user 'donor' hoga
    $role = 'donor'; 

    try {
        // 3. Database Guard (Prepared Statement) ko SQL query ka dhancha do
        $sql = "INSERT INTO users (name, email, password_hash, blood_group, role) 
                VALUES (:name, :email, :pass, :bg, :role)";
        
        $stmt = $conn->prepare($sql);
        
        // 4. Guard ko asli data do aur execute karo
        $stmt->execute([
            ':name' => $name, 
            ':email' => $email, 
            ':pass' => $password, 
            ':bg' => $blood_group, 
            ':role' => $role
        ]);
        
        // Agar yahan tak aa gaya, matlab data save ho gaya!
        $msg = "<h3 style='color:green;'>Registration Successful! You can login now.</h3>";

    } catch(PDOException $e) {
        // Agar email already exist karta hai, toh error aayega
        $msg = "<h3 style='color:red;'>Error: " . $e->getMessage() . "</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - RaktSetu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>Create Donor Account</h2>
    
    <?php if(isset($msg)) echo $msg; ?>
    
    <form action="register.php" method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email ID:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Blood Group:</label><br>
        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select><br><br>

        <button type="submit" name="submit" style="padding: 10px; background-color: #d9534f; color: white; border: none;">Register Now</button>
    </form>

</body>
</html>