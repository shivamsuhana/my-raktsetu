<?php
// 1. Database ke credentials (Pata)
$host = 'localhost';
$dbname = 'my-raktsetu'; // Make sure phpMyAdmin me tera database ka naam yahi ho
$db_user = 'root';
$db_pass = '';

// 2. Try-Catch Block (Safety Net)
try {
    // Naya connection bana rahe hain
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    
    // Agar koi error aaye, toh chup mat rehna, exception (warning) phekna
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test karne ke liye ek temporary line (Baad me hata denge)
    // echo "Connection Success!"; 

} catch(PDOException $e) {
    // Agar connection fail hua toh script yahi rok do (die) aur error batao
    die("Database Connection Failed: " . $e->getMessage());
}
?>