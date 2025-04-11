<?php
// Include database connection
try {
    // Replace these with your actual database credentials
    $host = 'localhost';
    $dbname = 'gym';
    $username = 'root';
    $password = 'nethmitha';

    // Establish the PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Start the session to manage user login
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user data based on username or email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // Redirect to a welcome or dashboard page
        header("Location: welcome.php");
        exit;
    } else {
        $message = "Invalid username/email or password.";
    }
}
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym User Login</title>
</head>
<body>
    <h2>Gym User Login</h2>

    <!-- Display error message if any -->
    <?php if (isset($message)) { echo "<p style='color:red;'>$message</p>"; } ?>

    <!-- Login form -->
    <form action="login.php" method="POST">
        <input type="text" name="username_or_email" placeholder="Username or Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
