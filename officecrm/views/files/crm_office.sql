-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 06 2016 г., 11:57
-- Версия сервера: 10.1.9-MariaDB
-- Версия PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_crm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `crm_office`
--

CREATE TABLE `crm_office` (
  `of_id` int(11) NOT NULL,
  `of_name` varchar(200) NOT NULL,
  `of_country` varchar(200) NOT NULL,
  `of_city` varchar(200) NOT NULL,
  `of_phone` varchar(200) NOT NULL,
  `of_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `crm_office`
--

INSERT INTO `crm_office` (`of_id`, `of_name`, `of_country`, `of_city`, `of_phone`, `of_image`) VALUES
(1, 'Администраторская', 'Россия', 'Иркутск', '44-14-22', '122393999eyes-office-women-red-icon.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `crm_office`
--
ALTER TABLE `crm_office`
  ADD PRIMARY KEY (`of_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `crm_office`
--
ALTER TABLE `crm_office`
  MODIFY `of_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
