-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-03-2026 a las 17:03:31
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm_doctoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointments`
--

CREATE TABLE `appointments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `doctor_id` int DEFAULT NULL,
  `patient_id` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `contact_phone` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `source_channel` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'crm',
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `title`, `doctor_id`, `patient_id`, `created_by`, `start_date`, `end_date`, `contact_phone`, `status`, `source_channel`, `description`, `created_at`) VALUES
(242, 5, 'Consulta General #1', 2, 5, 5, '2026-03-10 08:00:00', '2026-03-10 08:30:00', '+57 300 100 1005', 'pending', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(243, 6, 'Control Mensual #2', 3, 6, 3, '2026-03-10 11:00:00', '2026-03-10 11:30:00', '+57 300 100 1006', 'approved', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(244, 7, 'Seguimiento #3', 4, 7, 7, '2026-03-10 14:00:00', '2026-03-10 14:30:00', '+57 300 100 1007', 'approved', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(245, 8, 'Chequeo #4', 11, 8, 11, '2026-03-10 17:00:00', '2026-03-10 17:30:00', '+57 300 100 1008', 'approved', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(246, 9, 'Teleconsulta #5', 12, 9, 9, '2026-03-10 20:00:00', '2026-03-10 20:30:00', '+57 300 100 1009', 'pending', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(247, 10, 'Revisión #6', 2, 10, 2, '2026-03-10 23:00:00', '2026-03-10 23:30:00', '+57 300 100 1010', 'rejected', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(248, 5, 'Consulta Especializada #7', 3, 5, 5, '2026-03-11 02:00:00', '2026-03-11 02:30:00', '+57 300 100 1005', 'completed', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(249, 6, 'Consulta General #8', 4, 6, 4, '2026-03-11 05:00:00', '2026-03-11 05:30:00', '+57 300 100 1006', 'pending', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(250, 7, 'Control Mensual #9', 11, 7, 7, '2026-03-11 08:00:00', '2026-03-11 08:30:00', '+57 300 100 1007', 'approved', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(251, 8, 'Seguimiento #10', 12, 8, 12, '2026-03-11 11:00:00', '2026-03-11 11:30:00', '+57 300 100 1008', 'approved', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(252, 9, 'Chequeo #11', 2, 9, 9, '2026-03-11 14:00:00', '2026-03-11 14:30:00', '+57 300 100 1009', 'approved', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(253, 10, 'Teleconsulta #12', 3, 10, 3, '2026-03-11 17:00:00', '2026-03-11 17:30:00', '+57 300 100 1010', 'pending', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(254, 5, 'Revisión #13', 4, 5, 5, '2026-03-11 20:00:00', '2026-03-11 20:30:00', '+57 300 100 1005', 'rejected', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(255, 6, 'Consulta Especializada #14', 11, 6, 11, '2026-03-11 23:00:00', '2026-03-11 23:30:00', '+57 300 100 1006', 'completed', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(256, 7, 'Consulta General #15', 12, 7, 7, '2026-03-12 02:00:00', '2026-03-12 02:30:00', '+57 300 100 1007', 'pending', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(257, 8, 'Control Mensual #16', 2, 8, 2, '2026-03-12 05:00:00', '2026-03-12 05:30:00', '+57 300 100 1008', 'approved', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(258, 9, 'Seguimiento #17', 3, 9, 9, '2026-03-12 08:00:00', '2026-03-12 08:30:00', '+57 300 100 1009', 'approved', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(259, 10, 'Chequeo #18', 4, 10, 4, '2026-03-12 11:00:00', '2026-03-12 11:30:00', '+57 300 100 1010', 'approved', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(260, 5, 'Teleconsulta #19', 11, 5, 5, '2026-03-12 14:00:00', '2026-03-12 14:30:00', '+57 300 100 1005', 'pending', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(261, 6, 'Revisión #20', 12, 6, 12, '2026-03-12 17:00:00', '2026-03-12 17:30:00', '+57 300 100 1006', 'rejected', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(262, 7, 'Consulta Especializada #21', 2, 7, 7, '2026-03-12 20:00:00', '2026-03-12 20:30:00', '+57 300 100 1007', 'completed', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(263, 8, 'Consulta General #22', 3, 8, 3, '2026-03-12 23:00:00', '2026-03-12 23:30:00', '+57 300 100 1008', 'pending', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(264, 9, 'Control Mensual #23', 4, 9, 9, '2026-03-13 02:00:00', '2026-03-13 02:30:00', '+57 300 100 1009', 'approved', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(265, 10, 'Seguimiento #24', 11, 10, 11, '2026-03-13 05:00:00', '2026-03-13 05:30:00', '+57 300 100 1010', 'approved', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(266, 5, 'Chequeo #25', 12, 5, 5, '2026-03-13 08:00:00', '2026-03-13 08:30:00', '+57 300 100 1005', 'approved', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(267, 6, 'Teleconsulta #26', 2, 6, 2, '2026-03-13 11:00:00', '2026-03-13 11:30:00', '+57 300 100 1006', 'pending', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(268, 7, 'Revisión #27', 3, 7, 7, '2026-03-13 14:00:00', '2026-03-13 14:30:00', '+57 300 100 1007', 'rejected', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(269, 8, 'Consulta Especializada #28', 4, 8, 4, '2026-03-13 17:00:00', '2026-03-13 17:30:00', '+57 300 100 1008', 'completed', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(270, 9, 'Consulta General #29', 11, 9, 9, '2026-03-13 20:00:00', '2026-03-13 20:30:00', '+57 300 100 1009', 'pending', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(271, 10, 'Control Mensual #30', 12, 10, 12, '2026-03-13 23:00:00', '2026-03-13 23:30:00', '+57 300 100 1010', 'approved', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(272, 5, 'Seguimiento #31', 2, 5, 5, '2026-03-14 02:00:00', '2026-03-14 02:30:00', '+57 300 100 1005', 'approved', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(273, 6, 'Chequeo #32', 3, 6, 3, '2026-03-14 05:00:00', '2026-03-14 05:30:00', '+57 300 100 1006', 'approved', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(274, 7, 'Teleconsulta #33', 4, 7, 7, '2026-03-14 08:00:00', '2026-03-14 08:30:00', '+57 300 100 1007', 'pending', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(275, 8, 'Revisión #34', 11, 8, 11, '2026-03-14 11:00:00', '2026-03-14 11:30:00', '+57 300 100 1008', 'rejected', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(276, 9, 'Consulta Especializada #35', 12, 9, 9, '2026-03-14 14:00:00', '2026-03-14 14:30:00', '+57 300 100 1009', 'completed', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(277, 10, 'Consulta General #36', 2, 10, 2, '2026-03-14 17:00:00', '2026-03-14 17:30:00', '+57 300 100 1010', 'pending', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(278, 5, 'Control Mensual #37', 3, 5, 5, '2026-03-14 20:00:00', '2026-03-14 20:30:00', '+57 300 100 1005', 'approved', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(279, 6, 'Seguimiento #38', 4, 6, 4, '2026-03-14 23:00:00', '2026-03-14 23:30:00', '+57 300 100 1006', 'approved', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(280, 7, 'Chequeo #39', 11, 7, 7, '2026-03-15 02:00:00', '2026-03-15 02:30:00', '+57 300 100 1007', 'approved', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(281, 8, 'Teleconsulta #40', 12, 8, 12, '2026-03-15 05:00:00', '2026-03-15 05:30:00', '+57 300 100 1008', 'pending', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(282, 9, 'Revisión #41', 2, 9, 9, '2026-03-15 08:00:00', '2026-03-15 08:30:00', '+57 300 100 1009', 'rejected', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(283, 10, 'Consulta Especializada #42', 3, 10, 3, '2026-03-15 11:00:00', '2026-03-15 11:30:00', '+57 300 100 1010', 'completed', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(284, 5, 'Consulta General #43', 4, 5, 5, '2026-03-15 14:00:00', '2026-03-15 14:30:00', '+57 300 100 1005', 'pending', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(285, 6, 'Control Mensual #44', 11, 6, 11, '2026-03-15 17:00:00', '2026-03-15 17:30:00', '+57 300 100 1006', 'approved', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(286, 7, 'Seguimiento #45', 12, 7, 7, '2026-03-15 20:00:00', '2026-03-15 20:30:00', '+57 300 100 1007', 'approved', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(287, 8, 'Chequeo #46', 2, 8, 2, '2026-03-15 23:00:00', '2026-03-15 23:30:00', '+57 300 100 1008', 'approved', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(288, 9, 'Teleconsulta #47', 3, 9, 9, '2026-03-16 02:00:00', '2026-03-16 02:30:00', '+57 300 100 1009', 'pending', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(289, 10, 'Revisión #48', 4, 10, 4, '2026-03-16 05:00:00', '2026-03-16 05:30:00', '+57 300 100 1010', 'rejected', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(290, 5, 'Consulta Especializada #49', 11, 5, 5, '2026-03-16 08:00:00', '2026-03-16 08:30:00', '+57 300 100 1005', 'completed', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(291, 6, 'Consulta General #50', 12, 6, 12, '2026-03-16 11:00:00', '2026-03-16 11:30:00', '+57 300 100 1006', 'pending', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(292, 7, 'Control Mensual #51', 2, 7, 7, '2026-03-16 14:00:00', '2026-03-16 14:30:00', '+57 300 100 1007', 'approved', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(293, 8, 'Seguimiento #52', 3, 8, 3, '2026-03-16 17:00:00', '2026-03-16 17:30:00', '+57 300 100 1008', 'approved', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(294, 9, 'Chequeo #53', 4, 9, 9, '2026-03-16 20:00:00', '2026-03-16 20:30:00', '+57 300 100 1009', 'approved', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(295, 10, 'Teleconsulta #54', 11, 10, 11, '2026-03-16 23:00:00', '2026-03-16 23:30:00', '+57 300 100 1010', 'pending', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(296, 5, 'Revisión #55', 12, 5, 5, '2026-03-17 02:00:00', '2026-03-17 02:30:00', '+57 300 100 1005', 'rejected', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(297, 6, 'Consulta Especializada #56', 2, 6, 2, '2026-03-17 05:00:00', '2026-03-17 05:30:00', '+57 300 100 1006', 'completed', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(298, 7, 'Consulta General #57', 3, 7, 7, '2026-03-17 08:00:00', '2026-03-17 08:30:00', '+57 300 100 1007', 'pending', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(299, 8, 'Control Mensual #58', 4, 8, 4, '2026-03-17 11:00:00', '2026-03-17 11:30:00', '+57 300 100 1008', 'approved', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(300, 9, 'Seguimiento #59', 11, 9, 9, '2026-03-17 14:00:00', '2026-03-17 14:30:00', '+57 300 100 1009', 'approved', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(301, 10, 'Chequeo #60', 12, 10, 12, '2026-03-17 17:00:00', '2026-03-17 17:30:00', '+57 300 100 1010', 'approved', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(302, 5, 'Teleconsulta #61', 2, 5, 5, '2026-03-17 20:00:00', '2026-03-17 20:30:00', '+57 300 100 1005', 'pending', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(303, 6, 'Revisión #62', 3, 6, 3, '2026-03-17 23:00:00', '2026-03-17 23:30:00', '+57 300 100 1006', 'rejected', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(304, 7, 'Consulta Especializada #63', 4, 7, 7, '2026-03-18 02:00:00', '2026-03-18 02:30:00', '+57 300 100 1007', 'completed', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(305, 8, 'Consulta General #64', 11, 8, 11, '2026-03-18 05:00:00', '2026-03-18 05:30:00', '+57 300 100 1008', 'pending', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(306, 9, 'Control Mensual #65', 12, 9, 9, '2026-03-18 08:00:00', '2026-03-18 08:30:00', '+57 300 100 1009', 'approved', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(307, 10, 'Seguimiento #66', 2, 10, 2, '2026-03-18 11:00:00', '2026-03-18 11:30:00', '+57 300 100 1010', 'approved', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(308, 5, 'Chequeo #67', 3, 5, 5, '2026-03-18 14:00:00', '2026-03-18 14:30:00', '+57 300 100 1005', 'approved', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(309, 6, 'Teleconsulta #68', 4, 6, 4, '2026-03-18 17:00:00', '2026-03-18 17:30:00', '+57 300 100 1006', 'pending', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30'),
(310, 7, 'Revisión #69', 11, 7, 7, '2026-03-18 20:00:00', '2026-03-18 20:30:00', '+57 300 100 1007', 'rejected', 'crm', 'Dolor persistente', '2026-03-14 16:28:30'),
(311, 8, 'Consulta Especializada #70', 12, 8, 12, '2026-03-18 23:00:00', '2026-03-18 23:30:00', '+57 300 100 1008', 'completed', 'web', 'Chequeo anual', '2026-03-14 16:28:30'),
(312, 9, 'Consulta General #71', 2, 9, 9, '2026-03-19 02:00:00', '2026-03-19 02:30:00', '+57 300 100 1009', 'pending', 'whatsapp', 'Consulta rápida', '2026-03-14 16:28:30'),
(313, 10, 'Control Mensual #72', 3, 10, 3, '2026-03-19 05:00:00', '2026-03-19 05:30:00', '+57 300 100 1010', 'approved', 'chatbot', 'Revisión integral', '2026-03-14 16:28:30'),
(314, 5, 'Seguimiento #73', 4, 5, 5, '2026-03-19 08:00:00', '2026-03-19 08:30:00', '+57 300 100 1005', 'approved', 'crm', 'Control clínico', '2026-03-14 16:28:30'),
(315, 6, 'Chequeo #74', 11, 6, 11, '2026-03-19 11:00:00', '2026-03-19 11:30:00', '+57 300 100 1006', 'approved', 'web', 'Validación de resultados', '2026-03-14 16:28:30'),
(316, 7, 'Teleconsulta #75', 12, 7, 7, '2026-03-19 14:00:00', '2026-03-19 14:30:00', '+57 300 100 1007', 'pending', 'whatsapp', 'Dolor persistente', '2026-03-14 16:28:30'),
(317, 8, 'Revisión #76', 2, 8, 2, '2026-03-19 17:00:00', '2026-03-19 17:30:00', '+57 300 100 1008', 'rejected', 'chatbot', 'Chequeo anual', '2026-03-14 16:28:30'),
(318, 9, 'Consulta Especializada #77', 3, 9, 9, '2026-03-19 20:00:00', '2026-03-19 20:30:00', '+57 300 100 1009', 'completed', 'crm', 'Consulta rápida', '2026-03-14 16:28:30'),
(319, 10, 'Consulta General #78', 4, 10, 4, '2026-03-19 23:00:00', '2026-03-19 23:30:00', '+57 300 100 1010', 'pending', 'web', 'Revisión integral', '2026-03-14 16:28:30'),
(320, 5, 'Control Mensual #79', 11, 5, 5, '2026-03-20 02:00:00', '2026-03-20 02:30:00', '+57 300 100 1005', 'approved', 'whatsapp', 'Control clínico', '2026-03-14 16:28:30'),
(321, 6, 'Seguimiento #80', 12, 6, 12, '2026-03-20 05:00:00', '2026-03-20 05:30:00', '+57 300 100 1006', 'approved', 'chatbot', 'Validación de resultados', '2026-03-14 16:28:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(42, 5, 2, 'Hola doctor, quiero cambiar la hora', '2026-03-14 16:28:30'),
(43, 2, 5, 'Perfecto, te muevo a las 10:30', '2026-03-14 16:28:30'),
(44, 6, 3, 'Tengo una pregunta de mi receta', '2026-03-14 16:28:30'),
(45, 3, 6, 'Te respondo en unos minutos', '2026-03-14 16:28:30'),
(46, 7, 4, '¿La consulta sigue confirmada?', '2026-03-14 16:28:30'),
(47, 4, 7, 'Sí, nos vemos hoy', '2026-03-14 16:28:30'),
(48, 8, 11, 'Necesito una teleconsulta', '2026-03-14 16:28:30'),
(49, 11, 8, 'Listo, te agendo para mañana', '2026-03-14 16:28:30'),
(50, 9, 12, 'Quiero revisión general', '2026-03-14 16:28:30'),
(51, 12, 9, 'Te comparto horarios disponibles', '2026-03-14 16:28:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','medico','cliente') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cliente',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `password`, `created_at`) VALUES
(1, 'Administrador CRM', 'admin@gmail.com', '+57 300 100 0001', 'admin', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 14:02:01'),
(2, 'Dr. Gregory House', 'house@doctoria.com', '+57 300 100 0002', 'medico', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(3, 'Dra. Elena Torres', 'elena@doctoria.com', '+57 300 100 0003', 'medico', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(4, 'Dr. Alfredo Hidalgo', 'alfredo@doctoria.com', '+57 300 100 0004', 'medico', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(5, 'Pepe Paciente', 'pepe@doctoria.com', '+57 300 100 0005', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(6, 'Ana Suarez', 'ana@doctoria.com', '+57 300 100 0006', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(7, 'Carlos Rivas', 'carlos@doctoria.com', '+57 300 100 0007', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(8, 'Marta Perez', 'marta@doctoria.com', '+57 300 100 0008', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(9, 'Lucia Mendez', 'lucia@doctoria.com', '+57 300 100 0009', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(10, 'Jorge Almanza', 'jorge@doctoria.com', '+57 300 100 0010', 'cliente', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(11, 'Dra. Sofia Rosales', 'sofia@doctoria.com', '+57 300 100 0011', 'medico', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20'),
(12, 'Dr. Juan Pardo', 'juan@doctoria.com', '+57 300 100 0012', 'medico', '$2y$10$MIeGyqx0eRCRig576t44Ueqc.Et/d53P2ZpYlcG9/fduHm9fd9Soe', '2026-03-14 15:12:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT de la tabla `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
