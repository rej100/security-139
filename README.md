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
1. Navigate to `http://<server-ip>:8080`
2. Access the database with the credentials [root, root] or [user, user].

### 2. Cryptographic Failures (A02)
#### 2.1 When a user registers using the register page the password is stored in plaintext.
1. Obtain acess to the user credentials (for example using vulnerability 1.1)
2. The credentials can now be used freely.

### 3. Injection (A03)
#### 3.1 SQL Injection on the Comments Page
1. Navigate to `http://<server-ip>/comments/index.php`. Register and log in if needed.
2. In the text field, enter `', 'dummy'), ((SELECT CONCAT('STOLEN PASS:', password) FROM users WHERE id=1 LIMIT 1), (SELECT CONCAT('STOLEN UNAME:', username) FROM users WHERE id=1 LIMIT 1)) -- `.
3. Press the "Add Comment" button.
4. A password from the database will appear in the list of comments.
#### 3.2 SQL Injection on the Login Page (username and password fields)
#### 3.3 SQL Injection on the Register Page (username, password, and bio fields)

#### 3.4 XSS on the Comments Page
1. Navigate to `http://<server-ip>/comments/index.php`. Register and log in if needed.
2. In the text field, enter `<script>alert("XSS")</script>`.
3. Press the "Add Comment" button.
4. An alert will now appear whenever the page is opened.
#### 3.5 XSS on the My Profile Page (through username and bio display)

### 4. Insecure Design (A04)
#### 4.1 Usernames Used for Authentication are Part of Comments
1. Navigate to `http://<server-ip>/comments/index.php`. Register and log in if needed.
2. The usernames that are at the beginning of comments can be used in the log in page to attempt bruteforce/dictionary attacks.

### 5. Security Misconfiguration (A05)
#### 5.1 Verbose Error Message After Exceeding the SQL Text Limit on the Comments Page
1. Navigate to `http://<server-ip>/comments/index.php`. Register and log in if needed.
2. In the text field, enter more than 255 characters.
3. Press the "Add Comment" button.
4. A verbose error message will be displayed, exposing potentially sensitive information about the app, such as the name of a column in the database.
#### 5.2 Verbose Error Message After Exceeding the SQL Text Limit on the Login Page
#### 5.3 Verbose Error Message After Exceeding the SQL Text Limit on the Register Page

### 6. Identification and Authentication Failures (A07)
#### 6.1 User Login Page With No Login Cooldown Susceptible to Bruteforce/Dictionary Attacks.
1. Obtain a username, for example from vulnerability 4.1.
2. Navigate to `http://<server-ip>/login/index.php`.
3. Execute an attack, for example `hydra -l alice -P rockyou.txt <server-ip> http-post-form "/login/index.php:username=^USER^&password=^PASS^&login=Login:Invalid credentials."`

### 7. SSRF Vulnerability (A10)
#### 7.1 The Url Fetcher Can Be Used to Access Server Resources
1. Navigate to `http://<server-ip>/url-fetcher/index.php`.
2. In the text field, enter `file:///var/secret/secret.txt`.
3. Press the "Fetch" button.
4. The contents of the secret file stored on the server will be displayed.
