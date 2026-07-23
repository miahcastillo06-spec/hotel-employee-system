-- ==========================================================
--  HOTEL SYSTEM DATABASE
--  Run this in phpMyAdmin / MySQL CLI on PC1 / Web Server 1
-- ==========================================================
-- Entity: reservation
-- Attributes match the diagram:
--   1. name customer
--   2. check in
--   3. check out
--   4. employee name
--   5. employee id
-- ==========================================================

CREATE DATABASE IF NOT EXISTS hotel_db;
USE hotel_db;

CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name  VARCHAR(100) NOT NULL,
    check_in       DATE NOT NULL,
    check_out      DATE NOT NULL,
    employee_name  VARCHAR(100) NOT NULL,
    employee_id    INT NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
