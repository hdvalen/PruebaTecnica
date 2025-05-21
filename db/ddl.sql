CREATE DATABASE IF NOT EXISTS pruebaTecnica;
USE pruebaTecnica;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  contrasena VARCHAR(255),
  fecha_nacimiento DATE,
  genero VARCHAR(20),
  pais VARCHAR(100),
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
