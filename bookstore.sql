-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2026 at 07:44 PM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `price`, `description`, `created_at`) VALUES
(2, 'Web Application Hacker’s Handbook', 'Dafydd Stuttard & Marcus Pinto', 120.00, 'A comprehensive guide to discovering, exploiting, and preventing security vulnerabilities in modern web applications. Considered one of the most authoritative books in web security and penetration testing.', '2026-05-08 22:12:21'),
(3, 'The Tangled Web: A Guide to Securing Modern Web Applications', 'Michal Zalewski', 95.00, 'A deep exploration of browser security, web architecture, and common vulnerabilities that affect modern web applications.', '2026-05-08 22:13:41'),
(4, 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 80.00, 'A practical guide for building dynamic, database-driven websites using PHP, MySQL, JavaScript, and CSS.', '2026-05-08 22:14:16'),
(5, 'PHP & MySQL: Server-Side Web Development', 'Jon Duckett', 110.00, 'A visually rich and beginner-friendly book covering backend development using PHP and MySQL.', '2026-05-08 22:14:56'),
(6, 'Network Security Essentials', 'William Stallings', 130.00, 'A foundational textbook covering core concepts of network security, encryption, and secure communication.', '2026-05-08 22:15:32'),
(7, 'CEH v11 Certified Ethical Hacker Study Guide', 'Ric Messier', 150.00, 'A comprehensive study guide for ethical hacking, covering tools, techniques, and methodologies used in penetration testing.', '2026-05-08 22:16:11'),
(8, 'JavaScript: The Good Parts', 'Douglas Crockford', 60.00, 'A focused guide on the most powerful and effective parts of JavaScript for building secure and efficient web applications.', '2026-05-08 22:16:44'),
(9, 'Web Security for Developers', 'Malcolm McDonald', 75.00, 'A practical guide that teaches developers how to secure web applications by understanding common vulnerabilities and implementing defensive coding techniques.', '2026-05-08 22:19:28'),
(10, 'Hands-On Penetration Testing on Web Applications', 'Rohit Tamma & Don Murdoch', 140.00, 'A hands-on guide to performing penetration testing on modern web applications using real-world tools and methodologies.', '2026-05-08 22:20:01'),
(11, 'Modern Web Development with HTML5 and CSS3', 'Benjamin LaGrone', 90.00, 'A complete introduction to building modern, responsive, and secure web interfaces using HTML5, CSS3, and best practices.', '2026-05-08 22:20:44'),
(13, 'Cross‑Site Scripting (XSS)', 'test', 1.00, '<script>alert(\'XSS\')</script>', '2026-05-09 14:24:59'),
(14, 'test book', 'hala', 12.00, '', '2026-05-15 21:47:57'),
(15, 'Test website', 'Hind', 15.00, '', '2026-05-15 22:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@bookstore.local', '$2y$10$Qe6q6uQ0pQ8x2Y8x2Y8x2uGx7x7x7x7x7x7x7x7x7x7x7x7x7', 'admin', '2026-05-06 19:23:26'),
(2, 'Admin', 'admin@bookstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-05-06 22:21:34'),
(3, 'Joury', 'joury2002@gmail.com', '$2y$10$9TMJXQMC4rbvyAzV4RI/OeX.cq98m9qDkbyKMlwhI9C6tHOFRpRKm', 'user', '2026-05-08 21:18:03'),
(5, 'Nouf', 'Nouf2004@yahoo.com', '$2y$10$OommHtKM0RmG5uh31YgIRunZRkmoyWsnSRfiJJTOoWEy9ltOFu1AC', 'user', '2026-05-08 22:49:44'),
(6, 'Mariam', 'mariamali@outlook.com', '$2y$10$VR2IvX4lcrdSoIxkvA6qbOOOSP3WgNR9z7DHHtNoD41yze.336hwG', 'user', '2026-05-08 22:50:34'),
(7, 'Haya', 'hayaehab@gmail.com', '$2y$10$n6g//ZaJdQUcpUYT6zLhxe89I..oshEL5r4yI/CFh5ZQxpKo8eVHm', 'admin', '2026-05-10 16:23:53'),
(9, 'Huda', 'huda1985@gmail.com', '$2y$10$jGko5wyUtPg2zUv6YTYqsueJC3Ypul.SXEiU3dZFS0JdvK0d/6Gv2', 'user', '2026-05-15 21:53:58'),
(10, 'Rahaf', 'rahaf2007@yahoo.com', '$2y$10$8YAStD0p69f/.T4EeNFoQessFSIXIzKM8tq74kxgdiIXfOozGaYWW', 'user', '2026-05-15 21:55:00'),
(11, 'Hala', 'halahamed@gmail.com', '$2y$10$RgDbLBaDc7IvIi56Pfv8Cu5d0TkAL9mhuDmb3dhTrLHJE2RobZSiu', 'admin', '2026-05-15 22:02:00'),
(12, 'Albandari', 'albandari@outlook.com', '$2y$10$rH.kiFTGAzx7.CrCGbuWtOs/4w3eZpNX1Ix8inCXjk5X3t8mhArle', 'user', '2026-05-15 22:07:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
