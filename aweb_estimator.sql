-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2017 at 03:22 AM
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
  `field_required` tinyint(1) NOT NULL DEFAULT '1',
  `step_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_ID`, `field_slug`, `field_name`, `field_required`, `step_ID`) VALUES
(1, 'domain', 'Will you provide us a domain to use on your project?', 1, 1),
(2, 'server', 'Do you have a hosting package to use on your project?', 1, 2),
(3, 'static', 'Check the static pages you want to add into your website.', 1, 3),
(4, 'dynamic', 'Check the dynamic pages you want to add into your website.', 0, 4),
(5, 'products', 'How many products do you want to add your website for first?', 1, 5),
(6, 'product_image', 'Do you have your images/illustrations to use for the products?', 1, 6),
(7, 'product_watermark', 'Would you like to secure your product images with a watermark?', 1, 6),
(8, 'payment_method', 'Which payment methods will your website use?', 1, 7),
(9, 'ssl', 'Do you want to purchase a SSL Security Certificate? SSL is especially recommended for e-Commerce websites.', 1, 7),
(10, 'additional', 'Check the services you also want to get.', 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

CREATE TABLE `inputs` (
  `input_ID` int(10) NOT NULL,
  `input_slug` varchar(60) NOT NULL,
  `input_name` varchar(100) NOT NULL,
  `input_description` varchar(300) NOT NULL,
  `input_value` varchar(60) NOT NULL,
  `input_required` tinyint(1) NOT NULL DEFAULT '1',
  `input_time` int(20) NOT NULL,
  `input_type` varchar(60) NOT NULL,
  `field_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`input_ID`, `input_slug`, `input_name`, `input_description`, `input_value`, `input_required`, `input_time`, `input_type`, `field_ID`) VALUES
(1, 'domain', 'Yes, I already have my website\'s domain', '', 'yes', 1, 0, 'radio', 1),
(2, 'domain', 'No, we will buy a new domain', '', 'no', 1, 15, 'radio', 1),
(5, 'hosting', 'Yes, It is a <b>Linux Hosting</b>', '', 'linux', 1, 0, 'radio', 2),
(6, 'hosting', 'Yes, It is a <b>Windows Hosting</b>', '', 'windows', 1, 30, 'radio', 2),
(7, 'hosting', 'Other or not sure', '', 'other', 1, 40, 'radio', 2),
(8, 'hosting', 'No, we will buy a new hosting', '', 'no', 1, 30, 'radio', 2),
(9, 'home', 'Home Page', '', 'home', 1, 360, 'checkbox', 3),
(10, 'about', 'About Us Page', '', 'about', 0, 60, 'checkbox', 3),
(11, 'privacy', 'Privacy Policy Page', '', 'privacy', 0, 40, 'checkbox', 3),
(12, 'terms', 'Terms and Conditions Page', '', 'terms', 0, 40, 'checkbox', 3),
(13, 'contact', 'Contact Us Page', '', 'contact', 0, 60, 'checkbox', 3),
(14, 'more_static', 'and', 'more custom static page(s)', '0', 0, 60, 'number', 3);

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
(8, 'additional', 'Additional Features and Services', 8, 20);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `input_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `main_choices`
--
ALTER TABLE `main_choices`
  MODIFY `main_choice_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `step_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
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
