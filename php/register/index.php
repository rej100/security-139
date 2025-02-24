<?php
if (isset($_POST['register'])) {
    $servername   = "db"; 
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("Connection failed");
    }
    
    // Get form data including nickname
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bio      = $_POST['bio'];
    $nickname = $_POST['nickname'];

    // Validate comment length.
    if (strlen($username) > 255 && strlen($password) > 255 && strlen($bio) > 255 && strlen($nickname) > 255) {
        echo "Fields can't exceed maximum allowed length of 255 characters.";
        mysqli_close($link);
        exit;
    }
    
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "Error: Username already exists.";
    } else {
        // Insert user with hashed password
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, bio, nickname) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPassword, $bio, $nickname);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful. <a href='../login/index.php'>Click here to login</a>.";
        } else {
            echo "Error: Failed to register";
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="post" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br>
        
        <label for="bio">Bio:</label><br>
        <input type="text" name="bio" required><br>
        
        <!-- New field for nickname -->
        <label for="nickname">Nickname:</label><br>
        <input type="text" name="nickname" required><br><br>
        
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
