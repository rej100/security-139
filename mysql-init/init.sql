-- Create users table with an additional nickname field
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio VARCHAR(255) NOT NULL,
    nickname VARCHAR(255) NOT NULL
);

-- Insert test users with a nickname for comments and hashed passwords
-- The sample hashed values below were generated using PHP's password_hash()
INSERT INTO users (username, password, bio, nickname) VALUES
    ('alice', '$2y$10$mnjjaXUos.U23UtgiQNhnetXan3F5tjekJ/W0jlqF7OHB7Heyqgvm', 'Test user Alice.', 'AliceNick'), -- password123
    ('bob', '$2y$10$kR1DYsRJIINXviDNNQOmuOKWIClcKjdNcA2MHyacEXmOEe0ELHnS6', 'Test user Bob.', 'Bobby'), -- qwerty
    ('charlie', '$2y$10$T6QsZs5lpOaJnavfZKkl8.F/Q95jYkv4R0dRFZiIdp2vOs5KwLjZq', 'Test user Charlie.', 'CharlieD'); -- letmein

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

-- Create table to track login attempts by IP address to prevent brute-force attacks
CREATE TABLE IF NOT EXISTS login_attempts (
    ip_address VARCHAR(45) PRIMARY KEY,
    attempts INT NOT NULL DEFAULT 0,
    last_attempt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);