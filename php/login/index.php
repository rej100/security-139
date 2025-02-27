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

    // Define cooldown parameters
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $cooldown_period = 15 * 60; // 15 minutes in seconds
    $max_attempts = 5;

    // Check if this IP has previous login attempts
    $attempt_query = "SELECT * FROM login_attempts WHERE ip_address = ?";
    $stmt = mysqli_prepare($conn, $attempt_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $ip_address);
        mysqli_stmt_execute($stmt);
        $attempt_result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        error_log("Prepare failed: " . mysqli_error($conn));
        $attempt_result = false;
    }

    if (mysqli_num_rows($attempt_result) > 0) {
        $attempt_data = mysqli_fetch_assoc($attempt_result);
        $attempts = $attempt_data['attempts'];
        $last_attempt = strtotime($attempt_data['last_attempt']);
        
        // If the last attempt was within the cooldown period and max attempts reached, block login
        if (time() - $last_attempt < $cooldown_period && $attempts >= $max_attempts) {
            die('Too many login attempts. Please try again later. <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Forgot Your Password?</a>');
        } 
        // If the cooldown period has passed, reset the attempts
        else if (time() - $last_attempt >= $cooldown_period) {
            $delete_attempts = "DELETE FROM login_attempts WHERE ip_address = ?";
            $stmt = mysqli_prepare($conn, $delete_attempts);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $ip_address);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                error_log("Prepare failed: " . mysqli_error($conn));
            }
        }
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate comment length.
    if (strlen($username) > 255 && strlen($password) > 255) {
        echo "Fields can't exceed maximum allowed length of 255 characters.";
        mysqli_close($conn);
        exit;
    }
    
    // Select user based on username only
    $user_query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $user_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        error_log("Prepare failed: " . mysqli_error($conn));
        $result = false;
    }

    function failed_login_attempt($conn, $ip_address, $attempt_result): void {
        if (mysqli_num_rows($attempt_result) > 0) {
            $query = "UPDATE login_attempts SET attempts = attempts + 1, last_attempt = NOW() WHERE ip_address = ?";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $ip_address);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                error_log("Prepare failed: " . mysqli_error($conn));
            }
        } else {
            $query = "INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES (?, 1, NOW())";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $ip_address);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                error_log("Prepare failed: " . mysqli_error($conn));
            }
        }
        echo "Invalid credentials.";
    }
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify the provided password against the stored hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];  // For authentication purposes
            $_SESSION['nickname'] = $user['nickname'];    // For comments display
            $_SESSION['bio'] = $user['bio'];
            header("Location: ../myprofile/index.php");
            exit();
        } else {
            failed_login_attempt($conn, $ip_address, $attempt_result);
        }
    } else {
        failed_login_attempt($conn, $ip_address, $attempt_result);
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