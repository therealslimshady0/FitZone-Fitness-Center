<?php
// Database connection
try {
    // Replace with your own database credentials
    $host = 'localhost';
    $dbname = 'gym';
    $username = 'root';
    $password = '';
    
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");

    try {
        // Execute the query
        $stmt->execute([$username, $email, $password]);
        $message = "User registered successfully.";
    } catch (PDOException $e) {
        $message = "Registration failed: " . $e->getMessage();
    }
}
?>

<!-- HTML Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Admin Registration</title>
</head>
<body>
    <h2>Gym User Registration</h2>

    <!-- Show success or error message -->
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

    <form action="#" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
