CREATE DATABASE IF NOT EXISTS cisc3003_paper02_a CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cisc3003_paper02_a;

CREATE TABLE IF NOT EXISTS student_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL,
    student_year VARCHAR(30) NOT NULL,
    study_mode VARCHAR(30) NOT NULL,
    interests VARCHAR(255) NOT NULL,
    comments TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO student_feedback (full_name, email, student_year, study_mode, interests, comments)
VALUES ('Sample Student', 'sample@example.com', 'Year 3', 'Full-time', 'PHP,MySQL', 'Sample INSERT INTO record.');
