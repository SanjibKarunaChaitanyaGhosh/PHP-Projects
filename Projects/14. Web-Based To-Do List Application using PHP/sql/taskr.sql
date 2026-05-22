CREATE DATABASE taskr;

USE taskr;

CREATE TABLE tasks(

    id INT AUTO_INCREMENT PRIMARY KEY,

    text VARCHAR(255) NOT NULL,

    priority ENUM('high','medium','low') DEFAULT 'medium',

    done BOOLEAN DEFAULT 0,

    created BIGINT NOT NULL
);