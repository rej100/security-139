# security-139
This is the vulnerable version of the easy mode of the project for the computer security course.

## How to run
To run this project clone the repository and navigate to the directory. For a first time set up run:
```bash
docker-compose up --build
```

To resume after stopping run:
```bash
docker-compose up
```

To rebuild everything from scratch run:
```bash
docker-compose down -v
docker-compose up --build
```

## Vulnerabilities

### 1. Broken Access Control (A01)
#### 1.1 phpMyAdmin on Port 8080
1. Navigate to `http://<server ip>:8080`
2. Access the database with the credentials [root, root] or [user, user].

### 2. Cryptographic Failures (A02)
When a user registers using the register page the password is stored in plaintext.

### 3. Injection (A03)
#### 3.1 SQL Injection on the Comments Page
1. Navigate to `http://172.31.32.1/comments/index.php`.
2. In the text field, enter `'), ((SELECT CONCAT('STOLEN PASS:', password) FROM users WHERE id=1 LIMIT 1)) -- `.
3. Press the "Add Comment" button.
4. A password from the database will appear in the list of comments.

#### 3.2 XSS on the Comments Page
1. Navigate to `http://172.31.32.1/comments/index.php`.
2. In the text field, enter `<script>alert("XSS")</script>`.
3. Press the "Add Comment" button.
4. An alert will now appear whenever the page is opened.

### 4. Security Misconfiguration (A05)
#### 4.1 Verbose Error Message After Exceeding SQL the Text Limit on the Comments Page
1. Navigate to `http://172.31.32.1/comments/index.php`.
2. In the text field, enter more than 255 characters.
3. Press the "Add Comment" button.
4. A verbose error message will be displayed, exposing potentially sensitive information about the app, such as the name of a column in the database.

### 5. Identification and Authentication Failures (A07)
user login page with no login cooldown, susceptible to bruteforce/dictionary attacks.

### 6. SSRF Vulnerability (A10)
#### 6.1 The Url Fetcher Can Be Used to Access Server Resources
1. Navigate to `http://172.31.32.1/url-fetcher/index.php`.
2. In the text field, enter `file:///var/secret/secret.txt`.
3. Press the "Fetch" button.
4. The contents of the secret file stored on the server will be displayed.
