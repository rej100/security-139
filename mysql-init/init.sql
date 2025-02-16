CREATE DATABASE IF NOT EXISTS comp_sec_db;
USE comp_sec_db;

CREATE TABLE IF NOT EXISTS comments (
    content TEXT NOT NULL
);

INSERT INTO comments (content) VALUES
    ('This is the first example comment.'),
    ('Another example comment for testing.'),
    ('Final test comment to check data insertion.');
