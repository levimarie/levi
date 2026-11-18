-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2026 at 01:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizify_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('unread','read') DEFAULT 'unread',
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `quiz_id`, `user_id`, `message`, `created_at`, `status`, `is_read`) VALUES
(43, NULL, 4, 'You have successfully created the quiz: Science', '2025-05-29 17:48:16', 'unread', 0),
(44, NULL, 4, 'You have successfully logged in to Quizify', '2025-05-29 18:02:32', 'unread', 0),
(45, NULL, 4, 'You changed your username from aiza21 to Aiza Mae.', '2025-05-29 09:06:29', 'unread', 0),
(51, NULL, 4, 'You have successfully logged in to Quizify', '2025-05-29 20:30:45', 'unread', 0),
(52, NULL, 4, 'You have successfully logged in to Quizify', '2025-05-30 01:26:36', 'unread', 0),
(54, NULL, 9, 'You have successfully created the quiz: Filipino', '2025-05-30 01:27:44', 'unread', 1),
(55, NULL, 9, 'You have successfully created the quiz: English', '2025-05-30 01:29:00', 'unread', 1),
(56, NULL, 9, 'You have successfully logged in to Quizify', '2025-05-30 04:36:15', 'unread', 1),
(57, NULL, 9, 'You have successfully created the quiz: English', '2025-05-30 05:37:08', 'unread', 1),
(58, NULL, 9, 'You have successfully logged in to Quizify', '2025-05-30 15:13:15', 'unread', 1),
(59, NULL, 9, 'You have successfully created the quiz: English', '2025-05-30 15:17:12', 'unread', 1),
(60, NULL, 9, 'You have successfully logged in to Quizify', '2025-05-30 19:55:20', 'unread', 0),
(61, NULL, 2, 'You have successfully logged in to Quizify', '2025-05-30 20:08:41', 'unread', 0),
(62, NULL, 2, 'You have successfully created the quiz: Filipino', '2025-05-30 20:15:03', 'unread', 0),
(72, NULL, 10, 'You have successfully logged in to Quizify', '2025-05-30 22:03:47', 'unread', 0),
(73, NULL, 10, 'You have successfully created the quiz: Filipino', '2025-05-30 22:04:45', 'unread', 0),
(74, NULL, 10, 'You have successfully created the quiz: English', '2025-05-30 22:06:56', 'unread', 0),
(75, NULL, 10, 'You changed your username from genrose to rose.', '2025-05-30 13:09:56', 'unread', 0),
(76, NULL, 10, 'You changed your email from genrose@rosil to rose@hghh.', '2025-05-30 13:10:19', 'unread', 0),
(77, NULL, 10, 'Quiz \"english\" was updated.', '2025-05-30 13:11:34', 'unread', 0),
(78, NULL, 10, 'You have successfully created the quiz: English', '2025-05-30 22:13:22', 'unread', 0),
(79, NULL, 11, 'You have successfully logged in to Quizify', '2025-06-02 05:56:38', 'unread', 0),
(80, NULL, 11, 'You have successfully created the quiz: English', '2025-06-02 05:57:52', 'unread', 0),
(81, NULL, 12, 'You have successfully logged in to Quizify', '2025-06-02 06:05:04', 'unread', 0),
(82, NULL, 12, 'You have successfully created the quiz: English', '2025-06-02 06:05:54', 'unread', 0),
(83, NULL, 0, 'User \'Levi\' has deleted their account.', '2025-06-01 21:12:24', 'unread', 0),
(96, NULL, 0, 'User \'Levi Marie\' has deleted their account.', '2025-06-01 21:36:32', 'unread', 0),
(100, NULL, 1, 'You have successfully created the quiz: English', '2026-11-18 05:58:04', 'unread', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `subject`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 'English', 'What is the antonym of \"easy\"?', 'Hard', 'Simple', 'Quick', 'Bright', 'A'),
(2, 'English', 'What is the synonym of \"big\"?', 'Tiny', 'Huge', 'Small', 'Short', 'B'),
(3, 'English', 'Which word means the opposite of \"cold\"?', 'Hot', 'Cool', 'Freezing', 'Ice', 'A'),
(4, 'English', 'What is the synonym of \"happy\"?', 'Sad', 'Joyful', 'Angry', 'Tired', 'B'),
(5, 'English', 'What is the antonym of \"begin\"?', 'Start', 'Commence', 'End', 'Initiate', 'C'),
(6, 'English', 'Which word is a synonym of \"kind\"?', 'Slow', 'Rapid', 'Lazy', 'Late', 'B'),
(7, 'English', 'What is the antonym of \"strong\"?', 'Weak', 'Powerful', 'Sturdy', 'Mighty', 'A'),
(8, 'English', 'Which word is a synonym of \"angry\"?', 'Happy', 'Furious', 'Calm', 'Joyful', 'B'),
(9, 'English', 'What is the antonym of \"hot\"?', 'Warm', 'Cold', 'Boiling', 'Heated', 'B'),
(10, 'English', 'Which word is a synonym of \"beautiful\"?', 'Ugly', 'Pretty', 'Plain', 'Dull', 'B'),
(14, 'English', 'What is the synonym of \"smart\"?', 'Intelligent', 'Dull', 'Lazy', 'Slow', 'A'),
(15, 'English', 'What is the antonym of \"clean\"?', 'Neat', 'Tidy', 'Dirty', 'Pure', 'C'),
(16, 'English', 'What is the synonym of \"cold\"?', 'Hot', 'Chilly', 'Warm', 'Boiling', 'B'),
(17, 'English', 'What is the antonym of \"up\"?', 'Down', 'Above', 'Over', 'High', 'A'),
(18, 'English', 'What is the synonym of \"big\"?', 'Tiny', 'Huge', 'Small', 'Short', 'B'),
(19, 'English', 'What is the antonym of \"open\"?', 'Close', 'Shut', 'Seal', 'Lock', 'B'),
(20, 'English', 'What is the synonym of \"happy\"?', 'Sad', 'Joyful', 'Angry', 'Tired', 'B'),
(21, 'English', 'What is the antonym of \"begin\"?', 'Start', 'Commence', 'End', 'Initiate', 'C'),
(22, 'English', 'What is the synonym of \"quick\"?', 'Slow', 'Rapid', 'Lazy', 'Late', 'B'),
(23, 'English', 'What is the antonym of \"strong\"?', 'Weak', 'Powerful', 'Sturdy', 'Mighty', 'A'),
(24, 'English', 'What is the synonym of \"angry\"?', 'Happy', 'Furious', 'Calm', 'Joyful', 'B'),
(25, 'English', 'What is the synonym of \"beautiful\"?', 'Ugly', 'Pretty', 'Plain', 'Dull', 'B'),
(26, 'English', 'What is the antonym of \"early\"?', 'Prompt', 'Late', 'Timely', 'Punctual', 'B'),
(27, 'English', 'What is the synonym of \"smart\"?', 'Intelligent', 'Dull', 'Lazy', 'Slow', 'A'),
(28, 'English', 'What is the antonym of \"clean\"?', 'Neat', 'Tidy', 'Dirty', 'Pure', 'C'),
(29, 'English', 'What is the synonym of \"abandon\"?', 'Leave', 'Stay', 'Arrive', 'Enter', 'A'),
(30, 'English', 'What is the antonym of \"ancient\"?', 'Old', 'Modern', 'Historic', 'Antique', 'B'),
(31, 'English', 'What is the synonym of \"brave\"?', 'Cowardly', 'Fearful', 'Courageous', 'Timid', 'C'),
(32, 'English', 'What is the antonym of \"create\"?', 'Build', 'Destroy', 'Invent', 'Construct', 'B'),
(33, 'English', 'What is the synonym of \"difficult\"?', 'Easy', 'Hard', 'Simple', 'Light', 'B'),
(34, 'English', 'What is the antonym of \"ancient\"?', 'Old', 'Modern', 'Historic', 'Antique', 'B'),
(35, 'English', 'What is the antonym of \"expand\"?', 'Enlarge', 'Increase', 'Contract', 'Grow', 'C'),
(36, 'English', 'What is the synonym of \"frequent\"?', 'Rare', 'Often', 'Seldom', 'Never', 'B'),
(37, 'English', 'What is the antonym of \"generous\"?', 'Kind', 'Selfish', 'Giving', 'Charitable', 'B'),
(38, 'English', 'What is the synonym of \"honest\"?', 'Deceitful', 'Truthful', 'Lying', 'Dishonest', 'B'),
(39, 'English', 'What is the antonym of \"increase\"?', 'Grow', 'Expand', 'Decrease', 'Enlarge', 'C'),
(40, 'English', 'What is the synonym of \"joyful\"?', 'Sad', 'Happy', 'Angry', 'Upset', 'B'),
(41, 'English', 'What is the antonym of \"kind\"?', 'Nice', 'Cruel', 'Friendly', 'Gentle', 'B'),
(42, 'English', 'What is the synonym of \"lazy\"?', 'Active', 'Energetic', 'Idle', 'Busy', 'C'),
(43, 'English', 'What is the antonym of \"major\"?', 'Minor', 'Big', 'Large', 'Great', 'B'),
(44, 'English', 'What is the synonym of \"narrow\"?', 'Wide', 'Broad', 'Slim', 'Thick', 'C'),
(45, 'English', 'What is the antonym of \"optimistic\"?', 'Hopeful', 'Positive', 'Pessimistic', 'Cheerful', 'C'),
(46, 'English', 'What is the synonym of \"polite\"?', 'Rude', 'Courteous', 'Impolite', 'Mean', 'B'),
(47, 'English', 'What is the antonym of \"quick\"?', 'Fast', 'Rapid', 'Slow', 'Swift', 'C'),
(48, 'English', 'What is the synonym of \"rich\"?', 'Wealthy', 'Poor', 'Broke', 'Needy', 'A'),
(49, 'English', 'What is the antonym of \"strong\"?', 'Weak', 'Powerful', 'Sturdy', 'Mighty', 'A'),
(50, 'English', 'What is the synonym of \"vacant\"?', 'Occupied', 'Empty', 'Full', 'Taken', 'B'),
(51, 'English', 'What is the synonym of \"young\"?', 'Old', 'Elderly', 'Youthful', 'Aged', 'C'),
(52, 'English', 'What is the antonym of \"accept\"?', 'Receive', 'Reject', 'Admit', 'Agree', 'B'),
(53, 'English', 'What is the synonym of \"bright\"?', 'Dim', 'Shiny', 'Dull', 'Dark', 'B'),
(54, 'English', 'What is the antonym of \"calm\"?', 'Peaceful', 'Quiet', 'Agitated', 'Serene', 'C'),
(55, 'English', 'What is the synonym of \"dangerous\"?', 'Safe', 'Risky', 'Secure', 'Harmless', 'B'),
(56, 'English', 'What is the antonym of \"early\"?', 'Prompt', 'Late', 'Timely', 'Punctual', 'B'),
(57, 'English', 'What is the synonym of \"famous\"?', 'Unknown', 'Renowned', 'Obscure', 'Nameless', 'B'),
(58, 'English', 'What is the antonym of \"gain\"?', 'Win', 'Lose', 'Earn', 'Acquire', 'B'),
(59, 'English', 'What is the synonym of \"happy\"?', 'Sad', 'Joyful', 'Angry', 'Tired', 'B'),
(60, 'English', 'What is the antonym of \"increase\"?', 'Grow', 'Expand', 'Decrease', 'Enlarge', 'C'),
(61, 'English', 'What is the synonym of \"jolly\"?', 'Gloomy', 'Cheerful', 'Sad', 'Depressed', 'B'),
(62, 'English', 'What is the synonym of \"jolly\"?', 'Gloomy', 'Cheerful', 'Sad', 'Depressed', 'B'),
(63, 'English', 'What is the antonym of \"kind\"?', 'Nice', 'Cruel', 'Friendly', 'Gentle', 'B'),
(64, 'English', 'What is the synonym of \"lucky\"?', 'Unfortunate', 'Fortunate', 'Unlucky', 'Cursed', 'B'),
(65, 'English', 'What is the antonym of \"modern\"?', 'Ancient', 'New', 'Current', 'Recent', 'A'),
(66, 'English', 'What is the synonym of \"neat\"?', 'Messy', 'Tidy', 'Dirty', 'Cluttered', 'B'),
(67, 'English', 'What is the antonym of \"open\"?', 'Close', 'Shut', 'Seal', 'Lock', 'B'),
(68, 'English', 'What is the synonym of \"peaceful\"?', 'Violent', 'Calm', 'Aggressive', 'Hostile', 'B'),
(69, 'English', 'What is the antonym of \"quiet\"?', 'Noisy', 'Silent', 'Still', 'Calm', 'A'),
(70, 'English', 'A paragraph is made up of sentences.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(71, 'English', 'The past tense of eat is ate.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(72, 'English', 'Its is the same as its.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(73, 'English', 'The word quiet is spelled correctly.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(74, 'English', 'Book is a verb.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(75, 'English', 'He plays soccer every day is in present simple tense.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(76, 'English', 'All sentences must have a subject and predicate.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(77, 'English', 'The word them is a possessive pronoun.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(78, 'English', 'An adverb can describe a verb.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(79, 'English', '\"See\" and \"sea\" are homophones.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(80, 'English', 'A preposition shows relationship between a noun and another word.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(81, 'English', 'Was is used with plural subjects.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(82, 'English', 'The word honest starts with a silent letter.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(83, 'English', 'May and can can both express permission.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(84, 'English', 'A colon is used to show possession.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(85, 'English', 'The word I should always be capitalized.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(86, 'English', 'Quickly is an example of an adjective.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(87, 'English', 'The word honor is spelled differently in British English.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(88, 'English', 'A compound sentence contains two independent clauses.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(89, 'English', 'An interjection expresses emotion.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(90, 'English', 'To, too, and two are homophones.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(91, 'English', 'Run is always used as a noun.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(92, 'English', 'A question should end with a question mark.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(93, 'English', 'An acronym is a word formed from initials of other words.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(94, 'English', 'A proper noun always begins with a capital letter.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(95, 'English', 'She dont like apples is grammatically correct.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(96, 'English', 'Laugh and smile are synonyms.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(97, 'English', 'Every sentence must have a verb.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(98, 'English', 'The word honest has a silent h.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(99, 'English', 'The simple past of go is gone.', 'True', 'False', 'Both A and B', 'All of the above', 'B'),
(100, 'English', 'Is, am, and are are all forms of to be.', 'True', 'False', 'Both A and B', 'All of the above', 'A'),
(101, 'Filipino', 'Ano ang tawag sa mga titik na bumubuo ng isang salita?', 'Pantig', 'Alpabeto', 'Titik', 'Letra', 'A'),
(102, 'Filipino', 'Ano ang tawag sa mga titik na bumubuo ng isang salita?', 'Pantig', 'Alpabeto', 'Titik', 'Letra', 'A'),
(103, 'Filipino', 'Anong uri ng pangngalan ang paaralan?', 'Pantangi', 'Pambalana', 'Pang-uri', 'Pang-abay', 'B'),
(104, 'Filipino', 'Ang Jose Rizal ay halimbawa ng anong uri ng pangngalan?', 'Pambalana', 'Pantangi', 'Panghalip', 'Pang-uri', 'B'),
(105, 'Filipino', 'Alin sa mga sumusunod ang panghalip?', 'Siya', 'Aklat', 'Mesa', 'Lapis', 'A'),
(106, 'Filipino', 'Ano ang kasingkahulugan ng \"masaya\"?', 'Malungkot', 'Magulo', 'Masigla', 'Matapang', 'C'),
(107, 'Filipino', 'Ang salitang \"malaki\" ay kabaligtaran ng...', 'Maliit', 'Mabigat', 'Malayo', 'Mabilis', 'A'),
(108, 'Filipino', 'Piliin ang tamang gamit ng \"ng\"', 'Ako ay kumain ng mangga.', 'Ako ay ng kumain mangga.', 'Kumain ako mangga ng.', 'Ako ng mangga ay kumain.', 'A'),
(109, 'Filipino', 'Ano ang salitang-ugat ng \"paglilinis\"?', 'Linis', 'Linisin', 'Naglinis', 'Nilinis', 'A'),
(110, 'Filipino', 'Alin ang tambalang salita?', 'Bahaghari', 'Isda', 'Bahay', 'Tubig', 'A'),
(111, 'Filipino', 'Ano ang tawag sa larawan ng damdamin ng isang tauhan sa kwento?', 'Banghay', 'Tauhan', 'Dayalogo', 'Damdamin', 'D'),
(112, 'Filipino', 'Alin sa mga sumusunod ang **pandiwa**?', 'Takbo', 'Maganda', 'Aklat', 'Lamesa', 'A'),
(113, 'Filipino', 'Ang salitang \"kahon\" ay isang uri ng...', 'Pangngalan', 'Pandiwa', 'Pang-abay', 'Pang-uri', 'A'),
(114, 'Filipino', 'Ano ang wastong baybay ng salitang nangangahulugang \"hindi totoo\"?', 'Sinungaling', 'Senungaling', 'Sinongaling', 'Sinungaleng', 'A'),
(115, 'Filipino', 'Anong bahagi ng pananalita ang naglalarawan?', 'Pangngalan', 'Pandiwa', 'Pang-abay', 'Pang-uri', 'D'),
(116, 'Filipino', 'Ang \"masipag\" ay kabaligtaran ng...', 'Masaya', 'Tamad', 'Magulo', 'Marunong', 'B'),
(117, 'Filipino', 'Alin sa mga sumusunod ang halimbawa ng **pang-abay**?', 'Mabilis', 'Aso', 'Takbo', 'Lamesa', 'A'),
(118, 'Filipino', 'Piliin ang salitang **pantangi**.', 'Guro', 'Aklat', 'Pedro', 'Silya', 'C'),
(119, 'Filipino', 'Ano ang ibig sabihin ng tambalang salitang \"silid-aralan\"?', 'Silid ng pagkain', 'Silid ng laro', 'Silid ng pag-aaral', 'Silid ng pahinga', 'C'),
(120, 'Filipino', 'Alin sa mga sumusunod ang **hindi** bahagi ng kwento?', 'Tauhan', 'Banghay', 'Pamagat', 'Lamesa', 'D'),
(121, 'Filipino', 'Ano ang wastong baybay ng salitang pantukoy sa maraming bagay?', 'Mga', 'Manga', 'Manga\'', 'Mga\'', 'A'),
(122, 'Filipino', 'Anong uri ng pangungusap ito: \"Ang ganda ng bulaklak!\"', 'Pasalaysay', 'Patanong', 'Padamdam', 'Pautos', 'C'),
(123, 'Filipino', 'Piliin ang kasingkahulugan ng \"matalino\".', 'Maganda', 'Marunong', 'Malaki', 'Mabango', 'B'),
(124, 'Filipino', 'Piliin ang kasalungat ng \"mabilis\".', 'Mabagal', 'Maingay', 'Masaya', 'Matamis', 'A'),
(125, 'Filipino', 'Anong uri ng pangungusap ang \"Pakiabot mo ang lapis.\"?', 'Pasalaysay', 'Pautos', 'Patanong', 'Padamdam', 'B'),
(126, 'Filipino', 'Ang salitang \"maganda\" ay isang...', 'Pangngalan', 'Pandiwa', 'Pang-abay', 'Pang-uri', 'D'),
(127, 'Filipino', 'Piliin ang tamang gamit ng salitang \"may\".', 'May lapis ako.', 'Mayroon lapis ako.', 'May lapis mayroon.', 'Ako may lapis mayroon.', 'A'),
(128, 'Filipino', 'Ano ang dapat gamitin kapag maraming gamit?', 'May', 'Mayroon', 'Meron', 'Meyron', 'B'),
(129, 'Filipino', 'Ano ang tawag sa pagkakasunod-sunod ng mga pangyayari sa kwento?', 'Tauhan', 'Tagpuan', 'Banghay', 'Wakas', 'C'),
(130, 'Filipino', 'Alin sa mga sumusunod ang **hindi** pangngalan?', 'Aklat', 'Lamesa', 'Kumain', 'Silya', 'C'),
(131, 'Filipino', 'Piliin ang kasalungat ng \"mataas\".', 'Mababa', 'Malayo', 'Malaki', 'Masikip', 'A'),
(132, 'Filipino', 'Ano ang tawag sa mga salitang magkasalungat ang kahulugan?', 'Magkasama', 'Magkasingkahulugan', 'Magkasalungat', 'Magkakambal', 'C'),
(133, 'Filipino', 'Ano ang tawag sa mga salitang magkapareho o magkalapit ang kahulugan?', 'Magkasama', 'Magkasingkahulugan', 'Magkasalungat', 'Magkatulad', 'B'),
(134, 'Filipino', 'Alin sa mga sumusunod ang pang-uri?', 'Mabango', 'Upo', 'Kumain', 'Ngayon', 'A'),
(135, 'Filipino', 'Ano ang tamang pangungusap?', 'Ako ay nagbabasa ng aklat.', 'Nagbabasa ako aklat.', 'Ako aklat nagbabasa.', 'Aklat ako nagbasa.', 'A'),
(136, 'Filipino', 'Anong bahagi ng pananalita ang \"araw-araw\"?', 'Pandiwa', 'Pangngalan', 'Pang-abay', 'Pang-uri', 'C'),
(137, 'Filipino', 'Piliin ang pangngalang pantangi.', 'Babae', 'Guro', 'Juan', 'Lalaki', 'C'),
(138, 'Filipino', 'Ang \"kumain\" ay anong bahagi ng pananalita?', 'Pang-abay', 'Pandiwa', 'Pang-uri', 'Pangngalan', 'B'),
(139, 'Filipino', 'Ano ang kasalungat ng \"malamig\"?', 'Mataas', 'Mainit', 'Mabigat', 'Mahaba', 'B'),
(140, 'Filipino', 'Ang \"silid-aklatan\" ay isang halimbawa ng...', 'Pandiwa', 'Pangngalan', 'Tambalang salita', 'Panghalip', 'C'),
(141, 'Filipino', 'Piliin ang kasingkahulugan ng \"matapang\".', 'Mabait', 'Malakas', 'Matigas', 'Matibay', 'B'),
(142, 'Filipino', 'Alin ang wastong gamit ng \"rin\"?', 'Siya rin ay sasama.', 'Rin siya ay sasama.', 'Siya ay rin sasama.', 'Sasama siya rin.', 'A'),
(143, 'Filipino', 'Ano ang salitang-ugat ng \"naglaro\"?', 'Laro', 'Naglaruan', 'Nag', 'Naglaro', 'A'),
(144, 'Filipino', 'Piliin ang tamang baybay ng salitang nangangahulugang lugar na pinagtutulugan.', 'Kuwarto', 'Kwato', 'Kwartu', 'Kuwatro', 'A'),
(145, 'Filipino', 'Ang pangungusap na \"Kumain si Ana ng mangga.\" ay may pandiwang nasa anong panahunan?', 'Pangnagdaan', 'Pangkasalukuyan', 'Panghinaharap', 'Pang-uri', 'A'),
(146, 'Filipino', 'Anong bahagi ng pananalita ang \"ikaw\"?', 'Panghalip', 'Pangngalan', 'Pang-abay', 'Pandiwa', 'A'),
(147, 'Filipino', 'Piliin ang kasalungat ng \"maingay\".', 'Tahimik', 'Magulo', 'Masaya', 'Malakas', 'A'),
(148, 'Filipino', 'Ano ang tawag sa pagsasama ng dalawang salita upang bumuo ng bagong salita?', 'Pag-uulit', 'Pagpapahaba', 'Pagtatambal', 'Paglilipat', 'C'),
(150, 'Filipino', 'Alin ang pangungusap na nagpapayo?', 'Kumain ka ng gulay.', 'Ang gulay ay masustansya.', 'Masarap ang gulay.', 'Gulay ang gusto ko.', 'A'),
(151, 'Filipino', 'Anong uri ng pangungusap ang \"Buksan mo ang pinto.\"?', 'Pautos', 'Padamdam', 'Patanong', 'Pasalaysay', 'A'),
(152, 'Filipino', 'Anong bahagi ng aklat ang nagpapakita ng listahan ng mga nilalaman?', 'Pamagat', 'Talaan ng Nilalaman', 'Index', 'Paunang Salita', 'B'),
(153, 'Filipino', 'Ano ang tamang gamit ng \"doon\"?', 'Doon ako nagpunta kahapon.', 'Doon kahapon ako nagpunta.', 'Ako kahapon nagpunta doon.', 'Nagpunta ako kahapon doon.', 'A'),
(154, 'Filipino', 'Ang \"makata\" ay isang taong...', 'Umiiyak', 'Sumasayaw', 'Sumusulat ng tula', 'Umaawit', 'C'),
(155, 'Filipino', 'Ano ang ibig sabihin ng salitang \"mapagkumbaba\"?', 'Mayabang', 'Matulungin', 'Hindi mapagmataas', 'Masaya', 'C'),
(156, 'Filipino', 'Alin sa mga sumusunod ang tambalang salita?', 'Araw-araw', 'Gabi', 'Umaga', 'Lakad', 'A'),
(157, 'Filipino', 'Anong bahagi ng pananalita ang \"kanila\"?', 'Panghalip', 'Pandiwa', 'Pangngalan', 'Pang-uri', 'A'),
(158, 'Filipino', 'Ang salitang \"malambing\" ay ginagamit upang ilarawan ang...', 'Gamit', 'Lugar', 'Tao', 'Hayop', 'C'),
(159, 'Filipino', 'Piliin ang pangungusap na padamdam.', 'Aray! Nasugatan ako.', 'Kumain ako ng mangga.', 'Gusto ko ng laruan.', 'Nag-aral ako kagabi.', 'A'),
(160, 'Filipino', 'Ano ang kasalungat ng \"masaya\"?', 'Malungkot', 'Makulit', 'Mabait', 'Masipag', 'A'),
(161, 'Filipino', 'Anong salita ang pantukoy sa iisang bagay?', 'Ang', 'Mga', 'Ng', 'Sa', 'A'),
(162, 'Filipino', 'Piliin ang kasingkahulugan ng \"maganda\".', 'Pangit', 'Marikit', 'Masama', 'Matapang', 'B'),
(163, 'Filipino', 'Ano ang tawag sa pagkakasunod-sunod ng mga letra sa alpabeto?', 'Pagbabaybay', 'Pag-uulit', 'Pagsusulat', 'Pagbigkas', 'A'),
(164, 'Filipino', 'Alin ang tamang pangungusap?', 'May dala akong payong.', 'Dala akong payong may.', 'Payong dala akong may.', 'Ako may payong dala.', 'A'),
(165, 'Filipino', 'Ano ang ibig sabihin ng sawikain na \"nasa kamay mo ang desisyon\"?', 'Naghuhugas ng kamay', 'May dala kang bagay', 'Ikaw ang magpapasya', 'May sugat sa kamay', 'C'),
(166, 'Filipino', 'Ano ang bahagi ng pananalita na ginagamit bilang panghalili sa ngalan ng tao?', 'Pang-abay', 'Pang-uri', 'Panghalip', 'Pangngalan', 'C'),
(167, 'Filipino', 'Ano ang tawag sa taong mahilig magbasa?', 'Manunulat', 'Mambabasa', 'Magtutula', 'Tagapagsalita', 'B'),
(168, 'Filipino', 'Alin sa mga sumusunod ang halimbawa ng payak na pangungusap?', 'Si Ana ay naglilinis.', 'Dahil umuulan, hindi kami lumabas.', 'Nag-aral siya ngunit bumagsak.', 'Kumain si Ana habang nanonood.', 'A'),
(169, 'Filipino', 'Ano ang kasingkahulugan ng \"mabilis\"?', 'Mabagal', 'Maiksi', 'Matulin', 'Mataas', 'C'),
(170, 'Filipino', 'Ang \"masipag\" ay kabaligtaran ng \"tamad\".', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(171, 'Filipino', 'Ang \"araw-araw\" ay isang tambalang salita na inuulit.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(172, 'Filipino', 'Ang \"umaga\" ay isang halimbawa ng pangngalan.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(173, 'Filipino', 'Ang \"siya\" ay isang halimbawa ng panghalip.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(174, 'Filipino', 'Ang \"naglakad\" ay isang halimbawa ng pandiwa.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(175, 'Filipino', 'Ang \"malaki\" ay kabaligtaran ng \"maliit\".', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(176, 'Filipino', 'Ang salitang \"marumi\" ay kasingkahulugan ng \"malinis\".', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'B'),
(177, 'Filipino', 'Ang \"masaya\" ay isang pang-uri na naglalarawan ng damdamin.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(178, 'Filipino', 'Ang \"bahaghari\" ay isang tambalang salita.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(179, 'Filipino', 'Ang pangungusap ay dapat nagsisimula sa maliit na titik.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'B'),
(180, 'Filipino', 'Ang \"at\", \"pero\", at \"dahil\" ay mga halimbawa ng pangatnig.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(181, 'Filipino', 'Ang \"kumain\" ay isang halimbawa ng pandiwa.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(182, 'Filipino', 'Ang \"ako\", \"ikaw\", at \"sila\" ay mga halimbawa ng panghalip.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(183, 'Filipino', 'Ang \"masarap\" ay ginagamit upang ilarawan ang lasa.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(184, 'Filipino', 'Ang \"bata\" ay isang halimbawa ng pang-uri.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'B'),
(185, 'Filipino', 'Ang tambalang salita ay binubuo ng dalawang salitang pinagsama.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(186, 'Filipino', 'Ang pangngalang pantangi ay karaniwang nagsisimula sa maliit na titik.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'B'),
(187, 'Filipino', 'Ang \"maganda\" ay kasalungat ng \"pangit\".', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(188, 'Filipino', 'Ang pangungusap na \"Mag-aral ka nang mabuti.\" ay nagpapahayag ng utos.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(189, 'Filipino', 'Ang \"umaga\", \"hapon\", at \"gabi\" ay mga bahagi ng araw.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(190, 'Filipino', 'Ang \"basa\" ay maaaring maging pandiwa o pang-uri depende sa gamit sa pangungusap.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(191, 'Filipino', 'Ang \"sumayaw\" ay isang pandiwa na nagsasaad ng kilos.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(192, 'Filipino', 'Ang pang-abay ay naglalarawan ng kilos.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(193, 'Filipino', 'Ang \"bahay-kubo\" ay halimbawa ng tambalang salita.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(194, 'Filipino', 'Ang \"lunti\" ay isang kulay.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(195, 'Filipino', 'Ang \"at\", \"o\", at \"pero\" ay pang-ukol.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'B'),
(196, 'Filipino', 'Ang \"maingay\" ay pang-uri na naglalarawan sa tunog.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(197, 'Filipino', 'Ang \"matulungin\" ay isang positibong katangian.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(198, 'Filipino', 'Ang panlaping \"mag-\" ay ginagamit sa pandiwa.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(199, 'Filipino', 'Ang \"madumi\" ay kasalungat ng \"malinis\".', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(200, 'Filipino', 'Ang pangngalan ay maaaring pantangi o pambalana.', 'Tama', 'Mali', 'A at B', 'Lahat ng nabanggit', 'A'),
(201, 'Science', 'What do plants need to make their own food?', 'Rocks', 'Sunlight', 'Moonlight', 'Soil', 'B'),
(202, 'Science', 'Which part of the plant takes in water from the soil?', 'Flower', 'Leaf', 'Stem', 'Roots', 'D'),
(203, 'Science', 'Which is a source of light?', 'Mirror', 'Moon', 'Sun', 'Spoon', 'C'),
(204, 'Science', 'What do animals need to breathe?', 'Soil', 'Water', 'Food', 'Air', 'D'),
(205, 'Science', 'What body part helps you smell?', 'Eyes', 'Ears', 'Nose', 'Hands', 'C'),
(206, 'Science', 'How many legs does an insect have?', '4', '6', '8', '2', 'B'),
(207, 'Science', 'What is the liquid form of water called?', 'Ice', 'Steam', 'Gas', 'Water', 'D'),
(208, 'Science', 'Which of these is not a planet?', 'Earth', 'Mars', 'Sun', 'Venus', 'C'),
(209, 'Science', 'Which sense organ helps you see?', 'Tongue', 'Ear', 'Eye', 'Skin', 'C'),
(210, 'Science', 'Which of these is a solid?', 'Water', 'Steam', 'Ice', 'Air', 'C'),
(211, 'Science', 'What do we call animals that eat only plants?', 'Carnivores', 'Herbivores', 'Omnivores', 'Insectivores', 'B'),
(212, 'Science', 'What force pulls things to the ground?', 'Light', 'Heat', 'Gravity', 'Magnetism', 'C'),
(213, 'Science', 'What do we breathe in from the air?', 'Carbon dioxide', 'Nitrogen', 'Oxygen', 'Hydrogen', 'C'),
(214, 'Science', 'Which is a source of heat?', 'Flashlight', 'Fan', 'Fire', 'Ice', 'C'),
(215, 'Science', 'What tool helps us see tiny objects?', 'Telescope', 'Thermometer', 'Microscope', 'Binoculars', 'C'),
(216, 'Science', 'Which part of the body helps you taste?', 'Nose', 'Ears', 'Tongue', 'Hands', 'C'),
(217, 'Science', 'Which of the following is a gas?', 'Rock', 'Steam', 'Ice', 'Wood', 'B'),
(218, 'Science', 'Which planet do we live on?', 'Mars', 'Venus', 'Earth', 'Jupiter', 'C'),
(219, 'Science', 'Which part of the plant is usually colorful and attracts bees?', 'Root', 'Stem', 'Flower', 'Leaf', 'C'),
(220, 'Science', 'Which of these is man-made?', 'Tree', 'Rock', 'Car', 'River', 'C'),
(221, 'Science', 'Which animal lays eggs?', 'Dog', 'Cat', 'Chicken', 'Horse', 'C'),
(222, 'Science', 'Which of these is a living thing?', 'Chair', 'Cat', 'Pencil', 'Book', 'B'),
(223, 'Science', 'What helps fish to breathe in water?', 'Nose', 'Mouth', 'Gills', 'Fins', 'C'),
(224, 'Science', 'Which of the following has feathers?', 'Snake', 'Dog', 'Bird', 'Frog', 'C'),
(225, 'Science', 'What do we use to measure temperature?', 'Scale', 'Thermometer', 'Ruler', 'Barometer', 'B'),
(226, 'Science', 'Which of the following is a liquid?', 'Ice', 'Water', 'Stone', 'Iron', 'B'),
(227, 'Science', 'What does the sun give us?', 'Moonlight', 'Rain', 'Snow', 'Heat and light', 'D'),
(228, 'Science', 'Which part of your body helps you hear?', 'Mouth', 'Eyes', 'Nose', 'Ears', 'D'),
(229, 'Science', 'Which of the following is found in space?', 'Forest', 'Sun', 'Tree', 'River', 'B'),
(230, 'Science', 'What do birds use to fly?', 'Beaks', 'Wings', 'Legs', 'Feathers', 'B'),
(231, 'Science', 'How many planets are in the solar system?', '5', '7', '8', '10', 'C'),
(232, 'Science', 'What causes day and night?', 'Moon movement', 'Rotation of the Earth', 'Clouds', 'Sun setting', 'B'),
(233, 'Science', 'Which of these is a healthy habit?', 'Eating too much candy', 'Sleeping late', 'Washing hands', 'Skipping meals', 'C'),
(234, 'Science', 'Which of these is a reptile?', 'Frog', 'Snake', 'Fish', 'Eagle', 'B'),
(235, 'Science', 'Which material is used to make glass?', 'Wood', 'Sand', 'Metal', 'Clay', 'B'),
(236, 'Science', 'Which gas do plants take in during fvbghmh?', 'Oxygen', 'Carbon dioxide', 'Nitrogen', 'Hydrogen', 'D'),
(237, 'Science', 'Which sense helps us feel things?', 'Taste', 'Touch', 'Smell', 'Sight', 'B'),
(238, 'Science', 'Which organ helps in digestion?', 'Brain', 'Liver', 'Stomach', 'Heart', 'C'),
(239, 'Science', 'Which object is attracted to a magnet?', 'Wood', 'Plastic', 'Iron nail', 'Paper', 'C'),
(240, 'Science', 'Which of these is not living?', 'Bird', 'Leaf', 'Car', 'Fish', 'C'),
(241, 'Science', 'What helps people move?', 'Skin', 'Muscles', 'Hair', 'Nose', 'B'),
(242, 'Science', 'Which tool is used to look at stars?', 'Microscope', 'Thermometer', 'Telescope', 'Binoculars', 'C'),
(243, 'Science', 'Which part of the body pumps blood?', 'Brain', 'Lungs', 'Heart', 'Stomach', 'C'),
(244, 'Science', 'Which of these is an amphibian?', 'Fish', 'Turtle', 'Frog', 'Lizard', 'C'),
(245, 'Science', 'How do plants reproduce?', 'By sleeping', 'Through seeds', 'By flying', 'By swimming', 'B'),
(246, 'Science', 'What is rainwater an example of?', 'Solid', 'Liquid', 'Gas', 'Ice', 'B'),
(247, 'Science', 'What is the shape of the Earth?', 'Flat', 'Round', 'Cube', 'Triangle', 'B'),
(248, 'Science', 'What do we use to see stars clearly at night?', 'Torch', 'Glasses', 'Telescope', 'Microscope', 'C'),
(249, 'Science', 'Which of these grows and changes?', 'Rock', 'Paper', 'Cat', 'Chair', 'C'),
(250, 'Science', 'What do bees collect from flowers?', 'Water', 'Soil', 'Pollen', 'Seeds', 'C'),
(251, 'Science', 'What season is usually cold and snowy?', 'Summer', 'Winter', 'Fall', 'Spring', 'B'),
(252, 'Science', 'Which part of the plant makes seeds?', 'Root', 'Leaf', 'Flower', 'Stem', 'C'),
(253, 'Science', 'What helps birds to stay warm?', 'Skin', 'Feathers', 'Shell', 'Scales', 'B'),
(254, 'Science', 'What do plants give off during photosynthesis?', 'Nitrogen', 'Carbon dioxide', 'Oxygen', 'Smoke', 'C'),
(255, 'Science', 'What is the main source of energy on Earth?', 'Water', 'Electricity', 'Sun', 'Wind', 'C'),
(256, 'Science', 'Where does a baby grow before birth?', 'Brain', 'Heart', 'Womb', 'Lungs', 'C'),
(257, 'Science', 'What does your skeleton do?', 'Helps digest food', 'Pumps blood', 'Supports your body', 'Helps you breathe', 'C'),
(258, 'Science', 'What changes water into vapor?', 'Freezing', 'Cooling', 'Heating', 'Mixing', 'C'),
(259, 'Science', 'What is made of millions of stars?', 'Solar system', 'Galaxy', 'Planet', 'Asteroid', 'B'),
(260, 'Science', 'Which part of the body controls everything?', 'Nose', 'Stomach', 'Brain', 'Heart', 'C'),
(261, 'Science', 'What is needed for fire to burn?', 'Sand', 'Oxygen', 'Ice', 'Water', 'B'),
(262, 'Science', 'What moves the blood through your body?', 'Brain', 'Bones', 'Heart', 'Lungs', 'C'),
(263, 'Science', 'What helps people stand up straight?', 'Muscles', 'Skin', 'Bones', 'Blood', 'C'),
(264, 'Science', 'Which helps you digest food?', 'Stomach', 'Brain', 'Heart', 'Nose', 'A'),
(265, 'Science', 'Which organ helps you breathe?', 'Heart', 'Liver', 'Lungs', 'Stomach', 'C'),
(266, 'Science', 'What changes liquid water to solid ice?', 'Heating', 'Freezing', 'Melting', 'Evaporation', 'B'),
(267, 'Science', 'Which material comes from trees?', 'Plastic', 'Metal', 'Paper', 'Glass', 'C'),
(268, 'Science', 'Which material comes from trees?', 'Plastic', 'Metal', 'Paper', 'Glass', 'C'),
(269, 'Science', 'What causes shadows?', 'Light passing through', 'Blocking light', 'Reflection', 'Heat', 'B'),
(270, 'Science', 'The Earth is the third planet from the Sun.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(271, 'Science', 'Water is a solid at room temperature.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(272, 'Science', 'The Earth revolves around the Sun.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(273, 'Science', 'Plants can make their own food through photosynthesis.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(274, 'Science', 'Humans have three lungs.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(275, 'Science', 'Fish breathe using gills.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(276, 'Science', 'Sound travels faster than light.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(277, 'Science', 'The sun is a source of light and heat.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(278, 'Science', 'Bats are birds because they fly.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(279, 'Science', 'Stars are visible during the day.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(280, 'Science', 'The moon gets its light from the sun.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(281, 'Science', 'Ice melts into water.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(282, 'Science', 'Snakes have legs to move.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(283, 'Science', 'Air is made up of different gases.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(284, 'Science', 'All animals lay eggs.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(285, 'Science', 'Cows are herbivores.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(286, 'Science', 'Electricity can flow through metal.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(287, 'Science', 'You can hear sounds in space.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(288, 'Science', 'Our body has 206 bones.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(289, 'Science', 'Gravity pulls objects toward Earth.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(290, 'Science', 'Water boils at 50 degrees Celsius.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(291, 'Science', 'The human heart has two chambers.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(292, 'Science', 'The sun is a planet.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(293, 'Science', 'A caterpillar turns into a butterfly.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(294, 'Science', 'The ocean is made of saltwater.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(295, 'Science', 'Paper comes from trees.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(296, 'Science', 'Penguins can fly like eagles.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(297, 'Science', 'An insect has six legs.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(298, 'Science', 'Frogs breathe through their skin.', 'True', 'False', 'Both A and B', 'None of the above', 'A'),
(299, 'Science', 'All plants grow fruits.', 'True', 'False', 'Both A and B', 'None of the above', 'B'),
(300, 'Science', 'The Earth is flat.', 'True', 'False', 'Both A and B', 'None of the above', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `subject` varchar(50) NOT NULL,
  `num_questions` int(11) NOT NULL,
  `points_per_item` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `user_id`, `title`, `description`, `subject`, `num_questions`, `points_per_item`, `created_at`) VALUES
(256, 9, 'Filipino', 'Tangkilikin ang Sariling Wika ', 'filipino', 10, 1, '2025-05-29 23:27:44'),
(257, 9, 'English', 'xxs x x', 'english', 10, 1, '2025-05-29 23:29:00'),
(258, 9, 'English', 'nnbhnh', 'english', 20, 1, '2025-05-30 03:37:08'),
(260, 2, 'Filipino', 'hfnjung', 'filipino', 10, 1, '2025-05-30 18:15:03'),
(265, 10, 'Filipino', 'Tangkilikin ang wikang filipino', 'filipino', 30, 2, '2025-05-30 20:04:45'),
(269, 12, 'English', 'dfbgffhhhhnn', 'english', 10, 1, '2025-06-02 04:05:54'),
(275, 14, 'Science', 'htnbhynytjn', 'science', 30, 2, '2026-08-22 10:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_items`
--

CREATE TABLE `quiz_items` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_items`
--

INSERT INTO `quiz_items` (`id`, `quiz_id`, `question_id`) VALUES
(3101, 256, 141),
(3102, 256, 200),
(3103, 256, 161),
(3104, 256, 189),
(3105, 256, 110),
(3106, 256, 183),
(3107, 256, 177),
(3108, 256, 104),
(3109, 256, 148),
(3110, 256, 137),
(3111, 257, 61),
(3112, 257, 5),
(3113, 257, 19),
(3114, 257, 15),
(3115, 257, 33),
(3116, 257, 57),
(3117, 257, 68),
(3118, 257, 28),
(3119, 257, 95),
(3120, 257, 71),
(3121, 258, 16),
(3122, 258, 73),
(3123, 258, 27),
(3124, 258, 39),
(3125, 258, 61),
(3126, 258, 82),
(3127, 258, 57),
(3128, 258, 85),
(3129, 258, 48),
(3130, 258, 10),
(3131, 258, 62),
(3132, 258, 50),
(3133, 258, 6),
(3134, 258, 43),
(3135, 258, 76),
(3136, 258, 7),
(3137, 258, 28),
(3138, 258, 77),
(3139, 258, 21),
(3140, 258, 83),
(3161, 260, 143),
(3162, 260, 182),
(3163, 260, 115),
(3164, 260, 165),
(3165, 260, 175),
(3166, 260, 107),
(3167, 260, 156),
(3168, 260, 180),
(3169, 260, 160),
(3170, 260, 167),
(3271, 265, 133),
(3272, 265, 113),
(3273, 265, 158),
(3274, 265, 170),
(3275, 265, 165),
(3276, 265, 179),
(3277, 265, 136),
(3278, 265, 105),
(3279, 265, 176),
(3280, 265, 160),
(3281, 265, 186),
(3282, 265, 161),
(3283, 265, 192),
(3284, 265, 153),
(3285, 265, 130),
(3286, 265, 187),
(3287, 265, 116),
(3288, 265, 115),
(3289, 265, 119),
(3290, 265, 102),
(3291, 265, 197),
(3292, 265, 151),
(3293, 265, 195),
(3294, 265, 106),
(3295, 265, 162),
(3296, 265, 167),
(3297, 265, 145),
(3298, 265, 191),
(3299, 265, 111),
(3300, 265, 117),
(3391, 269, 64),
(3392, 269, 100),
(3393, 269, 86),
(3394, 269, 63),
(3395, 269, 22),
(3396, 269, 62),
(3397, 269, 56),
(3398, 269, 8),
(3399, 269, 82),
(3400, 269, 76),
(3551, 275, 228),
(3552, 275, 210),
(3553, 275, 203),
(3554, 275, 232),
(3555, 275, 271),
(3556, 275, 285),
(3557, 275, 267),
(3558, 275, 236),
(3559, 275, 288),
(3560, 275, 239),
(3561, 275, 296),
(3562, 275, 223),
(3563, 275, 238),
(3564, 275, 240),
(3565, 275, 266),
(3566, 275, 225),
(3567, 275, 209),
(3568, 275, 243),
(3569, 275, 275),
(3570, 275, 273),
(3571, 275, 215),
(3572, 275, 295),
(3573, 275, 251),
(3574, 275, 214),
(3575, 275, 257),
(3576, 275, 233),
(3577, 275, 248),
(3578, 275, 208),
(3579, 275, 220),
(3580, 275, 234);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `profile_pic`) VALUES
(1, 'aiza', 'montebon', 'levimarieagbong672@gmail.com', 'meme', '$2y$10$sa8TG5GuQHqtwN66eCAd6./Tl3vM40.T41Qa/Re7xVYCD1rFKR7fq', 'uploads/profile_1_1748541615.jpg'),
(10, 'Genrose', 'Rosil', 'rose@hghh', 'rose', '$2y$10$6nGiM95LqiZ13NwkpNHNnONGmlhD6NvialKeCyi.ZUK28PuYtxv7y', 'uploads/profile_10_1748635775.png'),
(14, 'Levi Marie', 'Agbong', 'levimarie672@gmail.com', 'Lev', '$2y$10$HU2jQIh6UcO7mpgRhRefW.Fy5Hev4fKsSoySZTRK5htz5qwyDYSVq', 'uploads/profile_14_1787393086.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_items`
--
ALTER TABLE `quiz_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `quiz_items`
--
ALTER TABLE `quiz_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3591;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_items`
--
ALTER TABLE `quiz_items`
  ADD CONSTRAINT `quiz_items_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_items_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
