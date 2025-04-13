<?php
// dashboard.php

// Connect to the database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gym", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user counts
function getRoleCount($pdo, $role) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
    $stmt->execute([$role]);
    return $stmt->fetchColumn();
}

$adminCount = getRoleCount($pdo, 'admin');
$staffCount = getRoleCount($pdo, 'staff');
$userCount  = getRoleCount($pdo, 'user');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - FitZone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        .dashboard {
            max-width: 900px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .card-container {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            width: 200px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card h2 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #1e90ff;
        }
        .card p {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>FitZone Admin Dashboard</h1>
        <div class="card-container">
            <div class="card">
                <h2><?= $adminCount ?></h2>
                <p>Admins</p>
            </div>
            <div class="card">
                <h2><?= $staffCount ?></h2>
                <p>Staff</p>
            </div>
            <div class="card">
                <h2><?= $userCount ?></h2>
                <p>Gym Users</p>
            </div>
        </div>
    </div>
</body>
</html>
