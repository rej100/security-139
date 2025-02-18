<?php
session_start();
if (isset($_POST['login'])) {
    $servername   = "db";
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";
    
    $conn = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Select user with matching credentials
    $query  = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username']   = $user['username'];
        $_SESSION['bio'] = $user['bio'];
        header("Location: ../myprofile/index.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Forgot Your Password?</a>
        <br>
        <br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
