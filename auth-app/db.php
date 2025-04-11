<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'gym';
    $username = 'root';
    $password = 'nethmitha'; // Replace with your actual DB password

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("DB connection failed: " . $e->getMessage());
    }
}
?>
