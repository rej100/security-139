-- Create users table with an additional nickname field
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio VARCHAR(255) NOT NULL,
    nickname VARCHAR(255) NOT NULL
);

-- Insert test users with a nickname for comments
INSERT INTO users (username, password, bio, nickname) VALUES
    ('alice', 'password123', 'Test user Alice.', 'AliceNick'),
    ('bob', 'qwerty', 'Test user Bob.', 'Bobby'),
    ('charlie', 'letmein', 'Test user Charlie.', 'CharlieD');


-- Create comments table with nickname instead of username
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content VARCHAR(255) NOT NULL,
    nickname VARCHAR(255) NOT NULL
);

-- Insert example comments using the new nicknames
INSERT INTO comments (content, nickname) VALUES
    ('This is the first example comment.', 'AliceNick'),
    ('Another example comment for testing.', 'Bobby'),
    ('Final test comment to check data insertion.', 'CharlieD');
