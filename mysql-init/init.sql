CREATE DATABASE IF NOT EXISTS comp_sec_db;
USE comp_sec_db;

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio VARCHAR(255) NOT NULL
);

INSERT INTO comments (content, username) VALUES
    ('This is the first example comment.', 'alice'),
    ('Another example comment for testing.', 'bob'),
    ('Final test comment to check data insertion.', 'charlie');

-- Insert test users with simple usernames and passwords
INSERT INTO users (username, password, bio) VALUES
    ('alice', 'password123', 'Test user Alice.'),
    ('bob', 'qwerty', 'Test user Bob.'),
    ('charlie', 'letmein', 'Test user Charlie.');
