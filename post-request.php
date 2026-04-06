<?php
// 1. VIP Pass check karo aur Engine chalu karo
session_start();
require 'db.php';

// THE BOUNCER: Bina login wale form nahi dekh sakte
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Form Submit hone par action
if (isset($_POST['post_request'])) {
    
    // YAHAN HAI MAGIC: Logged-in user ki ID humne session (VIP Pass) se chura li
    $uid = $_SESSION['user_id']; 
    
    // Baaki data form se pakda
    $patient_name = $_POST['patient_name'];
    $blood_group = $_POST['blood_group'];
    $hospital_name = $_POST['hospital_name'];
    $urgency = $_POST['urgency'];

    try {
        // 3. Database Guard (Prepared Statement)
        $sql = "INSERT INTO requests (user_id, patient_name, blood_group, hospital_name, urgency) 
                VALUES (:uid, :pname, :bg, :hname, :urgency)";
        
        $stmt = $conn->prepare($sql);
        
        // Data bhejo
        $stmt->execute([
            ':uid' => $uid, 
            ':pname' => $patient_name, 
            ':bg' => $blood_group, 
            ':hname' => $hospital_name, 
            ':urgency' => $urgency
        ]);
        
        $msg = "<h3 style='color:green;'>Emergency Broadcasted Successfully!</h3>";

    } catch(PDOException $e) {
        $msg = "<h3 style='color:red;'>Error: " . $e->getMessage() . "</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Emergency - RaktSetu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2 style="color: red;">🚨 Broadcast Blood Emergency</h2>
    <p>Logged in as: <strong><?php echo $_SESSION['name']; ?></strong></p>
    
    <?php if(isset($msg)) echo $msg; ?>

    <form method="POST" action="post-request.php" style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
        <label>Patient Name:</label><br>
        <input type="text" name="patient_name" required><br><br>

        <label>Blood Group Needed:</label><br>
        <select name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option value="A+">A+</option><option value="A-">A-</option>
            <option value="B+">B+</option><option value="B-">B-</option>
            <option value="O+">O+</option><option value="O-">O-</option>
            <option value="AB+">AB+</option><option value="AB-">AB-</option>
        </select><br><br>

        <label>Hospital Name & Area:</label><br>
        <input type="text" name="hospital_name" placeholder="e.g. City Hospital, Kanakapura" required><br><br>

        <label>Urgency Level:</label><br>
        <select name="urgency" required>
            <option value="Normal">Normal (Within 24 hours)</option>
            <option value="High">High (Within 6 hours)</option>
            <option value="Critical">Critical (Needed Immediately)</option>
        </select><br><br>

        <button type="submit" name="post_request" style="padding: 10px 20px; background-color: red; color: white; border: none; font-weight: bold;">Post Emergency Now</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>