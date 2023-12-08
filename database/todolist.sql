-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 03:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `description_tags`
--

CREATE TABLE `description_tags` (
  `id` int(11) NOT NULL,
  `task` int(11) DEFAULT NULL,
  `tag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `description_tags`
--

INSERT INTO `description_tags` (`id`, `task`, `tag`) VALUES
(14, 1, 1),
(16, 3, 1),
(17, 4, 1),
(18, 2, 1),
(19, 5, 2),
(20, 5, 3),
(21, 6, 2),
(22, 6, 3),
(24, 13, 2),
(25, 13, 3),
(27, 8, 1),
(28, 1, 3),
(36, 7, 2),
(41, 7, 1),
(42, 7, 3),
(43, 7, 4),
(52, 9, 1),
(53, 9, 2),
(56, 12, 2),
(57, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(55, 'App\\Models\\User', 1, 'authToken', '85facfedb6e92690e6a553ccfdedf61b23d3643b884908d6591de100e25f6890', '[\"*\"]', NULL, NULL, '2023-12-08 14:48:32', '2023-12-08 14:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `background_color` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `user`, `background_color`) VALUES
(1, 'congviec', 1, 'green'),
(2, 'tinhyeu', 1, 'red'),
(3, 'henho', 1, 'pink'),
(4, 'naunuong', 1, 'purple'),
(7, 'abc', 1, '#8b2727');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `deadline` date NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `description` text DEFAULT NULL,
  `list` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `deadline`, `is_completed`, `description`, `list`, `is_deleted`) VALUES
(1, 'Tìm hiểu về Wordpress', '2023-11-15', 0, 'Tìm hiểu về cách cài đặt và sử dụng Wordpress.\r\n\r\nĐể mai mốt còn đi làm để kiếm tiền nữa trời ơi trời!!!', 3, 0),
(2, 'Chạy deadline', '2023-11-13', 0, 'Làm đồ án to do list app với laravel và mysql', 3, 0),
(3, 'Nghiên cứu và viết báo cáo về công nghệ mới', '2023-11-13', 0, 'Nghiên cứu và theo dõi các xu hướng công nghệ mới, đánh giá ảnh hưởng của chúng đối với doanh nghiệp. Viết báo cáo chi tiết về những phát hiện mới và đề xuất cách tích hợp công nghệ mới để cải thiện quy trình làm việc.', 2, 0),
(4, 'Phát triển ứng dụng di động mới', '2023-11-18', 1, 'Xây dựng ứng dụng di động từ đầu, bao gồm phân tích yêu cầu, thiết kế giao diện người dùng, và triển khai các tính năng chính. Công việc cũng bao gồm kiểm thử toàn diện và tối ưu hóa hiệu suất.', 2, 0),
(5, 'Dạo phố và ăn trưa tại nhà hàng ưa thích', '2023-11-30', 1, 'Một buổi hẹn nhẹ nhàng với việc dạo chơi ở khu vực phố cổ, sau đó thưởng thức bữa trưa ngon miệng tại nhà hàng với không khí ấm áp.', 4, 0),
(6, 'Chuyến picnic cuối tuần', '2023-11-14', 0, 'Hãy cùng nhau chuẩn bị những đồ ăn nhẹ và thú vị cho một buổi picnic tại công viên. Thưởng thức thời tiết tuyệt vời và chia sẻ những câu chuyện về cuộc sống.', 4, 0),
(7, 'Khám phá triển lãm nghệ thuật đương đại', '2023-12-23', 0, 'Một chuyến thăm triển lãm nghệ thuật sẽ mang lại cho chúng ta cơ hội chia sẻ ý kiến về nghệ thuật đương đại, khám phá cái mới và tận hưởng không gian sáng tạo.', 4, 0),
(8, 'Lớp nấu ăn cùng nhau', '2023-11-18', 1, 'Chúng ta có thể cùng nhau tham gia một buổi lớp nấu ăn để học cách chuẩn bị một bữa tối ngon miệng. Chọn một món ăn yêu thích hoặc thử nghiệm một công thức mới!', 5, 0),
(9, 'Cuộc thi nấu ăn gia đình', '2023-11-30', 0, 'Tạo ra một không khí cuộc thi nấu ăn tại nhà, nơi mỗi người sẽ là đầu bếp chính cho một bữa tối. Sự cạnh tranh và niềm vui đảm bảo sẽ làm cho buổi tối thêm phần thú vị.', 5, 0),
(10, 'Dãn cách nấu món ngon từ các nền văn hóa khác nhau', '2023-11-14', 0, 'Khám phá thế giới qua ẩm thực! Chọn một đất nước hoặc vùng lãnh thổ và nấu một bữa tối đặc sắc với các món ăn đặc trưng từ đó.', 5, 0),
(11, 'Đọc sách cùng nhau', '2023-11-13', 1, 'Chọn một cuốn sách bạn muốn đọc hoặc chia sẻ một cuốn sách mới. Sau đó, cùng nhau trao đổi ý kiến và suy nghĩ về nội dung của cuốn sách.', 3, 0),
(12, 'Học tập từ khóa mới', '2023-11-13', 1, 'Hãy cùng nhau chọn một chủ đề hoặc kỹ năng bạn muốn học, sau đó tìm hiểu cùng nhau thông qua các tài nguyên trực tuyến, video học, hoặc sách. Cuối cùng, thảo luận về những gì bạn đã học và làm thế nào bạn có thể áp dụng.', 3, 0),
(13, 'Nhắn tin với người yêu', '2023-11-18', 0, 'Nhắn hỏi em ấy hôm nay thế nào', 1, 0),
(14, 'Tìm hiểu về OOP trong PHP', '2023-11-07', 1, 'Tìm hiểu về cách sử dụng OOP trong PHP', 3, 0),
(15, 'Tìm hiểu về OOP trong PHP', '2023-11-13', 0, 'Tìm hiểu về cách sử dụng OOP trong PHP', 6, 0),
(16, 'Tìm hiểu về OOP trong PHP (2)', '2023-11-14', 0, 'Tìm hiểu về cách sử dụng OOP trong PHP', 1, 0),
(17, 'Chuyến picnic cuối tuần', '2023-11-09', 0, 'Hãy cùng nhau chuẩn bị những đồ ăn nhẹ và thú vị cho một buổi picnic tại công viên. Thưởng thức thời tiết tuyệt vời và chia sẻ những câu chuyện về cuộc sống.', 6, 0),
(18, 'Dãn cách nấu món ngon từ các nền văn hóa khác nhau', '2023-11-15', 1, 'Khám phá thế giới qua ẩm thực! Chọn một đất nước hoặc vùng lãnh thổ và nấu một bữa tối đặc sắc với các món ăn đặc trưng từ đó.', 6, 0),
(20, 'ngày mai em đi biển nhớ tên em gọi về', '2023-11-20', 0, '', 1, 1),
(21, 'thêm task mới vào task công việc', '2023-11-19', 0, 'Hello', 1, 0),
(24, 'làm deadline todo list', '2023-11-23', 0, '', 3, 1),
(25, 'test thêm task mới', '2023-11-19', 1, '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username_account` varchar(255) DEFAULT NULL,
  `password_account` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `OTP` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `social_id` varchar(28) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username_account`, `password_account`, `avatar`, `OTP`, `created_at`, `updated_at`, `social_id`) VALUES
(1, 'Nguyễn Thành Văn', 'ntvan39a7@gmail.com', 'van1972001', '$2y$12$6HSbKg2tx6uSGtxVbc0y0uyzoVg3NkDJHs2oYQUMOYvQzYBvIBC06', 'user-1_20231205205311', '', '2023-11-06 04:23:06', '2023-12-08 14:48:10', NULL),
(2, 'Hứa Hiền Vinh', 'vinhvinh@gmail.com', 'vinh123', '$2y$12$yIX5CuIu1QdhRpB.gidUtu18eWwssCgidcRnnWQe8BMYOGTsv1Ucq', 'default', '', '2023-11-06 04:23:06', '2023-11-22 05:57:56', NULL),
(9, 'Ngô Đình Hiếu', 'hieuyeuthao1@gmail.com', 'dinhhieulovetkao', '$2y$12$j02z/4xLF60pSLmkJpwYROdYGfUIVwCJudI0EIG2/ettrs7pJ3PTG', 'default', '', '2023-11-18 13:36:25', '2023-11-22 05:58:02', NULL),
(11, 'Nguyễn Thành Văn', 'ntvan39a7@gmail.com', NULL, NULL, '133571200_20231123195807', NULL, '2023-11-23 12:58:09', '2023-11-23 12:58:09', '133571200'),
(12, 'Thành Văn Nguyễn', 'ntvan39a7@gmail.com', NULL, NULL, '106561374579888135834_20231123200709', NULL, '2023-11-23 13:07:10', '2023-11-23 13:07:10', '106561374579888135834');

-- --------------------------------------------------------

--
-- Table structure for table `user_lists`
--

CREATE TABLE `user_lists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `user_lists`
--

INSERT INTO `user_lists` (`id`, `name`, `type`, `user`) VALUES
(1, 'Mặc định', 'default', 1),
(2, 'Công việc', 'custom', 1),
(3, 'Học tập', 'custom', 1),
(4, 'Hẹn hò', 'custom', 1),
(5, 'Nấu nướng', 'custom', 1),
(6, 'Mặc định', 'default', 2),
(25, 'van ne', 'custom', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `description_tags`
--
ALTER TABLE `description_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task` (`task`),
  ADD KEY `tag` (`tag`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`list`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_account` (`username_account`);

--
-- Indexes for table `user_lists`
--
ALTER TABLE `user_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_lists_with_user` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `description_tags`
--
ALTER TABLE `description_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_lists`
--
ALTER TABLE `user_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `description_tags`
--
ALTER TABLE `description_tags`
  ADD CONSTRAINT `description_tags_ibfk_1` FOREIGN KEY (`task`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `description_tags_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`list`) REFERENCES `user_lists` (`id`);

--
-- Constraints for table `user_lists`
--
ALTER TABLE `user_lists`
  ADD CONSTRAINT `FK_user_lists_with_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
