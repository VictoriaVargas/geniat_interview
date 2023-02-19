-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2023 a las 00:34:09
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `geniat_db`
--
CREATE DATABASE IF NOT EXISTS `geniat_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `geniat_db`;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `datauser`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `datauser`;
CREATE TABLE `datauser` (
`userid` int(11)
,`username` varchar(15)
,`userlastname` varchar(60)
,`useremail` varchar(60)
,`userpassword` varchar(10)
,`useridrole` varchar(15)
,`rolename` varchar(30)
,`loginpermission` tinyint(1)
,`selectpermission` tinyint(1)
,`createpermission` tinyint(1)
,`updatepermission` tinyint(1)
,`deletepermission` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `login` tinyint(1) NOT NULL,
  `select` tinyint(1) NOT NULL,
  `create` tinyint(1) NOT NULL,
  `update` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `login`, `select`, `create`, `update`, `delete`, `id_role`) VALUES
(1, 1, 1, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Testing Role');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'Testing', 'Geniat', 'testing_geniat@test.com', '', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_token`
--

DROP TABLE IF EXISTS `users_token`;
CREATE TABLE `users_token` (
  `id_token` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura para la vista `datauser`
--
DROP TABLE IF EXISTS `datauser`;

DROP VIEW IF EXISTS `datauser`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datauser`  AS SELECT `users`.`id` AS `userid`, `users`.`name` AS `username`, `users`.`last_name` AS `userlastname`, `users`.`email` AS `useremail`, `users`.`password` AS `userpassword`, `users`.`role` AS `useridrole`, `roles`.`name` AS `rolename`, `permissions`.`login` AS `loginpermission`, `permissions`.`select` AS `selectpermission`, `permissions`.`create` AS `createpermission`, `permissions`.`update` AS `updatepermission`, `permissions`.`delete` AS `deletepermission` FROM ((`users` join `roles` on(`users`.`role` = `roles`.`id`)) join `permissions` on(`roles`.`id` = `permissions`.`id_role`))  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_token`
--
ALTER TABLE `users_token`
  ADD PRIMARY KEY (`id_token`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users_token`
--
ALTER TABLE `users_token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
