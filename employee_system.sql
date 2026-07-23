-- ==========================================================
--  EMPLOYEE SYSTEM DATABASE
--  Run this in phpMyAdmin / MySQL CLI on PC2 / Webserver 2
-- ==========================================================

CREATE DATABASE IF NOT EXISTS employee_db;
USE employee_db;

CREATE TABLE IF NOT EXISTS employees (
    employee_id   INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    position      VARCHAR(100) DEFAULT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

TRUNCATE TABLE employees;

INSERT INTO employees (employee_id, employee_name, position) VALUES
(1001, 'Hector Morales', 'Front Desk Officer'),
(1002, 'Daniel Jonasan', 'Housekeeping Supervisor'),
(1003, 'Ivan Morales', 'Concierge'),
(1004, 'Aiyana Ibarra', 'Night Auditor'),
(1005, 'Vincent Orpesa', 'Front Desk Officer'),
(1006, 'Heavely Joy Fuentes', 'Manager'),
(1007, 'Jenifer Talavera', 'Supervisor'),
(1008, 'Christian Rylle Aclon', 'Bell Captain'),
(1009, 'Kim Galendez', 'Housekeeping Staff');

ALTER TABLE employees AUTO_INCREMENT = 1010;
