<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Validate URL and restrict to http and https schemes.
    if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match("/^https?:\/\//", $url)) {
        echo "Invalid URL.";
        exit;
    }
    
    // Parse the host and resolve it to an IP address.
    $host = parse_url($url, PHP_URL_HOST);
    $ip = gethostbyname($host);
    
    // Block access if the IP is in a private or reserved range.
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        echo "Access to local or reserved addresses is not allowed.";
        exit;
    }

    // Set a timeout for the HTTP request.
    $context = stream_context_create([
        'http' => [
            'timeout' => 5 // Timeout in seconds.
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
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
    <form method="get">
        <label for="url">Enter URL to fetch:</label>
        <input type="text" id="url" name="url" placeholder="e.g. http://example.com" required>
        <button type="submit">Fetch</button>
    </form>
</body>
</html>
