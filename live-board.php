<?php
// 1. Engine Start (Session ki zaroorat nahi hai yahan, koi bhi emergencies dekh sakta hai)
require 'db.php';

try {
    // 2. Query: Saari Open requests lao, sabse nayi wali pehle
    $sql = "SELECT * FROM requests WHERE status = 'Open' ORDER BY created_at DESC";
    $stmt = $conn->query($sql);
    
    // Saara data nikal kar ek Array me daal do
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Live Board - RaktSetu</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Thodi si CSS magic taaki card ache dikhein */
        .card { 
            border: 1px solid #ccc; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 8px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        /* Urgency ke hisaab se color badlega */
        .Critical { border-left: 8px solid red; background-color: #ffe6e6; }
        .High { border-left: 8px solid orange; background-color: #fff2e6; }
        .Normal { border-left: 8px solid green; background-color: #e6ffe6; }
        
        .blood-badge {
            background-color: darkred; color: white; 
            padding: 5px 10px; border-radius: 5px; font-weight: bold; float: right;
        }
    </style>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2 style="color: darkred;">🚨 Live Blood Emergencies</h2>
    <a href="dashboard.php" style="text-decoration: none; color: blue;">⬅ Back to Dashboard</a>
    <hr>

    <?php if (count($requests) == 0): ?>
        <h3 style="color: green;">No active emergencies right now. Everyone is safe!</h3>
    <?php else: ?>
        
        <?php foreach ($requests as $req): ?>
            
            <div class="card <?php echo $req['urgency']; ?>">
                <span class="blood-badge"><?php echo $req['blood_group']; ?></span>
                
                <h3 style="margin-top: 0;"><?php echo htmlspecialchars($req['hospital_name']); ?></h3>
                
                <p style="margin: 5px 0;"><strong>Patient:</strong> <?php echo htmlspecialchars($req['patient_name']); ?></p>
                <p style="margin: 5px 0;"><strong>Urgency:</strong> <?php echo $req['urgency']; ?></p>
                <p style="margin: 5px 0; color: #666; font-size: 12px;">
                    Posted on: <?php echo date('d M Y, h:i A', strtotime($req['created_at'])); ?>
                </p>
            </div>

        <?php endforeach; ?>
        <?php endif; ?>

</body>
</html>