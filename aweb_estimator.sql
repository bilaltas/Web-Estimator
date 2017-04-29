-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2017 at 10:24 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aweb_estimator`
--

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `field_ID` int(10) NOT NULL,
  `field_slug` varchar(60) NOT NULL,
  `field_name` varchar(300) NOT NULL,
  `field_short_name` varchar(100) NOT NULL,
  `field_required` tinyint(1) NOT NULL DEFAULT '1',
  `step_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_ID`, `field_slug`, `field_name`, `field_short_name`, `field_required`, `step_ID`) VALUES
(1, 'domain', 'Will you provide us a domain to use on your project?', 'Domain', 1, 1),
(2, 'server', 'Do you have a hosting package to use on your project?', 'Server', 1, 2),
(3, 'static', 'Check the static pages you want to add into your website.', 'Static Pages', 1, 3),
(4, 'dynamic', 'Check the dynamic pages you want to add into your website.', 'Dynamic Pages', 0, 4),
(5, 'products', 'How many products do you want to add your website for first?', 'Initial Products', 1, 5),
(6, 'product_image', 'Do you have your images/illustrations to use for the products?', 'Product Images', 1, 6),
(7, 'product_watermark', 'Would you like to secure your product images with a watermark?', 'Product Image Watermark', 1, 6),
(8, 'payment_method', 'Which payment methods will your website use?', 'Payment Method', 1, 7),
(9, 'ssl', 'Do you want to purchase a SSL Security Certificate? SSL is especially recommended for e-Commerce websites.', 'SSL Certificate', 1, 7),
(10, 'additional', 'Check the services you also want to get.', 'Additional Services', 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

CREATE TABLE `inputs` (
  `input_ID` int(10) NOT NULL,
  `input_slug` varchar(60) NOT NULL,
  `input_name` varchar(100) NOT NULL,
  `input_short_name` varchar(100) NOT NULL,
  `input_description` varchar(300) NOT NULL,
  `input_value` varchar(60) NOT NULL,
  `input_required` tinyint(1) NOT NULL DEFAULT '1',
  `input_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `input_time` int(20) NOT NULL,
  `input_type` varchar(60) NOT NULL,
  `input_checkbox_name` varchar(100) DEFAULT NULL,
  `field_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`input_ID`, `input_slug`, `input_name`, `input_short_name`, `input_description`, `input_value`, `input_required`, `input_disabled`, `input_time`, `input_type`, `input_checkbox_name`, `field_ID`) VALUES
(1, 'domain', 'Yes, I already have my website\'s domain', 'I have', '', 'yes', 1, 0, 0, 'radio', NULL, 1),
(2, 'domain', 'No, we will buy a new domain', 'I don\'t have', '', 'no', 1, 0, 15, 'radio', NULL, 1),
(5, 'server', 'Yes, It is a <b>Linux Hosting</b>', 'Linux', '', 'linux', 1, 0, 0, 'radio', NULL, 2),
(6, 'server', 'Yes, It is a <b>Windows Hosting</b>', 'Windows', '', 'windows', 1, 0, 30, 'radio', NULL, 2),
(7, 'server', 'Other or not sure', 'Other or not sure', '', 'other', 1, 0, 40, 'radio', NULL, 2),
(8, 'server', 'No, we will buy a new hosting', 'I don\'t have', '', 'no', 1, 0, 30, 'radio', NULL, 2),
(9, 'static_pages', 'Home Page', 'Home Page', '', 'home', 1, 1, 360, 'checkbox', NULL, 3),
(10, 'static_pages', 'About Us Page', 'About Page', '', 'about', 0, 0, 65, 'checkbox', NULL, 3),
(11, 'static_pages', 'Privacy Policy Page', 'Privacy Page', '', 'privacy', 0, 0, 40, 'checkbox', NULL, 3),
(12, 'static_pages', 'Terms and Conditions Page', 'Terms Page', '', 'terms', 0, 0, 40, 'checkbox', NULL, 3),
(13, 'static_pages', 'Contact Us Page', 'Contact Page', '', 'contact', 0, 0, 60, 'checkbox', NULL, 3),
(14, 'more_static', 'and', 'More Custom Static Page', 'more custom static page(s)', '0', 0, 0, 60, 'number', NULL, 3),
(15, 'blog_posts', 'How many blog posts do you want to add for first?', 'Blog Posts', 'blog post(s)', '1', 0, 0, 10, 'number-checktoshow', 'Blog Page', 4),
(16, 'portfolio', 'How many portfolio items do you want to add for first?', 'Portfolio Pages', 'portfolio item(s)', '1', 0, 0, 30, 'number-checktoshow', 'Portfolio Page', 4),
(17, 'ecommerce_products', '', 'Initial Products', 'products(s)', '1', 1, 0, 20, 'number', NULL, 5),
(18, 'ecommerce_images', 'Yes, I have. / They will be ready.', 'All ready', '', 'yes', 1, 0, 0, 'radio', NULL, 6),
(19, 'ecommerce_images', 'Yes, but not all the products. I need a photography service for rest of my products.', 'Not all', '', 'half', 1, 0, 30, 'radio', NULL, 6),
(20, 'ecommerce_images', 'No, I don\'t. I need a photography service for all my products.', 'I don\'t have', '', 'no', 1, 0, 30, 'radio', NULL, 6),
(21, 'watermark', 'Yes, I would.', 'Yes', '', 'yes', 1, 0, 30, 'radio', NULL, 7),
(22, 'watermark', 'No, I don\'t need that.', 'No', '', 'no', 1, 0, 0, 'radio', NULL, 7),
(23, 'ecommerce_payment', 'Via PayPal (No requirements)', 'Paypal', '', 'paypal', 0, 0, 30, 'checkbox', NULL, 8),
(24, 'ecommerce_payment', 'Credit Card Direct Payment (Needs some merchandise information)', 'Credit Card', '', 'card', 0, 0, 360, 'checkbox', NULL, 8),
(25, 'ecommerce_payment', 'Others (Wire, Pay on Delivery, etc. )', 'Other', '', 'other', 0, 0, 360, 'checkbox', NULL, 8),
(26, 'ecommerce_ssl', 'Yes, I do.', 'Yes', '', 'yes', 1, 0, 15, 'radio', NULL, 9),
(27, 'ecommerce_ssl', 'No, I don\'t want it.', 'No', '', 'no', 1, 0, 0, 'radio', NULL, 9),
(28, 'additional', 'Logo Design', 'Logo', 'Description', 'logo', 0, 0, 500, 'checkbox', NULL, 10),
(29, 'additional', 'Custom Under Construction Page', 'Coming Soon Page', 'Description', 'underconstruction', 0, 0, 360, 'checkbox', NULL, 10),
(30, 'additional', 'Content Writing Service', 'Content', 'Description', 'content', 0, 0, 360, 'checkbox', NULL, 10),
(31, 'additional', 'Social Media Management', 'Social Media', 'Description', 'social', 0, 0, 360, 'checkbox', NULL, 10),
(32, 'additional', 'Speed Optimization', 'Speed', 'Description', 'speed', 0, 0, 365, 'checkbox', NULL, 10),
(33, 'additional', 'Organic Search Engine Optimization', 'SEO', 'Description', 'seo', 0, 0, 360, 'checkbox', NULL, 10),
(34, 'additional', 'Marketing & Advertisement', 'Marketing & Ads', 'Description', 'ads', 0, 0, 360, 'checkbox', NULL, 10),
(35, 'additional', 'Auto/Cloud Backup', 'Backup', 'Description', 'backup', 0, 0, 360, 'checkbox', NULL, 10),
(36, 'additional', 'Extra Security', 'Security', 'Description', 'security', 0, 0, 360, 'checkbox', NULL, 10),
(37, 'additional', 'Newsletter', '', 'Description', 'newsletter', 0, 0, 360, 'checkbox', NULL, 10),
(38, 'additional', 'Live Support Chat Feature', 'Chat Support', 'Description', 'chat', 0, 0, 360, 'checkbox', NULL, 10),
(39, 'additional', 'Periodic Maintenance & Updates', 'Maintenance', 'Description', 'maintenance', 0, 0, 360, 'checkbox', NULL, 10),
(40, 'additional', 'Custom Requests & Programs', 'Custom', 'Description', 'custom', 0, 0, 360, 'checkbox', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `main_choices`
--

CREATE TABLE `main_choices` (
  `main_choice_ID` int(10) NOT NULL,
  `main_choice_slug` varchar(60) NOT NULL,
  `main_choice_name` varchar(100) NOT NULL,
  `main_choice_description` varchar(300) NOT NULL,
  `main_choice_parent_ID` int(10) NOT NULL,
  `main_choice_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `main_choices`
--

INSERT INTO `main_choices` (`main_choice_ID`, `main_choice_slug`, `main_choice_name`, `main_choice_description`, `main_choice_parent_ID`, `main_choice_active`) VALUES
(1, 'ecommerce', 'E-Commerce', '', 20, 1),
(2, 'news', 'News', '', 20, 0),
(3, 'blog', 'Personal Blog', '', 20, 0),
(4, 'portfolio', 'Portfolio', '', 20, 0),
(5, 'promotion', 'Promotion', '', 20, 0),
(6, 'seo', 'Search Engine Optimization (SEO)', '', 30, 0),
(7, 'socialmedia', 'Social Media Management', '', 30, 0),
(8, 'logo', 'Logo Design', '', 30, 0),
(9, 'marketing', 'Marketing & Advertisement', '', 30, 0),
(10, 'backup', 'Auto/Cloud Backup', '', 30, 0),
(11, 'security', 'Extra Security', '', 30, 0),
(12, 'speed', 'Speed Optimization', '', 30, 0),
(13, 'newsletter', 'Newsletter', '', 30, 0),
(14, 'chat', 'Live Support Chat Feature', '', 30, 0),
(15, 'maintenance', 'Periodic Maintenance & Updates', '', 30, 0),
(16, 'content', 'Content Writing', '', 30, 0),
(17, 'custom', 'Custom Requests', '', 30, 0),
(20, 'website', 'New Website', '', 0, 1),
(30, 'feature', 'New Feature For Current Website', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `step_ID` int(10) NOT NULL,
  `step_slug` varchar(60) NOT NULL,
  `step_name` varchar(300) NOT NULL,
  `step_order` smallint(6) NOT NULL DEFAULT '0',
  `main_choice_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`step_ID`, `step_slug`, `step_name`, `step_order`, `main_choice_ID`) VALUES
(0, 'concept', 'Website Concept', 0, 20),
(1, 'domain', 'Current Domain Information', 1, 20),
(2, 'server', 'Current Server Information', 2, 20),
(3, 'static_pages', 'Static Pages', 3, 20),
(4, 'dynamic_pages', 'Dynamic Pages', 4, 20),
(5, 'ecommerce_products', 'E-Commerce Products', 5, 1),
(6, 'ecommerce_images', 'E-Commerce Product Images', 6, 1),
(7, 'ecommerce_payment', 'E-Commerce Payment Methods', 7, 1),
(8, 'additional', 'Additional Features and Services', 8, 20),
(9, 'results', 'Results Page', 9, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_title` varchar(10) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(60) NOT NULL,
  `user_level` int(10) NOT NULL,
  `daily_work_hours` int(3) NOT NULL,
  `hourly_rate` int(5) NOT NULL,
  `hourly_rate_currency` varchar(5) NOT NULL,
  `discount_description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `user_name`, `user_email`, `user_password`, `user_title`, `user_first_name`, `user_last_name`, `user_level`, `daily_work_hours`, `hourly_rate`, `hourly_rate_currency`, `discount_description`) VALUES
(1, 'bilal', 'bilaltas@me.com', '$2y$10$eeUBAjuE05eBTwUxlNEAZ.4aKMCkRrrZevnjHEmdpwXWrF7cdc/uG', 'Mr.', 'Bilal', 'TAŞ', 0, 8, 60, '$%d', '*You can adjust the features above according to your budget.'),
(2, 'kubilay', 'oren.kubilay@me.com', '$2y$10$eeUBAjuE05eBTwUxlNEAZ.4aKMCkRrrZevnjHEmdpwXWrF7cdc/uG', 'Mr.', 'Kubilay', 'Ören', 1, 6, 70, '₺%d', '*This rate is special for you.'),
(3, 'murat', 'kubilay.bicakci@outlook.com', '$2y$10$eeUBAjuE05eBTwUxlNEAZ.4aKMCkRrrZevnjHEmdpwXWrF7cdc/uG', 'Mr.', 'Murat Kubilay', 'Bıçakçı', 1, 0, 0, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_ID`),
  ADD KEY `FK_steps` (`step_ID`);

--
-- Indexes for table `inputs`
--
ALTER TABLE `inputs`
  ADD PRIMARY KEY (`input_ID`),
  ADD KEY `FK_fields` (`field_ID`);

--
-- Indexes for table `main_choices`
--
ALTER TABLE `main_choices`
  ADD PRIMARY KEY (`main_choice_ID`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`step_ID`),
  ADD KEY `main_choice_ID` (`main_choice_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `input_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `main_choices`
--
ALTER TABLE `main_choices`
  MODIFY `main_choice_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `FK_steps` FOREIGN KEY (`step_ID`) REFERENCES `steps` (`step_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `inputs`
--
ALTER TABLE `inputs`
  ADD CONSTRAINT `FK_fields` FOREIGN KEY (`field_ID`) REFERENCES `fields` (`field_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `FK_main_choices` FOREIGN KEY (`main_choice_ID`) REFERENCES `main_choices` (`main_choice_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
