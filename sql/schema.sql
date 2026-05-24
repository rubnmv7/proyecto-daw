-- Ejecutar en phpMyAdmin o MySQL CLI para crear la BD y tablas, si es en el hosting no poner las 4 primeras lineas

CREATE DATABASE IF NOT EXISTS Fanfia
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE Fanfia;

-- ── Usuarios registrados ──
CREATE TABLE IF NOT EXISTS usuarios (
  ID_usuario    INT AUTO_INCREMENT PRIMARY KEY,
  email         VARCHAR(100) NOT NULL UNIQUE,
  contraseña    VARCHAR(255) NOT NULL,
  nombre_usuario VARCHAR(30) NOT NULL UNIQUE,
  tipo_usuario  ENUM('Normal', 'Admin') DEFAULT 'Normal',
  foto_perfil   VARCHAR(500) DEFAULT NULL,
  fecha_creacion DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Fanfics creados por usuarios ──
CREATE TABLE IF NOT EXISTS fanfics (
  ID_fanfic           INT AUTO_INCREMENT PRIMARY KEY,
  ID_usuario          INT NOT NULL,
  titulo              VARCHAR(200) NOT NULL,
  descripcion         TEXT DEFAULT NULL,
  estado              ENUM('Borrador', 'En progreso', 'Terminado') DEFAULT 'Borrador',
  cantidad_capitulos  INT DEFAULT 1,
  fecha_actualizacion DATE NOT NULL,
  FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Capítulos de cada fanfic ──
CREATE TABLE IF NOT EXISTS capitulos (
  ID_capitulo     INT AUTO_INCREMENT PRIMARY KEY,
  ID_fanfic       INT NOT NULL,
  titulo          VARCHAR(200) NOT NULL,
  contenido       LONGTEXT NOT NULL,
  numero_capitulo INT NOT NULL,
  longitud        INT DEFAULT 0,
  FOREIGN KEY (ID_fanfic) REFERENCES fanfics(ID_fanfic) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Valoraciones de fanfics ──
CREATE TABLE IF NOT EXISTS valoraciones (
  ID_valoracion   INT AUTO_INCREMENT PRIMARY KEY,
  ID_fanfic       INT NOT NULL,
  fecha_valoracion DATE NOT NULL,
  comentario      TEXT DEFAULT NULL,
  tipo_valoracion ENUM('Positiva', 'Negativa') NOT NULL,
  FOREIGN KEY (ID_fanfic) REFERENCES fanfics(ID_fanfic) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Géneros disponibles ──
CREATE TABLE IF NOT EXISTS generos (
  ID_genero     INT AUTO_INCREMENT PRIMARY KEY,
  nombre_genero VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── Relación N:M entre fanfics y géneros ──
CREATE TABLE IF NOT EXISTS tienen (
  ID_fanfic INT NOT NULL,
  ID_genero INT NOT NULL,
  PRIMARY KEY (ID_fanfic, ID_genero),
  FOREIGN KEY (ID_fanfic) REFERENCES fanfics(ID_fanfic) ON DELETE CASCADE,
  FOREIGN KEY (ID_genero) REFERENCES generos(ID_genero) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
