<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $servername   = "db"; 
    $db_username  = "user";
    $db_password  = "user";
    $database     = "comp_sec_db";

    $link = mysqli_connect($servername, $db_username, $db_password, $database);
    mysqli_query($link, "SET NAMES UTF8");

    $content = $_POST['comment'];
    // Use nickname instead of username for comments
    $nickname = $_SESSION['nickname'];

    $query = "INSERT INTO comments (content, nickname) VALUES ('$content', '$nickname')";
    mysqli_query($link, $query);

    header("Location: " . $_SERVER['PHP_SELF']);
    mysqli_close($link);
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
            mysqli_query($link, "SET NAMES UTF8");
            $res = mysqli_query($link, "SELECT * FROM comments");
            while($row = mysqli_fetch_assoc($res))
            {
                // Escape output to prevent XSS
                $nickname = $row["nickname"];
                $content = $row["content"];
                echo "<p><strong>$nickname</strong>: $content<br /></p>";
            }
            mysqli_free_result($res);
            mysqli_close($link);
        ?>
    </main>
    <footer>
        <form method="post" action="">
            <textarea name="comment" rows="4" placeholder="Enter your comment here..." required></textarea>
            <br>
            <input type="submit" name="submit" value="Add Comment">
        </form>
    </footer>
</body>
</html>
