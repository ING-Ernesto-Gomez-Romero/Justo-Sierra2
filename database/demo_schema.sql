DROP DATABASE IF EXISTS `justo_sierra_demo`;
CREATE DATABASE `justo_sierra_demo` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `justo_sierra_demo`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `administradores` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_admin` enum('vinculacion','alumnos') NOT NULL DEFAULT 'vinculacion',
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `uq_administradores_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `alumnos` (
  `id_alumno` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `semestre` int DEFAULT NULL,
  `cv_url` varchar(255) DEFAULT NULL,
  `perfil_linkedin` varchar(255) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `uq_alumnos_email` (`email`),
  UNIQUE KEY `uq_alumnos_matricula` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `empresas` (
  `id_empresa` int NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(255) NOT NULL,
  `carreras_afines` text DEFAULT NULL,
  `email_contacto` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `sitio_web` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `estado_validacion` enum('pendiente','aprobada','rechazada') DEFAULT 'pendiente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `es_catalogo_sspp` tinyint(1) DEFAULT 0,
  `vigencia_sspp` date DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `notas_internas` text DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  UNIQUE KEY `uq_empresas_email` (`email_contacto`),
  KEY `idx_estado_validacion` (`estado_validacion`),
  KEY `idx_es_catalogo_sspp` (`es_catalogo_sspp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vacantes` (
  `id_vacante` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo_contrato` enum('tiempo_completo','medio_tiempo','practicas','temporal','proyecto') NOT NULL,
  `modalidad` enum('presencial','remoto','hibrido') NOT NULL,
  `salario_ofrecido` decimal(10,2) DEFAULT NULL,
  `carrera_afin` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `estado` enum('abierta','cerrada') DEFAULT 'abierta',
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_vacante`),
  KEY `idx_vacantes_empresa` (`id_empresa`),
  KEY `idx_vacantes_estado` (`estado`),
  CONSTRAINT `fk_vacantes_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `postulaciones` (
  `id_postulacion` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_vacante` int NOT NULL,
  `fecha_postulacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_postulacion` enum('enviada','vista','en_proceso','aceptada','rechazada') DEFAULT 'enviada',
  `notas_empresa` text DEFAULT NULL,
  PRIMARY KEY (`id_postulacion`),
  UNIQUE KEY `uq_postulacion` (`id_alumno`,`id_vacante`),
  KEY `idx_postulaciones_vacante` (`id_vacante`),
  CONSTRAINT `fk_postulaciones_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `fk_postulaciones_vacante` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solicitudes_sspp` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `estado_tramite` enum('Solicitud Inicial','Formato Enviado','Datos Recibidos','Validado por Teléfono','Aprobado Catálogo','Expirado') DEFAULT 'Solicitud Inicial',
  `fecha_inicio` date NOT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `archivo_solicitud_dir` varchar(255) DEFAULT NULL,
  `archivo_catalogo_generado` varchar(255) DEFAULT NULL,
  `notas_admin` text DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`),
  KEY `idx_solicitudes_empresa` (`id_empresa`),
  KEY `idx_solicitudes_estado` (`estado_tramite`),
  CONSTRAINT `fk_solicitudes_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tramites_servicio_social` (
  `id_tramite` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int NOT NULL,
  `id_postulacion` int NOT NULL,
  `estado_tramite` enum('solicitud_creditos','pago_validado_escolares','etapa_1_iniciada','etapa_1_documentos_entregados','etapa_2_liberacion','finalizado','cancelado') DEFAULT 'solicitud_creditos',
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_pago_validado` datetime DEFAULT NULL,
  `empresa_nombre` varchar(255) DEFAULT NULL,
  `dirigido_a` varchar(255) DEFAULT NULL,
  `cargo_dirigido` varchar(255) DEFAULT NULL,
  `avance_porcentaje` varchar(10) DEFAULT NULL,
  `domicilio` text DEFAULT NULL,
  `telefonos` varchar(100) DEFAULT NULL,
  `programa_ss` varchar(255) DEFAULT NULL,
  `duracion_ss` varchar(100) DEFAULT NULL,
  `tareas_especificas` text DEFAULT NULL,
  `apoyo_economico` varchar(100) DEFAULT NULL,
  `archivo_carta_aceptacion` varchar(255) DEFAULT NULL,
  `evaluacion_empresa_amabilidad` int DEFAULT NULL,
  `evaluacion_empresa_ambiente` int DEFAULT NULL,
  `plantel_tramite` varchar(100) DEFAULT NULL,
  `archivo_evaluacion_desempeno` varchar(255) DEFAULT NULL,
  `archivo_reporte_global` varchar(255) DEFAULT NULL,
  `archivo_carta_terminacion` varchar(255) DEFAULT NULL,
  `comentarios_escolares` text DEFAULT NULL,
  PRIMARY KEY (`id_tramite`),
  UNIQUE KEY `uq_tramite_postulacion` (`id_postulacion`),
  KEY `idx_tramites_alumno` (`id_alumno`),
  CONSTRAINT `fk_tramites_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE CASCADE,
  CONSTRAINT `fk_tramites_postulacion` FOREIGN KEY (`id_postulacion`) REFERENCES `postulaciones` (`id_postulacion`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vistas_vacantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_vacante` int NOT NULL,
  `id_alumno` int DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_vistas_vacante` (`id_vacante`),
  CONSTRAINT `fk_vistas_vacante` FOREIGN KEY (`id_vacante`) REFERENCES `vacantes` (`id_vacante`) ON DELETE CASCADE,
  CONSTRAINT `fk_vistas_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- All demo accounts use the password: Demo123!
INSERT INTO `administradores` (`nombre`, `email`, `password`, `tipo_admin`) VALUES
('Administrador de Vinculación', 'admin.engagement@demo.local', '$2y$10$ngTXWOgY8hlQ0QRPruZArefsaQwHXnTt3Db6fzHrmlweMdBZ2C5qW', 'vinculacion'),
('Administrador de Alumnos', 'admin.students@demo.local', '$2y$10$ngTXWOgY8hlQ0QRPruZArefsaQwHXnTt3Db6fzHrmlweMdBZ2C5qW', 'alumnos');

INSERT INTO `alumnos` (`nombre`, `apellidos`, `email`, `password`, `matricula`, `carrera`, `semestre`) VALUES
('Ana', 'Estudiante Demo', 'student@demo.local', '$2y$10$ngTXWOgY8hlQ0QRPruZArefsaQwHXnTt3Db6fzHrmlweMdBZ2C5qW', 'DEMO001', 'sistemas', 8);

INSERT INTO `empresas` (`nombre_empresa`, `carreras_afines`, `email_contacto`, `password`, `descripcion`, `sitio_web`, `estado_validacion`, `es_catalogo_sspp`, `vigencia_sspp`) VALUES
('NovaTech Demo', 'sistemas,diseno_grafico', 'company@demo.local', '$2y$10$ngTXWOgY8hlQ0QRPruZArefsaQwHXnTt3Db6fzHrmlweMdBZ2C5qW', 'Empresa ficticia utilizada exclusivamente para demostrar las funciones de la plataforma.', 'https://example.com', 'aprobada', 1, DATE_ADD(CURDATE(), INTERVAL 1 YEAR));

INSERT INTO `vacantes` (`id_empresa`, `titulo`, `descripcion`, `tipo_contrato`, `modalidad`, `salario_ofrecido`, `carrera_afin`, `ubicacion`, `estado`) VALUES
(1, 'Desarrollador Backend Junior', 'Vacante ficticia para estudiantes con conocimientos de PHP, SQL y desarrollo web.', 'practicas', 'hibrido', 8000.00, 'sistemas', 'Ciudad de México', 'abierta'),
(1, 'Soporte Técnico', 'Vacante ficticia para apoyar en diagnóstico, documentación y atención de incidencias.', 'medio_tiempo', 'presencial', 7000.00, 'sistemas', 'Ciudad de México', 'abierta'),
(1, 'Diseño Web Junior', 'Vacante ficticia para colaborar en interfaces y contenido web.', 'proyecto', 'remoto', NULL, 'diseno_grafico', 'Remoto', 'cerrada');

INSERT INTO `postulaciones` (`id_alumno`, `id_vacante`, `estado_postulacion`, `notas_empresa`) VALUES
(1, 1, 'en_proceso', 'Perfil de demostración en revisión.');

INSERT INTO `solicitudes_sspp` (`id_empresa`, `estado_tramite`, `fecha_inicio`) VALUES
(1, 'Aprobado Catálogo', CURDATE());

INSERT INTO `vistas_vacantes` (`id_vacante`, `id_alumno`) VALUES
(1, 1), (1, NULL), (2, 1);
