-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2017 at 06:00 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teej`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `role_id`, `user_name`, `ip_address`, `password`, `created`) VALUES
(1, 1, 'admin', '', 'eb0a191797624dd3a48fa681d3061212', '2017-01-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `excerpt` varchar(50) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `front_image` varchar(50) NOT NULL,
  `is_front` enum('Yes','No') NOT NULL COMMENT 'True for Yes & False for No on Front page',
  `create_by` tinyint(2) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `slug`, `title`, `excerpt`, `description`, `image`, `front_image`, `is_front`, `create_by`, `created_date`, `update_date`) VALUES
(1, 'about_teej', 'Teej', '', '<p>Teej is one of the most widely celebrated festivals of Rajasthan.It is an ode to Goddess Parvati & Lord Shiva. Thousands of women and young girls offer prayers to Goddess Parvati for well-being of their husband. Swings, traditional songs, mehandi and Ghewar are the key ingredients of the magnificent Teej celebrations in Rajasthan. Women perform traditional folk dance and sing beautiful Teej songs while enjoying their sway on swings bedecked with flowers.</p>\r\n<p>Markets are stocked with trendiest women accessories and clothing. </p>', 'images/about.jpg', '', '', 1, '2017-07-20 01:55:56', '2017-07-20 01:55:56'),
(2, 'swings', 'Swings', 'That symbolize happiness.', '<p>All over Rajasthan, during teej tyohar Jhoolas (swings) are hung from trees and are decorated with leaves and flowers. Married women and young girls are seen enjoying these swings. They celebrate this festival with earnest devotion. </p>\r\n\r\n<p>It is a festival that has everything that can awake the child in every adult. No matter how old you grow but the experience that such little things add to your life is beyond explanation.</p>', 'images/swing.jpg', 'images/page1.jpg', 'Yes', 1, '2017-07-20 01:55:56', '2017-07-20 01:55:56'),
(3, 'mehandi', 'Mehandi', 'That reflects every woman\\\'s charm.', '<p>For women in Jaipur, a Teej celebration is incomplete without adorning their hands with the beautiful designs of Mehandi. On the evening before Teej, you will find most of the women getting their mehandis done from the nearby markets. One thing that they are really excited about is choosing a pattern that can hide their husband\\\'s name in it. This is more common with the ones who celebrate their first Teej after marriage.<p>\r\n\r\n<p>Closer to the festival, the demand for mehandiwalas increase and so do their rates. The prices also increase according to the designs and patterns. More elaborate is the design, more is its price. While most of the ladies in Jaipur go to the markets, there are some who organize mehandi parties at their places. They invite their friends and call a mehandiwala too, who charges much less as he gets more business at one place. So, it\\\'s more of a Teej party for the ladies!</p>\r\n\r\n<p>Those heavy designs of mehandi and elegant sets of churis, make their Teej celebrations grand. </p>', 'images/mehendi.jpg', 'images/page3.jpg', 'Yes', 1, '2017-07-20 01:55:56', '2017-07-20 01:55:56'),
(4, 'ghewar', 'Ghewar', 'That completes Teej celebrations.', '<p>Ghewar is at a high demand during Teej festival in Rajasthan. It is a traditional sweet dish which is a circular disc of maida (flour) mildly fried in moulds, soaked in sugar syrup and dressed with rabri or dry fruits. It is mostly sprinkled with kesar(saffron) and covered with silver varak on its top. With approximately ten variations including paneer ghewar, kesariya ghewar and malai ghewar, it is a kind of sweatmeat that manages to be totally light even with the thick layers of desi ghee. </p>\r\n\r\n<p>The reason why it is preffered to prepare ghewar during monsoon is that the moisture it absorbs during the process gives it a good rise. It is believed that it was brought to Jaipur during the time of Wajid Ali Shah. Even after many years, this dessert still continues to occuppy the shelves of many confectionaries. There is no doubt about why any Teej celebration is incomplete without this delicacy. </p>', 'images/ghevar.jpg', 'images/page2.jpg', 'Yes', 1, '2017-07-20 01:55:56', '2017-07-20 01:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `manage_count`
--

CREATE TABLE `manage_count` (
  `id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_count`
--

INSERT INTO `manage_count` (`id`, `count`, `created`) VALUES
(1, 50, '2017-01-25 22:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `position` int(11) NOT NULL,
  `created_by` tinyint(2) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `slug`, `position`, `created_by`, `created_date`, `updated_date`) VALUES
(1, 'ABOUT Teej', 'about_teej', 1, 1, '2017-07-20 01:24:04', '2017-07-20 01:24:04'),
(2, 'SWINGS', 'swings', 2, 1, '2017-07-20 01:24:04', '2017-07-20 01:24:04'),
(3, 'MEHANDI', 'mehandi', 3, 1, '2017-07-20 01:24:04', '2017-07-20 01:24:04'),
(4, 'GHEWAR', 'ghewar', 4, 1, '2017-07-20 01:24:04', '2017-07-20 01:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `position` tinyint(2) NOT NULL,
  `created_by` tinyint(2) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `type`, `position`, `created_by`, `created_date`, `updated_date`) VALUES
(1, 'Administrator', 1, 1, '2017-07-19 23:55:03', '2017-07-19 23:55:03'),
(2, 'Editor', 2, 1, '2017-07-19 23:55:03', '2017-07-19 23:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `message` text,
  `document_type` varchar(25) NOT NULL DEFAULT 'text',
  `image` text,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `name`, `email`, `mobile`, `ip_address`, `message`, `document_type`, `image`, `deleted`, `status`) VALUES
(4, 'sdfadsf', 'sdfasdf@gmail.com', '3242323233', '127.0.0.1', 'sdfasdf asdf', 'text', '', 0, 1),
(5, 'asdfasdf', 'sdfasdf@gmail.com', '1234567890', '127.0.0.1', 'sdfasdf asdf', 'text', '', 0, 1),
(6, 'asdfad', 'sdfasdf@gmail.com', '1234567890', '127.0.0.1', 'fasdf asdfasdfadsf', 'text', '', 0, 1),
(7, 'asdfasdf', 'asdfasdf@gmail.com', '2342341234', '127.0.0.1', 'df asdfadfasdf', 'text', '', 0, 1),
(8, 'asdfads', 'dsfasdf@gmail.com', '2423432323', '127.0.0.1', '', 'text', '', 0, 1),
(9, 'dsfasdf', 'aaa@gmail.com', '2342343423', '127.0.0.1', 'asdfasd fasdfadfasd', 'text', '', 0, 1),
(10, 'asdfasd', 'ert@gmail.com', '2342341234', '127.0.0.1', 'dasf asdfasdfasdf', 'text', '', 0, 1),
(11, 'dsafa', 'jkkj@gmail.com', '2342344567', '127.0.0.1', 'dfa sdfadfadf', 'text', '', 0, 1),
(12, 'vipin', 'vipin@gmail.com', '3242341234', '127.0.0.1', 'dfad fasdfasdfasdfasd', 'text', '', 0, 1),
(13, 'asumit', 'sumit@gmail.com', '2342342378', '127.0.0.1', 'faedrwerqwerq wer', 'text', '', 0, 1),
(14, 'sdf', 'sumi8t@gmail.com', '2344567890', '127.0.0.1', 'asdf asdfasdf', 'text', '', 0, 1),
(15, 'asdf', 'fasdf@gmail.com', '3242342456', '127.0.0.1', 'dsfa sdfasdfadsf', 'text', '', 0, 1),
(16, 'vipin', 'vipp@gmail.com', '2342344567', '127.0.0.1', '', 'text', '', 0, 1),
(17, 'VipinYadav', 'vipin6@gmail.com', '9123786543', '127.0.0.1', '', 'text', '', 0, 1),
(19, 'Vivek', 'viviek@gmail.com', '2342341234', '127.0.0.1', 'sdf asdfasdfasdfadsfad', 'image', '19-17-01-25-22-01-20-karsalaam.png', 0, 1),
(20, 'sdfsd', 'manoj@gmail.com', '2342343241', '127.0.0.1', 'asd fasdf asdfasdf asd fasdf', 'image', '20-17-01-25-23-01-27-karsalaam.jpg', 0, 1),
(21, 'adGloba', 'manoj.bhagat@adglobal360.com', '1212121212', '127.0.0.1', 'sdsdsd', 'image', '21-17-01-25-23-01-39-karsalaam.jpg', 0, 1),
(22, 'Manoj', 'manoj.bhagat@adglobal3601.com', '9582612232', '::1', 'Jay HInddddddddddd', 'text', NULL, 0, 1),
(23, 'afda', 'dfaa@gmail.com', '9212376832', '127.0.0.1', '', 'image', '23-17-07-20-00-07-11-karsalaam.png', 0, 1),
(24, 'ads', 'af@gmail.com', '1234567890', '127.0.0.1', '', 'text', NULL, 0, 1),
(25, 'asd', 'ad@gmail.com', '1234567890', '127.0.0.1', 'adfadsfa sdf', 'image', '25-17-07-20-15-07-00-karsalaam.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` longtext,
  `image` longtext,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `document_type` enum('image','video','text') NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `firstname`, `email`, `message`, `image`, `deleted`, `status`, `document_type`, `created_date`) VALUES
(18, 'MEERA', 'meera@gmail.com', 'Had a great time celebrating Teej in Jaipur. It showcased a collage of extremely amazing processional activities, that can make anyone say: â€œIâ€™ll be back next year!â€ ', NULL, 0, 1, 'text', '2017-07-20 20:00:00'),
(19, 'Suman', 'suman@gmail.com', 'Ever seen something traditional offering a whole new experience? Well, Teej celebrations in Jaipur are completely like that. A festival thatâ€™s celebrated for about 3 days is so entertaining that one feels it was just a day long!', NULL, 0, 1, 'text', '2017-07-20 20:00:32'),
(20, 'Tusharika', '', 'Wow, is the only emotion that everyone gets during Teej in Jaipur. Thereâ€™s no doubt about the way they spellbound you with the charm of their tradition. Excited about this time too!', NULL, 0, 1, 'text', '2017-07-20 20:00:51'),
(21, 'Artika', 'Artika@gmail.com', 'To experience the real essence of Teej, one should definitely celebrate it in Jaipur. Once in a lifetime at least! If not, the person is surely gonna miss something.', 'DSC_0100_artika_17-07-20-06.jpg', 0, 1, 'image', '2017-07-20 20:12:06'),
(22, 'Deepika', 'deepika@gmail.com', '', 'DSC_0089_deepika_17-07-20-56.jpg', 0, 1, 'image', '2017-07-20 20:17:56'),
(23, 'asdfa', 'sdf adf', 'asd fadf', 'DSC_0100_asdfa_17-07-20-58.jpg', 0, 1, 'image', '2017-07-20 20:20:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
