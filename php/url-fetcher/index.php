<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    // Vulnerable: No validation or sanitization is performed.
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        echo "Error fetching the URL.";
    } else {
        echo nl2br(htmlspecialchars($response));
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Fetcher</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        input[type="text"] { width: 400px; padding: 0.5em; }
        button { padding: 0.5em 1em; }
    </style>
</head>
<body>
    <h1>URL Fetcher</h1>
    <p>This page is vulnerable to Server Side Request Forgery (SSRF). You can supply any URL to be fetched by the server.</p>
    <form method="get">
        <label for="url">Enter URL to fetch:</label>
        <input type="text" id="url" name="url" placeholder="e.g. http://example.com" required>
        <button type="submit">Fetch</button>
    </form>
    <p><strong>Demo Tip:</strong> To retrieve the secret file on the server, try entering:</p>
    <pre>file:///var/secret/secret.txt</pre>
</body>
</html>
