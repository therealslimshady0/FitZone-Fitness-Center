<?php
// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gym", 'root', 'nethmitha');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        $message = "Blog post published successfully!";
    } else {
        $message = "Title and content cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Blog</title>
</head>
<body>
    <h2>Post a New Blog</h2>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Blog Title" required><br><br>
        <textarea name="content" placeholder="Blog Content" rows="10" cols="50" required></textarea><br><br>
        <button type="submit">Publish</button>
    </form>

    <p><a href="blog.php">View Blog</a></p>
</body>
</html>
