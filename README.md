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

### Injection (A03)
XSS on the comments page.
SQL injection on login page.

### Security Misconfiguration (A05)
Verbose error message after exceeding SQL text limit on comments page.

### Broken Access Control (A01)
phpmyadmin on port 8080

### Identification and Authentication Failures (A07)
user login page with no login cooldown, susceptible to bruteforce/dictionary attacks.

### SSRF Vulnerability (A10)
The url fetcher can be used to access server files such file:///var/secret/secret.txt

### A02 Cryptographic Failures
When a user registers using the register page the password is stored in plaintext.