-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 19 2022 г., 21:27
-- Версия сервера: 5.5.62
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'название категории',
  `description` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'описание категории',
  `parent_id` int(15) NOT NULL DEFAULT '0' COMMENT 'id родителя из этой же таблицы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Дерево данных';

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`, `description`, `parent_id`) VALUES
(1, 'Уровень 1', 'Тут описание категории', 0),
(2, 'Уровень 1', '', 0),
(3, 'Уровень 1', '', 0),
(4, 'Уровень 1', '', 0),
(5, 'Уровень 2', 'Тут второе описание категории', 1),
(6, 'Уровень 2', '', 1),
(7, 'Уровень 2', '', 1),
(8, 'Уровень 2', '', 2),
(9, 'Уровень 3', '', 5),
(10, 'Уровень 3', '', 5),
(11, 'прбпобпоб', 'Тут третье описание категории', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'логин пользователя',
  `pass` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'пароль пользователя',
  `name` varchar(555) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'имя пользователя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `pass`, `name`) VALUES
(1, 'admin', '$2y$10$L0Qlxx2tKmR6w2JPJfMbt.HR.uwHXq3S0.ZZlET.4psSP/SKqmYEu', 'Администратор');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
