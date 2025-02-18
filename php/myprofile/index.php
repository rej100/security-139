<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
</head>
<body>
    <h2>My Profile</h2>
    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <p>Bio: <?php echo htmlspecialchars($_SESSION['bio']); ?></p>
    <p><a href="../comments/index.php">Comments</a></p>
    <p><a href="../logout/index.php">Logout</a></p>
</body>
</html>
