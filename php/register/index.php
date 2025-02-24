<?php
if (isset($_POST['register'])) {
    $servername   = "db"; 
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";

    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Get form data including nickname
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bio      = $_POST['bio'];
    $nickname = $_POST['nickname'];
    
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($result) > 0) {
        echo "Error: Username already exists.";
    } else {
        // Insert user with hashed password
        $query = "INSERT INTO users (username, password, bio, nickname) VALUES ('$username', '$hashedPassword', '$bio', '$nickname')";
        if (mysqli_query($conn, $query)) {
            echo "Registration successful. <a href='../login/index.php'>Click here to login</a>.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    
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
