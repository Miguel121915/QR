CREATE DATABASE IF NOT EXISTS osin;

USE osin;

-- =====================================
-- TABLA PERSONAS
-- =====================================
CREATE TABLE personas (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(150) NOT NULL,

    matricula VARCHAR(50) UNIQUE NOT NULL,

    instrumento VARCHAR(100) NOT NULL,

    categoriaInstrumento VARCHAR(100),

    fechaNacimiento DATE,

    tipo VARCHAR(50),

    nivel VARCHAR(50),

    foto LONGTEXT,

    qrData LONGTEXT,

    entrada VARCHAR(20) DEFAULT '-',

    salida VARCHAR(20) DEFAULT '-',

    fechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =====================================
-- TABLA HISTORIAL
-- =====================================
CREATE TABLE historial (

    id INT AUTO_INCREMENT PRIMARY KEY,

    matricula VARCHAR(50),

    fecha DATE,

    hora TIME,

    tipoRegistro VARCHAR(20),

    FOREIGN KEY (matricula)
    REFERENCES personas(matricula)
    ON DELETE CASCADE

);

-- =====================================
-- TABLA USUARIOS
-- =====================================
CREATE TABLE usuarios (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario VARCHAR(50) UNIQUE,

    password VARCHAR(255)

);

INSERT INTO usuarios(usuario,password)

VALUES

('admin','1234');