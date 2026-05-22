-- TASKR — MySQL Setup
-- Run this once before launching todo.php

CREATE DATABASE IF NOT EXISTS taskr
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE taskr;

CREATE TABLE IF NOT EXISTS tasks (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  text     VARCHAR(200)                         NOT NULL,
  done     TINYINT(1)    DEFAULT 0              NOT NULL,
  priority ENUM('high','medium','low')          DEFAULT 'medium',
  created  INT                                  NOT NULL,
  INDEX idx_done    (done),
  INDEX idx_created (created)
);
