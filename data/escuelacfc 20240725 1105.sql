﻿--
-- Script was generated by Devart dbForge Studio for MySQL, Version 8.0.40.0
-- Product home page: http://www.devart.com/dbforge/mysql/studio
-- Script date 25/07/2024 11:05:41
-- Server version: 5.5.5-10.1.40-MariaDB
-- Client version: 4.1
--

-- 
-- Disable foreign keys
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Set SQL mode
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Set character set the client will use to send SQL statements to the server
--
SET NAMES 'utf8';

--
-- Set default database
--
USE escuelacfc;

--
-- Drop table `migration`
--
DROP TABLE IF EXISTS migration;

--
-- Drop table `utilizan`
--
DROP TABLE IF EXISTS utilizan;

--
-- Drop table `instrumentos`
--
DROP TABLE IF EXISTS instrumentos;

--
-- Drop table `auth_assignment`
--
DROP TABLE IF EXISTS auth_assignment;

--
-- Drop table `auth_item_child`
--
DROP TABLE IF EXISTS auth_item_child;

--
-- Drop table `auth_item`
--
DROP TABLE IF EXISTS auth_item;

--
-- Drop table `auth_rule`
--
DROP TABLE IF EXISTS auth_rule;

--
-- Drop table `pasos`
--
DROP TABLE IF EXISTS pasos;

--
-- Drop table `ensenan`
--
DROP TABLE IF EXISTS ensenan;

--
-- Drop table `noticias`
--
DROP TABLE IF EXISTS noticias;

--
-- Drop table `telefonos`
--
DROP TABLE IF EXISTS telefonos;

--
-- Drop table `user`
--
DROP TABLE IF EXISTS user;

--
-- Drop table `usuarios`
--
DROP TABLE IF EXISTS usuarios;

--
-- Drop table `niveles`
--
DROP TABLE IF EXISTS niveles;

--
-- Set default database
--
USE escuelacfc;

--
-- Create table `niveles`
--
CREATE TABLE niveles (
  color varchar(15) NOT NULL,
  descripcion varchar(3000) DEFAULT NULL,
  PRIMARY KEY (color)
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 4096,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create table `usuarios`
--
CREATE TABLE usuarios (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre_apellidos varchar(50) DEFAULT NULL,
  rol varchar(40) DEFAULT NULL,
  fecha_nacimiento date DEFAULT NULL,
  celula varchar(20) DEFAULT NULL,
  fecha_ingreso date DEFAULT NULL,
  fecha_graduacion date DEFAULT NULL,
  foto varchar(255) DEFAULT NULL,
  color varchar(15) DEFAULT NULL,
  username varchar(255) NOT NULL,
  auth_key varchar(32) NOT NULL,
  password_hash varchar(255) NOT NULL,
  password_reset_token varchar(255) DEFAULT NULL,
  email varchar(255) NOT NULL,
  status smallint(6) NOT NULL DEFAULT 10,
  created_at int(11) NOT NULL,
  updated_at int(11) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 5,
AVG_ROW_LENGTH = 4096,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create foreign key
--
ALTER TABLE usuarios
ADD CONSTRAINT fk_usuarios_niveles FOREIGN KEY (color)
REFERENCES niveles (color);


--
-- Create index `email` on table `user`
--
ALTER TABLE usuarios
ADD UNIQUE INDEX email (email);

--
-- Create index `password_reset_token` on table `user`
--
ALTER TABLE usuarios
ADD UNIQUE INDEX password_reset_token (password_reset_token);

--
-- Create index `username` on table `user`
--
ALTER TABLE usuarios
ADD UNIQUE INDEX username (username);

--
-- Create table `telefonos`
--
CREATE TABLE telefonos (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario int(11) DEFAULT NULL,
  telefono varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 4,
AVG_ROW_LENGTH = 8192,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create index `uk_telefono_usuario` on table `telefonos`
--
ALTER TABLE telefonos
ADD UNIQUE INDEX uk_telefono_usuario (usuario, telefono);

--
-- Create foreign key
--
ALTER TABLE telefonos
ADD CONSTRAINT fk_telefonos_usuarios FOREIGN KEY (usuario)
REFERENCES usuarios (id);

--
-- Create table `noticias`
--
CREATE TABLE noticias (
  id int(11) NOT NULL AUTO_INCREMENT,
  fecha_publicacion date DEFAULT NULL,
  contenido varchar(3000) DEFAULT NULL,
  autor int(11) DEFAULT NULL,
  publico tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create foreign key
--
ALTER TABLE noticias
ADD CONSTRAINT fk_noticias_usuarios FOREIGN KEY (id)
REFERENCES usuarios (id);

--
-- Create table `ensenan`
--
CREATE TABLE ensenan (
  id int(11) NOT NULL AUTO_INCREMENT,
  maestra int(11) DEFAULT NULL,
  color varchar(15) DEFAULT NULL,
  funcion varchar(20) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create index `uk_usuarios_niveles` on table `ensenan`
--
ALTER TABLE ensenan
ADD UNIQUE INDEX uk_usuarios_niveles (maestra, color);

--
-- Create foreign key
--
ALTER TABLE ensenan
ADD CONSTRAINT fk_ensenan_niveles FOREIGN KEY (color)
REFERENCES niveles (color);

--
-- Create foreign key
--
ALTER TABLE ensenan
ADD CONSTRAINT fk_ensenan_usuario FOREIGN KEY (maestra)
REFERENCES usuarios (id);

--
-- Create table `pasos`
--
CREATE TABLE pasos (
  id int(11) NOT NULL AUTO_INCREMENT,
  cita_biblica varchar(50) DEFAULT NULL,
  nombre varchar(40) DEFAULT NULL,
  descripcion varchar(3000) DEFAULT NULL,
  imagen varchar(50) DEFAULT NULL,
  color varchar(15) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 41,
AVG_ROW_LENGTH = 1638,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create foreign key
--
ALTER TABLE pasos
ADD CONSTRAINT fk_pasos_niveles FOREIGN KEY (color)
REFERENCES niveles (color);

--
-- Create table `auth_rule`
--
CREATE TABLE auth_rule (
  name varchar(64) NOT NULL,
  data blob DEFAULT NULL,
  created_at int(11) DEFAULT NULL,
  updated_at int(11) DEFAULT NULL,
  PRIMARY KEY (name)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_unicode_ci;

--
-- Create table `auth_item`
--
CREATE TABLE auth_item (
  name varchar(64) NOT NULL,
  type smallint(6) NOT NULL,
  description text DEFAULT NULL,
  rule_name varchar(64) DEFAULT NULL,
  data blob DEFAULT NULL,
  created_at int(11) DEFAULT NULL,
  updated_at int(11) DEFAULT NULL,
  PRIMARY KEY (name)
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 2730,
CHARACTER SET utf8,
COLLATE utf8_unicode_ci;

--
-- Create index `idx-auth_item-type` on table `auth_item`
--
ALTER TABLE auth_item
ADD INDEX `idx-auth_item-type` (type);

--
-- Create foreign key
--
ALTER TABLE auth_item
ADD CONSTRAINT auth_item_ibfk_1 FOREIGN KEY (rule_name)
REFERENCES auth_rule (name) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Create table `auth_item_child`
--
CREATE TABLE auth_item_child (
  parent varchar(64) NOT NULL,
  child varchar(64) NOT NULL,
  PRIMARY KEY (parent, child)
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 4096,
CHARACTER SET utf8,
COLLATE utf8_unicode_ci;

--
-- Create foreign key
--
ALTER TABLE auth_item_child
ADD CONSTRAINT auth_item_child_ibfk_1 FOREIGN KEY (parent)
REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Create foreign key
--
ALTER TABLE auth_item_child
ADD CONSTRAINT auth_item_child_ibfk_2 FOREIGN KEY (child)
REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Create table `auth_assignment`
--
CREATE TABLE auth_assignment (
  item_name varchar(64) NOT NULL,
  user_id varchar(64) NOT NULL,
  created_at int(11) DEFAULT NULL,
  PRIMARY KEY (item_name, user_id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_unicode_ci;

--
-- Create index `idx-auth_assignment-user_id` on table `auth_assignment`
--
ALTER TABLE auth_assignment
ADD INDEX `idx-auth_assignment-user_id` (user_id);

--
-- Create foreign key
--
ALTER TABLE auth_assignment
ADD CONSTRAINT auth_assignment_ibfk_1 FOREIGN KEY (item_name)
REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Create table `instrumentos`
--
CREATE TABLE instrumentos (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(20) DEFAULT NULL,
  significado varchar(3000) DEFAULT NULL,
  cita_biblica varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 5,
AVG_ROW_LENGTH = 4096,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create table `utilizan`
--
CREATE TABLE utilizan (
  id int(11) NOT NULL AUTO_INCREMENT,
  instrumento int(11) DEFAULT NULL,
  paso int(11) DEFAULT NULL,
  video varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

--
-- Create index `uk_instrumentos_pasos` on table `utilizan`
--
ALTER TABLE utilizan
ADD UNIQUE INDEX uk_instrumentos_pasos (instrumento, paso);

--
-- Create foreign key
--
ALTER TABLE utilizan
ADD CONSTRAINT fk_utilizan_instrumentos FOREIGN KEY (instrumento)
REFERENCES instrumentos (id);

--
-- Create foreign key
--
ALTER TABLE utilizan
ADD CONSTRAINT fk_utilizan_pasos FOREIGN KEY (paso)
REFERENCES pasos (id);

--
-- Create table `migration`
--
CREATE TABLE migration (
  version varchar(180) NOT NULL,
  apply_time int(11) DEFAULT NULL,
  PRIMARY KEY (version)
)
ENGINE = INNODB,
AVG_ROW_LENGTH = 3276,
CHARACTER SET latin1,
COLLATE latin1_swedish_ci;

-- 
-- Dumping data for table niveles
--
INSERT INTO niveles VALUES
('Azul', 'Nivel inicial.'),
('Blanco', 'Nivel principiantes.'),
('Rojo', 'Nivel medio.'),
('Rosa', 'Nivel avanzado.');

-- 
-- Dumping data for table auth_rule
--
-- Table escuelacfc.auth_rule does not contain any data (it is empty)

-- 
-- Dumping data for table pasos
--
INSERT INTO pasos VALUES
(1, 'Mateo 28:19', 'El Evangelio Completo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso1.png', 'Azul'),
(2, 'Hechos 1:8', 'Los Hechos', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso2.png', 'Azul'),
(3, 'Colosenses 1:27', 'Esperanza', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso3.png', 'Azul'),
(4, 'Isaías 59:19', 'Bandera', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso4.png', 'Azul'),
(5, 'Salmos 89:34', 'Pacto', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso5.png', 'Azul'),
(6, '2 Samuel 22:34', 'Combate', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso6.png', 'Azul'),
(7, 'Juan 14:12', 'Fe', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso7.png', 'Azul'),
(8, 'Éxodo 25:31', 'El Candelero', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso8.png', 'Azul'),
(9, 'Isaías 22:22', 'Hombro', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso9.png', 'Azul'),
(10, 'Isaías 42:13', 'Marcha', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso10.png', 'Azul'),
(11, 'Salmos 16:9', 'Gloria', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso11.png', 'Blanco'),
(12, 'Salmos 69:30', 'Alabanza', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso12.png', 'Blanco'),
(13, 'Mateo 28:19', 'Trinidad', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso13.png', 'Blanco'),
(14, 'Isaías 62:3', 'Diadema', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso14.png', 'Blanco'),
(15, 'Isaías 55:12', 'Alegría', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso15.png', 'Blanco'),
(16, 'Marcos 11:9', 'Hosanna', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso16.png', 'Blanco'),
(17, 'Salmos 84:7', 'Poder', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso17.png', 'Blanco'),
(18, 'Efesios 2:6', 'Celestial', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso18.png', 'Blanco'),
(19, 'salmos 84:11', 'Protección', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso19.png', 'Blanco'),
(20, 'Salmos 136:12', 'Fortaleza', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso20.png', 'Blanco'),
(21, 'Juan 1:16-17', 'Gracia', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso21.png', 'Rojo'),
(22, 'Salmos 63:7', 'Regocijo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso22.png', 'Rojo'),
(23, 'Salmos 3:3', 'Escudo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso23.png', 'Rojo'),
(24, 'Proverbios 21:21', 'Justicia', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso24.png', 'Rojo'),
(25, 'Salmos 99:5', 'Exaltación', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso25.png', 'Rojo'),
(26, 'Salmos 21:4', 'Vida', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso26.png', 'Rojo'),
(27, 'Job 8:21', 'Júbilo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso27.png', 'Rojo'),
(28, 'Romanos 8:37', 'Más Que Vencedor', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso28.png', 'Rojo'),
(29, 'Salmos 36:5', 'Fidelidad', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso29.png', 'Rojo'),
(30, '2 Conrintios 7:4', 'Consolación y Firmeza', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso30.png', 'Rojo'),
(31, 'Éxodo 14:15', 'Israel Marchad', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso31.png', 'Rosa'),
(32, 'Romanos 13:6', 'Tributo', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso32.png', 'Rosa'),
(33, 'Salmos 108:1', 'Corazón', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso33.png', 'Rosa'),
(34, 'Isaías 40:26', 'Dominio', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso34.png', 'Rosa'),
(35, 'Efesios 6:14-17', 'Armadura', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso35.png', 'Rosa'),
(36, 'Zacarías 9:14', 'Trompeta', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso36.png', 'Rosa'),
(37, 'Salmos 119:45-48', 'Libertad', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso37.png', 'Rosa'),
(38, 'Filipenses 4:4', 'Regocijaos', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso38.png', 'Rosa'),
(39, 'Salmos 100:1-2', 'Alegría', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso39.png', 'Rosa'),
(40, 'Apocalipsis 5:13', 'Honra y Gloria', 'Lorem ipsum dolor sit amet consectetur adipiscing elit vitae pulvinar tempor, a cursus auctor class ultricies vel orci malesuada lacus, donec urna arcu tempus conubia molestie nascetur elementum curae. Tempor malesuada in inceptos montes nullam dignissim luctus et magnis, primis lacinia consequat aliquet potenti non libero fringilla ultrices, class pretium elementum quam netus donec id semper. Egestas vel potenti mauris urna pellentesque mi litora praesent purus inceptos rutrum ad fringilla bibendum ac interdum, nunc vehicula semper mollis morbi primis luctus eu nostra platea duis aenean in id.', 'paso40.png', 'Rosa');

-- 
-- Dumping data for table instrumentos
--
INSERT INTO instrumentos VALUES
(1, 'Pandero', 'Id suscipit erat venenatis cursus felis consequat dignissim non facilisis tristique, vehicula sociosqu semper rhoncus ac aenean hendrerit turpis nullam, primis ad sociis scelerisque nostra magna placerat pulvinar habitant.', 'Salmos 150:4'),
(2, 'Banderas', 'Id suscipit erat venenatis cursus felis consequat dignissim non facilisis tristique, vehicula sociosqu semper rhoncus ac aenean hendrerit turpis nullam, primis ad sociis scelerisque nostra magna placerat pulvinar habitant.', 'Isaías 25:1'),
(3, 'Tabroi', 'Id suscipit erat venenatis cursus felis consequat dignissim non facilisis tristique, vehicula sociosqu semper rhoncus ac aenean hendrerit turpis nullam, primis ad sociis scelerisque nostra magna placerat pulvinar habitant.', 'Éxodo 25:8'),
(4, 'Cinta', 'Id suscipit erat venenatis cursus felis consequat dignissim non facilisis tristique, vehicula sociosqu semper rhoncus ac aenean hendrerit turpis nullam, primis ad sociis scelerisque nostra magna placerat pulvinar habitant.', 'Hechos 13:47');


-- 
-- Dumping data for table auth_item
--
INSERT INTO auth_item VALUES
('/*', 2, NULL, NULL, NULL, 1720642971, 1720642971),
('/usuarios/*', 2, NULL, NULL, NULL, 1720718763, 1720718763),
('admin', 1, 'Acceso a todo', NULL, NULL, 1720719241, 1720719241),
('maestra', 1, 'ver todo alumnos', NULL, NULL, 1720719268, 1720719268),
('permisoAdmin', 2, 'Acceso a todas las urls de la app', NULL, NULL, 1720719102, 1720719102),
('permisoMaestra', 2, 'Tiene acceso para ver las alumnas', NULL, NULL, 1720719165, 1720719165);

-- 
-- Dumping data for table utilizan
--
-- Table escuelacfc.utilizan does not contain any data (it is empty)


-- 
-- Dumping data for table telefonos
--
INSERT INTO telefonos VALUES
(2, 4, '123456789'),
(1, 4, '654321987'),
(3, 4, '654321988');

-- 
-- Dumping data for table noticias
--
-- Table escuelacfc.noticias does not contain any data (it is empty)

-- 
-- Dumping data for table migration
--
INSERT INTO migration VALUES
('m000000_000000_base', 1720630099),
('m140506_102106_rbac_init', 1720631152),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1720631152),
('m180523_151638_rbac_updates_indexes_without_prefix', 1720631152),
('m200409_110543_rbac_update_mssql_trigger', 1720631152),
('m240711_175301_user', 1720720796);

-- 
-- Dumping data for table ensenan
--
-- Table escuelacfc.ensenan does not contain any data (it is empty)

-- 
-- Dumping data for table auth_item_child
--
INSERT INTO auth_item_child VALUES
('admin', 'permisoAdmin'),
('maestra', 'permisoMaestra'),
('permisoAdmin', '/*'),
('permisoMaestra', '/usuarios/*');

-- 
-- Dumping data for table auth_assignment
--
INSERT INTO auth_assignment VALUES
('permisoAdmin', '1', 1721239186);

-- 
-- Restore previous SQL mode
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Enable foreign keys
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;