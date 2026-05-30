CREATE DATABASE IF NOT EXISTS jabulani_eventos;
USE jabulani_eventos;

CREATE TABLE Usuarios (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nomeUsuario VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'participante') DEFAULT 'participante', 
    registroCriado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    local VARCHAR(255),
    dataEvento DATE,
    registroCriado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Usuarios_Eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT,
    idEvento INT,
    registroCriado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE, 
    FOREIGN KEY (idEvento) REFERENCES Eventos(id) ON DELETE CASCADE[cite: 1]
);



INSERT INTO Usuarios (nomeUsuario, email, senha, tipo) 
VALUES ('Admin Jabulani', 'admin@jabulani.com', '$2y$10$wK8rDk9L6pM1.mF7qO2Z9.Ym7vCEx6S6j1vE8K7oY1234567890aa', 'admin');