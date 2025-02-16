<?php
    if (isset($_POST['submit'])) {
        $link = mysqli_connect("localhost", "root", "", "comp_sec_db");
        mysqli_query($link, "SET NAMES UTF8");

        $content = $_POST['comment'];

        $query = "INSERT INTO comments (content) VALUES ('$content')";
        mysqli_query($link, $query);

        header("Location: " . $_SERVER['PHP_SELF']);
        mysqli_free_result($result);
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

            $link=mysqli_connect("localhost", "root", "", "comp_sec_db");
            mysqli_query($link, "SET NAMES UTF8");
            $res=mysqli_query($link, "SELECT * FROM comments");
            while($row=mysqli_fetch_assoc($res))
            {
                $content = $row["content"];
                echo "<p>".$content."<br /></p>";
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