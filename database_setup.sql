-- Create the database
CREATE DATABASE IF NOT EXISTS course_registration;
USE course_registration;

-- Create the registrations table
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    course_id INT NOT NULL,
    session VARCHAR(20) NOT NULL,
    comments TEXT,
    registration_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 