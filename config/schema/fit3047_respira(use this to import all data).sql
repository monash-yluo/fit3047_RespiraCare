-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 09:33 PM
-- Server version: 11.8.6-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fit3047_respira`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_insights`
--

CREATE TABLE `ai_insights` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `risk_level` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `ai_insights`
--

INSERT INTO `ai_insights` (`id`, `patient_id`, `description`, `risk_level`, `created`, `modified`) VALUES
(1, 1, 'Baseline established. No immediate concerns.', 1, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 2, 'Slight decline in respiratory efficiency detected.', 2, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(3, 3, 'High risk: Multiple nocturnal symptoms reported.', 3, '2026-03-21 15:02:11', '2026-03-21 15:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `clinician_id` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `scheduled_date` datetime NOT NULL,
  `duration` int(2) NOT NULL DEFAULT 30,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `patient_id`, `clinician_id`, `notes`, `scheduled_date`, `duration`, `status`, `created`, `modified`) VALUES
(1, 1, 1, 'Initial consultation.', '2026-04-01 10:00:00', 30, 'confirmed', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 2, 1, 'Lung function test.', '2026-04-02 14:30:00', 30, 'declined', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(3, 3, 2, 'Routine follow-up.', '2026-04-03 09:15:00', 30, 'declined', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(6, 1, 1, '123', '2026-05-23 17:23:00', 30, 'confirmed', '2026-05-06 09:24:00', '2026-05-06 10:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `cake_migrations`
--

CREATE TABLE `cake_migrations` (
  `id` int(11) NOT NULL,
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `cake_migrations`
--

INSERT INTO `cake_migrations` (`id`, `version`, `migration_name`, `plugin`, `start_time`, `end_time`, `breakpoint`) VALUES
(2, 20230402063959, 'ContentBlocksMigration', 'ContentBlocks', '2026-04-30 05:54:50', '2026-04-30 05:54:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cake_seeds`
--

CREATE TABLE `cake_seeds` (
  `id` int(11) NOT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `seed_name` varchar(100) NOT NULL,
  `executed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `cake_seeds`
--

INSERT INTO `cake_seeds` (`id`, `plugin`, `seed_name`, `executed_at`) VALUES
(10, NULL, 'ContentBlocksSeed', '2026-05-05 13:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `clinicians`
--

CREATE TABLE `clinicians` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `clinicians`
--

INSERT INTO `clinicians` (`id`, `user_id`, `description`, `created`, `modified`) VALUES
(1, 2, 'Specializing in chronic lung disease and proactive remote patient monitoring.', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 3, 'Dedicated to improving patient outcomes through continuous virtual care.', '2026-03-21 15:02:11', '2026-03-21 15:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'new',
  `message` text NOT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `patient_id`, `first_name`, `last_name`, `email`, `category`, `status`, `message`, `notes`, `created`, `modified`) VALUES
(1, 1, 'John', 'Doe', 'john.patient@example.com', 'Technical Support', 'replied', 'The mobile app is not syncing my data.', NULL, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, NULL, 'Visitor', 'User', 'visitor@web.com', 'General Inquiry', 'new', 'Are you currently accepting new patients?', NULL, '2026-03-21 15:02:11', '2026-03-21 15:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `content_blocks`
--

CREATE TABLE `content_blocks` (
  `id` int(11) NOT NULL,
  `parent` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `value` text DEFAULT NULL,
  `previous_value` text DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `content_blocks`
--

INSERT INTO `content_blocks` (`id`, `parent`, `slug`, `label`, `description`, `type`, `value`, `previous_value`, `modified`) VALUES
(108, 'global', 'website-title', 'Website Title', 'Shown on the home page, as well as any tabs in the users browser.', 'html', '<h1 class=\"sitename mb-0 fs-3\">RespiraCare</h1>', NULL, '2026-05-05 13:36:07'),
(109, 'global', 'dashboard-website-title', 'Dashboard Website Title', 'Shown on the dashboard page.', 'html', '<h1 class=\"text-2xl mr-10 font-semibold text-gray-900 dark:text-white\">RespiraCare</h1>', NULL, '2026-05-05 13:36:07'),
(110, 'global', 'logo-light', 'Light Logo', 'Shown in the centre of the home page, and also in the top corner of all administration pages.', 'image', 'respiracare-Icon.png', NULL, '2026-05-05 13:39:02'),
(111, 'global', 'logo-dark', 'Dark Logo', 'Shown in the centre of the home page, and also in the top corner of all administration pages.', 'image', 'respiracare-Icon-dark.png', NULL, '2026-05-05 13:36:07'),
(112, 'home-hero', 'home-hero-title', 'Home Page Hero Title', 'The main content shown in the centre of the home page.', 'html', '<h1 class=\"fs-2 mb-3\">Your Dedicated Partner in <br><span>COPD Management</span></h1>', NULL, '2026-05-05 13:36:07'),
(113, 'home-hero', 'home-hero-description', 'Home Page Hero Description', 'A brief description for the home page hero section.', 'text', 'Log your daily vitals, receive personalised reminders, \r\n                and get expert respiratory support exactly when you need it.', NULL, '2026-05-05 13:36:07'),
(114, 'home-hero', 'home-hero-image', 'Home Page Hero Image', 'Hero image shown on the home page.', 'image', 'landing-hero.png', NULL, '2026-05-05 13:36:07'),
(115, 'home-process', 'home-process-title', 'Process Section Title', 'Section heading shown above the COPD management steps.', 'text', 'Simple, Remote COPD Management', NULL, '2026-05-05 13:36:07'),
(116, 'home-process', 'home-process-step-titles', 'Process Step Titles', 'Pipe-delimited titles for COPD process steps.', 'text', 'Log Daily Vitals:|Track Symptoms:|Receive Expert Care:', NULL, '2026-05-05 13:36:07'),
(117, 'home-process', 'home-process-step-descriptions', 'Process Step Descriptions', 'Pipe-delimited descriptions for COPD process steps.', 'text', 'Easily record your oxygen saturation (SpO2), blood pressure, and respiratory rate from the comfort of home.|Confidentially update your physician on coughing, wheezing, or shortness of breath via our secure portal.|Get personalised feedback, proactive treatment adjustments, and continuous monitoring.', NULL, '2026-05-05 13:36:07'),
(118, 'home-feature', 'home-feature-image', 'Feature Details Image', 'Image for the feature details section.', 'image', 'landing-feature.svg', NULL, '2026-05-05 13:36:07'),
(119, 'home-feature', 'home-feature-details', 'Feature Details Section', 'HTML content for the feature details section including title and paragraphs.', 'html', '<h3 class=\"fw-bold mb-4\">Empowering Your Respiratory Health</h3><p>Managing Chronic Obstructive Pulmonary Disease shouldn\'t require constant hospital visits. RespiraCare brings the clinic to your living room.</p><p>Our intuitive platform allows you to securely input your daily health data, providing your specialised care team with the real-time insights they need to monitor your condition.</p><p>With automated reminders, we are dedicated to helping you stay proactive about your lung health and preventing flare-ups before they happen.</p>', NULL, '2026-05-05 13:36:07'),
(120, 'home-doctors', 'home-doctors-header', 'Doctors Section Header', 'HTML content for the doctors section header including title and description.', 'html', '<h2 class=\"text-white fw-bold mb-3\">Meet Our Certified Specialists</h2><p class=\"text-white-50 col-lg-8 mb-0\">Our dedicated team of certified physicians and pulmonologists specialise in advanced COPD management, ensuring you receive the highest standard of virtual respiratory care.</p>', NULL, '2026-05-05 13:36:07'),
(121, 'home-doctors', 'doctor-name-1', 'Doctor 1 Name', 'Name of the first specialist doctor.', 'text', 'Dr. Alice Smith', NULL, '2026-05-05 13:36:07'),
(122, 'home-doctors', 'doctor-description-1', 'Doctor 1 Description', 'Description of the first specialist doctor.', 'text', 'Specializing in chronic lung disease and proactive remote patient monitoring.', NULL, '2026-05-05 13:36:07'),
(123, 'home-doctors', 'doctor-name-2', 'Doctor 2 Name', 'Name of the second specialist doctor.', 'text', 'Dr. Emily Rostova', NULL, '2026-05-05 13:36:07'),
(124, 'home-doctors', 'doctor-description-2', 'Doctor 2 Description', 'Description of the second specialist doctor.', 'text', 'Dedicated to improving patient outcomes through continuous virtual care.', NULL, '2026-05-05 13:36:07'),
(125, 'home-doctors', 'doctor-name-3', 'Doctor 3 Name', 'Name of the third specialist doctor.', 'text', 'Dr. Marcus Thompson', NULL, '2026-05-05 13:36:07'),
(126, 'home-doctors', 'doctor-description-3', 'Doctor 3 Description', 'Description of the third specialist doctor.', 'text', 'Passionate about advancing respiratory care through innovative virtual solutions.', NULL, '2026-05-05 13:36:07'),
(127, 'home-doctors', 'doctor-image-1', 'Doctor 1 Image', 'Profile image of the first specialist doctor.', 'image', NULL, NULL, '2026-05-05 13:36:07'),
(128, 'home-doctors', 'doctor-image-2', 'Doctor 2 Image', 'Profile image of the second specialist doctor.', 'image', NULL, NULL, '2026-05-05 13:36:07'),
(129, 'home-doctors', 'doctor-image-3', 'Doctor 3 Image', 'Profile image of the third specialist doctor.', 'image', NULL, NULL, '2026-05-05 13:36:07'),
(130, 'home-doctors', 'home-doctors-cta-text', 'Doctors CTA Section Text', 'Call-to-action text for the doctors section.', 'text', 'Ready to take control of your COPD? Reach out to our team to learn more about how the RespiraCare platform can support your daily health journey. Whether you need help setting up your remote vitals monitoring, or have questions about connecting with our certified specialists, we are here to help.', NULL, '2026-05-05 13:36:07'),
(131, 'about', 'about-hero', 'About Page Hero', 'Hero section HTML for the about page.', 'html', '<h1 class=\"fw-bold mb-3 display-4\">About RespiraCare</h1><p class=\"lead mb-0\">Pioneering the future of remote COPD management.</p>', NULL, '2026-05-05 13:36:07'),
(132, 'about', 'about-mission', 'About Mission Section', 'Mission section HTML for the about page.', 'html', '<span class=\"fw-bold text-uppercase small\" style=\"color: #305BAB; letter-spacing: 1.5px;\">Our Mission</span><h2 class=\"fw-bold mb-4 mt-2 display-6\">Empowering Patients. <br>Redefining Respiratory Care.</h2><p class=\"mb-4 lh-lg fs-5\">Founded by certified physicians specialising in Chronic Obstructive Pulmonary Disease (COPD), RespiraCare Online was built on a simple premise: managing a chronic lung condition should not mean living in a waiting room.</p><p class=\"mb-5 lh-lg\">Our platform allows patients to easily input vital data—such as lung function, oxygen saturation, and daily symptoms—directly from home. By seamlessly connecting this data to specialised clinicians, we provide real-time remote monitoring, personalised treatment adjustments, and total peace of mind.</p>', NULL, '2026-05-05 13:36:07'),
(133, 'about', 'about-clinic-image', 'About Clinic Image', 'Clinic image for the about page mission section.', 'image', 'about-clinic.jpg', NULL, '2026-05-05 13:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `clinician_id` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `sex` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `clinician_id`, `dob`, `sex`, `notes`, `created`, `modified`) VALUES
(1, 4, 1, '1985-05-12', 'Male', 'History of seasonal asthma.', '2026-03-21 15:02:11', '2026-04-23 09:19:52'),
(2, 5, 1, '1992-08-23', 'Female', 'High sensitivity to pollen.', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(3, 6, 2, '1978-11-30', 'Male', 'Smoker, trying to quit.', '2026-03-21 15:02:11', '2026-03-21 15:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `patient_measurements`
--

CREATE TABLE `patient_measurements` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `measured_at` datetime NOT NULL,
  `spo2` int(11) DEFAULT NULL,
  `heart_rate` int(11) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `respiratory_rate` int(11) DEFAULT NULL,
  `peak_flow` int(11) DEFAULT NULL,
  `blood_pressure_systolic` int(11) DEFAULT NULL,
  `blood_pressure_diastolic` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `patient_measurements`
--

INSERT INTO `patient_measurements` (`id`, `patient_id`, `measured_at`, `spo2`, `heart_rate`, `temperature`, `respiratory_rate`, `peak_flow`, `blood_pressure_systolic`, `blood_pressure_diastolic`, `notes`, `created`, `modified`) VALUES
(1, 1, '2026-03-20 08:00:00', 98, 72, 36.6, 16, 450, 120, 80, NULL, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 2, '2026-03-20 09:30:00', 94, 85, 37.1, 20, 390, 130, 85, NULL, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(3, 3, '2026-03-20 22:00:00', 96, 78, 36.8, 18, 410, 125, 82, NULL, '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(4, 1, '2026-05-06 08:30:00', 98, 72, 36.6, 16, 450, 120, 80, NULL, '2026-05-06 08:35:00', '2026-05-06 08:35:00'),
(5, 1, '2026-05-06 20:00:00', 97, 74, 36.7, 16, 445, 122, 82, NULL, '2026-05-06 20:02:10', '2026-05-06 20:02:10'),
(6, 1, '2026-05-07 08:15:00', 99, 68, 36.5, 15, 460, 118, 78, 'Slept very well', '2026-05-07 08:20:00', '2026-05-07 08:20:00'),
(7, 1, '2026-05-08 09:00:00', 98, 75, 36.8, 17, 440, 121, 81, NULL, '2026-05-08 09:05:00', '2026-05-08 09:05:00'),
(8, 1, '2026-05-08 19:30:00', 97, 77, 36.9, 17, 435, 124, 83, 'Felt slightly fatigued after walking', '2026-05-08 19:35:00', '2026-05-08 19:35:00'),
(9, 1, '2026-05-09 08:45:00', 96, 82, 37.1, 18, 425, 126, 85, 'Mild headache this morning', '2026-05-09 08:50:00', '2026-05-09 08:50:00'),
(10, 1, '2026-05-10 08:00:00', 98, 73, 36.6, 16, 450, 120, 80, 'Headache gone, feeling better', '2026-05-10 08:05:00', '2026-05-10 08:05:00'),
(11, 1, '2026-05-10 20:15:00', 98, 71, 36.5, 15, 455, 119, 79, NULL, '2026-05-10 20:20:00', '2026-05-10 20:20:00'),
(12, 1, '2026-05-11 07:45:00', 99, 69, 36.4, 15, 465, 117, 77, NULL, '2026-05-11 07:50:00', '2026-05-11 07:50:00'),
(13, 1, '2026-05-12 08:10:00', 98, 72, 36.6, 16, 450, 120, 80, 'Routine morning check', '2026-05-12 08:15:00', '2026-05-12 08:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `receiver_id`, `sender_id`, `message`, `is_read`, `created`, `modified`) VALUES
(1, 1, 2, 'Hi Admin, I am having trouble accessing the AI insight reports. Could you please verify my permissions?', 1, '2026-03-21 11:30:25', '2026-03-21 11:30:25'),
(2, 4, 2, 'John, please remember to record your SpO2 levels tonight before going to sleep.', 1, '2026-03-21 19:30:00', '2026-03-21 19:30:00'),
(3, 6, 3, 'Charlie, I noticed your recent logs. If the coughing persists, please schedule an urgent follow-up.', 1, '2026-03-21 19:35:00', '2026-03-21 19:35:00'),
(4, 5, NULL, 'System Notification: You have not updated your symptom log for 3 days. Please stay consistent!', 1, '2026-03-21 09:00:00', '2026-03-21 09:00:00'),
(5, 2, 1, 'Notice: The system will undergo maintenance at 23:00 tonight. Access may be limited.', 1, '2026-03-21 14:00:00', '2026-03-21 14:00:00'),
(6, 5, 2, 'Jane, I have updated your treatment plan based on your latest measurements. Please review.', 1, '2026-03-21 16:20:00', '2026-03-21 16:20:00'),
(7, 1, NULL, 'SYSTEM ALERT: High server CPU usage detected (85%+). Please check the server logs immediately.', 1, '2026-03-21 10:15:00', '2026-03-21 10:15:00'),
(8, 3, 2, '123', 1, '2026-04-23 06:32:22', '2026-04-23 06:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `published_date` date DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `content` text DEFAULT NULL,
  `url_link` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `title`, `published_date`, `type`, `content`, `url_link`, `status`, `created`, `modified`) VALUES
(1, 'Asthma Management Guide', '2026-01-10', 'PDF', NULL, 'https://respiracare.com/resources/guide.pdf', 'active', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 'How to use Peak Flow Meter', '2026-02-15', 'Video', NULL, 'https://respiracare.com/resources/video1', 'active', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(4, 'A Comprehensive Understanding of COPD', '2026-05-13', 'Article', '<p>What is COPD?</p><p>Chronic obstructive pulmonary disease (COPD) is a common, preventable, and treatable chronic lung disease. Its main characteristic is persistent airflow limitation, leading to difficulty breathing. COPD is not a single disease; it typically includes both chronic bronchitis and emphysema.</p><p>Core Symptoms</p><p>COPD often has an insidious onset and is easily mistaken for a common smoker\'s cough:</p><ol><li>Chronic cough: Usually the first symptom, worse in the morning.</li><li>Sputum production: Sputum is often white mucus or serous foam.</li><li>Shortness of breath or difficulty breathing: This is a hallmark symptom of COPD. Early on, it only occurs during physical exertion, but later, shortness of breath can be felt even at rest.</li><li>Wheezing and chest tightness: Commonly occurs in severely ill patients or during acute exacerbations.</li><li>Main Causes</li></ol><ul><li>Smoking: This is the most significant contributing factor, including exposure to secondhand smoke.</li><li>Air Pollution: Long-term inhalation of fumes from indoor cooking or outdoor air pollution.</li><li>Occupational Exposure: Long-term exposure to dust, chemicals, or exhaust fumes.</li><li>Biofuels: Cooking with firewood or crop residues in poorly ventilated homes.</li></ul><p>Home Management and Care Recommendations</p><ol><li>Quit Smoking Immediately: This is the most effective way to slow the decline in lung function.</li><li>Respiratory Function Exercises: Learn pursed-lip breathing and diaphragmatic breathing to improve ventilation efficiency.</li><li>Environmental Optimization: Maintain good indoor air circulation and avoid crowded or polluted areas.</li><li>Regular Vaccination: It is recommended to get a flu vaccine annually and a pneumococcal vaccine as prescribed by your doctor to reduce the risk of acute exacerbations.</li></ol><p>Summary</p><p>While COPD cannot be completely cured, patients can significantly improve their quality of life and reduce the frequency of exacerbations through scientific drug treatment (such as inhalers) and lifestyle changes.</p><p>&nbsp;</p><p>&nbsp;</p>', '', 'active', '2026-05-13 20:20:53', '2026-05-13 20:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `symptom_logs`
--

CREATE TABLE `symptom_logs` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `severity` int(11) NOT NULL DEFAULT 1,
  `logged_at` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `symptom_logs`
--

INSERT INTO `symptom_logs` (`id`, `patient_id`, `description`, `severity`, `logged_at`, `notes`, `created`, `modified`) VALUES
(1, 2, 'Feeling tight in the chest after climbing stairs.', 1, '2026-03-20 10:00:00', 'Symptoms resolved after rest.', '2026-03-21 15:02:11', '2026-03-21 15:02:11'),
(2, 3, 'Continuous coughing during the night.', 1, '2026-03-20 03:00:00', 'Did not use emergency inhaler.', '2026-03-21 15:02:11', '2026-03-21 15:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `symptom_logs_symptom_types`
--

CREATE TABLE `symptom_logs_symptom_types` (
  `id` int(11) NOT NULL,
  `symptom_log_id` int(11) NOT NULL,
  `symptom_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `symptom_logs_symptom_types`
--

INSERT INTO `symptom_logs_symptom_types` (`id`, `symptom_log_id`, `symptom_type_id`) VALUES
(2, 1, 1),
(1, 1, 3),
(3, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `symptom_types`
--

CREATE TABLE `symptom_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `symptom_types`
--

INSERT INTO `symptom_types` (`id`, `name`) VALUES
(3, 'Chest Tightness'),
(4, 'Coughing'),
(5, 'Fatigue'),
(1, 'Shortness of Breath'),
(2, 'Wheezing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `image_path` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `image_path`, `phone`, `created`, `modified`) VALUES
(1, 'System', 'Admin', 'admin@dev.u26s1188.iedev.org', '$2y$12$mlxnLgkk5BS17ul4Zf0F/ehGibeodl1clHH7aMu.tkNzMN8GbBpZW', 'admin', '/img/admin.jpg', '+61 401 550 100', '2026-03-21 15:02:11', '2026-03-25 07:09:20'),
(2, 'Alice', 'Smith', 'alice@dev.u26s1188.iedev.org', '$2y$12$aV7kNHrDDpo6KHfFk60xSe.jT3PMyG0tG2P5qd7Uc/uOGiVhWbY4.', 'clinician', 'sarah_jenkins.jpg', '+61 402 550 201', '2026-03-21 15:02:11', '2026-03-21 07:06:18'),
(3, 'Emily', 'Rostova', 'emily@dev.u26s1188.iedev.org', '$2y$12$LYk3Ruf6E/TQBF9X0WAVIe0dtXc5hG4ScUPuS1UoBnAN3HV3avVBS', 'clinician', 'emily_rostova.jpg', '+61 403 550 202', '2026-03-21 15:02:11', '2026-03-21 07:06:26'),
(4, 'John', 'Doe', 'john@dev.u26s1188.iedev.org', '$2y$12$e93jRs2CLEXx04rOdkReHeHupteYNcGM2X9V9wqi7tHUTdwL0aCu2', 'patient', '/img/john.jpg', '+61 404 550 101', '2026-03-21 15:02:11', '2026-04-23 09:19:51'),
(5, 'Jane', 'Miller', 'jane@dev.u26s1188.iedev.org', '$2y$12$iz8dw4sRv5aitqjWtvExaeJoFeU1xtyDsmnuF9epf9yv8UmzD3RRC', 'patient', '/img/jane.jpg', '+61 405 550 102', '2026-03-21 15:02:11', '2026-03-21 07:06:43'),
(6, 'Charlie', 'Brown', 'charlie@dev.u26s1188.iedev.org', '$2y$12$IXRC5eBFM2ZzeC2jj1SpyOkiyHEUm5tEZz9827kiqfGux38Yagvau', 'patient', '/img/charlie.jpg', '+61 406 550 103', '2026-03-21 15:02:11', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_insights`
--
ALTER TABLE `ai_insights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `idx_ai_risk` (`risk_level`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `clinician_id` (`clinician_id`),
  ADD KEY `idx_booking_date` (`scheduled_date`),
  ADD KEY `idx_booking_status` (`status`);

--
-- Indexes for table `cake_migrations`
--
ALTER TABLE `cake_migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `version_plugin_unique` (`version`,`plugin`);

--
-- Indexes for table `cake_seeds`
--
ALTER TABLE `cake_seeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinicians`
--
ALTER TABLE `clinicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `idx_contact_status` (`status`);

--
-- Indexes for table `content_blocks`
--
ALTER TABLE `content_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `clinician_id` (`clinician_id`);

--
-- Indexes for table `patient_measurements`
--
ALTER TABLE `patient_measurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `idx_measurement_date` (`measured_at`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_receiver` (`receiver_id`),
  ADD KEY `idx_sender` (`sender_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_resource_type` (`type`),
  ADD KEY `idx_resource_status` (`status`);

--
-- Indexes for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `idx_symptom_logged_at` (`logged_at`);

--
-- Indexes for table `symptom_logs_symptom_types`
--
ALTER TABLE `symptom_logs_symptom_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_unique_symptom_log` (`symptom_log_id`,`symptom_type_id`),
  ADD KEY `symptom_type_id` (`symptom_type_id`);

--
-- Indexes for table `symptom_types`
--
ALTER TABLE `symptom_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_symptom_name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_user_email` (`email`),
  ADD KEY `idx_user_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_insights`
--
ALTER TABLE `ai_insights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cake_migrations`
--
ALTER TABLE `cake_migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cake_seeds`
--
ALTER TABLE `cake_seeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clinicians`
--
ALTER TABLE `clinicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `content_blocks`
--
ALTER TABLE `content_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient_measurements`
--
ALTER TABLE `patient_measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `symptom_logs_symptom_types`
--
ALTER TABLE `symptom_logs_symptom_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `symptom_types`
--
ALTER TABLE `symptom_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_insights`
--
ALTER TABLE `ai_insights`
  ADD CONSTRAINT `ai_insights_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`clinician_id`) REFERENCES `clinicians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clinicians`
--
ALTER TABLE `clinicians`
  ADD CONSTRAINT `clinicians_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patients_ibfk_2` FOREIGN KEY (`clinician_id`) REFERENCES `clinicians` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `patient_measurements`
--
ALTER TABLE `patient_measurements`
  ADD CONSTRAINT `patient_measurements_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reminders`
--
ALTER TABLE `reminders`
  ADD CONSTRAINT `reminders_ibfk_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reminders_ibfk_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `symptom_logs`
--
ALTER TABLE `symptom_logs`
  ADD CONSTRAINT `symptom_logs_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `symptom_logs_symptom_types`
--
ALTER TABLE `symptom_logs_symptom_types`
  ADD CONSTRAINT `symptom_logs_symptom_types_ibfk_1` FOREIGN KEY (`symptom_log_id`) REFERENCES `symptom_logs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `symptom_logs_symptom_types_ibfk_2` FOREIGN KEY (`symptom_type_id`) REFERENCES `symptom_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
