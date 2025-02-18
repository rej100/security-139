<?php
if (isset($_POST['register'])) {
    // Database connection settings
    $servername   = "db";  // use the service name defined in docker-compose.yml
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";
    
    // Connect to the database
    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Get form data
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $bio = $_POST['bio'];

    $query = "INSERT INTO users (username, password, bio) VALUES ('$username', '$password', '$bio')";
    if (mysqli_query($conn, $query)) {
        echo "Registration successful. <a href='../login/login.php'>Click here to login</a>.";
    } else {
        echo "Error: " . mysqli_error($conn);
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
        <input type="text" name="bio" required><br><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
