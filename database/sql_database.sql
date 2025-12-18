DROP DATABASE dbPointSystem;
CREATE DATABASE dbPointSystem;

USE dbPointSystem;

CREATE TABLE users (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  google_id VARCHAR(255) NULL
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'manager', 'employee') DEFAULT 'employee',
  position VARCHAR(100) DEFAULT 'Operador',
  status ENUM('Ativo','Inativo') DEFAULT 'Ativo',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE time_punches (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT NOT NULL,
  punch_type ENUM('entrada','saida','pausa_inicio','pausa_fim') NOT NULL,
  recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  lat DOUBLE(10,7) NOT NULL,
  lng DOUBLE(10,7) NOT NULL,
  accuracy_m DECIMAL(8,2) NULL,
  formatted_address TEXT NULL,
  google_place_id VARCHAR(255) NULL,
  raw_api_response JSON NULL,
  ip_address VARCHAR(45) NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
