CREATE DATABASE IF NOT EXISTS comp_sec_db;
USE comp_sec_db;

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    bio VARCHAR(255) NOT NULL
);

INSERT INTO comments (content) VALUES
    ('This is the first example comment.'),
    ('Another example comment for testing.'),
    ('Final test comment to check data insertion.');
