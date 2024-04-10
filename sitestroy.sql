-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2024 г., 05:25
-- Версия сервера: 5.7.39
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sitestroy`
--

-- --------------------------------------------------------

--
-- Структура таблицы `to_do_list`
--

CREATE TABLE `to_do_list` (
  `id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `to_do_list`
--

INSERT INTO `to_do_list` (`id`, `text`, `completed`, `user_id`) VALUES
(27, 'новая задача 1', 0, 6),
(28, 'новая задача 2', 0, 6),
(29, 'Новая задачка', 1, 5),
(30, 'awdawd', 0, 5),
(34, 'новая задачка', 1, 3),
(35, 'awdawd', 0, 5),
(36, 'фцвфцв', 1, 3),
(37, 'awdawd', 0, 3),
(38, 'тестовая аздача', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('normal','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `token`, `role`) VALUES
(3, 'admin@mail.ru', '$2y$10$iA65yYoIklMemhsqEzvZiu.Tg0iWLAqDL2O8KhBmy.RwuAJYEof8K', '2621dd8bb0d66265d91451410babde454db151bc8f46b6f951f8017a92f6e8752ae149facf78f927', 'admin'),
(5, 'ilhalaktyushin@yandex.ru', '$2y$10$hpVUihYaL80hY8XX03s4GeTa2DLCIhy1eico3V1niivRGomdyJ.2S', '4fd980d6d62f2b78262486b14e252ccf22026d51676d763185d9c5de5ae80f0c12054b8a3b94a426', 'normal'),
(6, 'egeg@mail.ru', '$2y$10$rb.QraeEL/eqEvms3OEfSeYhnR84SA38Uks3fEzy4pVCbKJ8mGQ6G', '5f843f2f11e7db5cee1f053aa8d8ec1172417e205281730dfe0c05c7655640e38c72c081344dacfa', 'normal');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `to_do_list`
--
ALTER TABLE `to_do_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to-do-list_ibfk_1` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailunique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `to_do_list`
--
ALTER TABLE `to_do_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `to_do_list`
--
ALTER TABLE `to_do_list`
  ADD CONSTRAINT `to_do_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
