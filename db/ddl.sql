CREATE DATABASE registro_usuarios;

USE registro_usuarios;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  genero VARCHAR(20) NOT NULL,
  pais VARCHAR(50) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
