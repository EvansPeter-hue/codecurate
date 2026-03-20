-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 11:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codecurate`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `fa_icon` varchar(60) NOT NULL DEFAULT 'fas fa-code',
  `description` text DEFAULT NULL,
  `color` varchar(12) NOT NULL DEFAULT '#3b82f6',
  `subtitle` text DEFAULT NULL,
  `lang_class` varchar(40) NOT NULL DEFAULT 'lang-js',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `slug`, `icon`, `fa_icon`, `description`, `color`, `subtitle`, `lang_class`, `sort_order`, `created_at`) VALUES
(1, 'Python', 'python', '', 'fab fa-python', 'A versatile language for web, data science and AI', '#3b82f6', 'From scripting basics to data science and machine learning. Build real projects with Python\'s most powerful libraries.', 'lang-python', 1, '2026-03-15 11:23:42'),
(2, 'JavaScript', 'javascript', '', 'fab fa-js', 'The language of the web and interactive UIs', '#facc15', 'Master the language of the modern web. From fundamentals to advanced frameworks.', 'lang-js', 2, '2026-03-15 11:23:42'),
(3, 'React', 'react', '⚛️', 'fab fa-react', 'Component-based UI library for modern web apps', '#38bdf8', 'Build fast, scalable user interfaces with React hooks, context, and the latest patterns.', 'lang-react', 3, '2026-03-15 11:23:42'),
(4, 'DevOps', 'devops', '', 'fas fa-server', 'Cloud, containers and CI/CD pipelines', '#a78bfa', 'Master Docker, Kubernetes, CI/CD and cloud deployment. Go from dev to production confidently.', 'lang-devops', 4, '2026-03-15 11:23:42'),
(5, 'AI & ML', 'ai', '🧠', 'fas fa-brain', 'Machine learning and artificial intelligence', '#f472b6', 'Explore machine learning, deep learning and AI engineering with hands-on projects.', 'lang-ai', 5, '2026-03-15 11:23:42'),
(6, 'Java', 'java', '', 'fab fa-java', 'Object-oriented, platform-independent language', '#3b82f6', 'Learn Java from the ground up — OOP, data structures, Spring Boot and enterprise applications.', 'lang-java', 6, '2026-03-15 11:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `email` varchar(160) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'Evans', 'Peter', 'evansonal102@gmail.com', '$2y$10$X9j1Ttmcdl02DItehFwS8elm3g017ErMXeD0QxYBKkpn8ah0kpSOS', '2026-03-15 11:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `yt_id` varchar(30) NOT NULL,
  `title` varchar(300) NOT NULL,
  `duration` varchar(20) NOT NULL DEFAULT '00:00',
  `views` varchar(20) NOT NULL DEFAULT '0',
  `views_raw` bigint(20) NOT NULL DEFAULT 0,
  `likes` varchar(20) NOT NULL DEFAULT '0',
  `comments` varchar(20) NOT NULL DEFAULT '0',
  `subtopic` varchar(40) NOT NULL DEFAULT 'all',
  `published_ago` varchar(60) NOT NULL DEFAULT '',
  `level` varchar(20) NOT NULL DEFAULT 'Beginner',
  `filter_tag` varchar(40) NOT NULL DEFAULT 'all',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `course_id`, `yt_id`, `title`, `duration`, `views`, `views_raw`, `likes`, `comments`, `subtopic`, `published_ago`, `level`, `filter_tag`, `sort_order`, `created_at`) VALUES
(1, 1, '_uQrJ0TkZlc', 'Python Tutorial for Beginners — Full Course in 6 Hours', '6:14:07', '36M', 36000000, '820k', '45k', 'all', '3 years ago', 'Beginner', 'basics', 1, '2026-03-15 11:23:42'),
(2, 1, 'rfscVS0vtbw', 'Learn Python — Full Course for Beginners (freeCodeCamp)', '4:26:52', '45M', 45000000, '980k', '52k', 'all', '5 years ago', 'Beginner', 'basics', 2, '2026-03-15 11:23:42'),
(3, 1, 'ZDa-Z5JzLYM', 'Python OOP Tutorial — Classes and Objects Explained', '1:00:27', '2.1M', 2100000, '48k', '9k', 'all', '5 years ago', 'Intermediate', 'oop', 3, '2026-03-15 11:23:42'),
(4, 1, 'vmEHCJofslg', 'Pandas & Python for Data Analysis by Example', '3:20:41', '2.9M', 2900000, '62k', '14k', 'all', '2 years ago', 'Intermediate', 'data', 4, '2026-03-15 11:23:42'),
(5, 1, 'LHBE0uyla5M', 'Python for Data Science — NumPy, Pandas and Matplotlib', '1:54:00', '3.1M', 3100000, '71k', '18k', 'all', '1 year ago', 'Intermediate', 'data', 5, '2026-03-15 11:23:42'),
(6, 1, 'F5mRW0jo-U4', 'Django Full Stack Web Development Tutorial for Beginners', '3:45:00', '1.6M', 1600000, '36k', '11k', 'all', '1 year ago', 'Advanced', 'web', 6, '2026-03-15 11:23:42'),
(7, 1, 's3lrgez_b2w', 'Python Automation — Automate the Boring Stuff', '55:12', '1.2M', 1200000, '28k', '7k', 'all', '2 years ago', 'Beginner', 'automation', 7, '2026-03-15 11:23:42'),
(8, 1, '4F2m91eKmts', 'Python Web Scraping with BeautifulSoup and Requests', '48:30', '1.4M', 1400000, '32k', '8k', 'all', '2 years ago', 'Intermediate', 'automation', 8, '2026-03-15 11:23:42'),
(9, 1, 'p15xzjzR9j0', 'Python Flask Web App from Scratch — Full Tutorial', '2:10:22', '2.3M', 2300000, '51k', '12k', 'all', '3 years ago', 'Advanced', 'web', 9, '2026-03-15 11:23:42'),
(10, 1, 'HGOBQPFzWKo', 'Intermediate Python Programming Full Course', '5:55:00', '5.0M', 5000000, '110k', '22k', 'all', '4 years ago', 'Intermediate', 'oop', 10, '2026-03-15 11:23:42'),
(11, 2, 'V_Kr9OSfDeU', 'Mastering Async/Await in Modern JavaScript', '15:24', '1.4M', 1400000, '38k', '9k', 'all', '3 months ago', 'Advanced', 'async', 1, '2026-03-15 11:23:42'),
(12, 2, 'jS4aFq5-91M', 'JavaScript Full Course for Beginners — Zero to Hero', '8:00:00', '5.8M', 5800000, '130k', '28k', 'all', '6 months ago', 'Beginner', 'basics', 2, '2026-03-15 11:23:42'),
(13, 2, 'w7ejDZ8SWv8', 'React JS Crash Course — Learn React in 2 Hours', '1:48:38', '3.2M', 3200000, '72k', '16k', 'all', '8 months ago', 'Intermediate', 'react', 3, '2026-03-15 11:23:42'),
(14, 2, 'Mus_vwhTCq0', 'Node.js Crash Course — Build REST APIs Fast', '1:25:31', '1.9M', 1900000, '44k', '11k', 'all', '7 months ago', 'Intermediate', 'nodejs', 4, '2026-03-15 11:23:42'),
(15, 2, 'fBNz5xF-Kx4', 'Node.js Tutorial for Absolute Beginners', '45:30', '2.4M', 2400000, '54k', '13k', 'all', '9 months ago', 'Beginner', 'nodejs', 5, '2026-03-15 11:23:42'),
(16, 2, '8aGhZQkoFbQ', 'Deep Dive: Understanding the JavaScript Event Loop', '25:50', '1.0M', 1000000, '23k', '6k', 'all', '2 months ago', 'Advanced', 'architecture', 6, '2026-03-15 11:23:42'),
(17, 2, 'e-5obm1G_FY', 'Functional Programming in JS: Map, Filter, Reduce', '35:45', '1.1M', 1100000, '25k', '7k', 'all', '5 months ago', 'Intermediate', 'es6', 7, '2026-03-15 11:23:42'),
(18, 2, 'PkZNo7MFNFg', 'Complete JavaScript Course — Beginner to Expert', '52:00', '16M', 16000000, '420k', '28k', 'all', '2 years ago', 'Beginner', 'basics', 8, '2026-03-15 11:23:42'),
(19, 2, 'hdI2bqOjy3c', 'JavaScript Crash Course For Beginners', '1:40:00', '9.0M', 9000000, '230k', '16k', 'all', '3 years ago', 'Beginner', 'basics', 9, '2026-03-15 11:23:42'),
(20, 2, '3PHXvlpOkf4', 'Build 15 JavaScript Projects — Vanilla JS Course', '8:20:00', '6.0M', 6000000, '150k', '11k', 'all', '4 years ago', 'Intermediate', 'es6', 10, '2026-03-15 11:23:42'),
(21, 3, 'w7ejDZ8SWv8', 'React JS Crash Course — Learn React in 2 Hours', '1:48:38', '3.2M', 3200000, '72k', '16k', 'all', '8 months ago', 'Beginner', 'basics', 1, '2026-03-15 11:23:42'),
(22, 3, 'mTz0GXj8NN0', 'Next.js 14 Crash Course — App Router and Server Actions', '1:30:00', '2.3M', 2300000, '51k', '12k', 'all', '4 months ago', 'Advanced', 'nextjs', 2, '2026-03-15 11:23:42'),
(23, 3, 'bMknfKXIFA8', 'React Tutorial for Beginners — Full Course (freeCodeCamp)', '9:37:46', '4.1M', 4100000, '90k', '20k', 'all', '2 years ago', 'Beginner', 'basics', 3, '2026-03-15 11:23:42'),
(24, 3, 'f55qgjxir_g', 'React Hooks Tutorial — useState and useEffect Explained', '2:25:00', '1.5M', 1500000, '34k', '8k', 'all', '1 year ago', 'Intermediate', 'hooks', 4, '2026-03-15 11:23:42'),
(25, 3, 'I6BvBe3yCqs', 'React Context API — State Management Without Redux', '1:10:00', '1.1M', 1100000, '26k', '6k', 'all', '2 years ago', 'Intermediate', 'state', 5, '2026-03-15 11:23:42'),
(26, 3, 'WjERuLJJfGE', 'Redux Toolkit Tutorial — Modern State Management', '1:50:00', '1.3M', 1300000, '29k', '7k', 'all', '1 year ago', 'Advanced', 'state', 6, '2026-03-15 11:23:42'),
(27, 3, 'RVFAyFWO4go', 'React Testing Library — Unit Testing React Apps', '1:15:00', '1.0M', 1000000, '22k', '5k', 'all', '1 year ago', 'Advanced', 'testing', 7, '2026-03-15 11:23:42'),
(28, 3, 'SqcY0GlETPk', 'React TypeScript Tutorial — Full Beginner Guide', '55:00', '2.0M', 2000000, '45k', '10k', 'all', '1 year ago', 'Intermediate', 'typescript', 8, '2026-03-15 11:23:42'),
(29, 3, 'iUPPnKBF8q4', 'React Router v6 — Build Multi-page SPAs', '48:00', '1.2M', 1200000, '27k', '6k', 'all', '1 year ago', 'Intermediate', 'routing', 9, '2026-03-15 11:23:42'),
(30, 3, '46tqn9YcrBw', 'Build a Full-Stack React App with Node.js and MongoDB', '3:30:00', '1.8M', 1800000, '40k', '9k', 'all', '2 years ago', 'Advanced', 'fullstack', 10, '2026-03-15 11:23:42'),
(31, 4, 'pg19Z8LL06w', 'Docker Tutorial for Beginners — Full DevOps Course', '2:10:18', '2.4M', 2400000, '54k', '13k', 'all', '3 years ago', 'Beginner', 'docker', 1, '2026-03-15 11:23:42'),
(32, 4, 's_o8dwzRlu4', 'Kubernetes Tutorial for Beginners — Full Course', '3:45:35', '3.1M', 3100000, '68k', '16k', 'all', '4 years ago', 'Advanced', 'kubernetes', 2, '2026-03-15 11:23:42'),
(33, 4, '3c-iBn73dDE', 'Docker and Docker Compose Full Course for Beginners', '5:16:00', '4.6M', 4600000, '102k', '22k', 'all', '3 years ago', 'Beginner', 'docker', 3, '2026-03-15 11:23:42'),
(34, 4, 'd6WC5n9G_sM', 'Kubernetes Crash Course for Absolute Beginners', '1:13:00', '2.0M', 2000000, '44k', '10k', 'all', '2 years ago', 'Intermediate', 'kubernetes', 4, '2026-03-15 11:23:42'),
(35, 4, '5UF9IDxCgr8', 'GitHub Actions CI/CD Pipeline Tutorial', '1:42:00', '1.5M', 1500000, '34k', '8k', 'all', '1 year ago', 'Intermediate', 'cicd', 5, '2026-03-15 11:23:42'),
(36, 4, '7-ZLEWVbXO0', 'Terraform Tutorial — Infrastructure as Code for Beginners', '2:30:00', '1.2M', 1200000, '27k', '6k', 'all', '1 year ago', 'Advanced', 'cloud', 6, '2026-03-15 11:23:42'),
(37, 4, 'NN8_aALLGf0', 'AWS Certified Solutions Architect — Full Course', '10:26:11', '7.2M', 7200000, '160k', '34k', 'all', '2 years ago', 'Advanced', 'cloud', 7, '2026-03-15 11:23:42'),
(38, 4, 'a0CpECETN7E', 'Linux Command Line Tutorial for Beginners', '1:36:00', '3.8M', 3800000, '85k', '19k', 'all', '3 years ago', 'Beginner', 'linux', 8, '2026-03-15 11:23:42'),
(39, 4, 'fqMOX6JJhGo', 'Git and GitHub Crash Course For Beginners', '32:41', '4.5M', 4500000, '100k', '22k', 'all', '5 years ago', 'Beginner', 'git', 9, '2026-03-15 11:23:42'),
(40, 4, 'X48VuDVv0do', 'Ansible Tutorial for Beginners — Full Course', '1:57:00', '1.1M', 1100000, '25k', '6k', 'all', '2 years ago', 'Intermediate', 'automation', 10, '2026-03-15 11:23:42'),
(41, 5, 'NWONeJKn6kc', 'Machine Learning for Beginners — Full Course (freeCodeCamp)', '9:52:19', '4.3M', 4300000, '98k', '22k', 'all', '2 years ago', 'Beginner', 'ml', 1, '2026-03-15 11:23:43'),
(42, 5, 'GwIo3gDZCVQ', 'TensorFlow 2.0 Complete Course — Python Neural Networks', '6:52:08', '2.5M', 2500000, '56k', '13k', 'all', '4 years ago', 'Intermediate', 'deep', 2, '2026-03-15 11:23:43'),
(43, 5, 'i_LwzRVP7bg', 'PyTorch Tutorial for Deep Learning — Full Course', '9:38:00', '2.1M', 2100000, '47k', '11k', 'all', '3 years ago', 'Advanced', 'deep', 3, '2026-03-15 11:23:43'),
(44, 5, 'tPYj3fFJGjk', 'ChatGPT and OpenAI API — Build AI Apps with Python', '1:30:00', '1.8M', 1800000, '40k', '9k', 'all', '1 year ago', 'Intermediate', 'llm', 4, '2026-03-15 11:23:43'),
(45, 5, '7eh4d9ejTuw', 'Deep Learning Crash Course for Beginners', '1:25:41', '2.8M', 2800000, '62k', '14k', 'all', '3 years ago', 'Beginner', 'deep', 5, '2026-03-15 11:23:43'),
(46, 5, 'RUo-YKnkWpY', 'Scikit-Learn Tutorial — Machine Learning Crash Course', '2:29:00', '1.2M', 1200000, '27k', '6k', 'all', '2 years ago', 'Beginner', 'ml', 6, '2026-03-15 11:23:43'),
(47, 5, 'X3paOmcrTjQ', 'Computer Vision with Python and OpenCV — Full Course', '3:31:00', '1.3M', 1300000, '29k', '7k', 'all', '1 year ago', 'Intermediate', 'cv', 7, '2026-03-15 11:23:43'),
(48, 5, 'V_xro1gepHg', 'LangChain and LLMs — Build Real AI Applications', '1:00:00', '2.2M', 2200000, '49k', '11k', 'all', '1 year ago', 'Advanced', 'llm', 8, '2026-03-15 11:23:43'),
(49, 5, 'c-lUrArKSmA', 'Natural Language Processing with Python — Full Course', '6:00:00', '1.5M', 1500000, '34k', '8k', 'all', '2 years ago', 'Advanced', 'nlp', 9, '2026-03-15 11:23:43'),
(50, 5, 'vmEHCJofslg', 'Data Science Full Course — Analysis and Visualization', '3:20:41', '2.9M', 2900000, '62k', '14k', 'all', '2 years ago', 'Beginner', 'data', 10, '2026-03-15 11:23:43'),
(51, 6, 'eIrMbAQSU34', 'Java Tutorial for Beginners — Full Course (Programming with Mosh)', '2:30:27', '10M', 10000000, '220k', '48k', 'all', '5 years ago', 'Beginner', 'basics', 1, '2026-03-15 11:23:43'),
(52, 6, 'grEKMHGYyns', 'Java Full Course for Beginners — 12 Hours (freeCodeCamp)', '12:00:00', '5.8M', 5800000, '128k', '28k', 'all', '3 years ago', 'Beginner', 'basics', 2, '2026-03-15 11:23:43'),
(53, 6, 'K-o4NNSrgWo', 'Java Spring Boot Tutorial — Full Course for Beginners', '3:36:57', '2.1M', 2100000, '47k', '11k', 'all', '2 years ago', 'Advanced', 'spring', 3, '2026-03-15 11:23:43'),
(54, 6, '5DyDg5Ac2bM', 'Java OOP Tutorial — Object-Oriented Programming Full Course', '2:07:00', '1.6M', 1600000, '36k', '8k', 'all', '3 years ago', 'Intermediate', 'oop', 4, '2026-03-15 11:23:43'),
(55, 6, '8cm1x4bC610', 'Java Data Structures and Algorithms Full Course', '11:45:00', '3.0M', 3000000, '66k', '15k', 'all', '4 years ago', 'Advanced', 'dsa', 5, '2026-03-15 11:23:43'),
(56, 6, 'WPvGqX-TXP0', 'Java Collections Framework — Full Tutorial', '1:20:00', '1.5M', 1500000, '34k', '8k', 'all', '3 years ago', 'Intermediate', 'oop', 6, '2026-03-15 11:23:43'),
(57, 6, '6bR3pMQb1vs', 'Hibernate and JPA Tutorial — Database Persistence in Java', '1:50:00', '1.3M', 1300000, '29k', '7k', 'all', '2 years ago', 'Advanced', 'spring', 7, '2026-03-15 11:23:43'),
(58, 6, 'Ik1BYE9mGiA', 'Microservices with Spring Boot and Spring Cloud', '4:45:00', '2.4M', 2400000, '53k', '12k', 'all', '2 years ago', 'Advanced', 'spring', 8, '2026-03-15 11:23:43'),
(59, 6, 'Ae-r8hsbPUo', 'Java Maven Tutorial — Build and Manage Projects', '35:00', '1.1M', 1100000, '24k', '5k', 'all', '2 years ago', 'Intermediate', 'tools', 9, '2026-03-15 11:23:43'),
(60, 6, 'xk4_1vDrzzo', 'JavaFX GUI Tutorial — Build Desktop Applications', '1:30:00', '1.2M', 1200000, '27k', '6k', 'all', '3 years ago', 'Intermediate', 'gui', 10, '2026-03-15 11:23:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
