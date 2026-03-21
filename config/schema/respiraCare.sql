
start transaction;

-- Database Setup
SET FOREIGN_KEY_CHECKS = 0;
DROP DATABASE IF EXISTS Respiracare_db;
CREATE DATABASE Respiracare_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE Respiracare_db;

-- 1. Users Table
CREATE TABLE users (
   id INT AUTO_INCREMENT PRIMARY KEY,
   first_name VARCHAR(255) NOT NULL,
   last_name VARCHAR(255) NOT NULL,
   email VARCHAR(255) NOT NULL UNIQUE,
   password VARCHAR(255) NOT NULL,
   role VARCHAR(50) NOT NULL,
   created DATETIME,
   modified DATETIME,
   INDEX idx_user_email (email),
   INDEX idx_user_role (role)
) ENGINE=InnoDB;

-- 2. Clinicians Table
CREATE TABLE clinicians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Patients Table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    clinician_id INT NULL,
    dob DATE,
    sex VARCHAR(50),
    phone VARCHAR(50),
    notes TEXT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (clinician_id) REFERENCES clinicians(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Bookings Table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    clinician_id INT NOT NULL,
    notes TEXT NULL,
    scheduled_date DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (clinician_id) REFERENCES clinicians(id) ON DELETE CASCADE,
    INDEX idx_booking_date (scheduled_date),
    INDEX idx_booking_status (status)
) ENGINE=InnoDB;

-- 5. Reminders Table
CREATE TABLE reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    clinician_id INT NULL,
    message TEXT NOT NULL,
    sent_at DATETIME NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (clinician_id) REFERENCES clinicians(id) ON DELETE SET NULL,
    INDEX idx_reminder_sent (sent_at)
) ENGINE=InnoDB;

-- 6. Contact Messages Table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    status VARCHAR(50),
    message TEXT NOT NULL,
    sent_at DATETIME NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE SET NULL,
    INDEX idx_contact_status (status)
) ENGINE=InnoDB;

-- 7. AI Insights Table
CREATE TABLE ai_insights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    description TEXT NOT NULL,
    risk_level INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    INDEX idx_ai_risk (risk_level)
) ENGINE=InnoDB;

-- 8. Patient Measurements Table
CREATE TABLE patient_measurements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    measured_at DATETIME NOT NULL,
    spo2 INT NULL,
    heart_rate INT NULL,
    temperature FLOAT NULL,
    respiratory_rate INT NULL,
    peak_flow INT NULL,
    blood_pressure_systolic INT NULL,
    blood_pressure_diastolic INT NULL,
    notes TEXT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    INDEX idx_measurement_date (measured_at)
) ENGINE=InnoDB;

-- 9. Symptom Logs
CREATE TABLE symptom_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    description TEXT NULL,
    logged_at DATETIME NOT NULL,
    notes TEXT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    INDEX idx_symptom_logged_at (logged_at)
) ENGINE=InnoDB;

-- 10. Symptom Types
CREATE TABLE symptom_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    INDEX idx_symptom_name (name)
) ENGINE=InnoDB;

-- 11. Symptom Logs & Types Bridge Table
CREATE TABLE symptom_logs_symptom_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symptom_log_id INT NOT NULL,
    symptom_type_id INT NOT NULL,
    severity INT NULL,
    present BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (symptom_log_id) REFERENCES symptom_logs(id) ON DELETE CASCADE,
    FOREIGN KEY (symptom_type_id) REFERENCES symptom_types(id) ON DELETE CASCADE,
    UNIQUE INDEX idx_unique_symptom_log (symptom_log_id, symptom_type_id)
) ENGINE=InnoDB;

-- 12. Resources Table
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    published_date DATE NULL,
    type VARCHAR(50) NOT NULL,
    url_link VARCHAR(255) NULL,
    status VARCHAR(50) NOT NULL,
    created DATETIME,
    modified DATETIME,
    INDEX idx_resource_type (type),
    INDEX idx_resource_status (status)
) ENGINE=InnoDB;

-- Finish Transaction
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
