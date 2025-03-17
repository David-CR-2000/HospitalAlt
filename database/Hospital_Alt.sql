-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS `Hospital_Alt`;
USE `Hospital_Alt`;

-- Tabla de Pacientes
CREATE TABLE `pacientes` (
  `id_paciente` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido1` VARCHAR(50) NOT NULL,
  `apellido2` VARCHAR(50),
  `DNI` VARCHAR(9) UNIQUE NOT NULL,
  `TLF` VARCHAR(15) NOT NULL,
  `num_poliza` VARCHAR(20) NOT NULL,
  `datos_biometricos` TEXT,
  `estado` ENUM('ingresado', 'alta') DEFAULT 'alta',
  `implante` VARCHAR(50)
);

-- Tabla de Personal Médico
CREATE TABLE `personal_medico` (
  `id_medico` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido1` VARCHAR(50) NOT NULL,
  `apellido2` VARCHAR(50),
  `DNI` VARCHAR(9) UNIQUE NOT NULL,
  `TLF` VARCHAR(15) NOT NULL,
  `num_poliza` VARCHAR(20),
  `datos_biometricos` TEXT,
  `especialidad` VARCHAR(50) NOT NULL,
  `turno` ENUM('mañana', 'tarde', 'noche') NOT NULL
);

-- Tabla de Equipamiento Tecnológico
CREATE TABLE `equipamiento_tecnologico` (
  `id_equipo` INT AUTO_INCREMENT PRIMARY KEY,
  `Nombre_Dispositivo` VARCHAR(100) NOT NULL,
  `Funcion` TEXT NOT NULL,
  `Estado` ENUM('operativo', 'mantenimiento', 'inactivo') DEFAULT 'operativo',
  `Ultimo_Mantenimiento` DATE
);

-- Tabla de Implantes
CREATE TABLE `implantes` (
  `id_implante` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL
);

-- Resto de tablas (ejemplo)
CREATE TABLE `drones_medicos` (
  `id_dron` INT AUTO_INCREMENT PRIMARY KEY,
  `Modelo` VARCHAR(50) NOT NULL,
  `Capacidad` VARCHAR(100) NOT NULL,
  `Autonomia` VARCHAR(50) NOT NULL,
  `Ubicacion_Actual` VARCHAR(100) NOT NULL
);

-- ... (Agregar el resto de tablas según especificaciones)