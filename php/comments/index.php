<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}

// Generate CSRF token if not already set.
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // CSRF token validation.
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
         echo "Invalid CSRF token.";
         exit;
    }

    $servername   = "db"; 
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";

    $link = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$link) {
        echo "Database connection error.";
        exit;
    }
    mysqli_set_charset($link, "utf8");

    $content = $_POST['comment'];
    $nickname = $_SESSION['nickname'];

    // Validate comment length.
    if (strlen($content) > 255 ) {
        echo "Comment exceeds maximum allowed length of 255 characters.";
        mysqli_close($link);
        exit;
    }

    if (strlen(trim($content)) < 1 ) {
        echo "Cannot submit empty comment";
        mysqli_close($link);
        exit;
    }

    // Use a prepared statement to prevent SQL injection.
    $stmt = mysqli_prepare($link, "INSERT INTO comments (content, nickname) VALUES (?, ?)");
    if ($stmt === false) {
        echo "An error occurred. Please try again.";
        mysqli_close($link);
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ss", $content, $nickname);
    if (!mysqli_stmt_execute($stmt)) {
        echo "An error occurred while adding your comment. Please try again.";
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        exit;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Comments</title>
</head>
<body>
    <header>
        <h1>Comments</h1>
    </header>
    <main>
        <?php
            $servername   = "db";
            $db_username  = "user";
            $db_password  = "user";
            $database     = "comp_sec_db";

            $link = mysqli_connect($servername, $db_username, $db_password, $database);
            if (!$link) {
                echo "Database connection error.";
                exit;
            }
            mysqli_set_charset($link, "utf8");

            $res = mysqli_query($link, "SELECT * FROM comments");
            if ($res) {
                while($row = mysqli_fetch_assoc($res))
                {
                    // Escape output to prevent XSS.
                    $nickname = htmlspecialchars($row["nickname"], ENT_QUOTES, 'UTF-8');
                    $content = htmlspecialchars($row["content"], ENT_QUOTES, 'UTF-8');
                    echo "<p><strong>$nickname</strong>: $content<br /></p>";
                }
                mysqli_free_result($res);
            } else {
                echo "An error occurred while fetching comments.";
            }
            mysqli_close($link);
        ?>
    </main>
    <footer>
        <form method="post" action="">
            <textarea name="comment" rows="4" placeholder="Enter your comment here..." required></textarea>
            <!-- CSRF token field -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <br>
            <input type="submit" name="submit" value="Add Comment">
        </form>
    </footer>
</body>
</html>
