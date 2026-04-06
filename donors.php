<?php
session_start();
require 'db.php';

// Bouncer: Bina login walo ko donors ki detail mat dikhao (Privacy)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Sirf 'donor' role walo ka data nikalo
    $sql = "SELECT name, blood_group, email FROM users WHERE role = 'donor' ORDER BY blood_group ASC";
    $stmt = $conn->query($sql);
    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching donors: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Directory - RaktSetu</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: darkred; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body style="font-family: Arial; padding: 20px; background-color: #f8f9fa;">

    <h2 style="color: darkred;">🩸 Verified Blood Donors</h2>
    <a href="dashboard.php" style="text-decoration: none; color: blue;">⬅ Back to Dashboard</a>
    
    <?php if (count($donors) == 0): ?>
        <p>No donors registered yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Donor Name</th>
                <th>Contact Email</th>
            </tr>
            
            <?php foreach ($donors as $donor): ?>
            <tr>
                <td><strong><?php echo $donor['blood_group']; ?></strong></td>
                <td><?php echo htmlspecialchars($donor['name']); ?></td>
                <td><a href="mailto:<?php echo $donor['email']; ?>"><?php echo htmlspecialchars($donor['email']); ?></a></td>
            </tr>
            <?php endforeach; ?>
            
        </table>
    <?php endif; ?>

</body>
</html>