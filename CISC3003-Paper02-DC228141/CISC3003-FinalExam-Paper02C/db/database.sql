CREATE DATABASE IF NOT EXISTS cisc3003_paper02_c CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cisc3003_paper02_c;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    activation_token VARCHAR(64),
    reset_token_hash VARCHAR(255),
    reset_token_expires_at DATETIME,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
