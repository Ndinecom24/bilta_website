-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2026 at 09:58 AM
-- Server version: 10.6.24-MariaDB-cll-lve
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i9135899_lara2`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `objective` text NOT NULL,
  `description` longtext NOT NULL,
  `who_we_are` mediumtext NOT NULL,
  `what_is` mediumtext NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `mission`, `vision`, `objective`, `description`, `who_we_are`, `what_is`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'To serve God through the translation of scriptures and essential literature into heart languages for their accessibility and transformation of lives. Acts 2:6-8, mt 28:19-20', 'To be a transformative force by equipping translators to make scripture and essential literature accessible in every heart language.  ', '* To mobilise and build capacity of the local people for Bible translation.\n* Seek to promote the use of the local language in the dissemination of the word of God by embracing the use of other languages\n* To promote literacy and education through production of all types of materials such as newsletters, books, magazines, and videos in the local language.\n', 'BiLTA has a constitution and is registered with the Registrar of Societies in Zambia as a charitable organisation aimed at empowering communities to translate the word of God and other literatures into their own language.', 'The Bible and Literature Translation Association (BiLTA) was established in 2019. It is a dedicated translation association committed to advancing the translation of the Bible and other essential literature works into local languages. \n', 'BiLTA is an acronym standing for “Bible and Literature Translation Association.”In 2012, it was first called Senga Bible and Literature Translation Association (SBLTA), however in January 2021, its name changed to BiLTA so that other language groups could be helped with the translation work of their languages.\n', NULL, '2023-06-06 17:35:50', '2025-09-23 21:35:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audio_files`
--

CREATE TABLE `audio_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `file_url` varchar(191) NOT NULL,
  `status_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audio_files`
--

INSERT INTO `audio_files` (`id`, `title`, `description`, `file_url`, `status_id`, `project_id`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Senga Audio Bible', 'Luke 1 vs 1-4', 'Luke_001_01-04__SGQPITP1DA.mp3', 1, 5, 1, '2024-12-23 18:00:06', '2024-12-23 18:00:06'),
(4, 'Senga Audio Bible', 'Luke 1 vs 5-25', 'Luke_001_05-25__SGQPITP1DA.mp3', 1, 5, 1, '2024-12-23 18:02:32', '2024-12-23 18:02:32'),
(5, 'Senga Audio Bible', 'Luke 1 vs 26-38', 'Luke_001_26-38__SGQPITP1DA.mp3', 1, 5, 1, '2024-12-23 18:03:36', '2024-12-23 18:03:36');

-- --------------------------------------------------------

--
-- Table structure for table `chairman_messages`
--

CREATE TABLE `chairman_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `title` varchar(300) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chairman_messages`
--

INSERT INTO `chairman_messages` (`id`, `name`, `title`, `message`, `created_by`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Rev. Fr. Jackson J. Katete', '', '<div style=\"font-family: \'Times New Roman\', serif; font-size: 16px; line-height: 1.6; color: #000;\"> <p style=\"text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px;\">  </p> <p>Dear friends,</p> <p> <span>BILTA is passionate about translating the Bible and essential literature materials into languages that connect with people\'s hearts and cultures.</span> <span>Our mission is to ensure that these texts inspire faith, foster understanding, and empower communities by making knowledge and truth accessible to all.</span> </p> <p> Through collaboration and dedication, we strive to ensure that no one is left without access to the transformative power of these texts. </p> <p> Thank you for your interest and support as we work together to bring light, understanding, and unity through translation. </p> <p>Blessings,</p> <p style=\"margin-top: 30px;\"> <strong>Rev. Fr. Jackson J. Katete</strong><br> Executive Chairman – BILTA </p> </div>', 1, 2, '2025-05-15 18:39:04', '2025-06-29 19:16:31');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` varchar(191) NOT NULL,
  `commentable_type` varchar(191) NOT NULL,
  `commentable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status_id` varchar(191) DEFAULT NULL,
  `recipient` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `spam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_by`, `status_id`, `recipient`, `created_at`, `updated_at`, `spam`) VALUES
(9, 'Goma Daniel Green', 'gdgdgoma@gmail.com', 'Enquiry on expected time for us to start using the Bible being translated in Senga', 'Dear sir,\r\n\r\nI am Senga by tribe and I heard a good news about us having our own Bible. When are we expecting to have the same Bible I am zealous I cant wait to hear God\'s in my language\r\n\r\nThank you', 0, '1', 'admin@bilta.org', '2024-12-14 17:16:45', '2024-12-14 17:16:45', 0),
(16, 'SHUBART  NYIMBILI', 'NSHUBART@ZESCO.CO.ZM', 'Test Email Sending', 'This is a test email sending to see if the message comes through', 0, '1', 'infor@bilta.org', '2024-12-14 17:30:04', '2024-12-14 17:30:04', 0),
(18, 'Emmanuel Sana', 'emmanuelsana3@gmail.com', 'More information about the organization', 'I would like to get more information about your organization. How do I go about that?', 0, '1', 'infor@bilta.org', '2024-12-14 22:33:05', '2024-12-14 22:33:05', 0),
(31, 'REV. PATRICK MUBANGA', 'mubangapatrick19@gmail.com', 'THANKING THE LEADERSHIP', 'I am one of the exegetical leaders of this program and I want to appreciate the work the organization is doing. Many people are getting saved by hearing the messages in their own languages. Here we are translating into a language called \"Kabennde\" This is Luapula Province. Samfya District. Zambia.\r\nThanks Rev. Patrick Mubanga', 0, '1', 'infor@bilta.org', '2024-12-23 18:54:32', '2024-12-23 18:54:32', 0),
(40, 'Allan M. Mukuni', 'allanmukuni@bilta.org', 'ACKNOWLEDGEMENT', 'I just want to thank the National Executive Committee for giving an opportunity to part this great and passion cloud of dedicated people seeking to bring the Word of God closer to every soul in their own mother tongue. Now more than ever I feel satisfied with ministry and enjoying what am doing in the Lord while committing myself to learning new things everyday as I interact with the scriptures.  God Bless BiLTA.  \r\nLUNGU OBT OFFICE TA1', 0, '1', 'infor@bilta.org', '2024-12-28 13:19:05', '2024-12-28 13:19:05', 0),
(41, 'Allan M. Mukuni', 'allanmukuni@yahoo.com', 'ACKNOWLEDGEMENT', 'I just want to thank the National Executive Committee for giving an opportunity to part this great and passion cloud of dedicated people seeking to bring the Word of God closer to every soul in their own mother tongue. Now more than ever I feel satisfied with ministry and enjoying what am doing in the Lord while committing myself to learning new things everyday as I interact with the scriptures.  God Bless BiLTA.  \r\nLUNGU OBT OFFICE TA1', 0, '1', 'infor@bilta.org', '2024-12-28 13:19:49', '2024-12-28 13:19:49', 0),
(67, 'LeoStalt', 'ibucezevuda439@gmail.com', 'Hello  i am write about   the price for reseller', 'Zdravo, htio sam znati vašu cijenu.', 0, '1', 'infor@bilta.org', '2025-02-03 19:58:01', '2025-02-03 19:58:01', 0),
(68, 'Joseph', 'info@joseph.caredogbest.com', 'Joseph Holroyd', 'Hey there \r\n\r\nI wanted to reach out and let you know about our new dog harness. It\'s really easy to put on and take off - in just 2 seconds - and it\'s personalized for each dog. \r\nPlus, we offer a lifetime warranty so you can be sure your pet is always safe and stylish.\r\n\r\nWe\'ve had a lot of success with it so far and I think your dog would love it. \r\n\r\nGet yours today with 50% OFF: https://caredogbest.com\r\n\r\nFREE Shipping - TODAY ONLY! \r\n\r\nHave a great time, \r\n\r\nJoseph', 0, '1', 'infor@bilta.org', '2025-02-05 13:18:16', '2025-02-05 13:18:16', 0),
(69, 'TedStalt', 'moqagides18@gmail.com', 'Hi  i am writing about   the price for reseller', 'Ndewo, achọrọ m ịmara ọnụahịa gị.', 0, '1', 'infor@bilta.org', '2025-02-05 17:45:35', '2025-02-05 17:45:35', 0),
(70, 'Chadwick', 'info@chadwick.caredogbest.com', 'Chadwick Dement', 'Hello \r\n\r\nI wanted to reach out and let you know about our new dog harness. It\'s really easy to put on and take off - in just 2 seconds - and it\'s personalized for each dog. \r\nPlus, we offer a lifetime warranty so you can be sure your pet is always safe and stylish.\r\n\r\nWe\'ve had a lot of success with it so far and I think your dog would love it. \r\n\r\nGet yours today with 50% OFF: https://caredogbest.com\r\n\r\nFREE Shipping - TODAY ONLY! \r\n\r\nThe Best, \r\n\r\nChadwick', 0, '1', 'infor@bilta.org', '2025-02-06 04:50:46', '2025-02-06 04:50:46', 0),
(71, 'Nicholas Doby', 'dobyfinancial@sendnow.win', 'Re: Explore Funding Opportunities', 'Greetings, Mr./Ms. \r\n \r\nI’m Nicholas Doby from an investment consultancy. We connect clients globally with low or no-interest loans to help achieve your goals. Whether for personal or business/project funding, we collaborate with reputable investors to turn your proposals into reality. Share your business plan and executive summary with us at: contact@dobyfinancial.com to explore funding options. \r\n \r\nSincerely, \r\nNicholas Doby \r\nSenior Financial Consultant \r\nhttps://dobyfinancial.com', 0, '1', 'infor@bilta.org', '2025-02-07 15:05:52', '2025-02-07 15:05:52', 0),
(72, 'WarRobots', 'warrobots@gmail.com', 'Re: WarRobots', 'https://slds.pro/qmdao Game.', 0, '1', 'infor@bilta.org', '2025-02-07 21:40:28', '2025-02-07 21:40:28', 0),
(73, 'GeorgeStalt', 'ibucezevuda439@gmail.com', 'Aloha,   wrote about     price', 'Sveiki, es gribēju zināt savu cenu.', 0, '1', 'infor@bilta.org', '2025-02-08 03:00:46', '2025-02-08 03:00:46', 0),
(74, 'TedStalt', 'moqagides18@gmail.com', 'Hallo, i am wrote about     prices', 'Hej, jeg ønskede at kende din pris.', 0, '1', 'infor@bilta.org', '2025-02-08 08:29:27', '2025-02-08 08:29:27', 0),
(75, 'Mike Thomas Lefevre', 'info@speed-seo.net', 'Unlock Your bilta.org Potential with a Free SEO Score Check', 'Hi, \r\n \r\nCurious about how your website is performing? Discover its strengths and weaknesses with our Free SEO Check Tool! In just 2 minutes, you’ll get a detailed analysis of your website’s SEO health and actionable insights to help improve your rankings. \r\n \r\nTake the first step towards better performance and growth. \r\n \r\nRun Your Free SEO Check Now \r\nhttps://www.speed-seo.net/check-site-seo-score/ \r\n \r\nDon’t let overlooked SEO issues hold you back. Optimize your site today and stay ahead of the competition! \r\n \r\nBest regards, \r\n \r\n \r\nMike Thomas Lefevre\r\n \r\nSpeed SEO \r\nWhatsapp us: https://www.speed-seo.net/whatsapp-with-us/', 0, '1', 'infor@bilta.org', '2025-02-08 17:50:12', '2025-02-08 17:50:12', 0),
(76, 'Noble', 'info@poston.bangeshop.com', 'BiLTA', 'Hey there, \r\n\r\nI hope this email finds you well. I wanted to let you know about our new BANGE backpacks and sling bags that just released.\r\n\r\nBange is perfect for students, professionals and travelers. The backpacks and sling bags feature a built-in USB charging port, making it easy to charge your devices on the go.  Also they are waterproof and anti-theft design, making it ideal for carrying your valuables.\r\n\r\nBoth bags are made of durable and high-quality materials, and are perfect for everyday use or travel.\r\n\r\nOrder yours now at 50% OFF with FREE Shipping: http://bangeshop.com\r\n\r\nSincerely,\r\n\r\nNoble', 0, '1', 'infor@bilta.org', '2025-02-10 15:33:18', '2025-02-10 15:33:18', 0),
(77, 'Bonus', '1win@gmail.com', 'Ready to hit the jackpot?', 'Your exclusive bonus awaits! Don’t miss your chance to WIN today! Get a gift at the best casino: promo code for +500% on your first 4 deposits. \r\n \r\n-Certified casino \r\n-Big winnings \r\n-Fast withdrawals \r\n-Chance to win Mercedes-Benz G 800 Brabus in Lucky Drive \r\n \r\nPromo code: skffih \r\nRegister and win: https://1waufy.com/?p=o4c4', 0, '1', 'infor@bilta.org', '2025-02-12 13:06:03', '2025-02-12 13:06:03', 0),
(78, 'Namfukwe Micah', 'micahnamfukwe7@gmail.com', 'APPLICATION FOR THE JOB AS A TRANSLATOR', 'GOOD MORNING SIR HAVE BEEN TRYING TO APPLY ONLINE FOR THE JOB BUT I CAN\'T SEEM TO FIND THE LINK PLEASE HELP I REALLY NEED THE THIS JOB', 0, '1', 'infor@bilta.org', '2025-02-12 13:58:35', '2025-02-12 13:58:35', 0),
(80, 'Valeron83Pap', 'romabookim@gmail.com', 'Conquer the peaks of luck: Play and win!', 'Hello! \r\nStrategy meets thrill in our diverse selection of games. Whether you\'re a seasoned player or a newcomer, there\'s always a way to maximize your wins!  https://media.playamopartners.com/redirect.aspx?bid=1929&pid=11112&lpid=6&sref=Revlab&Revlab=playamo_playamo127', 0, '1', 'infor@bilta.org', '2025-02-13 02:58:19', '2025-02-13 02:58:19', 0),
(82, 'GeorgeStalt', 'ibucezevuda439@gmail.com', 'Aloha    writing about your   prices', 'Sveiki, aš norėjau sužinoti jūsų kainą.', 0, '1', 'infor@bilta.org', '2025-02-14 10:29:12', '2025-02-14 10:29:12', 0),
(88, 'Betsy', 'info@mcelhaney.pawtrim.shop', 'Betsy McElhaney', 'Hello \r\n \r\nIs your dog\'s nails getting too long? If you\'re tired of going to the vet or groomer to get them trimmed, why not try PawSafer™? \r\nWith PawSafer™, you can trim your dog\'s nails from the comfort of your own home, and it only takes a few minutes!\r\n\r\nPawSafer™ is the safest and most convenient way to trim your dog\'s nails, and it\'s very affordable. \r\n\r\nGet it while it\'s still 50% OFF + FREE Shipping\r\n\r\nBuy here: https://pawtrim.shop\r\n \r\nBest, \r\n \r\nBetsy', 0, '1', 'infor@bilta.org', '2025-02-17 13:12:42', '2025-02-17 13:12:42', 0),
(89, 'Estela Waggoner', 'waggoner.estela@gmail.com', 'Boost Your Marketing Impact – Join in Our Directory Now!', 'Want to Attract More Business? Join Our Professional Registry Right Away!\r\n\r\nGreetings,\r\n\r\nReady to expand your audience? Our Professional Platform provides a solution where customers can quickly discover industry experts in marketing, online creation, online visibility, and more.\r\n\r\nBy joining our platform, you secure direct access to a larger client base, helping you expand your reach more efficiently.\r\n\r\nRegister now and begin attracting new clients!  https://tinyurl.com/ycx5h5ew\r\n\r\nWarm regards,\r\nMark\r\n\r\nAre you outside of the online content photo-based industry or marketing field? You can opt out here: https://gotunsubscribed.com/?info=bilta.org', 0, '1', 'infor@bilta.org', '2025-02-17 19:11:08', '2025-02-17 19:11:08', 0),
(90, 'Valorie Balke', 'balke.valorie@msn.com', 'Enhance Your Online Presence – Join Our Professional Platform', 'Enhance Your Exposure – List Your Business in Our Services Directory\r\n\r\nHello,\r\n\r\nIn today’s competitive market, exposure is essential to business growth. Our Professional Registry is an effective way to showcase your skills in fields such as online visibility, web design, online promotion, and additional specialties.\r\n\r\nGetting featured can amplify your visibility, put you in touch with new clients, and boost your business reputation.\r\n\r\nRegister immediately and start gaining the attention you are ready for!  https://tinyurl.com/ycx5h5ew\r\n\r\nBest,\r\nCharles\r\n\r\nNot part of the multimedia imaging technology or promotion sector? You can opt out here: https://gotunsubscribed.com/?info=bilta.org', 0, '1', 'infor@bilta.org', '2025-02-18 05:34:36', '2025-02-18 05:34:36', 0),
(91, 'Best shop for you   https://trk.mail.ru/c/ks4ad8', 'latoyapeterson64@yahoo.com', 'Best shop for you   https://trk.mail.ru/c/ks4ad8', 'Best shop for you   https://trk.mail.ru/c/caz3t5', 0, '1', 'infor@bilta.org', '2025-02-18 08:20:36', '2025-02-18 08:20:36', 0),
(92, 'Hester Hanger', 'hester.hanger@gmail.com', 'Promote Your Business to A Broader Audience – Join Now!', 'Increase Your Online Exposure – Be Part of Our Directory\r\n\r\nHello,\r\n\r\nIn today’s online landscape, digital visibility is crucial to achieving growth. Our Professional Registry can enable you to increase your exposure and engage with potential clients in need of marketing, SEO, creative solutions, and additional services.\r\n\r\nBy listing your business in our registry, you’ll improve your online footprint and gain access to more clients.\r\n\r\nGet started today! https://tinyurl.com/ycx5h5ew\r\n\r\nKind regards,\r\nBenjamin\r\n\r\nNot part of the digital media photography tech or advertising field? Feel free to unsubscribe at the following URL: https://gotunsubscribed.com/?info=bilta.org', 0, '1', 'infor@bilta.org', '2025-02-18 18:55:06', '2025-02-18 18:55:06', 0),
(93, 'Uwe Willison', 'uwe.willison@hotmail.com', 'Boost Your Visibility! Register for Our Business Listing Registry', 'Get Your Business Noticed! Join Our Marketing & Service Directory\r\n\r\nHi,\r\n\r\nYour professionalism should have more exposure. Our Business Platform is the ideal platform to highlight your business and reach clients seeking your skills.\r\n\r\nSign up today to shine in a crowded space and gain access to new possibilities!\r\n\r\nJoin right away and elevate your professional reach!  https://tinyurl.com/ycx5h5ew\r\n\r\nBest regards,\r\nBrandon\r\n\r\nNot part of the online content photography tech or promotion field? You can opt out here: https://gotunsubscribed.com/?info=bilta.org', 0, '1', 'infor@bilta.org', '2025-02-19 08:37:44', '2025-02-19 08:37:44', 0),
(94, 'Alton Justus', 'justus.alton24@gmail.com', 'Optimize bilta.org\'s traffic with a complimentary trial.', 'Every day, websites like bilta.org fail to capture valuable traffic opportunities. Don’t let yours be one of them. Our automated traffic system is designed to increase exposure and bring real visitors to your site.\r\n\r\nClaim your complimentary 4,000-visitor trial to see the benefits firsthand. Then, expand to plans offering up to 350,000 visitors per month. It’s time to realize your website’s true traffic potential. Get started here: https://ow.ly/X7kl50Urkab', 0, '1', 'infor@bilta.org', '2025-02-19 19:48:18', '2025-02-19 19:48:18', 0),
(95, 'Annette Harold', 'annette.harold@outlook.com', 'Grow Your Customer Reach – Join Our Services Registry!', 'Connect with Clients Faster – List Your Business in Our Services Platform\r\n\r\nHi,\r\n\r\nOur Business Platform is built to enable you to connect with clients in less time.\r\n\r\nBy joining, your brand will be listed among trusted experts in your specialization, helping you gain visibility by potential clients searching for your expertise.\r\n\r\nIt’s simple to get started and will take your business to the next stage.\r\n\r\nClick below to get started!  https://tinyurl.com/ycx5h5ew\r\n\r\nBest regards,\r\nRaymond\r\n\r\nAre you outside of the digital media imaging industry or promotion field? Feel free to opt out using this link: https://gotunsubscribed.com/?info=bilta.org', 0, '1', 'infor@bilta.org', '2025-02-19 21:51:13', '2025-02-19 21:51:13', 0),
(96, 'HenryStalt', 'ebojajuje04@gmail.com', 'Hello  i wrote about your the price', 'Hej, jeg ønskede at kende din pris.', 0, '1', 'infor@bilta.org', '2025-02-20 09:56:10', '2025-02-20 09:56:10', 0),
(97, 'Thank you for registering - it was incredible and pleasant all the best http://yandex.ru ladonna  cucumber', 'alex01@24red.ru', 'Thank you for registering - it was incredible and pleasant all the best http://yandex.ru  ladonna cucumber', 'Thank you for registering - it was incredible and pleasant all the best http://yandex.ru ladonna  cucumber', 0, '1', 'infor@bilta.org', '2025-02-21 01:39:15', '2025-02-21 01:39:15', 0),
(98, 'FreyaStalt', 'ebojajuje04@gmail.com', 'Hi, i wrote about your the price for reseller', 'Hi, მინდოდა ვიცოდე თქვენი ფასი.', 0, '1', 'infor@bilta.org', '2025-02-21 03:38:14', '2025-02-21 03:38:14', 0),
(99, 'JohnStalt', 'yawiviseya67@gmail.com', 'Hello, i writing about your the price', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-02-21 03:39:05', '2025-02-21 03:39:05', 0),
(100, 'TedStalt', 'ocopesuq299@gmail.com', 'Hello,   wrote about your   price for reseller', 'Hi, მინდოდა ვიცოდე თქვენი ფასი.', 0, '1', 'infor@bilta.org', '2025-02-21 23:06:07', '2025-02-21 23:06:07', 0),
(101, 'Leslie S.', 'marketerzseo@gmail.com', 'about bilta.org', 'Hi,\r\n\r\nWant fast Google ranking for bilta.org with minimum 10 keywords? For just US$3.99 now, I offer 10 x SEO content writing, optimization & publishing services, targeting 10 keywords for you, with potential Google 1st page ranking within 2 weeks time. \r\n\r\nLet me know if interested!\r\n\r\nThanks,\r\nLeslie\r\nMarketerz SEO', 0, '1', 'infor@bilta.org', '2025-02-21 23:33:44', '2025-02-21 23:33:44', 0),
(102, 'Hello nice web site https://google.com', 'elena_malaeva@rambler.ru', 'Hello nice web site https://google.com', 'Hello nice web site https://google.com', 0, '1', 'infor@bilta.org', '2025-02-22 10:32:08', '2025-02-22 10:32:08', 0),
(103, 'Mike Alexandre Nilsen', 'mike@monkeydigital.co', 'Collaboration Request', 'Hi, \n \nThis is Mike from Monkey Digital, \nI am contacting you to discuss a mutual business deal. \n \nHow would you like to show our promotions on your website and redirect via your custom tracking link towards hot-selling products from our business? \n \nThis way, you receive a recurring 35% commission, every month from any sales that generate from your site. \n \nThink about it, everyone require SEO, so this is a massive opportunity. \n \nWe already have over 12,000 affiliates and our payouts are paid out monthly. \nLast month, we distributed over $27,000 in commissions to our promoters. \n \nIf this sounds good, kindly message us here: \nhttps://monkeydigital.co/affiliates-whatsapp/ \n \nOr join us today: \nhttps://www.monkeydigital.co/join-our-affiliate-program/ \n \nCheers, \nMike Alexandre Nilsen\n \nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-02-23 13:51:24', '2025-02-23 13:51:24', 0),
(104, 'TestUser', 'zcatmers@do-not-respond.me', 'Alice', 'KcVIjRf hanrfeM QaSstx MSWsa DVQ LAGC nqDOW', 0, '1', 'infor@bilta.org', '2025-02-24 06:21:26', '2025-02-24 06:21:26', 0),
(105, 'GeorgeStalt', 'ocopesuq299@gmail.com', 'Aloha    wrote about your the price for reseller', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-02-28 01:51:01', '2025-02-28 01:51:01', 0),
(106, 'TedStalt', 'ocopesuq299@gmail.com', 'Aloha, i writing about   the prices', 'Hi, ego volo scire vestri pretium.', 0, '1', 'infor@bilta.org', '2025-02-28 14:43:37', '2025-02-28 14:43:37', 0),
(107, 'Mike Kenneth Jones', 'mike@monkeydigital.co', 'Grow Your Website Traffic with Country-Specific Social Ads – Only $10 for 10K Visits!', 'Dear Webmaster, \r\n \r\nI wanted to reach out with something that could seriously help your website’s visitor count. We work with a trusted ad network that allows us to deliver genuine, country-targeted social ads traffic for just $10 per 10,000 visits. \r\n \r\nThis isn\'t fake traffic—it’s real visitors, tailored to your chosen market and niche. \r\n \r\nWhat you get: \r\n \r\n10,000+ high-quality visitors for just $10 \r\nGeo-targeted traffic for your chosen location \r\nScalability available based on your needs \r\nUsed by marketers—we even use this for our SEO clients! \r\n \r\nWant to give it a try? Check out the details here: \r\nhttps://www.monkeydigital.co/product/country-targeted-traffic/ \r\n \r\nOr ask any questions on WhatsApp: \r\nhttps://monkeydigital.co/whatsapp-us/ \r\n \r\nLooking forward to helping you grow! \r\n \r\nBest, \r\nMike Kenneth Jones\r\n \r\nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-02-28 22:55:32', '2025-02-28 22:55:32', 0),
(108, 'Mike Rodrigo Dupont', 'info@strictlydigital.net', 'Semrush links for bilta.org', 'Hi there, \r\n \r\nGetting some set of links redirecting to bilta.org could have 0 value or negative impact for your site. \r\n \r\nIt really isn’t important the number of external links you have, what is crucial is the total of search terms those domains are optimized for. \r\n \r\nThat is the most important element. \r\nNot the meaningless third-party metrics or Domain Rating. \r\nAnyone can manipulate those. \r\nBUT the volume of Google-ranked terms the websites that point to your site have. \r\nThat’s the bottom line. \r\n \r\nHave such links link to your domain and your site will see real growth! \r\n \r\nWe are offering this exclusive SEO package here: \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nHave questions, or want to know more, message us here: \r\nhttps://www.strictlydigital.net/whatsapp-us/ \r\n \r\nKind regards, \r\nMike Rodrigo Dupont\r\n \r\nstrictlydigital.net \r\nPhone/WhatsApp: +1 (877) 566-3738', 0, '1', 'infor@bilta.org', '2025-03-01 20:42:19', '2025-03-01 20:42:19', 0),
(109, 'Amandaamudge3', 'amandaIromBeam3@gmail.com', 'Hey!', 'I think we could get along! Let’s talk?  \n \nMessage me there! ---> https://rb.gy/44z0k7?Axorne', 0, '1', 'infor@bilta.org', '2025-03-02 04:11:33', '2025-03-02 04:11:33', 0),
(110, 'Amandaamudgec', 'amandaIromBeamb@gmail.com', 'Looking for me?', 'I saw you and couldn’t resist writing!  \n \nMessage me there! ---> https://rb.gy/44z0k7?Axorne', 0, '1', 'infor@bilta.org', '2025-03-03 21:44:46', '2025-03-03 21:44:46', 0),
(111, 'stenlixPap', 'stenlyPap@gmail.com', 'Automatically updated databases for Xrumer 23 and GSA Search Engine Ranker', 'Databases for Xrumer\r\n \r\nWe offer the best website databases for working with Xrumer 23 ai Strong and GSA Search Engine Ranker. The databases are suitable for a professional SEO company and creating hundreds of thousands of backlinks. Our databases are used by many SEO professionals from different countries of the world. The price for the databases is low, having bought them you receive updates for 12 months. You can read more and order a subscription to the databases here: https://dseo24.monster/vip-base-for-xrumer-and-gsa-ser/ On the site page you can choose any language of the pages.', 0, '1', 'infor@bilta.org', '2025-03-04 16:14:07', '2025-03-04 16:14:07', 0),
(112, 'GeorgeStalt', 'ocopesuq299@gmail.com', 'Hallo, i am wrote about   the prices', 'Zdravo, htio sam znati vašu cijenu.', 0, '1', 'infor@bilta.org', '2025-03-05 22:09:23', '2025-03-05 22:09:23', 0),
(113, 'Kevin Barber', 'sparrow.eli@googlemail.com', 'Day 1: Why Most Marketing Fails (And How to Make Yours Succeed)', 'Hi Bilta,\r\n\r\nMost business owners pour money into marketing that doesn’t work. They run ads, post on social media, and hope for the best—only to be disappointed by the results. \r\n\r\nThe problem? They’re relying on vague branding tactics instead of proven strategies.\r\n\r\nDan Kennedy calls this the “ADHD approach to marketing”—jumping from one shiny tactic to another without a clear, measurable plan.\r\n\r\nBut there’s a better way: Direct-Response Marketing.\r\n\r\nThis approach focuses on generating real, measurable results, like leads, sales, and conversions. Here’s how you can start applying it today:\r\n\r\nStep 1: Speak Directly to Your Audience\r\n\r\nOne of Dan’s key teachings is this: “If you’re speaking to everyone, you’re speaking to no one.” Direct-response marketing works because it’s personal.\r\n\r\nFor example:\r\n\r\nA company selling weight loss supplements doesn’t just target “everyone who wants to lose weight.” Instead, they target busy moms who want to shed pounds quickly after having kids.\r\n\r\nA financial advisor doesn’t market to “everyone interested in saving money.” They craft campaigns for high-income professionals nearing retirement.\r\n\r\nYour Action Step: Write down your audience’s specific demographics, challenges, and goals.\r\n\r\nStep 2: Use an Irresistible Call-to-Action\r\n\r\nEvery piece of marketing must tell the audience what to do next. Whether it’s “Download this guide,” “Sign up for a webinar,” or “Call now,” your call-to-action (CTA) should be clear and compelling.\r\n\r\nExample 1:\r\nA dental clinic offered a free teeth-whitening session for new patients. The clear CTA—“Call to schedule your free session today!”—resulted in a 200% increase in appointments.\r\n\r\nExample 2:\r\nA SaaS company ran ads with the CTA: “Get a 30-day free trial today.” The campaign boosted signups by 35%.\r\n\r\nStep 3: Track and Test Everything\r\n\r\nOne of Dan’s most famous quotes is: “You can’t improve what you don’t measure.” Direct-response marketing relies on tracking every aspect of your campaign.\r\n\r\nWhat’s your click-through rate?\r\nHow many leads did you generate?\r\nWhat’s your cost per acquisition?\r\n\r\nExample:\r\nA real estate agent ran Facebook ads targeting first-time homebuyers. By testing different headlines and images, they reduced their cost per lead by 50%.\r\n\r\nTomorrow, we’ll dive into the art of crafting offers your customers can’t refuse.\r\n\r\nTo your success,\r\nKevin\r\n\r\nWho is Dan Kennedy?\r\nhttps://books.forbes.com/authors/dan-kennedy/\r\n\r\n\r\n\r\n\r\nUnsubscribe: \r\nhttps://marketersmentor.com/unsubscribe.php?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-03-08 06:33:15', '2025-03-08 06:33:15', 0),
(114, 'Mike Anthonv Nilsen', 'info@speed-seo.net', 'Unlock Your bilta.org Potential with a Free SEO Score Check', 'Greetings, \r\n \r\nCurious about how your site is performing? \r\nLearn its pros and cons with our Complimentary Site Analysis! \r\n \r\nIn just 2 minutes, you’ll get a detailed analysis of your search performance and recommendations to boost your visibility. \r\n \r\nTake the first step towards better performance and growth. \r\n \r\nRun Your Free SEO Check Now \r\nhttps://www.speed-seo.net/check-site-seo-score/ \r\n \r\nDon’t let undetected ranking obstacles damage your rankings. \r\nOptimize your website today and become more visible in your industry! \r\n \r\nNeed more info? Whatsapp with a SEO expert: https://www.speed-seo.net/whatsapp-with-us/ \r\n \r\nWishing you success, \r\n \r\n \r\nMike Anthonv Nilsen\r\n \r\nSpeed SEO \r\nPhone/WhatsApp: +1 (833) 454-8622', 0, '1', 'infor@bilta.org', '2025-03-09 06:09:52', '2025-03-09 06:09:52', 0),
(115, 'Amandaamudgeb', 'amandaIromBeam2@gmail.com', '\"You\'ve finally tracked me down!\"', '\"My intuition says we\'re a perfect match. Meet me at https://rb.gy/44z0k7?Axorne ?\"', 0, '1', 'infor@bilta.org', '2025-03-09 15:35:19', '2025-03-09 15:35:19', 0),
(116, 'Alice', 'rtppshnu@do-not-respond.me', 'Hello', 'iPSOn jMOy VNB', 0, '1', 'infor@bilta.org', '2025-03-10 16:49:48', '2025-03-10 16:49:48', 0),
(117, 'JohnStalt', 'duqotayowud23@gmail.com', 'Hi  i am write about   the prices', 'Hi, I wanted to know your price.', 0, '1', 'infor@bilta.org', '2025-03-10 21:40:56', '2025-03-10 21:40:56', 0),
(118, 'Mike Charles Persson', 'info@professionalseocleanup.com', 'Improve your website`s ranks totally free', 'Hi there, \r\n \r\nWhile checking your bilta.org for its ranks, I have noticed that \r\nthere are some toxic links pointing towards it. \r\n \r\nGrab your free clean up and improve ranks in no time \r\nhttps://www.professionalseocleanup.com/ \r\n \r\nAsk us how we do it: \r\nhttps://www.professionalseocleanup.com/whatsapp/ \r\n \r\nRegards \r\nMike Charles Persson\r\n \r\nPhone: +1 (855) 221-7591', 0, '1', 'infor@bilta.org', '2025-03-11 03:26:00', '2025-03-11 03:26:00', 0),
(119, 'Louispsymn', 'kk69000@gmail.com', 'SEXY GIRLS SUCHEN NUR HIER NACH SCHNELLEM SEX', 'Sehr schone Madchen wollen nur auf dieser Seite Sex mit dir http://stroygarantnu.ru/bitrix/redirect.php?goto=https%3A%2F%2Ftelegra.ph%2Fbhw-03-02%3F8544?2z0at2y9 \n \n \n \n \ns7vu7o6j4d1y0o1q \ng7vy0e0u0v8r4n6n \nx8vu3b6x3k1i5g4m \nv6oy2i2f3b2h6b5p', 0, '1', 'infor@bilta.org', '2025-03-11 05:26:42', '2025-03-11 05:26:42', 0),
(120, 'Joanna Riggs', 'joannariggs278@gmail.com', 'Explainer Video for your website', 'Hi,\r\n\r\nI just visited bilta.org and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur videos cost just $195 for a 30 second video ($239 for 60 seconds) and include a full script, voice-over and video.\r\n\r\nI can show you some previous videos we\'ve done if you want me to send some over. Let me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna', 0, '1', 'infor@bilta.org', '2025-03-11 11:57:56', '2025-03-11 11:57:56', 0),
(121, 'TedStalt', 'ocopesuq299@gmail.com', 'Hi    writing about your   prices', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-03-11 14:49:34', '2025-03-11 14:49:34', 0),
(122, 'Zeen Cloutier', 'zeen.localnews@gmail.com', 'Hello bilta.org Webmaster! :  Make AI Work for Your Business—Lifetime Access, No Ongoing Fees', 'Hi ,\r\n\r\nI hope you\'re doing well! I know running a business takes time, and keeping up with content creation, marketing, and admin tasks can feel overwhelming. That’s why I wanted to introduce you to 1min.AI—a powerful AI platform that can help you save time, work smarter, and grow your business.\r\n\r\nWhat is 1min.AI?\r\n\r\nhttps://tinyurl.com/1minilifetime\r\n\r\nIt’s an all-in-one AI-powered toolkit that helps businesses create content, edit images, generate videos, transcribe audio, and more—all in just minutes. Instead of juggling multiple tools and subscriptions, you get everything in one place.\r\n\r\nHow 1min.AI Can Benefit Your Business:\r\n✔ AI Writing & Chat: Generate blog posts, social media captions, marketing copy, or get instant business insights.\r\n✔ AI Image & Design Tools: Create stunning images, remove backgrounds, upscale photos, and design visuals effortlessly.\r\n✔ AI Video & Audio: Convert text into engaging videos, transcribe meetings, and turn written content into natural-sounding speech.\r\n✔ Top AI Models in One Platform: Includes GPT-4, Stable Diffusion, Midjourney, ClaudeAI, Gemini, and more.\r\n✔ Saves Time & Money: Automate repetitive tasks, enhance productivity, and cut down on costly software subscriptions.\r\n\r\n������ Special Offer: Lifetime Access (No Subscriptions!)\r\nInstead of paying monthly, you can get lifetime access to 1min.AI for a one-time payment of $39.99 (regularly $234). That means you own the tools forever—no ongoing fees.\r\n\r\n\r\n\r\n������ Claim Your Lifetime Deal Here → 1min.AI Advanced Business Plan\r\n\r\nhttps://tinyurl.com/1minilifetime\r\n\r\n\r\nIf this sounds interesting, feel free to check it out. I’m happy to answer any questions if you’d like to see how it could fit your business needs!\r\n\r\nLooking forward to hearing your thoughts.\r\n\r\nBest,', 0, '1', 'infor@bilta.org', '2025-03-12 01:54:08', '2025-03-12 01:54:08', 0),
(123, 'Andrewhob', 'tiarastover3@gmail.com', 'URGENT MESSAGE! $150,635.89 Alert: Act Before Deadline Hits', 'URGENT MESSAGE! We Owe You $150,755.48 – Claim Now! https://script.google.com/macros/s/AKfycbwxeHhqqu3j18Guyvni77I39Q6308ofbmp3Yt8g6N7pXKYsgEDTFofAb3inaIYVg0WEKA/exec/4r7y8s4y/7u6m/b/3q/1f3n9h3u/7z0q/y/m8/7q7u6j3t/7e8r/n/go?5f0vb2m3 \r\n \r\n \r\n \r\n \r\nw4gv1r7q3e3h3s5z \r\nz9ei4h7e9d7a3h7b \r\ne7fw5s2s5e2z6d9w \r\nq7ii5w4d6p8i0e8f', 0, '1', 'infor@bilta.org', '2025-03-12 21:25:00', '2025-03-12 21:25:00', 0),
(124, 'Andrewhob', 'smithsean77@gmail.com', 'IMPORTANT MESSAGE! Immediate Claim: Secure Your $150,935.52 Prize', 'URGENT MESSAGE! Don\'t Miss Your Fortune: $150,725.32 Ready for Withdrawal—Claim Now! https://script.google.com/macros/s/AKfycbzusC5_uj2t7hKYJyyzBOBN7hNpIy7bDrQ_M2fed5Yeiwrj4MvKadVkHOqHizAOZn18rg/exec/6s8l6j4r/5v0z/r/l2/7z9b9d1i/7m7r/g/ot/2f6i8l3i/7n6r/h/1y?5a5vh6b8 \r\n \r\n \r\n \r\n \r\nw6mj4x3w0y7a5e9d \r\nf5mv8w7n2f5q2a7c \r\na7ig8g5q5c2t0h1p \r\nt6nb8l4h2m1v8f0z', 0, '1', 'infor@bilta.org', '2025-03-13 19:51:04', '2025-03-13 19:51:04', 0),
(125, 'Zeen Blackmore', 'zeen.localnews@gmail.com', 'Hi bilta.org Webmaster. :  Make AI Work for Your Business—Lifetime Access, No Ongoing Fees', 'Hi ,\r\n\r\nI hope you\'re doing well! I know running a business takes time, and keeping up with content creation, marketing, and admin tasks can feel overwhelming. That’s why I wanted to introduce you to 1min.AI—a powerful AI platform that can help you save time, work smarter, and grow your business.\r\n\r\nWhat is 1min.AI?\r\n\r\nhttps://tinyurl.com/1minilifetime\r\n\r\nIt’s an all-in-one AI-powered toolkit that helps businesses create content, edit images, generate videos, transcribe audio, and more—all in just minutes. Instead of juggling multiple tools and subscriptions, you get everything in one place.\r\n\r\nHow 1min.AI Can Benefit Your Business:\r\n✔ AI Writing & Chat: Generate blog posts, social media captions, marketing copy, or get instant business insights.\r\n✔ AI Image & Design Tools: Create stunning images, remove backgrounds, upscale photos, and design visuals effortlessly.\r\n✔ AI Video & Audio: Convert text into engaging videos, transcribe meetings, and turn written content into natural-sounding speech.\r\n✔ Top AI Models in One Platform: Includes GPT-4, Stable Diffusion, Midjourney, ClaudeAI, Gemini, and more.\r\n✔ Saves Time & Money: Automate repetitive tasks, enhance productivity, and cut down on costly software subscriptions.\r\n\r\n������ Special Offer: Lifetime Access (No Subscriptions!)\r\nInstead of paying monthly, you can get lifetime access to 1min.AI for a one-time payment of $39.99 (regularly $234). That means you own the tools forever—no ongoing fees.\r\n\r\n\r\n\r\n������ Claim Your Lifetime Deal Here → 1min.AI Advanced Business Plan\r\n\r\nhttps://tinyurl.com/1minilifetime\r\n\r\n\r\nIf this sounds interesting, feel free to check it out. I’m happy to answer any questions if you’d like to see how it could fit your business needs!\r\n\r\nLooking forward to hearing your thoughts.\r\n\r\nBest,', 0, '1', 'infor@bilta.org', '2025-03-14 09:30:47', '2025-03-14 09:30:47', 0),
(126, 'Bryantnop', 'nomin.momin+227u2@mail.ru', 'Ncfwuwjijdwefjehue iwiqkwodeigi irwodwofjihgrjeo owofjiegheijwodkowj ihiwdowdkwojefgihg bilta.org', 'Nfwhdkjdwj rdqskwjfej wkdwodkwkifjejr okeowjrfiejfiej rowjedowkrfiejfi jrowkorwkjrfejfi jorkdworefoijfeijfowek okdwofjiejgierjfoe bilta.org', 0, '1', 'infor@bilta.org', '2025-03-15 02:52:16', '2025-03-15 02:52:16', 0),
(127, 'TedStalt', 'ocopesuq299@gmail.com', 'Aloha    writing about   the price for reseller', 'Ndewo, achọrọ m ịmara ọnụahịa gị.', 0, '1', 'infor@bilta.org', '2025-03-16 21:41:03', '2025-03-16 21:41:03', 0),
(128, 'GeorgeStalt', 'ocopesuq299@gmail.com', 'Hallo    write about     price', 'Hola, quería saber tu precio..', 0, '1', 'infor@bilta.org', '2025-03-17 00:29:20', '2025-03-17 00:29:20', 0),
(129, 'Amelia Brown', 'ameliabrown5822@gmail.com', 'YouTube Promotion: 700-1500 new subscribers each month', 'Hi there,\r\n\r\nWe run a Youtube growth service, where we can increase your subscriber count safely and practically. \r\n\r\n- Guaranteed: We guarantee to gain you 700-1500 new subscribers each month.\r\n- Real, human subscribers who subscribe because they are interested in your channel/videos.\r\n- Safe: All actions are done, without using any automated tasks / bots.\r\n\r\nOur price is just $60 (USD) per month and we can start immediately.\r\n\r\nIf you are interested then we can discuss further.\r\n\r\nKind Regards,\r\nAmelia', 0, '1', 'infor@bilta.org', '2025-03-18 14:20:03', '2025-03-18 14:20:03', 0),
(130, 'Greeting', 'greeting@gmail.com', 'Greeting', 'Welcome https://vk.com/clip-229128076_456239351', 0, '1', 'infor@bilta.org', '2025-03-20 09:23:09', '2025-03-20 09:23:09', 0),
(131, 'GeorgeStalt', 'aferinohis056@gmail.com', 'Hallo  i am writing about   the prices', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-03-21 15:16:36', '2025-03-21 15:16:36', 0),
(132, 'Mike Donald Michel', 'info@digital-x-press.com', 'Patience Pays Off – See the Results', 'Hi there, \r\n \r\nI understand that many have difficulty understanding that organic ranking growth requires time and a strategic long-term commitment. \r\n \r\nThe reality is, very few webmasters have the patience to wait for the gradual yet impactful trends that can transform their business. \r\n \r\nWith frequent SEO changes, a steady, long-term strategy is critical for getting a high return on investment. \r\n \r\nIf you see this as the right method, give us a try! \r\n \r\nCheck out Our SEO Growth Packages \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\n \r\nContact Us on Live Support \r\nhttps://www.digital-x-press.com/whatsapp-us/ \r\n \r\nWe deliver measurable growth for your SEO spend, and you won’t regret choosing us as your growth partner. \r\n \r\nThank you, \r\nDigital X SEO Experts \r\nPhone/WhatsApp: +1 (844) 754-1148', 0, '1', 'infor@bilta.org', '2025-03-22 23:40:19', '2025-03-22 23:40:19', 0),
(133, 'Mike Kristian Svensson', 'mike@monkeydigital.co', 'Collaboration Request', 'Hey, \r\n \r\nThis is Mike from Monkey Digital, \r\nI am reaching out to discuss a great business deal. \r\n \r\nHow would you like to feature our ads on your website and link back via your unique referral link towards popular products from our business? \r\n \r\nThis way, you receive a recurring 35% commission, month after month from any sales that are made from your site. \r\n \r\nThink about it, most website owners benefit from SEO, so this is a huge opportunity. \r\n \r\nWe already have over 12,000 affiliates and our commissions are processed on time. \r\nLast month, we distributed over $27,000 in payouts to our partners. \r\n \r\nIf you want in, kindly chat with us here: \r\nhttps://monkeydigital.co/affiliates-whatsapp/ \r\n \r\nOr sign up today: \r\nhttps://www.monkeydigital.co/join-our-affiliate-program/ \r\n \r\nCheers, \r\nMike Kristian Svensson\r\n \r\nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-03-23 07:25:35', '2025-03-23 07:25:35', 0),
(134, 'Hackersoft', 'joshuawright1972@tutamail.com', 'HACKER SOFT for Sale - Illegal Monero mining Combine.', 'HACKER SOFT - illegal virtual mining on other people\'s computers all over the world. \r\nThis is what really brings in money! \r\nThe program is all in one, simple and understandable even for inexperienced people. \r\nYou don\'t have to be a hacker to make money like a hacker! \r\n+3 to +6 XMR Monero per day (+150$ minimum every day!) \r\n \r\nhttps://how-to-become-a-hacker.com/', 0, '1', 'infor@bilta.org', '2025-03-24 18:09:41', '2025-03-24 18:09:41', 0),
(135, 'Mike Kenneth Davies', 'info@strictlydigital.net', 'Semrush links for bilta.org', 'Hi there, \r\n \r\nGetting some set of links redirecting to bilta.org could have zero worth or harmful results for your business. \r\n \r\nIt really makes no difference how many external links you have, what is key is the amount of keywords those websites are optimized for. \r\n \r\nThat is the critical thing. \r\nNot the fake third-party metrics or Domain Rating. \r\nThat anyone can do these days. \r\nBUT the volume of ranking keywords the websites that point to your site have. \r\nThat’s it. \r\n \r\nMake sure these backlinks point to your website and you will ROCK! \r\n \r\nWe are providing this powerful service here: \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nHave questions, or need more information, message us here: \r\nhttps://www.strictlydigital.net/whatsapp-us/ \r\n \r\nBest regards, \r\nMike Kenneth Davies\r\n \r\nstrictlydigital.net \r\nPhone/WhatsApp: +1 (877) 566-3738', 0, '1', 'infor@bilta.org', '2025-03-25 06:04:32', '2025-03-25 06:04:32', 0),
(136, 'Jeffreycoiny', 'chalifoux_strength@biebel54.dynainbox.com', 'Лучшие слоты в казино Риобет', '<a href=\"https://riobet-kasino.icu/\">казино Риобет</a>', 0, '1', 'infor@bilta.org', '2025-03-25 13:01:20', '2025-03-25 13:01:20', 0),
(137, 'HenryStalt', 'zekisuquc419@gmail.com', 'Aloha  i writing about your the prices', 'Hola, quería saber tu precio..', 0, '1', 'infor@bilta.org', '2025-03-26 05:11:31', '2025-03-26 05:11:31', 0),
(138, 'Chipampe Joseph', 'c302225@gmail.com', 'Applying for the job as a Translator (kabende as my local language, samfya)', 'Following the advertisement published on your platform, I am here to apply for the job mentioned in the subject.\r\nI am a male Zambian citizen aged 33 with a Green National Registration card number: 128026/36/1 based in samfya district.\r\nI hold two diplomas , one in Christian Leadership Development and the other one in Secondary teaching majored in English languages and social studies (un employed).\r\nI am very much interested in the job for it has been always my first priority working for God through our Lord Jesus Christ.\r\nI am an evengelist married man with two kids and I am not only a member but a preacher of church of Christ.', 0, '1', 'infor@bilta.org', '2025-03-28 20:19:00', '2025-03-28 20:19:00', 0),
(139, 'JohnStalt', 'zekisuquc419@gmail.com', 'Hi,   wrote about   the price for reseller', 'Salam, qiymətinizi bilmək istədim.', 0, '1', 'infor@bilta.org', '2025-03-28 23:05:02', '2025-03-28 23:05:02', 0),
(140, 'TedStalt', 'aferinohis056@gmail.com', 'Hallo, i am writing about     prices', 'Ola, quería saber o seu prezo.', 0, '1', 'infor@bilta.org', '2025-03-29 06:11:50', '2025-03-29 06:11:50', 0),
(141, 'Mike Thorsten Miller', 'mike@monkeydigital.co', 'Boost Your Website Traffic with Targeted Social Ads – Only $10 for 10K Visits!', 'Dear Webmaster, \r\n \r\nI wanted to check in with something that could seriously improve your website’s visitor count. We work with a trusted ad network that allows us to deliver authentic, location-based social ads traffic for just $10 per 10,000 visits. \r\n \r\nThis isn\'t fake traffic—it’s real visitors, tailored to your chosen market and niche. \r\n \r\nWhat you get: \r\n \r\n10,000+ high-quality visitors for just $10 \r\nLocalized traffic for your chosen location \r\nScalability available based on your needs \r\nProven to work—we even use this for our SEO clients! \r\n \r\nInterested? Check out the details here: \r\nhttps://www.monkeydigital.co/product/country-targeted-traffic/ \r\n \r\nOr ask any questions on WhatsApp: \r\nhttps://monkeydigital.co/whatsapp-us/ \r\n \r\nLooking forward to getting you more traffic! \r\n \r\nBest, \r\nMike Thorsten Miller\r\n \r\nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-03-29 18:17:12', '2025-03-29 18:17:12', 0),
(142, 'Joanna Riggs', 'joannariggs278@gmail.com', 'Explainer Video for bilta.org', 'Hi,\n\nI just visited bilta.org and wondered if you\'d ever thought about having an engaging video to explain what you do?\n\nOur videos cost just $195 for a 30 second video ($239 for 60 seconds) and include a full script, voice-over and video.\n\nI can show you some previous videos we\'ve done if you want me to send some over. Let me know if you\'re interested in seeing samples of our previous work.\n\nRegards,\nJoanna', 0, '1', 'infor@bilta.org', '2025-03-30 05:16:11', '2025-03-30 05:16:11', 0),
(143, 'FreyaStalt', 'zekisuquc419@gmail.com', 'Hallo, i write about your the price', 'Sawubona, bengifuna ukwazi intengo yakho.', 0, '1', 'infor@bilta.org', '2025-04-01 00:33:32', '2025-04-01 00:33:32', 0),
(144, 'GeorgeStalt', 'xiceruxuk02@gmail.com', 'Hello    writing about     price', 'Ola, quería saber o seu prezo.', 0, '1', 'infor@bilta.org', '2025-04-01 08:40:20', '2025-04-01 08:40:20', 0),
(145, 'TedStalt', 'aferinohis056@gmail.com', 'Hallo  i am wrote about your the price', 'Hej, jeg ønskede at kende din pris.', 0, '1', 'infor@bilta.org', '2025-04-02 12:01:06', '2025-04-02 12:01:06', 0),
(146, 'Van Gurt', 'vangurt@emailcheka.com', 'Your Project Funding', 'Dear Sir, \n \nWe are a Financial services provider. \n \nWe assist companies with loans/funds to expand their already existing businesses or companies. We also provide funds for new projects that meet our funding requirements. \n \nIf our services mean anything to you, Kindly contact us: van.gurt111@gmail.com \n \nVan Gurt \nvan.gurt111@gmail.com', 0, '1', 'infor@bilta.org', '2025-04-03 14:10:15', '2025-04-03 14:10:15', 0),
(147, 'Diana Mertz', 'mertz.diana@gmail.com', 'Build Your Own AI Subscription Business: All Premium Tools Included', 'Hi,\r\n\r\nAre you tired of paying multiple monthly subscriptions for premium AI tools? \r\n\r\nI\'d like to introduce the world\'s first cloud-based platform that gives you access to premium uncensored versions of leading AI apps in a single dashboard:\r\n\r\nDeepSeek R1, Grok, ChatGPT-4o, Gemini 2.0 Flash, Claude Pro, and more.\r\nNo monthly fees - just a one-time payment of $14.95 (normally $97).\r\nFull commercial license included.\r\nLaunch your own AI subscription platform and charge any amount\r\n\r\nKey Features:\r\n\r\nUncensored AI chat with no restrictions on topics.\r\nSupport for 40+ languages.\r\nCode generation capabilities.\r\nEasy-to-use dashboard.\r\n30-day money-back guarantee\r\n\r\nThis limited-time offer includes all premium AI tools without any censorship or monthly fees. You\'ll have everything you need to create high-quality content, generate stunning visuals, write code, and more.\r\n\r\nLearn more: https://furtherinfo.info/oneai\r\n\r\nBest regards,\r\nDiana\r\n\r\nIf you do not wish us to contact you again, let us know here: https://removeme.live/a/unsubscribe.php?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-04-03 22:09:30', '2025-04-03 22:09:30', 0),
(148, 'Amelia Brown', 'ameliabrown5812@gmail.com', 'YouTube Promotion: 700-1500 new subscribers each month', 'Hi there,\r\n\r\nWe run a YouTube growth service, which increases your number of subscribers both safely and practically.\r\n\r\n- We guarantee to gain you 700-1500+ subscribers per month.\r\n- People subscribe because they are interested in your channel/videos, increasing likes, comments and interaction.\r\n- All actions are made manually by our team. We do not use any \'bots\'.\r\n\r\nThe price is just $60 (USD) per month, and we can start immediately.\r\n\r\nIf you have any questions, let me know, and we can discuss further.\r\n\r\nKind Regards,\r\nAmelia', 0, '1', 'infor@bilta.org', '2025-04-04 09:08:03', '2025-04-04 09:08:03', 0),
(149, 'Mike Milan Miller', 'info@speed-seo.net', 'Find bilta.org SEO Issues totally free', 'Hi, \r\nWorried about hidden SEO issues on your website? Let us help — completely free. \r\nRun a 100% free SEO check and discover the exact problems holding your site back from ranking higher on Google. \r\n \r\nRun Your Free SEO Check Now \r\nhttps://www.speed-seo.net/check-site-seo-score/ \r\n \r\nOr chat with us and our agent will run the report for you: https://www.speed-seo.net/whatsapp-with-us/ \r\n \r\nBest regards, \r\n \r\n \r\nMike Milan Miller\r\n \r\nSpeed SEO Digital \r\nEmail: info@speed-seo.net \r\nPhone/WhatsApp: +1 (833) 454-8622', 0, '1', 'infor@bilta.org', '2025-04-04 21:43:46', '2025-04-04 21:43:46', 0),
(150, 'JohnStalt', 'zekisuquc419@gmail.com', 'Aloha,   write about your   price for reseller', 'Ողջույն, ես ուզում էի իմանալ ձեր գինը.', 0, '1', 'infor@bilta.org', '2025-04-05 16:31:25', '2025-04-05 16:31:25', 0),
(151, 'Jeanett Garten', 'jeanett.garten@outlook.com', 'Stop Losing Sales: Automate Customer Interactions Now', 'Hi,\r\n\r\nWe\'ve recently launched a chatbot which we think will transform how you convert your visitors on bilta.org.\r\n\r\nOur AI-powered chatbot works across Facebook, Instagram, and TikTok to:\r\n\r\n1. Engage visitors and respond to comments 24/7\r\n2. Automatically capture leads while you sleep\r\n3. Promote your products and drive sales on autopilot\r\n4. Provide instant customer support without hiring staff\r\n5. Create natural, human-like conversations with visitors\r\n\r\nOur tool integrates seamlessly with Zapier, CRMs, and payment platforms to automate your entire sales process from first contact to purchase.\r\n\r\nOur early customers are seeing up to a 128% increase in conversions with no technical skills required.\r\n\r\nLearn more here: https://furtherinfo.info/social\r\n\r\nRegards,\r\nJeanett\r\n\r\nOpt Out: https://removeme.live/a/unsubscribe.php?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-04-06 03:21:57', '2025-04-06 03:21:57', 0),
(152, 'GeorgeStalt', 'xiceruxuk02@gmail.com', 'Hallo, i am wrote about your the price for reseller', 'Здравейте, исках да знам цената ви.', 0, '1', 'infor@bilta.org', '2025-04-06 11:02:10', '2025-04-06 11:02:10', 0),
(153, 'Liam Healy', 'healy.liam@outlook.com', 'Build Your Own AI Subscription Business: All Premium Tools Included', 'Hi,\r\n\r\nAre you tired of paying multiple monthly subscriptions for premium AI tools? \r\n\r\nI\'d like to introduce the world\'s first cloud-based platform that gives you access to premium uncensored versions of leading AI apps in a single dashboard:\r\n\r\nDeepSeek R1, Grok, ChatGPT-4o, Gemini 2.0 Flash, Claude Pro, and more.\r\nNo monthly fees - just a one-time payment of $14.95 (normally $97).\r\nFull commercial license included.\r\nLaunch your own AI subscription platform and charge any amount\r\n\r\nKey Features:\r\n\r\nUncensored AI chat with no restrictions on topics.\r\nSupport for 40+ languages.\r\nCode generation capabilities.\r\nEasy-to-use dashboard.\r\n30-day money-back guarantee\r\n\r\nThis limited-time offer includes all premium AI tools without any censorship or monthly fees. You\'ll have everything you need to create high-quality content, generate stunning visuals, write code, and more.\r\n\r\nLearn more: https://furtherinfo.info/oneai\r\n\r\nBest regards,\r\nLiam\r\n\r\nIf you do not wish us to contact you again, let us know here: https://removeme.live/a/unsubscribe.php?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-04-07 05:05:12', '2025-04-07 05:05:12', 0),
(154, 'TestUser', 'ymirpoam@testing-your-form.info', 'Alice', 'GBu QsOZV uhTuO YSAeNzY', 0, '1', 'infor@bilta.org', '2025-04-08 00:03:07', '2025-04-08 00:03:07', 0);
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_by`, `status_id`, `recipient`, `created_at`, `updated_at`, `spam`) VALUES
(155, 'Lina Witt', 'lina.witt90@gmail.com', 'Exclusive Offer: All-in-One Uncensored AI Platform', 'Hi,\r\n\r\nAre you tired of paying multiple monthly subscriptions for premium AI tools? \r\n\r\nI\'d like to introduce the world\'s first cloud-based platform that gives you access to premium uncensored versions of leading AI apps in a single dashboard:\r\n\r\nDeepSeek R1, Grok, ChatGPT-4o, Gemini 2.0 Flash, Claude Pro, and more.\r\nNo monthly fees - just a one-time payment of $14.95 (normally $97).\r\nFull commercial license included.\r\nLaunch your own AI subscription platform and charge any amount\r\n\r\nKey Features:\r\n\r\nUncensored AI chat with no restrictions on topics.\r\nSupport for 40+ languages.\r\nCode generation capabilities.\r\nEasy-to-use dashboard.\r\n30-day money-back guarantee\r\n\r\nThis limited-time offer includes all premium AI tools without any censorship or monthly fees. You\'ll have everything you need to create high-quality content, generate stunning visuals, write code, and more.\r\n\r\nLearn more: https://furtherinfo.info/oneai\r\n\r\nBest regards,\r\nLina', 0, '1', 'infor@bilta.org', '2025-04-09 02:09:59', '2025-04-09 02:09:59', 0),
(156, 'Mike Lars-Erik Van de Berg', 'info@hilkom-digital.com', 'Last Remaining SEO Opportunities Open – Secure Your Monthly SEO Boost Now', 'Hi, \r\n \r\nIf you’re looking to boost your rankings, monthly SEO is the way forward. \r\n \r\nAt Hilkom Digital, we specialize in long-term growth through expert-led SEO strategies. Our monthly plans are crafted with care and ideal for teams that want actual growth — not just vanity metrics. \r\n \r\nDue to strong client interest and our commitment to quality, we can only take on a limited number of clients each month. This ensures we maintain quality service for every client. \r\n \r\n______________ \r\nYour SEO Plan Covers: \r\n•	On-site SEO & technical optimization \r\n•	DA50+ backlink building \r\n•	Smart keyword focus and tracking \r\n•	Link profile audit & clean-up \r\n•	Paid indexing for faster rankings \r\n•	Multilingual SEO support (DE, ES, FR, EN) \r\n______________ \r\n \r\nSpots are limited — reserve your monthly SEO plan now: \r\nhttps://www.hilkom-digital.com/seo-services/ \r\n \r\nHave questions? Chat with an SEO expert here: \r\nhttps://www.hilkom-digital.com/whatsapp-us/ \r\n \r\nLet’s boost your digital presence, drive traffic, and grow your business — the smart way. \r\n \r\nBest regards, \r\nMike Lars-Erik Van de Berg\r\n \r\nHilkom Digital \r\nPhone/WhatsApp: +1 (855) 221-7591 \r\nsupport@hilkom-digital.com', 0, '1', 'infor@bilta.org', '2025-04-13 10:18:10', '2025-04-13 10:18:10', 0),
(157, 'Rosario Birkbeck', 'birkbeck.rosario@outlook.com', 'Boost bilta.org\'s traffic with our AI traffic service.', 'Every day, websites like bilta.org lose valuable traffic opportunities. Don’t let yours be one of them. Our automated traffic system is designed to boost visibility and bring highly targeted traffic to your site.\r\n\r\nClaim your complimentary 4,000-visitor trial to experience the benefits firsthand. Then, expand to plans offering up to 350,000 visitors per month. It’s time to unlock your website’s true traffic potential. Get started here: https://ow.ly/20s350VyXXa', 0, '1', 'infor@bilta.org', '2025-04-14 03:46:05', '2025-04-14 03:46:05', 0),
(158, 'Aubrey Goldman', 'goldman.aubrey@gmail.com', 'The Magic of Speaking Directly to Your Leads', 'Dan Kennedy often uses a simple analogy to illustrate a common marketing mistake:\r\n\r\nImagine walking into a store and being swarmed by a salesperson who starts pitching everything they sell—refrigerators, running shoes, blenders—without once asking what you’re actually looking for. It’s frustrating, ineffective… and exactly what most businesses do in their marketing.\r\n\r\nInstead of speaking directly to prospects’ specific needs or concerns, most businesses blast the same generic message to everyone. And according to Dan, that’s a surefire way to water down your impact—and your profits.\r\n\r\nHe points to Weight Watchers as a prime example.\r\n\r\nThey serve two distinct types of customers:\r\n\r\nHealth Buyers – motivated by medical reasons, like a doctor’s orders or an upcoming surgery.\r\n\r\nEvent-Driven Buyers – focused on short-term goals, like fitting into a dress for a wedding or looking good for a vacation.\r\n\r\nThese two audiences have completely different motivations. One wants to avoid a health crisis. The other wants to feel confident on the beach. But for years, Weight Watchers hesitated to segment their leads and tailor their message accordingly—despite the fact that segmentation could’ve easily doubled their effectiveness.\r\n\r\nAnd this issue isn’t limited to weight loss companies.\r\n\r\nAt Magnetic Marketing, Dan Kennedy and his team have identified seven distinct interest categories among their audience—from wealth attraction to direct marketing and beyond. If they tried to send one message to all seven groups, they’d fail to deeply connect with any of them.\r\n\r\nDan compares this to politics: voters often care about one primary issue. Your leads are no different. Some are driven by fear. Others by ambition. And others by a very specific short-term goal.\r\n\r\nConsider three different prospects in the finance space:\r\n\r\nOne fears running out of money in retirement.\r\n\r\nAnother wants to protect wealth for their grandchildren.\r\n\r\nA third wants to maximize investment returns.\r\n\r\nA single message trying to appeal to all three ends up resonating with none of them.\r\n\r\nThat’s why segmentation is so powerful—and profitable.\r\n\r\nBy tailoring messages to meet prospects where they are mentally and emotionally, businesses instantly build trust, create relevance, and position themselves as the only solution that truly gets the customer.\r\n\r\nDan outlines a simple framework for doing this:\r\n\r\n1.Use a Self-Select Mechanism\r\nAsk your audience questions like:\r\n“Are you looking to grow your wealth?”\r\n“Do you want to protect your assets for your family?”\r\n\r\n2.Tailor the Follow-Up\r\nOnce they identify their concern, follow up with stories, testimonials, and offers that directly address it.\r\n\r\n3.Watch Response Rates Soar\r\nA personalized message turns cold leads into warm conversations—and buyers.\r\n\r\nDan stresses this strategy works in every industry. He’s seen it boost performance in colleges, financial firms, info-product businesses, and even local service providers.\r\n\r\nTake colleges, for example. A dad wants to know his kid will get a job after graduation. A mom wants safety and solid food options. The student just wants to know they’ll make friends. Smart schools speak directly to each one—and enrollment improves dramatically.\r\n\r\nIf segmentation sounds like a mystery to you, Dan lays it all out in plain English in The No B.S. Guide to Direct Marketing. In it, he reveals:\r\n\r\nThe art of message-to-market match—how to say the right thing to the right people.\r\n\r\nHow to build self-select mechanisms that get prospects to reveal what they want—without a survey.\r\n\r\nHis exact process for creating segmented campaigns that maximize every dollar spent.\r\n\r\n������ Click Here to Claim Your FREE Copy of The No B.S. Guide to Direct Marketing + $6,193 in Exclusive Bonuses:\r\n\r\nhttps://marketersmentor.com/direct-marketing-book.php?refer=bilta.org&real=yes\r\n\r\nDan Kennedy has watched businesses transform overnight simply by getting smarter with how they segment and speak to their audience.\r\n\r\nDon’t waste another marketing dollar talking to everyone. Start speaking to someone—the right someone—and watch your results soar.\r\n\r\nDedicated to Multiplying Your Income,\r\n\r\nAubrey\r\n\r\nP.S. Dan always reminds his clients:\r\nWhoever can spend the most to acquire a customer—wins.Segmentation helps you do just that… profitably.\r\n\r\n\r\nUnsubscribe: \r\nhttps://marketersmentor.com/unsubscribe.php?d=bilta.org&real=yes', 0, '1', 'infor@bilta.org', '2025-04-14 04:51:32', '2025-04-14 04:51:32', 0),
(159, 'TedStalt', 'aferinohis056@gmail.com', 'Hi  i write about   the prices', 'Ola, quería saber o seu prezo.', 0, '1', 'infor@bilta.org', '2025-04-14 07:20:35', '2025-04-14 07:20:35', 0),
(160, 'Ahmed Abdulla', 'ahmed.abdulla00175@gmail.com', 'Business Mandate', 'Dear Sir/ma, \r\n \r\nWe are a financial services and advisory company mandated by our investors to seek business opportunities and projects for possible funding and debt capital financing. \r\n \r\nPlease note that our investors are from the Gulf region. They intend to invest in viable business ventures or projects that you are currently executing or intend to embark upon as a means of expanding your (their) global portfolio. \r\n \r\nWe are eager to have more discussions on this subject in any way you believe suitable. \r\n \r\nPlease contact me on my direct email: ahmed.abdulla@dejlaconsulting.com \r\n \r\nLooking forward to working with you. \r\n \r\nYours faithfully, \r\nAhmed Abdulla \r\nfinancial advisor \r\nDejla Consulting LLC', 0, '1', 'infor@bilta.org', '2025-04-15 11:25:17', '2025-04-15 11:25:17', 0),
(161, 'GeorgeStalt', 'xiceruxuk02@gmail.com', 'Hi, i writing about   the prices', 'Здравейте, исках да знам цената ви.', 0, '1', 'infor@bilta.org', '2025-04-17 07:05:03', '2025-04-17 07:05:03', 0),
(162, 'Mike Mathis Eriksson', 'info@digital-x-press.com', 'Grow Your Site the Right Way – Here’s How to Win', 'Greetings, \r\n \r\nI realize that many struggle accepting that organic ranking growth is a long-term game and a well-planned long-term commitment. \r\n \r\nThe reality is, very few businesses have the patience to witness the progressive yet powerful trends that can completely change their online presence. \r\n \r\nWith frequent SEO changes, a consistent, ongoing optimization plan is critical for securing a high return on investment. \r\n \r\nIf you see this as the best strategy, give us a try! \r\n \r\nCheck out Our SEO Growth Packages \r\nhttps://www.digital-x-press.com/unbeatable-seo/ \r\n \r\nChat With Us on WhatsApp \r\nhttps://www.digital-x-press.com/whatsapp-us/ \r\n \r\nWe offer unbeatable results for your SEO spend, and you will be glad choosing us as your growth partner. \r\n \r\nLooking forward, \r\nDigital X SEO Experts \r\nPhone/WhatsApp: +1 (844) 754-1148', 0, '1', 'infor@bilta.org', '2025-04-17 10:44:53', '2025-04-17 10:44:53', 0),
(163, 'John', 'trjrzemx@formtest.guru', 'John', 'PzR hzRw sQm OHbzXZ', 0, '1', 'infor@bilta.org', '2025-04-17 16:06:45', '2025-04-17 16:06:45', 0),
(164, 'Son sans! 200 EUR https://ggleo.com', 'rgsgdjsgehd@gmail.com', 'Son sans! 200 EUR https://ggleo.com', 'Son sans! 200 EUR https://ggleo.com', 0, '1', 'infor@bilta.org', '2025-04-20 01:26:36', '2025-04-20 01:26:36', 0),
(165, 'Mike Martim Bonnet', 'mike@monkeydigital.co', 'Collaboration Request', 'Hey, \r\n \r\nThis is Mike from Monkey Digital, \r\nI am contacting you about a great business deal. \r\n \r\nHow would you like to feature our promotions on your site and redirect via your custom affiliate link towards popular services from our platform? \r\n \r\nThis way, you receive a 35% residual income, month after month from any purchases that generate from your audience. \r\n \r\nThink about it, all businesses need SEO, so this is a massive opportunity. \r\n \r\nWe already have over 12,000 affiliates and our commissions are paid out on time. \r\nLast month, we reached $27280 in commissions to our promoters. \r\n \r\nIf interested, kindly chat with us here: \r\nhttps://monkeydigital.co/affiliates-whatsapp/ \r\n \r\nOr sign up today: \r\nhttps://www.monkeydigital.co/join-our-affiliate-program/ \r\n \r\nBest Regards, \r\nMike Martim Bonnet\r\n \r\nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-04-20 08:04:55', '2025-04-20 08:04:55', 0),
(166, 'Acaschulse', 'y.a.n.vo.rob.ey.9.4@gmail.com', 'Electronic casino options', 'Looking to find a reliable internet gambling site? <a href=https://prof-casino.com/>https://prof-casino.com</a> stands out with its easy-to-use structure. Gamers globally have faith in this platform for its honesty and thrilling gaming options.', 0, '1', 'infor@bilta.org', '2025-04-20 09:27:44', '2025-04-20 09:27:44', 0),
(168, 'Mike Gerhardt Karlsen', 'info@strictlydigital.net', 'Semrush links for bilta.org', 'Greetings, \r\n \r\nHaving some bunch of links linking to bilta.org might bring 0 value or worse for your site. \r\n \r\nIt really doesn’t matter the total inbound links you have, what is key is the number of search terms those websites appear in search for. \r\n \r\nThat is the key factor. \r\nNot the meaningless Moz DA or SEO score. \r\nThat anyone can do these days. \r\nBUT the number of high-traffic search terms the sites that send backlinks to you have. \r\nThat’s what really matters. \r\n \r\nHave such links redirect to your site and your rankings will skyrocket! \r\n \r\nWe are providing this powerful service here: \r\nhttps://www.strictlydigital.net/product/semrush-backlinks/ \r\n \r\nHave questions, or want clarification, chat with us here: \r\nhttps://www.strictlydigital.net/whatsapp-us/ \r\n \r\nKind regards, \r\nMike Gerhardt Karlsen\r\n \r\nstrictlydigital.net \r\nPhone/WhatsApp: +1 (877) 566-3738', 0, '1', 'infor@bilta.org', '2025-04-21 17:09:28', '2025-04-21 17:09:28', 0),
(169, 'JohnStalt', 'zekisuquc419@gmail.com', 'Hallo    write about your   price for reseller', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-04-23 19:02:42', '2025-04-23 19:02:42', 0),
(170, 'Loyd Faunce', 'loyd.faunce22@gmail.com', 'Increase bilta.org\'s day-to-day visitors with our AI service.', 'Is your website bilta.org failing to capture its true potential? With our automated traffic system, you could connect with thousands of additional visitors daily—without any extra effort on your part.\r\n\r\nTake advantage of our complimentary offer that delivers four thousand targeted visitors so you can see the impact. If you love the results, our plans provide up to 350,000 visitors per month. Let’s turn missed opportunities into growth. Get more details here: https://ow.ly/mtQ250Vycxb', 0, '1', 'infor@bilta.org', '2025-04-23 23:00:56', '2025-04-23 23:00:56', 0),
(171, 'Nell Glassey', 'nell.glassey@remotesynergy.online', 'Re: bilta.org is ranking well — here’s why it’s not on page 1', 'Hi, I recently reviewed bilta.org and noticed it\'s already ranking for some high-potential keywords — but most are stuck on the second page or worse.\n\nFrom what I saw, the issue is not a lack of potential — it\'s the lack of a strong content strategy and topic relevance. With a proper SEO silo structure and well-planned content approach, we can improve those rankings significantly.\n\nHere’s a performance snapshot where you can see how bilta.org is ranking right now:  \nhttps://www.spyfu.com/overview/domain?query=bilta.org\n\nI’m not requesting payment in advance. I’ll use cutting-edge AI and SEO systems to create a custom strategy for bilta.org and even share a few example content pieces — so you can evaluate it before making any decision.\n\nIf you’re interested, just reply and I’ll send over the plan.\n\nThanks for your time,  \n\nBest regards,\n\nNell\nSEO virtual assistant\nNell.Glassey@remotesynergy.online', 0, '1', 'infor@bilta.org', '2025-04-23 23:52:05', '2025-04-23 23:52:05', 0),
(173, 'Jan Gossner', 'jan_gossner@sil.org', 'downloadable video link', 'Is it possible to get a downloadable copy/link of <One Matchstick: The Senga Fire | OFFICIAL TRAILER>? We want to use it at Awana this Sunday afternoon.\r\n\r\nMy wife and I are translators with Wycliffe Bible Translators, working in Papua New Guinea.', 0, '1', 'infor@bilta.org', '2025-04-24 23:25:21', '2025-04-24 23:25:21', 0),
(175, 'Mike Marcus Robertson', 'mike@monkeydigital.co', 'Boost Your Website Traffic with Targeted Social Ads – Only $10 for 10K Visits!', 'Hello, \r\n \r\nI wanted to connect with something that could seriously help your website’s visitor count. We work with a trusted ad network that allows us to deliver genuine, geo-targeted social ads traffic for just $10 per 10,000 visits. \r\n \r\nThis isn\'t bot traffic—it’s real visitors, tailored to your target country and niche. \r\n \r\nWhat you get: \r\n \r\n10,000+ genuine visitors for just $10 \r\nCountry-specific traffic for multiple regions \r\nHigher volumes available based on your needs \r\nProven to work—we even use this for our SEO clients! \r\n \r\nInterested? Check out the details here: \r\nhttps://www.monkeydigital.co/product/country-targeted-traffic/ \r\n \r\nOr ask any questions on WhatsApp: \r\nhttps://monkeydigital.co/whatsapp-us/ \r\n \r\nLooking forward to working with you! \r\n \r\nBest, \r\nMike Marcus Robertson\r\n \r\nPhone/whatsapp: +1 (775) 314-7914', 0, '1', 'infor@bilta.org', '2025-04-25 07:14:53', '2025-04-25 07:14:53', 0),
(176, '* * * Unlock Free Spins Today: http://v3itechnology.com/index.php?9tvisl * * * hs=18cb9b428f91dc05367c911c30287e03* ххх*', 'pazapz@mailbox.in.ua', 'r1di9i', 'dv6w8k', 0, '1', 'infor@bilta.org', '2025-04-26 13:26:23', '2025-04-26 13:26:23', 0),
(177, '* * * <a href=\"http://v3itechnology.com/index.php?9tvisl\">Unlock Free Spins Today</a> * * * hs=18cb9b428f91dc05367c911c30287e03* ххх*', 'pazapz@mailbox.in.ua', 'r1di9i', 'dv6w8k', 0, '1', 'infor@bilta.org', '2025-04-26 13:26:31', '2025-04-26 13:26:31', 0),
(178, 'GeorgeStalt', 'xiceruxuk02@gmail.com', 'Hi  i wrote about     prices', 'Hola, quería saber tu precio..', 0, '1', 'infor@bilta.org', '2025-04-26 20:09:31', '2025-04-26 20:09:31', 0),
(179, 'TedStalt', 'aferinohis056@gmail.com', 'Hallo, i wrote about   the price for reseller', 'Salam, qiymətinizi bilmək istədim.', 0, '1', 'infor@bilta.org', '2025-04-28 13:09:07', '2025-04-28 13:09:07', 0),
(180, 'TommyDeemi', 'xrumer23Pap@gmail.com', 'hi', 'hi', 0, '1', 'infor@bilta.org', '2025-05-01 12:52:26', '2025-05-01 12:52:26', 0),
(181, 'JohnStalt', 'zekisuquc419@gmail.com', 'Hello  i am wrote about   the price for reseller', 'হাই, আমি আপনার মূল্য জানতে চেয়েছিলাম.', 0, '1', 'infor@bilta.org', '2025-05-03 02:05:17', '2025-05-03 02:05:17', 0),
(182, 'Larryrop', 'socpeakbot@gmail.com', 'Grow Your social media Fast — With Socpeak.fun!', 'Are you looking to increase your visibility on Instagram, TikTok, or other platforms? \r\nWith Socpeak.fun, you can instantly boost your followers, likes, views, and more — safely and affordably. \r\nWhy choose Socpeak.fun? \r\n•	 Fast delivery \r\n•	 Real & organic-looking growth \r\n•	 Custom packages based on your goals \r\n•	 Trusted by influencers, brands & startups \r\n•	 Emails Campaign… and a lot more ! \r\nVisit us now: http://www.socpeak.fun/ \r\nStart building your audience today — and get noticed. \r\nGot questions or want a custom offer? \r\nJust email us at info@socpeak.net — and ask about your free welcome gift!', 0, '1', 'infor@bilta.org', '2025-05-04 08:30:50', '2025-05-04 08:30:50', 0),
(183, 'FreyaStalt', 'zekisuquc419@gmail.com', 'Aloha, i am writing about     price for reseller', 'Hola, volia saber el seu preu.', 0, '1', 'infor@bilta.org', '2025-05-04 10:45:53', '2025-05-04 10:45:53', 0),
(184, 'Mike Levi Jacobs', 'info@speed-seo.net', 'Find bilta.org SEO Issues totally free', 'Hi, \r\nWorried about hidden SEO issues on your website? Let us help — completely free. \r\nRun a 100% free SEO check and discover the exact problems holding your site back from ranking higher on Google. \r\n \r\nRun Your Free SEO Check Now \r\nhttps://www.speed-seo.net/check-site-seo-score/ \r\n \r\nOr chat with us and our agent will run the report for you: https://www.speed-seo.net/whatsapp-with-us/ \r\n \r\nBest regards, \r\n \r\n \r\nMike Levi Jacobs\r\n \r\nSpeed SEO Digital \r\nEmail: info@speed-seo.net \r\nPhone/WhatsApp: +1 (833) 454-8622', 0, '1', 'infor@bilta.org', '2025-05-04 15:53:36', '2025-05-04 15:53:36', 0),
(185, 'Nan Mixon', 'mixon.nan@gmail.com', 'Gain Likes to skyrocket visibility', 'Hi\r\n\r\nbilta.org\r\n\r\nWe’ve not spoken prior to this, and I hope you don’t mind this direct contact.\r\n \r\nMore followers, likes, subscribers, and views signal that your brand is trusted, building confidence with your audience.\r\n \r\n  - https://facebook.com/biltazambia\r\n  - Instagram\r\n  - Linkedin\r\n  - Twitter\r\n  - https://www.youtube.com/@SengaBible\r\n\r\nWhat the pros use to stay ahead: strategic investment in followers and views.\r\n\r\nWe’ve helped 205,000+ clients succeed.\r\n\r\nOpen an account now at this site = https://t.ly/drivesparksocial.ai', 0, '1', 'infor@bilta.org', '2025-05-06 22:29:16', '2025-05-06 22:29:16', 0),
(186, 'Joanna Riggs', 'joannariggs278@gmail.com', 'Video Promotion for your website', 'Hi,\r\n\r\nI just visited bilta.org and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur videos cost just $195 (USD) for a 30 second video ($239 for 60 seconds) and include a full script, voice-over and video.\r\n\r\nI can show you some previous videos we\'ve done if you want me to send some over. Let me know if you\'re interested in seeing samples of our previous work. If you are not interested, just use the link at the bottom.\r\n\r\nRegards,\r\nJoanna\r\n\r\nUnsubscribe: https://removeme.live/unsubscribe.php?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-07 21:05:10', '2025-05-07 21:05:10', 0),
(187, 'DjohnStalt', 'aferinohis056@gmail.com', 'Aloha, i wrote about     prices', 'Sveiki, es gribēju zināt savu cenu.', 0, '1', 'infor@bilta.org', '2025-05-08 04:45:36', '2025-05-08 04:45:36', 0),
(188, 'SimonStalt', 'aferinohis056@gmail.com', 'Hallo  i am wrote about   the price', 'হাই, আমি আপনার মূল্য জানতে চেয়েছিলাম.', 0, '1', 'infor@bilta.org', '2025-05-12 12:40:06', '2025-05-12 12:40:06', 0),
(189, 'CharlieStalt', 'yawiviseya67@gmail.com', 'Hi, i wrote about     price for reseller', 'Sawubona, bengifuna ukwazi intengo yakho.', 0, '1', 'infor@bilta.org', '2025-05-16 10:02:04', '2025-05-16 10:02:04', 1),
(190, 'Gregorio Hogben', 'gregorio.hogben70@outlook.com', 'Instantly Own 20 Ready-to-Sell Digital Marketing Courses (Unrestricted PLR)20 Ready-to-Sell Digital Marketing Courses - 100% Full PLR Rights', 'Hi,\r\n\r\nI thought this may interest you - Get immediate access to 20 premium digital marketing courses with 100% full unrestricted PLR.\r\n\r\nThis means you can:\r\n\r\nSell them as your own products\r\nRebrand them with your name/logo\r\nBundle them with other offerings\r\nGive them away to build your list\r\nUse the content in any way you choose\r\n\r\nThese in-demand courses cover essential digital marketing topics that your audience needs right now.\r\n\r\nWhy start from scratch when you can leverage these professionally-created resources immediately?\r\n\r\nFind out more: https://furtherinfo.info/20plr', 0, '1', 'infor@bilta.org', '2025-05-18 16:45:08', '2025-05-18 16:45:08', 0),
(191, 'LeeStalt', 'zekisuquc419@gmail.com', 'Hello  i am write about     price for reseller', 'Hi, I wanted to know your price.', 0, '1', 'infor@bilta.org', '2025-05-19 02:55:30', '2025-05-19 02:55:30', 1),
(192, 'CharlieStalt', 'yawiviseya67@gmail.com', 'Aloha  i wrote about   the price', 'Hæ, ég vildi vita verð þitt.', 0, '1', 'infor@bilta.org', '2025-05-21 09:36:59', '2025-05-21 09:36:59', 1),
(193, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Try this, get more leads', 'Hello Bilta Owner!\r\n\r\nMy name is Eric and I’m betting you’d like your website Bilta to generate more leads.\r\n\r\nHere’s how:\r\n\r\nWeb Visitors Into Leads is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. It signals you as soon as they say they’re interested – so that you can talk to that lead while they’re still there at Bilta.\r\n\r\nhttps://boltleadgeneration.com for a live demo now.\r\n\r\nPlus, now that you’ve got their phone number, with our new SMS Text With Lead feature, you can automatically start a text (SMS) conversation – answer questions, provide more info, and close a deal that way.\r\n\r\nIf they don’t take you up on your offer then, just follow up with text messages for new offers, content links, even just “how you doing?” notes to build a relationship.\r\n\r\nhttps://boltleadgeneration.com to discover what Web Visitors Into Leads can do for your business.\r\n\r\nThe difference between contacting someone within 5 minutes versus a half-hour means you could be converting up to 100X more leads today!\r\n\r\nTry Web Visitors Into Leads and get more leads now.\r\n\r\nEric\r\n\r\nPS: The studies show 7 out of 10 visitors don’t hang around – you can’t afford to lose them!\r\nWeb Visitors Into Leads offers a complimentary 14-day trial – and it even includes International Long Distance Calling.\r\nYou have customers waiting to talk with you right now… don’t keep them waiting.\r\nhttps://boltleadgeneration.com to try Web Visitors Into Leads now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://boltleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-24 15:29:23', '2025-05-24 15:29:23', 0),
(194, 'SimonStalt', 'aferinohis056@gmail.com', 'Aloha, i am writing about your   price for reseller', 'Hi, roeddwn i eisiau gwybod eich pris.', 0, '1', 'infor@bilta.org', '2025-05-24 20:15:45', '2025-05-24 20:15:45', 1),
(195, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Try this, get more leads', 'Hello, Bilta Owner.\r\n\r\nMy name’s Eric and I’m betting you’d like your website Bilta to generate more leads.\r\n\r\nHere’s how:\r\n\r\nWeb Visitors Into Leads is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. It signals you as soon as they say they’re interested – so that you can talk to that lead while they’re still there at Bilta.\r\n\r\nhttps://resultleadgeneration.com for a live demo now.\r\n\r\nAnd now that you’ve got their phone number, our new SMS Text With Lead feature enables you to start a text (SMS) conversation – answer questions, provide more info, and close a deal that way.\r\n\r\nIf they don’t take you up on your offer then, just follow up with text messages for new offers, content links, even just how you doing? notes to build a relationship.\r\n\r\nhttps://resultleadgeneration.com to discover what Web Visitors Into Leads can do for your business.\r\n\r\nThe difference between contacting someone within 5 minutes versus a half-hour means you could be converting up to 100X more leads today!\r\n\r\nTry Web Visitors Into Leads and get more leads now.\r\n\r\nEric\r\n\r\nPS: Studies show that 70% of a site’s visitors disappear and are gone forever after just a moment. Don’t keep losing them.\r\nWeb Visitors Into Leads offers a complimentary 14-day trial – and it even includes International Long Distance Calling.\r\nYou have customers waiting to talk with you right now… don’t keep them waiting.\r\nhttps://resultleadgeneration.com to try Web Visitors Into Leads now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://resultleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-25 17:05:25', '2025-05-25 17:05:25', 0),
(196, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'how to turn eyeballs into phone calls', 'Hello, Eric here with a quick thought about your website Bilta \r\n\r\nCool website!\r\n\r\nMy name’s Eric, and I just found your site - Bilta - while surfing the net. You showed up at the top of the search results, so I checked you out. Looks like what you’re doing is pretty cool.\r\n \r\nBut if you don’t mind me asking – after someone like me stumbles across Bilta, what usually happens?\r\n\r\nIs your site generating leads for your business? \r\n \r\nI’m guessing some, but I also bet you’d like more… studies show that 7 out of 10 who land on a site wind up leaving without a trace.\r\n\r\nNot good.\r\n\r\nHere’s a thought…\r\n\r\nHow about making it really EASY for every visitor who shows up to get a personal phone call from you as soon as they hit your site…\r\n\r\nYou can –\r\n  \r\nWeb Visitor is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. It lets you know IMMEDIATELY – so that you can talk to that lead while they’re literally looking over your site.\r\n\r\nhttps://resultleadgeneration.com to try out a Live Demo with Web Visitor now to see exactly how it works.\r\n\r\nYou’ll be amazed—the difference between contacting someone within 5 minutes versus a half-hour or more later could increase your results 100-fold.\r\n\r\nIt gets even better… once you’ve captured their phone number, with our new SMS Text With Lead feature, you can automatically start a text (SMS) conversation – immediately… and contacting someone in that 5-minute window is 100 times more powerful than reaching out 30 minutes or more later.\r\n\r\nPlus, with text messaging you can follow up later with new offers, content links, even just follow-up notes to keep the conversation going.\r\n\r\nEverything I’ve just described is simple, easy, and effective. \r\n     \r\nhttps://resultleadgeneration.com to discover what Web Visitor can do for your business, potentially converting up to 100X more eyeballs into leads today!\r\n\r\nEric\r\n\r\nPS: Web Visitor offers a complimentary 14-day trial – and it even includes International Long Distance Calling. \r\nYou have customers waiting to talk with you right now… don’t keep them waiting. \r\nhttps://resultleadgeneration.com to try Web Visitor now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://resultleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-25 21:35:51', '2025-05-25 21:35:51', 0),
(197, 'LeeStalt', 'xiceruxuk02@gmail.com', 'Hallo    write about   the price for reseller', 'Hi, მინდოდა ვიცოდე თქვენი ფასი.', 0, '1', 'infor@bilta.org', '2025-05-26 15:41:49', '2025-05-26 15:41:49', 1),
(198, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Instead, congrats', 'Hello to the Bilta Owner,\r\n\r\nI am Eric, and unlike many emails you may receive, I would like to share a note of positive feedback – well done!\r\n\r\nWhat for?\r\n\r\nPart of my role is to examine websites, and the work you have done with Bilta certainly stands out.\r\n\r\nIt is clear you have taken building a website seriously and invested real effort into developing something of quality.\r\n\r\nHowever, there is a question…\r\n\r\nWhen someone like me finds your site – maybe at the top of the search results (good job, by the way) or through a link, how can you tell?\r\n\r\nMore importantly, how can you connect with that visitor?\r\n\r\nResearch indicates that many visitors leave quickly.\r\n\r\nHere is a way to create immediate engagement that might be new to you:\r\n\r\nWeb Visitors Into Leads is a tool that operates on your site, ready to gather each visitor’s name, email address, and phone number. It alerts you promptly when they are interested – so you can speak with them while they are viewing Bilta.\r\n\r\nPlease visit https://actionleadgeneration.com to view a live demonstration of Web Visitors Into Leads today and see exactly how it operates.\r\n\r\nIt can be very helpful for your business – and it gets even better… after you have their phone number, with our text messaging feature, you can begin a conversation promptly (there’s a significant difference between connecting within a few minutes compared to waiting much longer).\r\n\r\nAdditionally, even if you do not reach a mutual understanding at once, you can maintain contact later with text messages for additional resources, content links, or follow-ups to build a rapport.\r\n\r\nEverything described is straightforward, convenient, and effective.\r\n\r\nVisit https://actionleadgeneration.com to learn what Web Visitors Into Leads can provide for your business.\r\n\r\nYou could be engaging with significantly more potential contacts soon!\r\n\r\nEric\r\n\r\nP.S. Web Visitors Into Leads includes a 14-day evaluation period and supports international communication. There are individuals ready to speak with you now, so please do not keep them waiting.\r\n\r\nVisit https://actionleadgeneration.com to explore Web Visitors Into Leads today.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://actionleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-29 23:42:30', '2025-05-29 23:42:30', 1),
(199, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Try this, get more leads', 'Hello Bilta Owner!\r\n\r\nMy name is Eric and I’m betting you’d like your website Bilta to generate more leads.\r\n\r\nHere’s how:\r\n\r\nWeb Visitors Into Leads is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. It signals you as soon as they say they’re interested – so that you can talk to that lead while they’re still there at Bilta.\r\n\r\nhttps://blastleadgeneration.com for a live demo now.\r\n\r\nPlus, now that you’ve got their phone number, with our new SMS Text With Lead feature, you can automatically start a text (SMS) conversation – answer questions, provide more info, and close a deal that way.\r\n\r\nIf they don’t take you up on your offer then, just follow up with text messages for new offers, content links, even just “how you doing?” notes to build a relationship.\r\n\r\nhttps://blastleadgeneration.com to discover what Web Visitors Into Leads can do for your business.\r\n\r\nThe difference between contacting someone within 5 minutes versus a half-hour means you could be converting up to 100X more leads today!\r\n\r\nTry Web Visitors Into Leads and get more leads now.\r\n\r\nEric\r\n\r\nPS: The studies show 7 out of 10 visitors don’t hang around – you can’t afford to lose them!\r\nWeb Visitors Into Leads offers a complimentary 14-day trial – and it even includes International Long Distance Calling.\r\nYou have customers waiting to talk with you right now… don’t keep them waiting.\r\nhttps://blastleadgeneration.com to try Web Visitors Into Leads now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://blastleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-29 23:57:35', '2025-05-29 23:57:35', 0),
(200, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Cool website!', 'Hello to the Bilta Owner,\r\n\r\nMy name’s Eric, and I recently came across your site, Bilta, while browsing online. Your site showed up near the top of the search results, so whatever you’re doing for visibility seems effective.\r\n\r\nIf I may ask: after someone like me finds Bilta, what typically happens?\r\n\r\nIs your site generating valuable inquiries for your business?\r\n\r\nMany visitors view a website and then leave without taking the next step. Research suggests that a majority of visitors exit quickly, leaving no contact information.\r\n\r\nConsider this idea: What if there was a straightforward way for each visitor to indicate they’d like a call from you right when they arrive?\r\n\r\nYou can make this happen.\r\n\r\nWeb Visitor is a tool that works on your site, ready to securely gather a visitor’s name, email, and phone number. It alerts you immediately, so you can speak with that person while they are still viewing your site.\r\n\r\nPlease visit:  \r\nhttps://trustedleadgeneration.com  \r\nto see a live demonstration of Web Visitor and observe precisely how it works.\r\n\r\nActing promptly matters when it comes to building connections. The difference between engaging with someone within a few minutes, versus waiting longer, can be substantial.\r\n\r\nOur new SMS Text With Lead feature allows you to begin a text conversation as soon as you have their number. Even if they aren’t ready right now, you can keep in touch with updates, offers, and helpful information.\r\n\r\nPlease visit the link above to learn what Web Visitor can do for your business. You might be surprised at how much more interest you can capture.\r\n\r\nEric\r\n\r\nP.S. Web Visitor offers a 14-day evaluation period and includes the ability to reach out internationally. Interested individuals may be ready to speak with you now, so please don’t miss out.  \r\nhttps://trustedleadgeneration.com\r\n\r\nWant to receive less emails, or none whatsoever? Update your email preferences by clicking here. https://trustedleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-30 20:22:55', '2025-05-30 20:22:55', 1),
(201, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Cool website!', 'Hello to the Bilta Owner.\r\n\r\nGreat website!\r\n\r\nMy name’s Eric, and I just found your site - Bilta - when browsing the net. You showed up on the top of the search engine results, so I checked you out. Seems like what you’re doing is really interesting.\r\n\r\nBut if you don’t mind me asking – after someone like me lands across Bilta, what usually happens?\r\n\r\nIs your site generating leads for your business?\r\n\r\nI’m guessing some, but I also guess you’d like more… research show that 7 out of 10 people that land on a site end up leaving without any interaction.\r\n\r\nThat’s unfortunate.\r\n\r\nHere is an idea – what if there’s a simple way for each visitor to signal interest to get a phone call from you immediately…the moment they visit your site and said, “call me now.”\r\n\r\nYou can –\r\n\r\nWeb Visitors Into Leads is a tool that works on your site, ready to capture every visitor’s Name, Email address, and Phone Number. It allows you to know immediately – so that you can talk to that lead while they’re actually browsing your site.\r\n\r\nGo to https://actionleadgeneration.com to check out a Live Demo with Web Visitors Into Leads today to see exactly how it works.\r\n\r\nTime is essential when it comes to engaging with leads – the difference between contacting someone within 5 minutes compared to 30 minutes later is significant – like 100 times more effective!\r\n\r\nThat’s why we created our new SMS Text With Lead feature… because once you’ve collected the visitor’s phone number, you can automatically start a text message conversation.\r\n\r\nConsider the opportunities – even if you don’t close a deal right away, you can stay connected with text messages for new offers, content links, or even just a quick “how are you doing?” note to establish a relationship.\r\n\r\nWouldn’t that be helpful?\r\n\r\nGo to https://actionleadgeneration.com to find out what Web Visitors Into Leads can offer for your business.\r\n\r\nYou could be converting up to 100X more leads today!  \r\nEric\r\n\r\nPS: Web Visitors Into Leads provides a complimentary 14-day trial – and it even includes International calling.  \r\nYou have customers waiting to talk with you right now… don’t leave them waiting.  \r\nGo to https://actionleadgeneration.com to try Web Visitors Into Leads today.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://actionleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-31 02:14:58', '2025-05-31 02:14:58', 0),
(202, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'how to turn eyeballs into phone calls', 'Hello to the Bilta Owner,\r\n\r\nThis is Eric here, with a brief note about your website Bilta.\r\n\r\nI am on the internet often, and I see many business websites.\r\n\r\nSimilar to yours, several of them have excellent content.  \r\nHowever, too often, they fall short when it comes to interacting and connecting with a visitor.\r\n\r\nI understand – it is challenging. Research shows that many individuals who arrive at a site leave within moments without sharing any details. You gained their initial attention, but nothing else.\r\n\r\nHere is a possible solution:\r\n\r\nWeb Visitors Into Leads is a tool that operates on your site, prepared to collect each visitor’s name, email address, and phone number. You will know right away that they are interested, and you could speak with them while they are still online viewing your site.\r\n\r\nPlease visit https://actionleadgeneration.com to view a Live Demo with Web Visitors Into Leads today to see exactly how it operates.\r\n\r\nIt can be significant for your business – and because you have their phone number, with our SMS Text With Lead capability, you can instantly begin a text conversation. Connecting with someone in those first minutes is far more effective than waiting longer.\r\n\r\nAdditionally, with text messaging, you may follow up later with new updates, content links, or simple notes to keep the conversation moving.\r\n\r\nEverything described is straightforward to implement, cost-effective, and genuinely helpful.\r\n\r\nPlease visit https://actionleadgeneration.com to learn what Web Visitors Into Leads can provide for your business.\r\n\r\nYou can be engaging with more visitors as we speak!\r\n\r\nEric\r\n\r\nP.S. Web Visitors Into Leads provides a 14-day evaluation – and it includes international calling. You have individuals who may be ready to speak with you now, so please do not delay.\r\n\r\nPlease visit https://actionleadgeneration.com to view Web Visitors Into Leads today.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://actionleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-05-31 10:29:38', '2025-05-31 10:29:38', 1),
(203, 'George', 'info@hargrave.caredogbest.com', 'George Hargrave', 'Hello there \r\n\r\nI wanted to reach out and let you know about our new dog harness. It\'s really easy to put on and take off - in just 2 seconds - and it\'s personalized for each dog. \r\nPlus, we offer a lifetime warranty so you can be sure your pet is always safe and stylish.\r\n\r\nWe\'ve had a lot of success with it so far and I think your dog would love it. \r\n\r\nGet yours today with 50% OFF: https://caredogbest.com\r\n\r\nFREE Shipping - TODAY ONLY! \r\n\r\nHave a great time, \r\n\r\nGeorge', 0, '1', 'infor@bilta.org', '2025-06-02 09:40:52', '2025-06-02 09:40:52', 0),
(204, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Turn Surf-Surf-Surf into Talk Talk Talk', 'Hello Bilta Owner,\r\n\r\nMy name’s Eric and I just ran across your website at Bilta...\r\n\r\nI found it after a quick search, so your SEO’s working out…\r\n\r\nContent looks pretty good…\r\n\r\nOne thing’s missing though…\r\n\r\nA QUICK, EASY way to connect with you NOW.\r\n\r\nBecause studies show that a web lead like me will only hang out a few seconds – 7 out of 10 disappear almost instantly, Surf Surf Surf… then gone forever.\r\n\r\nI have the solution:\r\n\r\nWeb Visitor is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. You’ll know immediately they’re interested and you can call them directly to TALK with them - literally while they’re still on the web looking at your site.\r\n\r\nhttps://resultleadgeneration.com to try out a Live Demo with Web Visitor now to see exactly how it works and even give it a try… it could be huge for your business.\r\n\r\nPlus, now that you’ve got that phone number, with our new SMS Text With Lead feature, you can automatically start a text (SMS) conversation pronto… which is so powerful, because connecting with someone within the first 5 minutes is 100 times more effective than waiting 30 minutes or more later.\r\n\r\nThe new text messaging feature lets you follow up regularly with new offers, content links, even just follow-up notes to build a relationship.\r\n\r\nEverything I’ve just described is extremely simple to implement, cost-effective, and profitable.\r\n \r\nhttps://resultleadgeneration.com to discover what Web Visitor can do for your business, potentially converting up to 100X more eyeballs into leads today!\r\n\r\nYou could be converting up to 100X more leads today!\r\n\r\nEric\r\n\r\nPS: Web Visitor offers a complimentary 14-day trial – and it even includes International Long Distance Calling. \r\nYou have customers waiting to talk with you right now… don’t keep them waiting. \r\nhttps://resultleadgeneration.com to try Web Visitor now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://resultleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-06-04 20:28:53', '2025-06-04 20:28:53', 1),
(205, 'Ivan Ramirez', 'bethany.oshaughnessy@gmail.com', 'Free ads credit of $10k/monthly Google Ads accounts for very cheap prices!', 'Hey there, I apologize for using your contact form, but I wasn\'t sure who the right person was to speak with in your company.\r\n\r\nI want to ask you if you\'re interested in buying/renting Google Ads accounts with free spending ads credit limit of 10k USD monthly budget on each account ($329 daily budget & $120k a year of free ppc ads spend limit) for a very cheap price starting at $500-$1000? \r\n\r\n\r\nWant more info: http://10k-ad-accounts.xyz\r\n\r\nNew YouTube video (social proof): http://10k-youtubevideo.xyz  \r\n\r\nIf you\'re interested or have any questions private email me at ivanr1030@gmail.com\r\n\r\n\r\n\r\nThanks & Regards,\r\nIvan R.\r\n\r\n\r\n\r\nIf you would like to opt-out of communication with us, visit:\r\nhttps://bit.ly/websiteoptout', 0, '1', 'infor@bilta.org', '2025-06-11 04:47:40', '2025-06-11 04:47:40', 1),
(206, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Who needs eyeballs, you need BUSINESS', 'Hello to the Bilta Manager,\r\n\r\nI am Eric, and I recently discovered your website Bilta in the search results.\r\n\r\nYour site is visible online and the content is solid.\r\n\r\nHowever, there’s one area that may help improve results:\r\n\r\nWhen visitors arrive at Bilta, many may look around briefly, then leave without taking further action. Research suggests most visitors exit quickly, and you never learn who they were or how to reach them.\r\n\r\nYou can change that.\r\n\r\nConsider using Web Visitors Into Leads. This tool operates on your site and is ready to securely collect each visitor’s name, email, and phone number. It informs you right away when someone shows interest, so you can connect with them while they are still on your website.\r\n\r\nView a Demonstration https://actionleadgeneration.com\r\n\r\nPrompt and meaningful outreach can make a substantial difference. Additionally, once you have a visitor’s phone number, you can begin a friendly text conversation. Even if they aren’t ready at that moment, you can keep in touch over time with relevant updates and useful information.\r\n\r\nThis approach is easy to implement and can help you engage more effectively with interested individuals.\r\n\r\nVisit the link above to see what Web Visitors Into Leads can do for your business. By reaching out promptly, you may find that more visitors become engaged prospects.\r\n\r\nEric\r\n\r\nP.S. Web Visitors Into Leads includes an evaluation period and supports international communication. Interested individuals may be ready to speak with you now, so please don’t miss the opportunity.\r\n\r\nVisit the link https://actionleadgeneration.com to learn more.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://actionleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-06-18 18:52:10', '2025-06-18 18:52:10', 1),
(207, 'Eric Jones', 'ericjonesmyemail@gmail.com', 'Turn Surf-Surf-Surf into Talk Talk Talk', 'Hi Bilta Owner!\r\n\r\nMy name’s Eric and I just ran across your website at Bilta...\r\n\r\nIt’s got a lot going for it, but here’s an idea to make it even MORE effective.\r\n\r\nhttps://blastleadgeneration.com for a live demo now.\r\n\r\nLeadConnect is a software widget that works on your site, ready to capture any visitor’s Name, Email address, and Phone Number. You’ll know immediately they’re interested and you can call them directly to TALK with them - literally while they’re still on the web looking at your site.\r\n\r\nhttps://blastleadgeneration.com to try out a Live Demo with LeadConnect now to see exactly how it works and even give it a try… it could be huge for your business.\r\n\r\nPlus, now that you’ve got that phone number, with our new SMS Text With Lead feature, you can automatically start a text (SMS) conversation pronto… which is so powerful, because connecting with someone within the first 5 minutes is 100 times more effective than waiting 30 minutes or more later.\r\n\r\nThe new text messaging feature lets you follow up regularly with new offers, content links, even just “how you doing?” notes to build a relationship.\r\n\r\nEverything I’ve just described is extremely simple to implement, cost-effective, and profitable.\r\n\r\nhttps://blastleadgeneration.com to discover what LeadConnect can do for your business, potentially converting up to 100X more eyeballs into leads today!\r\n\r\nEric\r\n\r\nPS: LeadConnect offers a complimentary 14-day trial – and it even includes International Long Distance Calling.  \r\nYou have customers waiting to talk with you right now… don’t keep them waiting.  \r\nhttps://blastleadgeneration.com to try LeadConnect now.\r\n\r\nIf you\'d like to Want to receive fewer emails, or none whatsoever? Update your email preferences by visiting https://blastleadgeneration.com/unsubscribe.aspx?d=bilta.org', 0, '1', 'infor@bilta.org', '2025-06-19 07:03:55', '2025-06-19 07:03:55', 1);
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_by`, `status_id`, `recipient`, `created_at`, `updated_at`, `spam`) VALUES
(208, 'Hanson Mollie', 'molliehanson.vgo@gmail.com', 'YouTube Promotion: Grow your subscribers by 700 each month', 'Hi. We run a YouTube growth service, which increases your number of subscribers both safety and practically.\r\n\r\n- We guarantee to gain you new 700+ subscribers per month\r\n- People subscribe because they are interested in your videos/channel, increasing video likes, comments and interaction.\r\n- All actions are made manually by our team. We do not use any bots.\r\n\r\nThe price is just $60 (USD) per month, and we can start immediately. If you are interested and would like to see some of our previous work, let me know and we can discuss further.\r\n\r\nKind Regards,\r\n\r\nTo Unsubscribe, reply with the word unsubscribe in the subject.', 0, '1', 'infor@bilta.org', '2025-07-03 16:11:20', '2025-07-03 16:11:20', 0),
(209, 'Kory Merewether', 'merewether.kory47@outlook.com', 'Enftl joqj', 'Getting property doesn’t come with a manual, but this video is a helpful place to start. I’m showing you six crucial steps to help with paperwork, family, and next steps. https://tinyurl.com/mu8ndf3v', 0, '1', 'infor@bilta.org', '2025-07-16 04:36:24', '2025-07-16 04:36:24', 1),
(210, 'Starseed Council', 'starseed@zonelogidentity.net', 'Trying to get in touch', 'Was instructed this the best way to get into contact with Lawerence on behalf of the starseed council. You were sent down to Earth for the human experience but there was an anomaly in the system that can\'t be corrected. We can\'t get the exact date and only that it will happen in 2025. The wars/conflict with India and Pakistan, Ukraine and Russia, Iran and Israel are going to lead to a nuclear war which will be an extinction level event destroying the majority of the population on Earth. In the past this was corrected but too many happening at one time happening at one time is making it impossible to correct. This is disrupting the whole experience and are calling back starseeds to their home planets and dimensions. In certain situations like this, we can pull you out at the last moment or be able to leave anytime you want now being aware after the veil of forgetfulness. Based on the level of the event you can be pulled out prior. Memory purges and alterations can be initiated for the next experience on another planet/dimension or could just choose to go back to the originating dimension or planet that you are originally from. s9d8f7a896ew', 0, '1', 'infor@bilta.org', '2025-08-05 04:09:59', '2025-08-05 04:09:59', 0),
(211, 'Joanna Riggs', 'joannariggs83@gmail.com', 'Video Promotion for your website', 'Hi,\r\n\r\nI just visited bilta.org and wondered if you\'ve ever considered an impactful video to advertise your business? Our videos can generate impressive results on both your website and across social media.\r\n\r\nOur videos cost just $195 for a 30 second video ($239 for 60 seconds) and include a full script, voice-over and video.\r\n\r\nI can show you some previous videos we\'ve done if you want me to send some over. Let me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna', 0, '1', 'infor@bilta.org', '2025-08-06 11:31:03', '2025-08-06 11:31:03', 0),
(212, 'Ellie Watson', 'elliewatson814@gmail.com', 'Boost bilta.org\'s Backlink Profile - DA 64 Site', 'Hi,\r\n\r\nI hope this email finds you well.\r\n\r\nI\'m reaching out as I\'ve been impressed with the content on bilta.org. We\'re offering a unique opportunity to enhance your online presence with a high-quality backlink from our website. We boast strong domain metrics with a Domain Authority (DA) of 64 (Moz) and a Domain Rating (DR) of 30 (Ahrefs).\r\n\r\nWe offer flexible options, including guest posting, content creation, and strategic link insertions, all designed to significantly boost your SEO and drive targeted traffic.\r\n\r\nIf you\'re interested in boosting your site\'s SEO, please let us know. If this isn\'t a good fit for you, no problem, just delete this email.\r\n\r\nLooking forward to the possibility of collaborating.\r\n\r\nKind Regards\r\nEllie', 0, '1', 'infor@bilta.org', '2025-08-15 04:47:24', '2025-08-15 04:47:24', 1),
(213, 'Lauren Murphy', 'laurenseo434@gmail.com', 'SEO Services for bilta.org', 'Hi,\r\n\r\nI\'ve just been on bilta.org and wanted to reach out as we help businesses like yours significantly enhance their online visibility.\r\n\r\nWe offer comprehensive SEO solutions, including keyword research, our Ultimate Optimization Package, Google Map Citations, high-authority backlink building, and on-demand Ahrefs Reports.\r\n\r\nOur process focuses on delivering measurable results through strategic analysis and continuous improvement.\r\n\r\nIf this is of interest and/or have any questions, just get in touch and we can discuss further.\r\n\r\nKind Regards,\r\nLauren', 0, '1', 'infor@bilta.org', '2025-08-15 05:29:51', '2025-08-15 05:29:51', 0),
(214, 'Karen B.', 'outreachseo56@gmail.com', 'Quick Link Partnership?', 'Hi,\r\n\r\nI wanted to see if you\'d be interested in a link exchange for mutual SEO benefits. I can link to your site (bilta.org) from a few of our high-authority websites. In return, you would link back to our clients’ sites, which cover niches like health, business services, real estate, consumer electronics, and more.\r\n\r\nIf you\'re interested, let me know — I\'d be happy to share more details!\r\n\r\nThanks for your time,\r\nKaren\r\nSEO Account Manager', 0, '1', 'infor@bilta.org', '2025-08-26 08:34:17', '2025-08-26 08:34:17', 0),
(215, 'yiCJxmhYdogPYbvOEeKM', 'obemuho627@gmail.com', 'kwIBxmsLAskawWhJwT', 'rWOrwCpCQgNTeRNOlHnY', 0, '1', 'infor@bilta.org', '2026-01-01 15:25:35', '2026-01-01 15:25:35', 0),
(216, 'Emma B.', 'emma.digitalhub56@gmail.com', 'Quick Link Exchange For SEO Boost with bilta.org', 'Hi,\r\n\r\nI’d like to propose a straightforward link exchange.\r\n\r\nI can link to bilta.org from 5 legitimate local business websites (DR30+), at no cost. In return, you’d link to 5 different of my client sites from your end — purely for mutual SEO value.\r\n\r\nLet me know if you’re interested, and I’ll send over the site list.\r\n\r\nRegards,\r\nEmma', 0, '1', 'infor@bilta.org', '2026-02-01 16:31:33', '2026-02-01 16:31:33', 0),
(217, 'OfFHUSgJrNYnMgKgXbeznE', 'q.i.zur.u.vif.151@gmail.com', 'bIymLUDhDHFVrajMeUDX', 'nbAgbNXcbjXywuZnNCgHq', 0, '1', 'infor@bilta.org', '2026-03-25 17:15:31', '2026-03-25 17:15:31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `message` varchar(250) NOT NULL,
  `google_maps` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `facebook_url` varchar(191) DEFAULT NULL,
  `linkedin_url` varchar(191) DEFAULT NULL,
  `twitter_url` varchar(191) DEFAULT NULL,
  `youtube` varchar(191) DEFAULT NULL,
  `whatsapp_link` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `phone`, `email`, `address`, `message`, `google_maps`, `created_by`, `facebook_url`, `linkedin_url`, `twitter_url`, `youtube`, `whatsapp_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '(+26) 0977-539-067', 'infor@bilta.org', 'Plot 324. Flat No 2 Bauhinia avenue - off Great-EastRroad - Chelston. Lusaka, Zambia', 'You are most welcome to our official website. if you have any question or would like to be part of us please feel free to contact us.', 'https://www.google.com/maps/dir/-15.3775832,28.3786351//@-15.3717874,28.3589894,13z/data=!4m5!4m4!1m1!4e1!1m0!3e0?entry=ttu', 1, 'https://www.facebook.com/biltazambia', 'Ullam aspernatur aut', 'Voluptatem esse do v', 'https://www.youtube.com/@SengaBible', '+260 962687990', '2023-05-22 23:17:55', '2024-12-10 23:56:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cookie_consents`
--

CREATE TABLE `cookie_consents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `analytics` tinyint(1) NOT NULL DEFAULT 0,
  `marketing` tinyint(1) NOT NULL DEFAULT 0,
  `consent_given_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookie_consents`
--

INSERT INTO `cookie_consents` (`id`, `ip_address`, `analytics`, `marketing`, `consent_given_at`, `created_at`, `updated_at`) VALUES
(1, '197.212.72.231', 1, 1, '2025-05-31 00:13:55', '2025-05-31 00:13:55', '2025-05-31 00:13:55'),
(2, '41.223.117.41', 1, 1, '2025-05-31 09:24:29', '2025-05-31 09:24:29', '2025-05-31 09:24:29'),
(3, '41.223.117.41', 1, 1, '2025-05-31 09:25:00', '2025-05-31 09:25:00', '2025-05-31 09:25:00'),
(4, '102.212.181.117', 1, 1, '2025-06-27 19:38:50', '2025-06-27 19:38:50', '2025-06-27 19:38:50'),
(5, '45.215.255.183', 1, 1, '2025-06-27 22:29:23', '2025-06-27 22:29:23', '2025-06-27 22:29:23'),
(6, '45.215.254.30', 0, 0, '2025-06-28 14:42:07', '2025-06-28 14:42:07', '2025-06-28 14:42:07'),
(7, '45.215.255.163', 1, 1, '2025-06-29 19:10:58', '2025-06-29 19:10:58', '2025-06-29 19:10:58'),
(8, '157.125.185.226', 1, 1, '2025-06-30 21:54:04', '2025-06-30 21:54:04', '2025-06-30 21:54:04'),
(9, '41.223.116.245', 1, 1, '2025-07-01 19:31:29', '2025-07-01 19:31:29', '2025-07-01 19:31:29'),
(10, '47.14.68.13', 0, 0, '2025-07-02 20:09:55', '2025-07-02 20:09:55', '2025-07-02 20:09:55'),
(11, '45.215.253.84', 1, 1, '2025-07-03 14:40:08', '2025-07-03 14:40:08', '2025-07-03 14:40:08'),
(12, '102.151.252.128', 1, 1, '2025-07-03 17:12:47', '2025-07-03 17:12:47', '2025-07-03 17:12:47'),
(13, '102.151.252.128', 1, 1, '2025-07-03 17:17:16', '2025-07-03 17:17:16', '2025-07-03 17:17:16'),
(14, '102.151.252.128', 1, 1, '2025-07-03 17:17:35', '2025-07-03 17:17:35', '2025-07-03 17:17:35'),
(15, '102.208.96.206', 1, 1, '2025-07-03 19:12:40', '2025-07-03 19:12:40', '2025-07-03 19:12:40'),
(16, '102.208.96.206', 1, 1, '2025-07-03 19:12:49', '2025-07-03 19:12:49', '2025-07-03 19:12:49'),
(17, '41.223.116.253', 1, 1, '2025-07-03 22:00:22', '2025-07-03 22:00:22', '2025-07-03 22:00:22'),
(18, '41.223.116.253', 1, 1, '2025-07-03 22:01:13', '2025-07-03 22:01:13', '2025-07-03 22:01:13'),
(19, '86.2.214.220', 1, 1, '2025-07-04 00:43:49', '2025-07-04 00:43:49', '2025-07-04 00:43:49'),
(20, '94.8.229.24', 1, 1, '2025-07-08 14:30:34', '2025-07-08 14:30:34', '2025-07-08 14:30:34'),
(21, '166.62.167.148', 1, 1, '2025-07-10 01:50:38', '2025-07-10 01:50:38', '2025-07-10 01:50:38'),
(22, '24.92.105.254', 0, 0, '2025-07-11 04:17:57', '2025-07-11 04:17:57', '2025-07-11 04:17:57'),
(23, '102.67.160.2', 1, 1, '2025-07-11 16:55:05', '2025-07-11 16:55:05', '2025-07-11 16:55:05'),
(24, '102.67.160.2', 1, 1, '2025-07-11 17:40:30', '2025-07-11 17:40:30', '2025-07-11 17:40:30'),
(25, '45.215.255.106', 1, 1, '2025-07-11 19:19:49', '2025-07-11 19:19:49', '2025-07-11 19:19:49'),
(26, '41.223.141.87', 1, 1, '2025-07-14 07:41:05', '2025-07-14 07:41:05', '2025-07-14 07:41:05'),
(27, '102.151.18.165', 1, 1, '2025-07-14 17:57:21', '2025-07-14 17:57:21', '2025-07-14 17:57:21'),
(28, '41.139.206.27', 1, 1, '2025-07-14 18:29:15', '2025-07-14 18:29:15', '2025-07-14 18:29:15'),
(29, '102.89.69.211', 1, 1, '2025-07-16 06:52:40', '2025-07-16 06:52:40', '2025-07-16 06:52:40'),
(30, '174.161.16.220', 1, 1, '2025-07-23 22:14:59', '2025-07-23 22:14:59', '2025-07-23 22:14:59'),
(31, '216.234.213.43', 1, 1, '2025-07-24 21:53:18', '2025-07-24 21:53:18', '2025-07-24 21:53:18'),
(32, '41.223.117.78', 1, 1, '2025-07-28 17:56:02', '2025-07-28 17:56:02', '2025-07-28 17:56:02'),
(33, '172.125.101.219', 0, 0, '2025-07-30 03:11:48', '2025-07-30 03:11:48', '2025-07-30 03:11:48'),
(34, '130.45.104.13', 0, 0, '2025-07-30 23:36:01', '2025-07-30 23:36:01', '2025-07-30 23:36:01'),
(35, '78.84.243.19', 1, 1, '2025-08-01 20:06:54', '2025-08-01 20:06:54', '2025-08-01 20:06:54'),
(36, '41.216.82.22', 1, 1, '2025-08-03 14:08:33', '2025-08-03 14:08:33', '2025-08-03 14:08:33'),
(37, '41.216.82.22', 1, 1, '2025-08-03 14:09:31', '2025-08-03 14:09:31', '2025-08-03 14:09:31'),
(38, '41.216.82.22', 1, 1, '2025-08-03 14:09:38', '2025-08-03 14:09:38', '2025-08-03 14:09:38'),
(39, '86.29.209.149', 1, 1, '2025-08-04 21:25:58', '2025-08-04 21:25:58', '2025-08-04 21:25:58'),
(40, '71.68.123.112', 1, 1, '2025-08-06 22:46:01', '2025-08-06 22:46:01', '2025-08-06 22:46:01'),
(41, '206.75.203.125', 1, 1, '2025-08-07 07:47:39', '2025-08-07 07:47:39', '2025-08-07 07:47:39'),
(42, '45.213.207.81', 1, 1, '2025-08-07 19:49:14', '2025-08-07 19:49:14', '2025-08-07 19:49:14'),
(43, '172.56.25.154', 1, 1, '2025-08-08 14:19:37', '2025-08-08 14:19:37', '2025-08-08 14:19:37'),
(44, '41.223.116.244', 1, 1, '2025-08-09 07:01:32', '2025-08-09 07:01:32', '2025-08-09 07:01:32'),
(45, '165.57.81.83', 1, 1, '2025-08-09 12:02:25', '2025-08-09 12:02:25', '2025-08-09 12:02:25'),
(46, '172.0.10.227', 1, 1, '2025-08-13 01:42:11', '2025-08-13 01:42:11', '2025-08-13 01:42:11'),
(47, '98.97.79.119', 1, 1, '2025-08-13 21:51:18', '2025-08-13 21:51:18', '2025-08-13 21:51:18'),
(48, '45.215.254.68', 1, 1, '2025-08-16 01:56:52', '2025-08-16 01:56:52', '2025-08-16 01:56:52'),
(49, '41.216.86.36', 1, 1, '2025-08-16 02:33:16', '2025-08-16 02:33:16', '2025-08-16 02:33:16'),
(50, '45.215.254.57', 1, 1, '2025-08-16 03:43:14', '2025-08-16 03:43:14', '2025-08-16 03:43:14'),
(51, '41.251.136.133', 1, 1, '2025-08-19 02:23:38', '2025-08-19 02:23:38', '2025-08-19 02:23:38'),
(52, '185.190.38.241', 0, 0, '2025-08-19 02:26:41', '2025-08-19 02:26:41', '2025-08-19 02:26:41'),
(53, '165.58.129.30', 1, 1, '2025-08-19 13:01:22', '2025-08-19 13:01:22', '2025-08-19 13:01:22'),
(54, '154.118.174.18', 1, 1, '2025-09-01 22:33:33', '2025-09-01 22:33:33', '2025-09-01 22:33:33'),
(55, '102.67.160.2', 1, 1, '2025-09-02 17:39:45', '2025-09-02 17:39:45', '2025-09-02 17:39:45'),
(56, '102.67.160.2', 1, 1, '2025-09-02 17:44:43', '2025-09-02 17:44:43', '2025-09-02 17:44:43'),
(57, '82.145.212.201', 0, 0, '2025-09-02 21:35:59', '2025-09-02 21:35:59', '2025-09-02 21:35:59'),
(58, '71.123.62.36', 0, 0, '2025-09-03 01:01:58', '2025-09-03 01:01:58', '2025-09-03 01:01:58'),
(59, '76.126.48.220', 1, 1, '2025-09-04 08:32:50', '2025-09-04 08:32:50', '2025-09-04 08:32:50'),
(60, '140.82.163.2', 0, 0, '2025-09-05 21:48:43', '2025-09-05 21:48:43', '2025-09-05 21:48:43'),
(61, '129.222.109.42', 1, 1, '2025-09-07 13:19:01', '2025-09-07 13:19:01', '2025-09-07 13:19:01'),
(62, '129.222.109.211', 0, 0, '2025-09-08 14:28:24', '2025-09-08 14:28:24', '2025-09-08 14:28:24'),
(63, '209.215.206.202', 1, 1, '2025-09-09 23:56:54', '2025-09-09 23:56:54', '2025-09-09 23:56:54'),
(64, '45.215.251.142', 1, 1, '2025-09-10 18:13:13', '2025-09-10 18:13:13', '2025-09-10 18:13:13'),
(65, '41.90.211.183', 1, 1, '2025-09-10 20:56:04', '2025-09-10 20:56:04', '2025-09-10 20:56:04'),
(66, '71.123.62.36', 0, 0, '2025-09-11 02:09:47', '2025-09-11 02:09:47', '2025-09-11 02:09:47'),
(67, '46.152.156.114', 1, 1, '2025-09-12 15:06:15', '2025-09-12 15:06:15', '2025-09-12 15:06:15'),
(68, '131.226.97.161', 1, 1, '2025-09-14 23:08:02', '2025-09-14 23:08:02', '2025-09-14 23:08:02'),
(69, '140.82.163.2', 1, 1, '2025-09-17 23:45:25', '2025-09-17 23:45:25', '2025-09-17 23:45:25'),
(70, '74.125.150.33', 1, 1, '2025-09-20 22:54:01', '2025-09-20 22:54:01', '2025-09-20 22:54:01'),
(71, '197.155.136.118', 1, 1, '2025-09-24 14:38:04', '2025-09-24 14:38:04', '2025-09-24 14:38:04'),
(72, '45.215.252.213', 1, 1, '2025-09-25 01:26:15', '2025-09-25 01:26:15', '2025-09-25 01:26:15'),
(73, '146.75.164.252', 1, 1, '2025-09-25 12:59:41', '2025-09-25 12:59:41', '2025-09-25 12:59:41'),
(74, '180.190.102.157', 0, 0, '2025-09-26 18:42:12', '2025-09-26 18:42:12', '2025-09-26 18:42:12'),
(75, '159.112.216.21', 1, 1, '2025-09-27 00:13:28', '2025-09-27 00:13:28', '2025-09-27 00:13:28'),
(76, '45.215.251.26', 1, 1, '2025-10-03 14:48:42', '2025-10-03 14:48:42', '2025-10-03 14:48:42'),
(77, '216.234.213.160', 1, 1, '2025-10-03 16:23:43', '2025-10-03 16:23:43', '2025-10-03 16:23:43'),
(78, '184.174.166.243', 0, 0, '2025-10-04 00:16:52', '2025-10-04 00:16:52', '2025-10-04 00:16:52'),
(79, '104.28.50.134', 0, 0, '2025-10-06 11:25:52', '2025-10-06 11:25:52', '2025-10-06 11:25:52'),
(80, '104.28.50.130', 0, 0, '2025-10-06 11:28:42', '2025-10-06 11:28:42', '2025-10-06 11:28:42'),
(81, '102.67.160.2', 1, 1, '2025-10-06 18:56:50', '2025-10-06 18:56:50', '2025-10-06 18:56:50'),
(82, '123.253.125.10', 1, 1, '2025-10-07 22:17:58', '2025-10-07 22:17:58', '2025-10-07 22:17:58'),
(83, '104.55.172.232', 1, 1, '2025-10-10 20:44:52', '2025-10-10 20:44:52', '2025-10-10 20:44:52'),
(84, '165.58.129.147', 1, 1, '2025-10-14 01:12:47', '2025-10-14 01:12:47', '2025-10-14 01:12:47'),
(85, '196.61.111.216', 1, 1, '2025-10-15 01:39:34', '2025-10-15 01:39:34', '2025-10-15 01:39:34'),
(86, '102.69.161.2', 1, 1, '2025-10-15 10:48:27', '2025-10-15 10:48:27', '2025-10-15 10:48:27'),
(87, '41.138.96.221', 1, 1, '2025-10-15 22:07:14', '2025-10-15 22:07:14', '2025-10-15 22:07:14'),
(88, '119.93.143.204', 1, 1, '2025-10-16 11:35:57', '2025-10-16 11:35:57', '2025-10-16 11:35:57'),
(89, '49.150.62.247', 1, 1, '2025-10-19 08:40:45', '2025-10-19 08:40:45', '2025-10-19 08:40:45'),
(90, '75.138.102.19', 1, 1, '2025-10-21 07:29:48', '2025-10-21 07:29:48', '2025-10-21 07:29:48'),
(91, '24.182.67.187', 0, 0, '2025-10-21 23:26:19', '2025-10-21 23:26:19', '2025-10-21 23:26:19'),
(92, '68.205.132.229', 0, 0, '2025-10-23 00:50:48', '2025-10-23 00:50:48', '2025-10-23 00:50:48'),
(93, '41.216.87.1', 1, 1, '2025-10-25 00:02:57', '2025-10-25 00:02:57', '2025-10-25 00:02:57'),
(94, '74.125.216.228', 1, 1, '2025-10-27 08:56:35', '2025-10-27 08:56:35', '2025-10-27 08:56:35'),
(95, '82.16.133.138', 0, 0, '2025-10-29 00:16:08', '2025-10-29 00:16:08', '2025-10-29 00:16:08'),
(96, '216.234.213.254', 1, 1, '2025-10-29 13:37:35', '2025-10-29 13:37:35', '2025-10-29 13:37:35'),
(97, '104.28.82.111', 1, 1, '2025-10-29 14:19:12', '2025-10-29 14:19:12', '2025-10-29 14:19:12'),
(98, '193.49.17.2', 1, 1, '2025-10-30 23:34:29', '2025-10-30 23:34:29', '2025-10-30 23:34:29'),
(99, '104.187.44.192', 1, 1, '2025-10-31 23:07:14', '2025-10-31 23:07:14', '2025-10-31 23:07:14'),
(100, '45.215.255.117', 1, 1, '2025-11-02 16:44:37', '2025-11-02 16:44:37', '2025-11-02 16:44:37'),
(101, '216.234.213.78', 1, 1, '2025-11-03 16:36:11', '2025-11-03 16:36:11', '2025-11-03 16:36:11'),
(102, '216.234.213.180', 1, 1, '2025-11-06 02:56:25', '2025-11-06 02:56:25', '2025-11-06 02:56:25'),
(103, '143.105.49.193', 0, 0, '2025-11-07 20:07:21', '2025-11-07 20:07:21', '2025-11-07 20:07:21'),
(104, '146.255.182.50', 1, 1, '2025-11-08 22:56:42', '2025-11-08 22:56:42', '2025-11-08 22:56:42'),
(105, '104.28.55.54', 1, 1, '2025-11-09 22:16:33', '2025-11-09 22:16:33', '2025-11-09 22:16:33'),
(106, '102.148.11.33', 1, 1, '2025-11-10 17:28:46', '2025-11-10 17:28:46', '2025-11-10 17:28:46'),
(107, '189.40.73.203', 1, 1, '2025-11-11 22:53:06', '2025-11-11 22:53:06', '2025-11-11 22:53:06'),
(108, '108.70.34.109', 1, 1, '2025-11-12 03:59:50', '2025-11-12 03:59:50', '2025-11-12 03:59:50'),
(109, '82.3.244.4', 1, 1, '2025-11-14 18:44:35', '2025-11-14 18:44:35', '2025-11-14 18:44:35'),
(110, '45.212.90.176', 1, 1, '2025-11-16 15:44:22', '2025-11-16 15:44:22', '2025-11-16 15:44:22'),
(111, '107.202.38.214', 0, 0, '2025-11-17 22:26:58', '2025-11-17 22:26:58', '2025-11-17 22:26:58'),
(112, '31.13.127.29', 1, 1, '2025-11-18 19:17:26', '2025-11-18 19:17:26', '2025-11-18 19:17:26'),
(113, '31.13.127.3', 1, 1, '2025-11-18 19:17:27', '2025-11-18 19:17:27', '2025-11-18 19:17:27'),
(114, '31.13.115.113', 1, 1, '2025-11-18 19:25:02', '2025-11-18 19:25:02', '2025-11-18 19:25:02'),
(115, '186.122.9.123', 1, 1, '2025-11-18 22:10:41', '2025-11-18 22:10:41', '2025-11-18 22:10:41'),
(116, '216.234.213.0', 1, 1, '2025-11-19 15:15:26', '2025-11-19 15:15:26', '2025-11-19 15:15:26'),
(117, '72.216.172.151', 1, 1, '2025-11-20 04:09:00', '2025-11-20 04:09:00', '2025-11-20 04:09:00'),
(118, '216.100.61.21', 0, 0, '2025-11-20 23:01:32', '2025-11-20 23:01:32', '2025-11-20 23:01:32'),
(119, '174.22.201.143', 1, 1, '2025-11-21 00:46:12', '2025-11-21 00:46:12', '2025-11-21 00:46:12'),
(120, '102.89.69.166', 0, 0, '2025-11-23 23:08:53', '2025-11-23 23:08:53', '2025-11-23 23:08:53'),
(121, '76.36.48.66', 1, 1, '2025-11-24 21:23:57', '2025-11-24 21:23:57', '2025-11-24 21:23:57'),
(122, '167.98.234.67', 1, 1, '2025-11-25 20:42:54', '2025-11-25 20:42:54', '2025-11-25 20:42:54'),
(123, '68.52.51.104', 0, 0, '2025-12-01 05:45:34', '2025-12-01 05:45:34', '2025-12-01 05:45:34'),
(124, '216.234.213.234', 1, 1, '2025-12-03 00:00:41', '2025-12-03 00:00:41', '2025-12-03 00:00:41'),
(125, '161.142.236.69', 0, 0, '2025-12-06 14:28:13', '2025-12-06 14:28:13', '2025-12-06 14:28:13'),
(126, '165.58.129.55', 1, 1, '2025-12-07 21:27:33', '2025-12-07 21:27:33', '2025-12-07 21:27:33'),
(127, '95.70.145.233', 1, 1, '2025-12-08 21:03:12', '2025-12-08 21:03:12', '2025-12-08 21:03:12'),
(128, '216.234.213.105', 1, 1, '2025-12-12 21:07:02', '2025-12-12 21:07:02', '2025-12-12 21:07:02'),
(129, '74.125.218.2', 1, 1, '2025-12-14 21:57:40', '2025-12-14 21:57:40', '2025-12-14 21:57:40'),
(130, '66.220.149.6', 1, 1, '2025-12-16 19:20:13', '2025-12-16 19:20:13', '2025-12-16 19:20:13'),
(131, '31.13.115.35', 1, 1, '2025-12-16 19:20:14', '2025-12-16 19:20:14', '2025-12-16 19:20:14'),
(132, '216.110.250.217', 1, 1, '2025-12-17 00:09:10', '2025-12-17 00:09:10', '2025-12-17 00:09:10'),
(133, '45.215.253.99', 1, 1, '2025-12-18 04:44:56', '2025-12-18 04:44:56', '2025-12-18 04:44:56'),
(134, '84.247.41.177', 1, 1, '2025-12-22 01:49:21', '2025-12-22 01:49:21', '2025-12-22 01:49:21'),
(135, '197.213.60.120', 1, 1, '2025-12-23 12:35:50', '2025-12-23 12:35:50', '2025-12-23 12:35:50'),
(136, '131.226.98.98', 1, 1, '2026-01-02 06:34:06', '2026-01-02 06:34:06', '2026-01-02 06:34:06'),
(137, '165.58.129.206', 1, 1, '2026-01-08 13:26:22', '2026-01-08 13:26:22', '2026-01-08 13:26:22'),
(138, '223.25.254.12', 0, 0, '2026-01-11 21:46:53', '2026-01-11 21:46:53', '2026-01-11 21:46:53'),
(139, '76.24.119.119', 0, 0, '2026-01-13 23:03:06', '2026-01-13 23:03:06', '2026-01-13 23:03:06'),
(140, '180.190.5.2', 0, 0, '2026-01-17 08:56:49', '2026-01-17 08:56:49', '2026-01-17 08:56:49'),
(141, '106.213.82.32', 1, 1, '2026-01-21 10:45:06', '2026-01-21 10:45:06', '2026-01-21 10:45:06'),
(142, '185.195.59.91', 1, 1, '2026-01-22 19:58:02', '2026-01-22 19:58:02', '2026-01-22 19:58:02'),
(143, '84.68.6.152', 1, 1, '2026-01-22 22:17:15', '2026-01-22 22:17:15', '2026-01-22 22:17:15'),
(144, '174.82.108.71', 1, 1, '2026-01-23 02:04:36', '2026-01-23 02:04:36', '2026-01-23 02:04:36'),
(145, '216.234.213.163', 1, 1, '2026-01-23 21:25:27', '2026-01-23 21:25:27', '2026-01-23 21:25:27'),
(146, '216.234.213.163', 1, 1, '2026-01-23 21:26:46', '2026-01-23 21:26:46', '2026-01-23 21:26:46'),
(147, '41.223.116.245', 1, 1, '2026-01-27 18:10:18', '2026-01-27 18:10:18', '2026-01-27 18:10:18'),
(148, '66.249.77.201', 1, 1, '2026-01-28 02:56:12', '2026-01-28 02:56:12', '2026-01-28 02:56:12'),
(149, '41.77.72.10', 1, 1, '2026-01-28 18:30:46', '2026-01-28 18:30:46', '2026-01-28 18:30:46'),
(150, '185.203.122.50', 0, 0, '2026-02-01 19:54:49', '2026-02-01 19:54:49', '2026-02-01 19:54:49'),
(151, '110.225.48.60', 1, 1, '2026-02-01 20:39:43', '2026-02-01 20:39:43', '2026-02-01 20:39:43'),
(152, '173.252.70.28', 1, 1, '2026-02-02 17:37:18', '2026-02-02 17:37:18', '2026-02-02 17:37:18'),
(153, '173.252.87.63', 1, 1, '2026-02-02 18:23:46', '2026-02-02 18:23:46', '2026-02-02 18:23:46'),
(154, '98.24.39.107', 1, 1, '2026-02-03 21:18:05', '2026-02-03 21:18:05', '2026-02-03 21:18:05'),
(155, '216.234.213.44', 1, 1, '2026-02-04 16:02:46', '2026-02-04 16:02:46', '2026-02-04 16:02:46'),
(156, '216.234.213.91', 1, 1, '2026-02-05 15:26:36', '2026-02-05 15:26:36', '2026-02-05 15:26:36'),
(157, '86.132.61.96', 1, 1, '2026-02-05 19:42:46', '2026-02-05 19:42:46', '2026-02-05 19:42:46'),
(158, '109.184.87.46', 1, 1, '2026-02-08 05:47:55', '2026-02-08 05:47:55', '2026-02-08 05:47:55'),
(159, '216.234.213.218', 1, 1, '2026-02-12 17:42:34', '2026-02-12 17:42:34', '2026-02-12 17:42:34'),
(160, '81.178.205.215', 1, 1, '2026-02-12 23:16:08', '2026-02-12 23:16:08', '2026-02-12 23:16:08'),
(161, '216.234.213.75', 1, 1, '2026-02-17 16:36:03', '2026-02-17 16:36:03', '2026-02-17 16:36:03'),
(162, '216.234.213.91', 1, 1, '2026-02-18 18:00:17', '2026-02-18 18:00:17', '2026-02-18 18:00:17'),
(163, '41.223.117.71', 1, 1, '2026-02-18 22:46:47', '2026-02-18 22:46:47', '2026-02-18 22:46:47'),
(164, '31.13.115.5', 1, 1, '2026-02-19 16:05:46', '2026-02-19 16:05:46', '2026-02-19 16:05:46'),
(165, '31.13.127.2', 1, 1, '2026-02-19 16:08:09', '2026-02-19 16:08:09', '2026-02-19 16:08:09'),
(166, '45.213.51.48', 1, 1, '2026-02-19 22:51:03', '2026-02-19 22:51:03', '2026-02-19 22:51:03'),
(167, '176.3.160.63', 1, 1, '2026-02-24 06:57:47', '2026-02-24 06:57:47', '2026-02-24 06:57:47'),
(168, '31.13.127.42', 1, 1, '2026-02-24 18:12:48', '2026-02-24 18:12:48', '2026-02-24 18:12:48'),
(169, '173.252.95.116', 1, 1, '2026-02-24 18:12:54', '2026-02-24 18:12:54', '2026-02-24 18:12:54'),
(170, '173.252.127.63', 1, 1, '2026-02-24 18:12:55', '2026-02-24 18:12:55', '2026-02-24 18:12:55'),
(171, '173.252.127.33', 1, 1, '2026-02-24 18:12:55', '2026-02-24 18:12:55', '2026-02-24 18:12:55'),
(172, '173.252.95.41', 1, 1, '2026-02-24 18:14:57', '2026-02-24 18:14:57', '2026-02-24 18:14:57'),
(173, '107.202.38.214', 0, 0, '2026-02-25 21:23:32', '2026-02-25 21:23:32', '2026-02-25 21:23:32'),
(174, '173.252.82.21', 1, 1, '2026-03-02 17:03:41', '2026-03-02 17:03:41', '2026-03-02 17:03:41'),
(175, '31.13.127.66', 1, 1, '2026-03-02 17:03:42', '2026-03-02 17:03:42', '2026-03-02 17:03:42'),
(176, '177.8.167.31', 1, 1, '2026-03-02 20:52:15', '2026-03-02 20:52:15', '2026-03-02 20:52:15'),
(177, '41.223.118.34', 1, 1, '2026-03-03 21:02:45', '2026-03-03 21:02:45', '2026-03-03 21:02:45'),
(178, '216.234.213.58', 0, 0, '2026-03-04 13:30:17', '2026-03-04 13:30:17', '2026-03-04 13:30:17'),
(179, '140.82.163.2', 1, 1, '2026-03-07 01:27:41', '2026-03-07 01:27:41', '2026-03-07 01:27:41'),
(180, '196.250.116.19', 1, 1, '2026-03-10 17:13:19', '2026-03-10 17:13:19', '2026-03-10 17:13:19'),
(181, '102.67.160.2', 1, 1, '2026-03-10 21:16:53', '2026-03-10 21:16:53', '2026-03-10 21:16:53'),
(182, '216.234.213.118', 1, 1, '2026-03-11 00:45:17', '2026-03-11 00:45:17', '2026-03-11 00:45:17'),
(183, '122.172.83.142', 1, 1, '2026-03-11 11:17:02', '2026-03-11 11:17:02', '2026-03-11 11:17:02'),
(184, '196.190.60.141', 0, 0, '2026-03-18 12:59:15', '2026-03-18 12:59:15', '2026-03-18 12:59:15'),
(185, '102.208.220.200', 0, 0, '2026-03-19 20:25:34', '2026-03-19 20:25:34', '2026-03-19 20:25:34'),
(186, '216.234.213.124', 1, 1, '2026-03-19 21:34:23', '2026-03-19 21:34:23', '2026-03-19 21:34:23'),
(187, '18.130.58.25', 0, 0, '2026-03-23 18:47:55', '2026-03-23 18:47:55', '2026-03-23 18:47:55'),
(188, '102.89.82.9', 1, 1, '2026-03-24 20:46:10', '2026-03-24 20:46:10', '2026-03-24 20:46:10'),
(189, '129.222.147.210', 1, 1, '2026-03-25 15:32:48', '2026-03-25 15:32:48', '2026-03-25 15:32:48'),
(190, '174.82.108.71', 1, 1, '2026-03-26 05:56:53', '2026-03-26 05:56:53', '2026-03-26 05:56:53'),
(191, '34.67.148.14', 0, 0, '2026-03-27 23:40:19', '2026-03-27 23:40:19', '2026-03-27 23:40:19'),
(192, '34.67.148.14', 0, 0, '2026-03-27 23:40:19', '2026-03-27 23:40:19', '2026-03-27 23:40:19'),
(193, '35.222.120.38', 0, 0, '2026-03-29 06:37:56', '2026-03-29 06:37:56', '2026-03-29 06:37:56'),
(194, '35.222.120.38', 0, 0, '2026-03-29 06:37:56', '2026-03-29 06:37:56', '2026-03-29 06:37:56'),
(195, '41.223.116.246', 1, 1, '2026-03-29 21:31:40', '2026-03-29 21:31:40', '2026-03-29 21:31:40'),
(196, '31.13.115.24', 1, 1, '2026-03-31 21:26:26', '2026-03-31 21:26:26', '2026-03-31 21:26:26'),
(197, '31.13.115.8', 1, 1, '2026-03-31 21:26:26', '2026-03-31 21:26:26', '2026-03-31 21:26:26'),
(198, '216.234.213.214', 1, 1, '2026-03-31 22:30:52', '2026-03-31 22:30:52', '2026-03-31 22:30:52'),
(199, '173.252.87.16', 1, 1, '2026-04-04 19:19:57', '2026-04-04 19:19:57', '2026-04-04 19:19:57'),
(200, '173.252.87.15', 1, 1, '2026-04-04 19:19:57', '2026-04-04 19:19:57', '2026-04-04 19:19:57'),
(201, '66.249.72.132', 1, 1, '2026-04-05 19:23:31', '2026-04-05 19:23:31', '2026-04-05 19:23:31'),
(202, '45.212.174.169', 0, 0, '2026-04-07 12:57:16', '2026-04-07 12:57:16', '2026-04-07 12:57:16'),
(203, '45.215.236.187', 1, 1, '2026-04-07 16:53:34', '2026-04-07 16:53:34', '2026-04-07 16:53:34'),
(204, '187.40.72.83', 1, 1, '2026-04-07 21:18:13', '2026-04-07 21:18:13', '2026-04-07 21:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `f_a_qs`
--

CREATE TABLE `f_a_qs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `f_a_qs`
--

INSERT INTO `f_a_qs` (`id`, `question`, `answer`, `created_by`, `status_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'When will I hear God’s word in my language through the project running in my language?', 'You don’t need to wait until years pass to hear God speak to you in your mother tongue. As soon as any single translated passage is approved by the Translation Consultant, you can walk into that translation office to get the Scripture for use, both at personal and community levels.', 2, 1, '2024-01-28 10:25:10', '2024-03-04 20:52:47', '2024-03-04 20:52:47'),
(2, 'What is BiLTA?', 'BILTA Is an acronym standing for \"Bible and Literature Translation Association.\" It was first called Senga Bible and Literature Translation Association (SBLTA), however in January 2021, the name changed to Bible and Literature Translation Association (BILTA) so that other languages could be helped with the translation work. Though started with only one project,BiLTA with support from FCBH and Spoken WorldWide, has expanded to many projects throughout zambia.\nWe are a non-profit making organisation and entirely depend on donor funds and partnerships.', 1, 1, '2024-03-04 20:44:09', '2024-03-04 20:56:34', NULL),
(3, 'What are some of the projects that BiLTA is currently working on?', '<ul>\n  <li><strong>Senga</strong> – Chama District, Eastern Province</li>\n  <li><strong>Fungwe</strong> – Mafinga District, Muchinga Province</li>\n  <li><strong>Tambo</strong> – Isoka District, Muchinga Province</li>\n  <li><strong>Lambya</strong> – Isoka District, Muchinga Province</li>\n  <li><strong>Mwenyi</strong> – Kalabo District, Western Province</li>\n  <li><strong>Kunda</strong> – Mambwe District, Eastern Province</li>\n  <li><strong>Chikunda</strong> – Luangwa District, Lusaka Province</li>\n  <li><strong>Bisa</strong> – Lavushimanda District, Muchinga Province</li>\n  <li><strong>Lungu</strong> – Mpulungu District, Northern Province</li>\n  <li><strong>Kabende</strong> – Samfya District, Luapula Province</li>\n  <li><strong>Wandya</strong> – Isoka District, Muchinga Province</li>\n  <li><strong>Mukulu</strong> – Luwingu District, Northern Province</li>\n  <li><strong>Shila</strong> – Chiengi District, Luapula Province</li>\n</ul>\n', 1, 1, '2024-03-04 20:46:04', '2025-05-30 02:39:36', NULL),
(4, 'When will I hear God’s word in my language through the project running in my language?', 'You don’t need to wait until years pass to hear God speak to you in your mother tongue. As soon as any single translated passage is approved by the Translation Consultant, you can walk into that translation office to get the Scripture for use, both at personal and community levels.', 1, 1, '2024-03-04 20:53:21', '2024-03-04 20:53:21', NULL),
(5, 'What are some of the Programes that BiLTA is doing?', '<h3>Programme</h3>\n<ol>\n  <li>Survey the viability and vitality of the languages before translation works.</li>\n  <li>Translating Bibles and essential literature in their heart languages.</li>\n  <li>Scripture Engagements which would help transform communities.\n    <ul>\n      <li>Improve the understanding of the Bible.</li>\n      <li>Develop literacy in the areas of:\n        <ol type=\"i\">\n          <li>Bad cultural vices such as child marriage.</li>\n          <li>Democracy and political tolerance.</li>\n          <li>Health and Agriculture.</li>\n        </ol>\n      </li>\n    </ul>\n  </li>\n</ol>\n', 1, 1, '2024-03-04 21:07:11', '2025-11-13 14:43:05', '2025-11-13 14:43:05'),
(6, 'What is OBT?', 'Oral Bible Translation (OBT) is a mother-tongue, speaker-centered approach to Bible translation in which both translation and quality assurance processes are carried out mostly orally, with the end result being an oral Scripture that is trustworthy, appropriate, intelligible, and appealing.', 1, 1, '2024-10-03 21:55:14', '2025-05-30 02:48:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_item`
--

CREATE TABLE `gallery_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_item`
--

INSERT INTO `gallery_item` (`id`, `name`, `description`, `created_by`, `status_id`, `item_category_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'TEST', 'TEST - TEST', 3, 1, 5, 'Images', '2023-09-27 02:17:29', '2023-10-02 22:43:15', '2023-10-02 22:43:15'),
(4, 'test', 'test', 3, 1, 5, 'Images', '2023-10-01 21:57:45', '2023-10-02 22:43:39', '2023-10-02 22:43:39'),
(5, 'Bertha Chilembo and colleagues in Nigeria at the Workshop for Render 3', 'On the right and only female in the photo is Bertha with other Lead trainers at the workshop in Nigeria for Render 3 release in November, 2023.', 2, 1, 10, 'Images', '2023-10-02 04:55:07', '2024-01-06 17:53:00', '2024-01-06 17:53:00'),
(6, 'The Chairperson (BiLTA) at Indonesia OBT Conference', 'Fr. Katete Jackson Jones, on the right', 2, 1, 6, 'Images', '2023-10-02 04:56:43', '2024-01-28 11:05:06', NULL),
(7, 'The Vice Chairperson (BiLTA) with the Management Team in Western Province, Mwenyi Project', 'Mwenyi Project Establishment ', 2, 1, 7, 'Images', '2023-10-02 05:00:29', '2024-01-28 11:03:45', '2024-01-28 11:03:45'),
(8, 'Pastors', 'Indonesia OTB Conference', 2, 1, 6, 'Images', '2023-10-02 05:01:23', '2023-10-02 05:01:23', NULL),
(9, 'Indonesia OBT Conference', 'Group Photo', 2, 1, 6, 'Images', '2023-10-02 05:02:40', '2023-10-02 05:02:40', NULL),
(10, 'Bertha Chilembo and colleagues in Nigeria at the Workshop for Render 3', 'On the right and only female in the photo is Bertha with other Lead trainers at the workshop in Nigeria for Render 3 release in November, 2023.', 2, 1, 5, 'Images', '2023-11-15 18:38:45', '2024-01-28 10:53:21', '2024-01-28 10:53:21'),
(11, 'Mwenyi Establishment trip', 'BiLTA members of staff pose for a photo after conducting interviews in Kalabo distrct, western province.', 1, 4, 7, 'Images', '2023-11-15 20:12:43', '2023-11-15 20:14:36', '2023-11-15 20:14:36'),
(12, 'Goma Daniel Green', 'Narrative Discourse Analysis facilitation, Kenya Discourse Analysis Workshop - 2023', 2, 1, 5, 'Images', '2023-12-15 22:05:18', '2023-12-15 22:05:18', NULL),
(13, 'Bertha Chilembo and colleagues in Nigeria at the Workshop for Render 3', 'On the right and only female in the photo is Bertha with other Lead trainers at the workshop in Nigeria for Render 3 release on November, 2023.', 2, 1, 5, 'Images', '2024-01-06 16:53:04', '2024-01-06 17:46:00', '2024-01-06 17:46:00'),
(14, 'Pastors in Mfuwe', 'These are Pastors in Mfuwe during the Kunda Bible Translation Project establishment in 2023. ', 2, 1, 5, 'Images', '2024-01-06 16:56:14', '2024-01-06 16:56:14', NULL),
(15, 'BiLTA Executive members at Mfuwe KBT Project', 'With the Executive Secretary in the middle, on the right is the Executive Chairperson with the Executive Treasurer on the left.', 2, 1, 5, 'Images', '2024-01-06 17:11:13', '2024-01-06 17:11:13', NULL),
(16, 'Bertha Chilembo and colleagues in Nigeria at the Workshop for Render 3', 'Bertha Chilembo with fellow Lead Trainers at the Render 3 Release workshop in Nigeria. The workshop was intended to make OBT Trainers updated with new features of the new version of Render. ', 2, 1, 11, 'Images', '2024-01-06 18:08:44', '2024-01-06 18:08:44', NULL),
(17, 'The Vice Chairperson (BiLTA) with the Management Team in Western Province, Mwenyi Project', 'Mwenyi Project Establishment Trip', 2, 1, 7, 'Images', '2024-01-28 10:52:26', '2024-01-28 10:52:26', NULL),
(19, 'Susan Mbuzi', 'One of the first OBT Translators for the Senga Project', 2, 1, 5, 'Images', '2024-01-28 11:37:18', '2024-01-28 11:37:18', NULL),
(18, 'Indonesia OBT Conference', 'Fr. Katete Jackson Jones, BiLTA Chairperson second from right with others at OBT Conference in Indonesia.', 2, 1, 6, 'Images', '2024-01-28 11:02:28', '2024-01-28 11:02:28', NULL),
(20, 'Fungwe established trip', 'Our newly recruited members of staff and the team from the National Office pose for photos today 26th September, 2023 at Chief Mwenechifungwe palace of Mafinga district in Muchinga Province.', 1, 1, 18, 'Images', '2024-02-14 14:48:15', '2024-02-14 14:48:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home_intros`
--

CREATE TABLE `home_intros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(491) NOT NULL,
  `short_description` varchar(1000) NOT NULL,
  `long_description` varchar(1000) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_intros`
--

INSERT INTO `home_intros` (`id`, `name`, `short_description`, `long_description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '', '', '', 1, '2025-05-15 15:05:47', '2025-05-19 16:02:39', NULL),
(7, 'Bible and Literature Translation Association', 'Bible and Literature Translation Association is a nonprofit making organisation whose mandate is to translate the word of God and essential literature into local languages', 'To build capacity of the local people to translate the Bible and essential liiterature into local languages for effective discipleship', 1, '2023-10-10 15:47:29', '2025-05-15 14:56:52', '2025-05-15 14:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `description`, `created_by`, `status_id`, `type`, `created_at`, `updated_at`) VALUES
(28, 'Tambo Oral Bible Translation Project', 'TOBT Project is located in Isoka, Muchinga Province', 1, 1, 'Projects', '2024-12-06 18:47:25', '2024-12-20 23:42:34'),
(27, 'Lambya Oral Bible Translation Project', 'LOBT Project is located in Isoka District, Muchinga Province', 1, 1, 'Projects', '2024-12-06 18:46:33', '2024-12-20 23:43:34'),
(7, 'Mwenyi Establishment trip', 'BiLTA members of staff pose for a photo with Chief Kaongolo of the Mwenyi people of Kalabo, Kalabo trades administrator and district chiefs and traditional affairs officer Mr Pelekelo Shwana\n', 1, 1, 'Images', '2023-11-15 18:24:42', '2024-08-24 00:57:37'),
(26, 'Fungwe Oral Bible Translation Project', 'The project located in Mafinga District of Muchinga Province in Zambia', 2, 1, 'Projects', '2024-08-24 21:14:16', '2024-08-24 21:14:16'),
(11, 'Render 3 Release Workshop', 'Three-day workshop in Nigeria', 2, 1, 'Images', '2024-01-06 18:02:50', '2024-01-06 18:02:50'),
(40, 'Scripture-in-song', 'Scripture-in-song', 1, 1, 'Videos', '2025-05-16 21:28:50', '2025-05-16 21:28:50'),
(15, 'Scripture-to-Song', 'Produced by the Senga people of Chama District, in Eastern Province Zambia.  This was recorded at the Senga Scripture-to-Song Seminar held in Chama.', 1, 1, 'Videos', '2024-02-07 16:46:25', '2024-08-24 00:51:15'),
(16, 'Consultative conference', 'Oral Bible Translation consultative conference', 1, 1, 'News', '2024-02-12 21:53:08', '2024-02-12 21:53:08'),
(39, 'Scripture engagement training', 'Scripture engagement training', 1, 1, 'News', '2025-04-17 11:46:54', '2025-04-17 11:46:54'),
(18, 'Fungwe establishment trip', 'Our newly recruited members of staff and the team from the National Office pose for photos today 26th September, 2023 at Chief Mwenechifungwe palace of Mafinga district in Muchinga Province.', 1, 1, 'Images', '2024-02-14 14:44:30', '2024-02-14 14:44:30'),
(38, 'Tambo Oral Bible Translation', 'Tambo Oral Bible Translation', 1, 1, 'Projects', '2024-12-23 18:13:35', '2024-12-23 18:13:35'),
(37, 'Bible Translation Publications ', 'Bible Translation Publications ', 1, 1, 'News', '2024-12-18 01:25:45', '2024-12-18 01:25:45'),
(36, 'Establishment trip', 'Establishment trip', 1, 1, 'Images', '2024-12-12 13:58:41', '2024-12-12 13:58:41'),
(35, 'Scripture-to-song', 'Produced by the Senga people of Chama District, in Eastern Province Zambia. This was recorded at the Senga Scripture-to-Song Seminar held in Chama.', 1, 1, 'Videos', '2024-12-12 13:57:29', '2024-12-12 16:24:18'),
(25, 'Scripture-to-Song', 'Produced by the Senga people of Chama District, in Eastern Province Zambia.  This was recorded at the Senga Scripture-to-Song Seminar held in Chama from August 4 to 6, 2023. ', 1, 1, 'Videos', '2024-08-24 00:43:47', '2024-08-24 01:07:03'),
(29, 'Kunda Oral Bible Translation Project', 'KOBT Project', 1, 1, 'Projects', '2024-12-06 18:48:37', '2024-12-20 23:44:36'),
(30, 'Chikunda Oral Bible Translation Project', 'COBT Project is located in Feira, Luangwa District of Lusaka Province', 1, 1, 'Projects', '2024-12-06 18:50:03', '2024-12-20 23:46:10'),
(31, 'Translation Trainings', 'Bible Translation Trainings', 1, 1, 'News', '2024-12-06 19:29:27', '2024-12-06 19:29:27'),
(32, 'OBT Office Luanch', 'OBT Office Luanch', 1, 1, 'News', '2024-12-06 19:31:38', '2024-12-06 19:31:38'),
(33, 'Conferences', 'Conferences', 1, 1, 'News', '2024-12-06 19:32:15', '2024-12-06 19:32:15'),
(34, 'OBT Community Review', 'OBT Community Review', 1, 1, 'News', '2024-12-06 19:33:24', '2024-12-06 19:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) DEFAULT NULL,
  `disk` varchar(191) NOT NULL,
  `conversions_disk` varchar(191) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Bilta\\HomeIntro', 3, '44ab8730-4deb-4194-af1a-6d874206053c', 'home_intro_images', 'ancient-manuscripts-2319469__480', 'ancient-manuscripts-2319469__480.jpg', 'image/jpeg', 'public', 'public', 61493, '[]', '[]', '[]', '[]', 1, '2023-05-22 23:19:04', '2023-05-22 23:19:04'),
(3, 'App\\Models\\Bilta\\OurTeam', 1, '64fac057-d76e-4106-b1a6-dd075f95c220', 'team_images', 'fr_katete', 'fr_katete.jpg', 'image/jpeg', 'public', 'public', 102887, '[]', '[]', '[]', '[]', 3, '2023-05-25 01:18:22', '2023-05-25 01:18:22'),
(4, 'App\\Models\\Bilta\\HomeIntro', 4, '71369fbf-2e91-4b8b-93a4-cfba522b6926', 'home_intro_images', 'Screenshot_20230209_080034', 'Screenshot_20230209_080034.png', 'image/png', 'public', 'public', 90296, '[]', '[]', '[]', '[]', 4, '2023-05-25 02:05:54', '2023-05-25 02:05:54'),
(7, 'App\\Models\\Bilta\\OurTeam', 2, 'fd993fef-d725-4648-96bd-4037f36b064c', 'team_images', '1684951954990', '1684951954990.jpg', 'image/jpeg', 'public', 'public', 33698, '[]', '[]', '[]', '[]', 6, '2023-06-10 17:10:52', '2023-06-10 17:10:52'),
(8, 'App\\Models\\Bilta\\OurTeam', 3, '84b02afa-2107-45bc-99e9-e23649f2dc3f', 'team_images', 'Screenshot_20230610-121730', 'Screenshot_20230610-121730.jpg', 'image/jpeg', 'public', 'public', 364968, '[]', '[]', '[]', '[]', 7, '2023-06-10 17:25:59', '2023-06-10 17:25:59'),
(9, 'App\\Models\\Bilta\\Gallery', 3, 'd7beb416-4122-4d46-9f48-03c1d1669dd1', 'gallery_images', 'biblee017c8414_1920', 'biblee017c8414_1920.png', 'image/png', 'public', 'public', 2859768, '[]', '[]', '[]', '[]', 8, '2023-09-27 02:17:29', '2023-09-27 02:17:29'),
(10, 'App\\Models\\Bilta\\Gallery', 4, 'a57486d1-5ab6-4324-aeb1-ba9191d3bf2c', 'gallery_images', 'Misriani -Consultant', 'Misriani--Consultant.jpg', 'image/jpeg', 'public', 'public', 59944, '[]', '[]', '[]', '[]', 9, '2023-10-01 21:57:45', '2023-10-01 21:57:45'),
(11, 'App\\Models\\Bilta\\Gallery', 5, '1744bd58-a6da-421d-b835-48a2f28e7f2f', 'gallery_images', 'Pastor 3', 'Pastor-3.jpg', 'image/jpeg', 'public', 'public', 83839, '[]', '[]', '[]', '[]', 10, '2023-10-02 04:55:07', '2023-10-02 04:55:07'),
(12, 'App\\Models\\Bilta\\Gallery', 6, 'c3bea04e-7b3e-4014-9be8-efe52c7e1c8c', 'gallery_images', 'Pastor', 'Pastor.jpg', 'image/jpeg', 'public', 'public', 92377, '[]', '[]', '[]', '[]', 11, '2023-10-02 04:56:43', '2023-10-02 04:56:43'),
(13, 'App\\Models\\Bilta\\Gallery', 7, 'd726232b-0932-4886-b28f-651ccdc676b5', 'gallery_images', 'YWAM Students', 'YWAM-Students.jpg', 'image/jpeg', 'public', 'public', 77396, '[]', '[]', '[]', '[]', 12, '2023-10-02 05:00:29', '2023-10-02 05:00:29'),
(14, 'App\\Models\\Bilta\\Gallery', 8, '4268fbd6-18c4-4517-ac25-ab7f5b410b7c', 'gallery_images', 'The Pastors', 'The-Pastors.jpg', 'image/jpeg', 'public', 'public', 53489, '[]', '[]', '[]', '[]', 13, '2023-10-02 05:01:23', '2023-10-02 05:01:23'),
(15, 'App\\Models\\Bilta\\Gallery', 9, '91d04b0f-8056-42b5-88b0-c7cba06f22ce', 'gallery_images', 'Group Photo 1', 'Group-Photo-1.jpg', 'image/jpeg', 'public', 'public', 202778, '[]', '[]', '[]', '[]', 14, '2023-10-02 05:02:40', '2023-10-02 05:02:40'),
(18, 'App\\Models\\Bilta\\OurTeam', 4, '751df725-7dca-400a-853a-c39aeb7d8ff9', 'team_images', 'Pastor Ngulube', 'Pastor-Ngulube.jpg', 'image/jpeg', 'public', 'public', 16952, '[]', '[]', '[]', '[]', 15, '2023-10-04 20:19:48', '2023-10-04 20:19:48'),
(19, 'App\\Models\\Bilta\\HomeIntro', 7, '7608b7be-3370-4b53-b1f9-ba07403c71d9', 'home_intro_images', 'Bible and Literature', 'Bible-and-Literature.jpg', 'image/jpeg', 'public', 'public', 490564, '[]', '[]', '[]', '[]', 16, '2023-10-10 15:47:29', '2023-10-10 15:47:29'),
(20, 'App\\Models\\Bilta\\Gallery', 10, 'c893e6f3-14f4-477a-bf02-cddcc0fa4f6c', 'gallery_images', 'IMG-20231019-WA0045', 'IMG-20231019-WA0045.jpg', 'image/jpeg', 'public', 'public', 54105, '[]', '[]', '[]', '[]', 17, '2023-11-15 18:38:45', '2023-11-15 18:38:45'),
(21, 'App\\Models\\Bilta\\Gallery', 11, 'cfaf6c8d-ea6f-4f4d-8db4-ce3f7210b43b', 'gallery_images', 'IMG-20231019-WA0050', 'IMG-20231019-WA0050.jpg', 'image/jpeg', 'public', 'public', 52708, '[]', '[]', '[]', '[]', 18, '2023-11-15 20:12:43', '2023-11-15 20:12:43'),
(22, 'App\\Models\\Bilta\\Gallery', 12, '9ceaf45f-be05-4859-b887-59af14821fd3', 'gallery_images', 'Goma Daniel Green at Ruiru town in Kenya being certified as Narrative Discourse Analysis Facilitator', 'Goma-Daniel-Green-at-Ruiru-town-in-Kenya-being-certified-as-Narrative-Discourse-Analysis-Facilitator.jpg', 'image/jpeg', 'public', 'public', 166638, '[]', '[]', '[]', '[]', 19, '2023-12-15 22:05:19', '2023-12-15 22:05:19'),
(23, 'App\\Models\\Bilta\\OurTeam', 5, 'ce722042-dec8-4339-be01-05d1712b0809', 'team_images', 'Pastor Lungu', 'Pastor-Lungu.png', 'image/png', 'public', 'public', 190693, '[]', '[]', '[]', '[]', 20, '2023-12-19 02:42:44', '2023-12-19 02:42:44'),
(24, 'App\\Models\\Bilta\\OurTeam', 6, 'e6199c36-307d-4c36-b88a-225d5ec2aa24', 'team_images', 'Apostle Chibesa', 'Apostle-Chibesa.jpg', 'image/jpeg', 'public', 'public', 26068, '[]', '[]', '[]', '[]', 21, '2023-12-22 14:45:24', '2023-12-22 14:45:24'),
(25, 'App\\Models\\Bilta\\OurTeam', 7, '276e59b7-ca60-4759-845c-d116a6f8149f', 'team_images', 'Fr. Katete JJ', 'Fr.-Katete-JJ.jpg', 'image/jpeg', 'public', 'public', 19756, '[]', '[]', '[]', '[]', 22, '2023-12-22 15:07:15', '2023-12-22 15:07:15'),
(27, 'App\\Models\\Bilta\\OurTeam', 9, '8b76a9e6-73e9-4262-a055-191134209c92', 'team_images', 'Pastor Lungu I', 'Pastor-Lungu-I.jpg', 'image/jpeg', 'public', 'public', 24111, '[]', '[]', '[]', '[]', 24, '2023-12-22 15:37:06', '2023-12-22 15:37:06'),
(28, 'App\\Models\\Bilta\\OurTeam', 10, 'f2cb3367-967c-4c12-8f58-f80333236e0c', 'team_images', 'Apostle Chibesa', 'Apostle-Chibesa.jpg', 'image/jpeg', 'public', 'public', 26068, '[]', '[]', '[]', '[]', 25, '2023-12-22 15:48:43', '2023-12-22 15:48:43'),
(29, 'App\\Models\\Bilta\\Gallery', 13, 'd52d2d11-ba96-44b0-bb9e-aaf5c25b14fa', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 26, '2024-01-06 16:53:04', '2024-01-06 16:53:04'),
(30, 'App\\Models\\Bilta\\Gallery', 14, '593fdfaa-3f2a-4f75-9943-16fee2da4199', 'gallery_images', 'Mfuwe Pastors', 'Mfuwe-Pastors.jpg', 'image/jpeg', 'public', 'public', 164579, '[]', '[]', '[]', '[]', 27, '2024-01-06 16:56:14', '2024-01-06 16:56:14'),
(31, 'App\\Models\\Bilta\\Gallery', 15, 'acc7fe81-8c1c-47c2-85db-a4902002c868', 'gallery_images', 'BiLTA Executive members at Mfuwe KBT Project', 'BiLTA-Executive-members-at-Mfuwe-KBT-Project.jpg', 'image/jpeg', 'public', 'public', 115593, '[]', '[]', '[]', '[]', 28, '2024-01-06 17:11:13', '2024-01-06 17:11:13'),
(32, 'App\\Models\\Bilta\\Gallery', 5, '748e1ada-0aad-4612-96cd-fd9af8a7c996', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 29, '2024-01-06 17:47:08', '2024-01-06 17:47:08'),
(33, 'App\\Models\\Bilta\\Gallery', 5, '92026448-a585-4ee5-ae62-40b95e1e936e', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 30, '2024-01-06 17:50:36', '2024-01-06 17:50:36'),
(34, 'App\\Models\\Bilta\\Gallery', 10, 'ae7b5259-c89f-4791-bb70-f3606a48448b', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 31, '2024-01-06 17:54:20', '2024-01-06 17:54:20'),
(35, 'App\\Models\\Bilta\\Gallery', 10, '354a99ca-a0be-4c5d-a054-6104cb706920', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 32, '2024-01-06 17:56:30', '2024-01-06 17:56:30'),
(36, 'App\\Models\\Bilta\\Gallery', 16, '7ddd6801-abb4-4c86-b0b1-1b8ed8343fb1', 'gallery_images', 'Bertha Chilembo and collegues in Nigeria at the Workshop for Render 3', 'Bertha-Chilembo-and-collegues-in-Nigeria-at-the-Workshop-for-Render-3.jpg', 'image/jpeg', 'public', 'public', 207534, '[]', '[]', '[]', '[]', 33, '2024-01-06 18:08:44', '2024-01-06 18:08:44'),
(37, 'App\\Models\\Bilta\\Gallery', 17, '910fc08b-3ded-4156-98e9-2ded26e93afc', 'gallery_images', 'Mwenyi E Trip', 'Mwenyi-E-Trip.jpg', 'image/jpeg', 'public', 'public', 54105, '[]', '[]', '[]', '[]', 34, '2024-01-28 10:52:26', '2024-01-28 10:52:26'),
(38, 'App\\Models\\Bilta\\Gallery', 18, 'bba2e899-ea7f-4160-bef6-5ab477d72a0f', 'gallery_images', 'Fr. Katete and Others', 'Fr.-Katete-and-Others.jpg', 'image/jpeg', 'public', 'public', 77396, '[]', '[]', '[]', '[]', 35, '2024-01-28 11:02:28', '2024-01-28 11:02:28'),
(39, 'App\\Models\\Bilta\\Gallery', 19, '755533b5-a4a2-4036-a27e-dd7944057c0f', 'gallery_images', 'Susan Recording ', 'Susan-Recording-.png', 'image/png', 'public', 'public', 1598252, '[]', '[]', '[]', '[]', 36, '2024-01-28 11:37:18', '2024-01-28 11:37:18'),
(42, 'App\\Models\\Bilta\\News', 2, '169e900a-caa2-426d-9c5a-b98798da2342', 'news_images', 'IMG-20230906-WA0034', 'IMG-20230906-WA0034.jpg', 'image/jpeg', 'public', 'public', 86516, '[]', '[]', '[]', '[]', 39, '2024-02-02 15:16:23', '2024-02-02 15:16:23'),
(44, 'App\\Models\\Bilta\\OurTeam', 11, 'fb093e5a-e5e4-4dde-8b0e-5d1ddc449933', 'team_images', 'Rev_S_P_Photo', 'Rev_S_P_Photo.jpg', 'image/jpeg', 'public', 'public', 62376, '[]', '[]', '[]', '[]', 41, '2024-02-07 15:06:32', '2024-02-07 15:06:32'),
(45, 'App\\Models\\Bilta\\OurTeam', 12, 'edaea165-8ded-49fb-bdcf-09b6338345cf', 'team_images', 'Mr_Goma_M', 'Mr_Goma_M.jpg', 'image/jpeg', 'public', 'public', 32348, '[]', '[]', '[]', '[]', 42, '2024-02-08 16:27:38', '2024-02-08 16:27:38'),
(46, 'App\\Models\\Bilta\\OurTeam', 13, '0fb8be95-e094-4381-92b6-f1ef8f1f1eff', 'team_images', '84814719_3701372929935325_4884363605035712512_n', '84814719_3701372929935325_4884363605035712512_n.jpg', 'image/jpeg', 'public', 'public', 110680, '[]', '[]', '[]', '[]', 43, '2024-02-08 19:28:57', '2024-02-08 19:28:57'),
(47, 'App\\Models\\Bilta\\News', 1, '301ac6d7-d62e-4a8f-ab54-fb16361d843c', 'news_title_images', 'WhatsApp Image 2024-01-31 at 08.44.19_9aefc05e', 'WhatsApp-Image-2024-01-31-at-08.44.19_9aefc05e.jpg', 'image/jpeg', 'public', 'public', 92141, '[]', '[]', '[]', '[]', 44, '2024-02-12 21:38:47', '2024-02-12 21:38:47'),
(48, 'App\\Models\\Bilta\\News', 2, 'f786c9e5-0704-4b97-85a4-b27bf5a2503b', 'news_images', 'IMG-20230901-WA0017', 'IMG-20230901-WA0017.jpg', 'image/jpeg', 'public', 'public', 104910, '[]', '[]', '[]', '[]', 45, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(49, 'App\\Models\\Bilta\\News', 2, 'f660b890-0b43-4686-a6e5-0ad60169772a', 'news_images', 'IMG-20230901-WA0018', 'IMG-20230901-WA0018.jpg', 'image/jpeg', 'public', 'public', 86561, '[]', '[]', '[]', '[]', 46, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(50, 'App\\Models\\Bilta\\News', 2, 'fcf28094-c5a6-44e2-ba5e-4edacd75cfcd', 'news_images', 'IMG-20230901-WA0019', 'IMG-20230901-WA0019.jpg', 'image/jpeg', 'public', 'public', 89308, '[]', '[]', '[]', '[]', 47, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(51, 'App\\Models\\Bilta\\News', 2, '62b8950a-40a1-47ad-93bc-e76f56c0e65e', 'news_images', 'IMG-20230901-WA0020', 'IMG-20230901-WA0020.jpg', 'image/jpeg', 'public', 'public', 110406, '[]', '[]', '[]', '[]', 48, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(52, 'App\\Models\\Bilta\\News', 2, '75da07f4-e536-4a1a-a748-950443fcd892', 'news_images', 'IMG-20230906-WA0028', 'IMG-20230906-WA0028.jpg', 'image/jpeg', 'public', 'public', 99902, '[]', '[]', '[]', '[]', 49, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(53, 'App\\Models\\Bilta\\News', 2, '800ea96b-fc7f-46b6-a781-05c2149c45aa', 'news_images', 'IMG-20230906-WA0031', 'IMG-20230906-WA0031.jpg', 'image/jpeg', 'public', 'public', 100389, '[]', '[]', '[]', '[]', 50, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(54, 'App\\Models\\Bilta\\News', 2, '9f030aa0-1878-4852-9dc1-66c3291ef633', 'news_images', 'IMG-20230906-WA0033', 'IMG-20230906-WA0033.jpg', 'image/jpeg', 'public', 'public', 110337, '[]', '[]', '[]', '[]', 51, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(55, 'App\\Models\\Bilta\\News', 2, '3b2ca04e-06ba-4039-82bc-8934529aa243', 'news_images', 'IMG-20230906-WA0034', 'IMG-20230906-WA0034.jpg', 'image/jpeg', 'public', 'public', 86516, '[]', '[]', '[]', '[]', 52, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(56, 'App\\Models\\Bilta\\News', 2, '893ab3e0-4abf-4eff-b0b9-dc8df6cdc086', 'news_images', 'IMG-20230906-WA0035', 'IMG-20230906-WA0035.jpg', 'image/jpeg', 'public', 'public', 91812, '[]', '[]', '[]', '[]', 53, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(57, 'App\\Models\\Bilta\\News', 2, '414db99f-1416-4c83-93b7-9adb10545c86', 'news_images', 'IMG-20230906-WA0037', 'IMG-20230906-WA0037.jpg', 'image/jpeg', 'public', 'public', 107177, '[]', '[]', '[]', '[]', 54, '2024-02-12 21:40:41', '2024-02-12 21:40:41'),
(58, 'App\\Models\\Bilta\\News', 3, '9f19cd66-28ea-4a46-939c-987d4aa56ede', 'news_title_images', '336885751_1007816466861492_3462124795528625168_n', '336885751_1007816466861492_3462124795528625168_n.jpg', 'image/jpeg', 'public', 'public', 152050, '[]', '[]', '[]', '[]', 55, '2024-02-12 21:57:26', '2024-02-12 21:57:26'),
(59, 'App\\Models\\Bilta\\News', 2, '841d4e8a-765d-4286-9be9-a02945a4b76b', 'news_images', '336885751_1007816466861492_3462124795528625168_n', '336885751_1007816466861492_3462124795528625168_n.jpg', 'image/jpeg', 'public', 'public', 152050, '[]', '[]', '[]', '[]', 56, '2024-02-12 22:08:10', '2024-02-12 22:08:10'),
(60, 'App\\Models\\Bilta\\News', 2, 'eb386f52-c172-4c57-8f72-5110a9efd692', 'news_images', '337346540_222245443715855_6913921460625292031_n', '337346540_222245443715855_6913921460625292031_n.jpg', 'image/jpeg', 'public', 'public', 249393, '[]', '[]', '[]', '[]', 57, '2024-02-12 22:08:10', '2024-02-12 22:08:10'),
(62, 'App\\Models\\Bilta\\News', 3, '5df08028-5056-41ec-b567-4b02e68a4118', 'news_images', '337346540_222245443715855_6913921460625292031_n', '337346540_222245443715855_6913921460625292031_n.jpg', 'image/jpeg', 'public', 'public', 249393, '[]', '[]', '[]', '[]', 59, '2024-02-12 22:15:29', '2024-02-12 22:15:29'),
(63, 'App\\Models\\Bilta\\News', 4, 'e09c211c-09ff-42b0-9d9b-2eab35e1111f', 'news_title_images', '325505419_1672366626566851_581600567647218868_n', '325505419_1672366626566851_581600567647218868_n.jpg', 'image/jpeg', 'public', 'public', 283585, '[]', '[]', '[]', '[]', 60, '2024-02-12 22:28:47', '2024-02-12 22:28:47'),
(64, 'App\\Models\\Bilta\\News', 4, 'f1f0138e-0160-4dbe-a633-9481100e447e', 'news_images', '325479352_492647529687851_6748494310690426382_n', '325479352_492647529687851_6748494310690426382_n.jpg', 'image/jpeg', 'public', 'public', 193128, '[]', '[]', '[]', '[]', 61, '2024-02-12 22:28:47', '2024-02-12 22:28:47'),
(65, 'App\\Models\\Bilta\\News', 4, 'ffe55385-2501-4142-8e66-1127502068ec', 'news_images', '325505419_1672366626566851_581600567647218868_n', '325505419_1672366626566851_581600567647218868_n.jpg', 'image/jpeg', 'public', 'public', 283585, '[]', '[]', '[]', '[]', 62, '2024-02-12 22:28:47', '2024-02-12 22:28:47'),
(66, 'App\\Models\\Bilta\\News', 4, '9d993d23-a9d4-40c9-9326-ea71ad8d7ece', 'news_images', '325514587_585218796769619_9091231746384470986_n', '325514587_585218796769619_9091231746384470986_n.jpg', 'image/jpeg', 'public', 'public', 235930, '[]', '[]', '[]', '[]', 63, '2024-02-12 22:28:47', '2024-02-12 22:28:47'),
(67, 'App\\Models\\Bilta\\News', 4, '7148dfdb-5f23-4943-b959-51327aac3718', 'news_images', '325595967_829851134779182_5287729307985224101_n', '325595967_829851134779182_5287729307985224101_n.jpg', 'image/jpeg', 'public', 'public', 306376, '[]', '[]', '[]', '[]', 64, '2024-02-12 22:28:47', '2024-02-12 22:28:47'),
(68, 'App\\Models\\Bilta\\News', 1, '174c3756-f623-45ce-9008-5cfe9dcf35c0', 'news_images', '2023-10-25_071530 Trip map-2', '2023-10-25_071530-Trip-map-2.jpg', 'image/jpeg', 'public', 'public', 73807, '[]', '[]', '[]', '[]', 65, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(69, 'App\\Models\\Bilta\\News', 1, 'c8653c31-51dc-4931-8a61-81232344d3c2', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.02_6cf3b31e', 'WhatsApp-Image-2024-01-31-at-08.44.02_6cf3b31e.jpg', 'image/jpeg', 'public', 'public', 32886, '[]', '[]', '[]', '[]', 66, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(70, 'App\\Models\\Bilta\\News', 1, 'd6753092-c827-414f-b639-5105b175938e', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.04_e4d94102', 'WhatsApp-Image-2024-01-31-at-08.44.04_e4d94102.jpg', 'image/jpeg', 'public', 'public', 64774, '[]', '[]', '[]', '[]', 67, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(71, 'App\\Models\\Bilta\\News', 1, '1bf7d56d-7ef1-4e82-a53f-20a07c9f4087', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.05_225b8697', 'WhatsApp-Image-2024-01-31-at-08.44.05_225b8697.jpg', 'image/jpeg', 'public', 'public', 83875, '[]', '[]', '[]', '[]', 68, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(72, 'App\\Models\\Bilta\\News', 1, '71f406d5-cbc6-4257-9340-104550a924d7', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.06_b6a394f4', 'WhatsApp-Image-2024-01-31-at-08.44.06_b6a394f4.jpg', 'image/jpeg', 'public', 'public', 75380, '[]', '[]', '[]', '[]', 69, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(73, 'App\\Models\\Bilta\\News', 1, 'b7789524-6ca2-47f3-aad5-cd000e4d7925', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.08_5c4b47ca', 'WhatsApp-Image-2024-01-31-at-08.44.08_5c4b47ca.jpg', 'image/jpeg', 'public', 'public', 90433, '[]', '[]', '[]', '[]', 70, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(74, 'App\\Models\\Bilta\\News', 1, 'ba4f14ac-15db-428d-8c96-d439fbb0112f', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.08_95ae753c', 'WhatsApp-Image-2024-01-31-at-08.44.08_95ae753c.jpg', 'image/jpeg', 'public', 'public', 90333, '[]', '[]', '[]', '[]', 71, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(75, 'App\\Models\\Bilta\\News', 1, '7772e54b-de73-4269-b942-97ee15bc7644', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.09_71a8e273', 'WhatsApp-Image-2024-01-31-at-08.44.09_71a8e273.jpg', 'image/jpeg', 'public', 'public', 84708, '[]', '[]', '[]', '[]', 72, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(76, 'App\\Models\\Bilta\\News', 1, '35720bdf-42e2-4ab8-9baf-f941067958ae', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.12_5bcb962a', 'WhatsApp-Image-2024-01-31-at-08.44.12_5bcb962a.jpg', 'image/jpeg', 'public', 'public', 93306, '[]', '[]', '[]', '[]', 73, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(77, 'App\\Models\\Bilta\\News', 1, '434010a1-2903-45d1-aed4-46e8e9aa5125', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.13_dde8b720', 'WhatsApp-Image-2024-01-31-at-08.44.13_dde8b720.jpg', 'image/jpeg', 'public', 'public', 84089, '[]', '[]', '[]', '[]', 74, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(78, 'App\\Models\\Bilta\\News', 1, '1a877480-30dc-4fc2-a054-d7d157b62b86', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.13_f041568f', 'WhatsApp-Image-2024-01-31-at-08.44.13_f041568f.jpg', 'image/jpeg', 'public', 'public', 86418, '[]', '[]', '[]', '[]', 75, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(79, 'App\\Models\\Bilta\\News', 1, 'b474a06e-f40e-4710-a540-6e77090aa240', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.14_ec223580', 'WhatsApp-Image-2024-01-31-at-08.44.14_ec223580.jpg', 'image/jpeg', 'public', 'public', 115236, '[]', '[]', '[]', '[]', 76, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(80, 'App\\Models\\Bilta\\News', 1, 'cd002b85-8197-40ba-9f98-b8d315fa587a', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.15_2197154d', 'WhatsApp-Image-2024-01-31-at-08.44.15_2197154d.jpg', 'image/jpeg', 'public', 'public', 90848, '[]', '[]', '[]', '[]', 77, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(81, 'App\\Models\\Bilta\\News', 1, '66c5adf5-8a27-40f3-b8bc-b4603ae70521', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.16_facbed16', 'WhatsApp-Image-2024-01-31-at-08.44.16_facbed16.jpg', 'image/jpeg', 'public', 'public', 111904, '[]', '[]', '[]', '[]', 78, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(82, 'App\\Models\\Bilta\\News', 1, '716589a4-9ce3-44b8-9d04-78f6885ac15d', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.19_9aefc05e', 'WhatsApp-Image-2024-01-31-at-08.44.19_9aefc05e.jpg', 'image/jpeg', 'public', 'public', 92141, '[]', '[]', '[]', '[]', 79, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(83, 'App\\Models\\Bilta\\News', 1, '4cd0420e-2af5-4f55-bd68-4c5281cc39bc', 'news_images', 'WhatsApp Image 2024-01-31 at 08.44.19_f46b19d4', 'WhatsApp-Image-2024-01-31-at-08.44.19_f46b19d4.jpg', 'image/jpeg', 'public', 'public', 117447, '[]', '[]', '[]', '[]', 80, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(84, 'App\\Models\\Bilta\\News', 1, '8ed479ec-702c-4bb8-9ec9-ff1a9c716554', 'news_images', 'WhatsApp Video 2024-01-31 at 08.44.12_804ddf8b', 'WhatsApp-Video-2024-01-31-at-08.44.12_804ddf8b.mp4', 'video/mp4', 'public', 'public', 10012929, '[]', '[]', '[]', '[]', 81, '2024-02-12 22:41:10', '2024-02-12 22:41:10'),
(85, 'App\\Models\\Bilta\\OurTeam', 14, '4526626d-1d2d-4c43-bebc-e1d0b5e0e304', 'team_images', 'Pastor D_ N_Photo', 'Pastor-D_-N_Photo.jpg', 'image/jpeg', 'public', 'public', 70172, '[]', '[]', '[]', '[]', 82, '2024-02-14 13:30:16', '2024-02-14 13:30:16'),
(86, 'App\\Models\\Bilta\\Gallery', 20, '12623b59-4ce2-41e5-9531-dd34ff343255', 'gallery_images', 'IMG-20231001-WA0000', 'IMG-20231001-WA0000.jpg', 'image/jpeg', 'public', 'public', 32504, '[]', '[]', '[]', '[]', 83, '2024-02-14 14:48:15', '2024-02-14 14:48:15'),
(88, 'App\\Models\\Bilta\\OurTeam', 15, '1eaf2fa1-9393-4668-816b-809fd4b1926f', 'team_images', 'Pastor D_ N_Photo', 'Pastor-D_-N_Photo.jpg', 'image/jpeg', 'public', 'public', 70172, '[]', '[]', '[]', '[]', 85, '2024-02-19 21:28:31', '2024-02-19 21:28:31'),
(89, 'App\\Models\\Bilta\\OurTeam', 16, '3f915828-800b-4651-810d-33405ea3f4a7', 'team_images', 'Rev_S_P_Photo', 'Rev_S_P_Photo.jpg', 'image/jpeg', 'public', 'public', 62376, '[]', '[]', '[]', '[]', 86, '2024-02-19 21:56:29', '2024-02-19 21:56:29'),
(90, 'App\\Models\\Bilta\\OurTeam', 17, 'c53a8cad-9e94-4c5f-9bd6-9c01ce9c1c06', 'team_images', 'WhatsApp Image 2024-02-19 at 17.03.32_3dba5649', 'WhatsApp-Image-2024-02-19-at-17.03.32_3dba5649.jpg', 'image/jpeg', 'public', 'public', 12389, '[]', '[]', '[]', '[]', 87, '2024-02-19 22:09:51', '2024-02-19 22:09:51'),
(91, 'App\\Models\\Bilta\\News', 5, '6123df0c-1d1b-49b8-8bbb-453db745a0a6', 'news_title_images', 'WhatsApp Image 2024-02-08 at 12.39.24_3ceb064b', 'WhatsApp-Image-2024-02-08-at-12.39.24_3ceb064b.jpg', 'image/jpeg', 'public', 'public', 121069, '[]', '[]', '[]', '[]', 88, '2024-02-26 21:35:42', '2024-02-26 21:35:42'),
(94, 'App\\Models\\Bilta\\News', 5, '71745e77-869d-401f-91f5-4ac1ade65b73', 'news_images', 'KBTA', 'KBTA.jpg', 'image/jpeg', 'public', 'public', 51959, '[]', '[]', '[]', '[]', 89, '2024-02-26 21:38:08', '2024-02-26 21:38:08'),
(95, 'App\\Models\\Bilta\\News', 5, '97af5def-f525-4a11-8ed5-4eab918cd7e1', 'news_images', 'WhatsApp Image 2024-02-08 at 12.04.34_52ec3eab', 'WhatsApp-Image-2024-02-08-at-12.04.34_52ec3eab.jpg', 'image/jpeg', 'public', 'public', 135359, '[]', '[]', '[]', '[]', 90, '2024-02-26 21:38:08', '2024-02-26 21:38:08'),
(97, 'App\\Models\\Bilta\\News', 5, '4dcf5a48-5a5f-4036-9e4d-334050a59d29', 'news_images', 'WhatsApp Image 2024-02-08 at 12.39.25_0f9a3d53', 'WhatsApp-Image-2024-02-08-at-12.39.25_0f9a3d53.jpg', 'image/jpeg', 'public', 'public', 100213, '[]', '[]', '[]', '[]', 92, '2024-02-26 21:38:09', '2024-02-26 21:38:09'),
(99, 'App\\Models\\Bilta\\News', 5, '6cac16f5-a751-4833-837b-74cfa9728479', 'news_images', 'KBTA', 'KBTA.jpg', 'image/jpeg', 'public', 'public', 51959, '[]', '[]', '[]', '[]', 93, '2024-02-26 21:40:10', '2024-02-26 21:40:10'),
(100, 'App\\Models\\Bilta\\News', 5, 'b0c0eb0b-873d-4217-8696-420444f7adc6', 'news_images', 'WhatsApp Image 2024-02-08 at 12.04.34_52ec3eab', 'WhatsApp-Image-2024-02-08-at-12.04.34_52ec3eab.jpg', 'image/jpeg', 'public', 'public', 135359, '[]', '[]', '[]', '[]', 94, '2024-02-26 21:40:10', '2024-02-26 21:40:10'),
(101, 'App\\Models\\Bilta\\News', 5, '8c67d982-7ec6-4304-bf8f-e0ea2c6f0830', 'news_images', 'WhatsApp Image 2024-02-08 at 12.39.24_3ceb064b', 'WhatsApp-Image-2024-02-08-at-12.39.24_3ceb064b.jpg', 'image/jpeg', 'public', 'public', 121069, '[]', '[]', '[]', '[]', 95, '2024-02-26 21:40:10', '2024-02-26 21:40:10'),
(102, 'App\\Models\\Bilta\\News', 5, '32936592-ffd2-42c5-868b-c00083c8676b', 'news_images', 'WhatsApp Image 2024-02-08 at 12.39.25_0f9a3d53', 'WhatsApp-Image-2024-02-08-at-12.39.25_0f9a3d53.jpg', 'image/jpeg', 'public', 'public', 100213, '[]', '[]', '[]', '[]', 96, '2024-02-26 21:40:10', '2024-02-26 21:40:10'),
(103, 'App\\Models\\Bilta\\News', 5, '19a89089-ae74-4184-bfa5-d3a6f03c3096', 'news_images', 'WhatsApp Image 2024-02-10 at 19.14.18_4224f96b', 'WhatsApp-Image-2024-02-10-at-19.14.18_4224f96b.jpg', 'image/jpeg', 'public', 'public', 51959, '[]', '[]', '[]', '[]', 97, '2024-02-26 21:40:10', '2024-02-26 21:40:10'),
(104, 'App\\Models\\Bilta\\News', 6, 'dd7ead78-487c-46c0-b11c-657b5dce5d4e', 'news_title_images', 'KBTA', 'KBTA.jpg', 'image/jpeg', 'public', 'public', 51959, '[]', '[]', '[]', '[]', 98, '2024-02-26 22:26:10', '2024-02-26 22:26:10'),
(105, 'App\\Models\\Bilta\\News', 7, '95a3715f-e4c3-4559-99cd-187910b7c6ea', 'news_title_images', 'WhatsApp Image 2024-02-25 at 19.29.15_21de07be', 'WhatsApp-Image-2024-02-25-at-19.29.15_21de07be.jpg', 'image/jpeg', 'public', 'public', 36788, '[]', '[]', '[]', '[]', 99, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(106, 'App\\Models\\Bilta\\News', 7, 'fd70663c-5a34-4de2-907b-ea69b260c734', 'news_images', 'WhatsApp Image 2024-02-25 at 19.29.12_ef2910d9', 'WhatsApp-Image-2024-02-25-at-19.29.12_ef2910d9.jpg', 'image/jpeg', 'public', 'public', 36791, '[]', '[]', '[]', '[]', 100, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(107, 'App\\Models\\Bilta\\News', 7, '4d3f0c1b-6c6d-4c5d-84f1-e846bef0ee39', 'news_images', 'WhatsApp Image 2024-02-25 at 19.29.13_76599b03', 'WhatsApp-Image-2024-02-25-at-19.29.13_76599b03.jpg', 'image/jpeg', 'public', 'public', 36906, '[]', '[]', '[]', '[]', 101, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(108, 'App\\Models\\Bilta\\News', 7, '575b36c0-f3cc-4e95-ac8e-55d95598f0bc', 'news_images', 'WhatsApp Image 2024-02-25 at 19.29.14_45274584', 'WhatsApp-Image-2024-02-25-at-19.29.14_45274584.jpg', 'image/jpeg', 'public', 'public', 38382, '[]', '[]', '[]', '[]', 102, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(109, 'App\\Models\\Bilta\\News', 7, 'caff5c84-9a73-4ed3-b314-c51483356ae7', 'news_images', 'WhatsApp Image 2024-02-25 at 19.29.15_21de07be', 'WhatsApp-Image-2024-02-25-at-19.29.15_21de07be.jpg', 'image/jpeg', 'public', 'public', 36788, '[]', '[]', '[]', '[]', 103, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(110, 'App\\Models\\Bilta\\News', 7, '2cfaaa21-dacd-41e4-b1cc-e7899188c081', 'news_images', 'WhatsApp Image 2024-02-25 at 19.29.15_e8c97162', 'WhatsApp-Image-2024-02-25-at-19.29.15_e8c97162.jpg', 'image/jpeg', 'public', 'public', 37736, '[]', '[]', '[]', '[]', 104, '2024-02-27 00:30:43', '2024-02-27 00:30:43'),
(111, 'App\\Models\\Bilta\\News', 8, '9da23dfd-c43d-42dc-97ab-ed9d70f12d24', 'news_title_images', '338378382_248355307549639_1524420088407900963_n', '338378382_248355307549639_1524420088407900963_n.jpg', 'image/jpeg', 'public', 'public', 131923, '[]', '[]', '[]', '[]', 105, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(112, 'App\\Models\\Bilta\\News', 8, '9f6afbc7-beb7-4f98-8849-e0c5faea1dba', 'news_images', '338378382_248355307549639_1524420088407900963_n', '338378382_248355307549639_1524420088407900963_n.jpg', 'image/jpeg', 'public', 'public', 131923, '[]', '[]', '[]', '[]', 106, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(113, 'App\\Models\\Bilta\\News', 8, 'acf89018-695a-48ac-8725-f638ab5a0187', 'news_images', '338387119_593573526124931_1516660761524772229_n', '338387119_593573526124931_1516660761524772229_n.jpg', 'image/jpeg', 'public', 'public', 146695, '[]', '[]', '[]', '[]', 107, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(114, 'App\\Models\\Bilta\\News', 8, '2b99837c-83cd-4e15-9bd1-e5e80c36db2b', 'news_images', '338409597_241749408216610_1302949932282621092_n', '338409597_241749408216610_1302949932282621092_n.jpg', 'image/jpeg', 'public', 'public', 144221, '[]', '[]', '[]', '[]', 108, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(115, 'App\\Models\\Bilta\\News', 8, '8157ffb5-a8f0-4a2a-9a55-fbabdcdc0c49', 'news_images', '338417390_254339163686798_1673130762862157464_n', '338417390_254339163686798_1673130762862157464_n.jpg', 'image/jpeg', 'public', 'public', 157017, '[]', '[]', '[]', '[]', 109, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(116, 'App\\Models\\Bilta\\News', 8, '7ba6ce0b-956f-423f-ba0a-7c71f0c1c2a2', 'news_images', '338419758_902871527647559_1338752290232457108_n', '338419758_902871527647559_1338752290232457108_n.jpg', 'image/jpeg', 'public', 'public', 149163, '[]', '[]', '[]', '[]', 110, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(117, 'App\\Models\\Bilta\\News', 8, 'b9a1d57a-c63d-4e0e-8704-c32579e4a191', 'news_images', '338437837_779182493342814_3531617313363197964_n', '338437837_779182493342814_3531617313363197964_n.jpg', 'image/jpeg', 'public', 'public', 135204, '[]', '[]', '[]', '[]', 111, '2024-02-27 01:14:11', '2024-02-27 01:14:11'),
(118, 'App\\Models\\Bilta\\News', 8, '10c97699-23ab-4fd2-90fa-fcb3e6f9f61d', 'news_images', '338516410_798920537744178_399242115186868780_n', '338516410_798920537744178_399242115186868780_n.jpg', 'image/jpeg', 'public', 'public', 148245, '[]', '[]', '[]', '[]', 112, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(119, 'App\\Models\\Bilta\\News', 8, '6a2c1f22-9920-4426-aba6-d0c2f4203476', 'news_images', '338558253_1301975587384167_1970446223003410793_n', '338558253_1301975587384167_1970446223003410793_n.jpg', 'image/jpeg', 'public', 'public', 92639, '[]', '[]', '[]', '[]', 113, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(120, 'App\\Models\\Bilta\\News', 8, '8ab458d8-858f-4327-9a25-dc27f84cc8e3', 'news_images', '338585931_997887224469866_7322370548923777728_n', '338585931_997887224469866_7322370548923777728_n.jpg', 'image/jpeg', 'public', 'public', 138792, '[]', '[]', '[]', '[]', 114, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(121, 'App\\Models\\Bilta\\News', 8, '693ca141-2bab-4148-b281-5807482ad17b', 'news_images', '338699258_1677862309339419_8362105399405711847_n', '338699258_1677862309339419_8362105399405711847_n.jpg', 'image/jpeg', 'public', 'public', 147867, '[]', '[]', '[]', '[]', 115, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(122, 'App\\Models\\Bilta\\News', 8, '5bf8cf84-00a1-4646-9074-bc9418257395', 'news_images', '338718931_1458544948009355_7210647957399911266_n', '338718931_1458544948009355_7210647957399911266_n.jpg', 'image/jpeg', 'public', 'public', 105247, '[]', '[]', '[]', '[]', 116, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(123, 'App\\Models\\Bilta\\News', 8, 'fa38099d-d72e-47e9-bd59-4fef71ed3265', 'news_images', '339092932_1163866824283844_1745862116432053299_n', '339092932_1163866824283844_1745862116432053299_n.jpg', 'image/jpeg', 'public', 'public', 139131, '[]', '[]', '[]', '[]', 117, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(124, 'App\\Models\\Bilta\\News', 8, '80e18e9a-e35e-4e53-aae6-e29f9699a5d9', 'news_images', '339128872_1072243887511941_2778662011606864570_n', '339128872_1072243887511941_2778662011606864570_n.jpg', 'image/jpeg', 'public', 'public', 155657, '[]', '[]', '[]', '[]', 118, '2024-02-27 01:14:12', '2024-02-27 01:14:12'),
(125, 'App\\Models\\Bilta\\News', 9, '9a3f304d-22cf-40e5-8b3a-c396ae1da1b2', 'news_title_images', '310278272_10158928641961080_3774582743432140760_n', '310278272_10158928641961080_3774582743432140760_n.jpg', 'image/jpeg', 'public', 'public', 106087, '[]', '[]', '[]', '[]', 119, '2024-03-01 22:54:11', '2024-03-01 22:54:11'),
(126, 'App\\Models\\Bilta\\News', 9, 'a5416fe9-5539-4e7f-b009-b9bdaf0a5f96', 'news_images', '311452585_10158928642341080_4384905368569424036_n', '311452585_10158928642341080_4384905368569424036_n.jpg', 'image/jpeg', 'public', 'public', 54757, '[]', '[]', '[]', '[]', 120, '2024-03-01 22:54:11', '2024-03-01 22:54:11'),
(133, 'App\\Models\\Bilta\\Projects', 5, 'faca7cd1-ba2a-4919-8a95-54f5eaecb9fd', 'project_images', 'Senga translators, Daniel Goma, Francis Milazi and Bertha Chilembo particiting in the 2021 OBT global Virtual conference ', 'Senga-translators,-Daniel-Goma,-Francis-Milazi-and-Bertha-Chilembo-particiting-in-the-2021-OBT-global-Virtual-conference-.jpg', 'image/jpeg', 'public', 'public', 23568, '[]', '[]', '[]', '[]', 122, '2024-08-24 21:09:38', '2024-08-24 21:09:38'),
(134, 'App\\Models\\Bilta\\Projects', 5, '990ff757-48e9-4bd2-a227-25ea594027b2', 'project_images', 'Senga Team, Rev. Frackson Ndhlovu, John Kumwenda and Suzan Mbuzi participating in the 2021 OBT virtual global conference', 'Senga-Team,-Rev.-Frackson-Ndhlovu,-John-Kumwenda-and-Suzan-Mbuzi-participating-in-the-2021-OBT-virtual-global-conference.jpg', 'image/jpeg', 'public', 'public', 26680, '[]', '[]', '[]', '[]', 123, '2024-08-24 21:09:38', '2024-08-24 21:09:38'),
(135, 'App\\Models\\Bilta\\Projects', 5, 'dc62c727-0a4f-4d70-bad1-84fa8e793542', 'project_files', 'The Senga Survey Report', 'The-Senga-Survey-Report.pdf', 'application/pdf', 'public', 'public', 2923339, '[]', '[]', '[]', '[]', 124, '2024-08-24 21:09:38', '2024-08-24 21:09:38'),
(137, 'App\\Models\\Bilta\\Projects', 6, '75c473d6-bb71-4aaf-b1c8-6b2fcee9184c', 'project_images', 'Intro Pic', 'Intro-Pic.jpg', 'image/jpeg', 'public', 'public', 78678, '[]', '[]', '[]', '[]', 126, '2024-08-24 21:16:11', '2024-08-24 21:16:11'),
(142, 'App\\Models\\Bilta\\OurTeam', 18, 'f1733092-0962-44a4-807f-6b5eecb3d6ec', 'team_images', 'Goma Daniel Green', 'Goma-Daniel-Green.jpg', 'image/jpeg', 'public', 'public', 518513, '[]', '[]', '[]', '[]', 128, '2024-11-08 17:22:17', '2024-11-08 17:22:17'),
(143, 'App\\Models\\Bilta\\OurTeam', 19, '3c069032-fc67-4c1a-8649-c0ce32cc4c74', 'team_images', 'Pr. Dickson Nyirenda', 'Pr.-Dickson-Nyirenda.jpg', 'image/jpeg', 'public', 'public', 17850, '[]', '[]', '[]', '[]', 129, '2024-11-08 17:44:28', '2024-11-08 17:44:28'),
(144, 'App\\Models\\Bilta\\News', 10, 'f3334952-6c95-4b84-b686-8f5673eb87fc', 'news_title_images', 'WhatsApp Image 2024-11-06 at 15.14.37_067e5e08', 'WhatsApp-Image-2024-11-06-at-15.14.37_067e5e08.jpg', 'image/jpeg', 'public', 'public', 65661, '[]', '[]', '[]', '[]', 130, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(145, 'App\\Models\\Bilta\\News', 10, '97894804-8cd1-4f78-b398-6dc8bb6dbd01', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.37_067e5e08', 'WhatsApp-Image-2024-11-06-at-15.14.37_067e5e08.jpg', 'image/jpeg', 'public', 'public', 65661, '[]', '[]', '[]', '[]', 131, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(146, 'App\\Models\\Bilta\\News', 10, 'e3754bba-afee-43dd-a683-2a0d7f36b46c', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.38_40f9b9db', 'WhatsApp-Image-2024-11-06-at-15.14.38_40f9b9db.jpg', 'image/jpeg', 'public', 'public', 66415, '[]', '[]', '[]', '[]', 132, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(147, 'App\\Models\\Bilta\\News', 10, 'a587a18c-1952-4b07-8d25-d5c09cd0c177', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.40_7958b295', 'WhatsApp-Image-2024-11-06-at-15.14.40_7958b295.jpg', 'image/jpeg', 'public', 'public', 82010, '[]', '[]', '[]', '[]', 133, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(148, 'App\\Models\\Bilta\\News', 10, '2cee9772-8fd5-4774-8409-24c132e2c432', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.41_667b16ae', 'WhatsApp-Image-2024-11-06-at-15.14.41_667b16ae.jpg', 'image/jpeg', 'public', 'public', 87184, '[]', '[]', '[]', '[]', 134, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(149, 'App\\Models\\Bilta\\News', 10, '9316691d-5a67-4c6c-a7c6-f9f1a68ce7c3', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.43_12c211aa', 'WhatsApp-Image-2024-11-06-at-15.14.43_12c211aa.jpg', 'image/jpeg', 'public', 'public', 93240, '[]', '[]', '[]', '[]', 135, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(150, 'App\\Models\\Bilta\\News', 10, 'ddcb2e0e-842c-466b-9735-4dc88b56832a', 'news_images', 'WhatsApp Image 2024-11-06 at 15.14.45_a1243dcd', 'WhatsApp-Image-2024-11-06-at-15.14.45_a1243dcd.jpg', 'image/jpeg', 'public', 'public', 128659, '[]', '[]', '[]', '[]', 136, '2024-11-13 19:27:20', '2024-11-13 19:27:20'),
(151, 'App\\Models\\Bilta\\OurTeam', 20, '598043fb-01eb-402f-a38f-36d8c4568157', 'team_images', 'WhatsApp Image 2024-12-06 at 10.05.55_a694da42', 'WhatsApp-Image-2024-12-06-at-10.05.55_a694da42.jpg', 'image/jpeg', 'public', 'public', 33848, '[]', '[]', '[]', '[]', 137, '2024-12-06 17:11:39', '2024-12-06 17:11:39'),
(152, 'App\\Models\\Bilta\\Projects', 7, '6716a676-b648-4d17-abc8-648df8ff510f', 'project_title_images', 'LAMBYA OBT', 'LAMBYA-OBT.png', 'image/png', 'public', 'public', 7700, '[]', '[]', '[]', '[]', 138, '2024-12-06 18:52:32', '2024-12-06 18:52:32'),
(153, 'App\\Models\\Bilta\\Projects', 7, '95cc21b2-e88f-4ba0-aef5-b17519fc07cb', 'project_images', 'LAMBYA OBT', 'LAMBYA-OBT.png', 'image/png', 'public', 'public', 7700, '[]', '[]', '[]', '[]', 139, '2024-12-06 18:52:32', '2024-12-06 18:52:32'),
(154, 'App\\Models\\Bilta\\Projects', 7, '2d9b7ae7-c527-4c38-a0c3-dd93aa122af4', 'project_files', 'LAMBYA OBT', 'LAMBYA-OBT.png', 'image/png', 'public', 'public', 7700, '[]', '[]', '[]', '[]', 140, '2024-12-06 18:52:32', '2024-12-06 18:52:32'),
(156, 'App\\Models\\Bilta\\News', 11, '94d34ab0-f457-49b2-94c9-1d7e02b1b0cf', 'news_title_images', 'IMG_2873', 'IMG_2873.jpg', 'image/jpeg', 'public', 'public', 2939378, '[]', '[]', '[]', '[]', 142, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(157, 'App\\Models\\Bilta\\News', 11, '1469c2ec-5817-46f2-8598-f9f42b699b7c', 'news_images', 'IMG_2352', 'IMG_2352.jpg', 'image/jpeg', 'public', 'public', 1805841, '[]', '[]', '[]', '[]', 143, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(158, 'App\\Models\\Bilta\\News', 11, '140d2297-4984-4817-9f31-0d33ea7c4482', 'news_images', 'IMG_2471', 'IMG_2471.jpg', 'image/jpeg', 'public', 'public', 2578185, '[]', '[]', '[]', '[]', 144, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(159, 'App\\Models\\Bilta\\News', 11, 'ba90a14f-9938-45a5-a080-14862c930f5d', 'news_images', 'IMG_2495', 'IMG_2495.jpg', 'image/jpeg', 'public', 'public', 1538898, '[]', '[]', '[]', '[]', 145, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(160, 'App\\Models\\Bilta\\News', 11, '8fa02e50-6eb4-434d-9cd3-bee98954186f', 'news_images', 'IMG_2550', 'IMG_2550.jpg', 'image/jpeg', 'public', 'public', 1761500, '[]', '[]', '[]', '[]', 146, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(161, 'App\\Models\\Bilta\\News', 11, 'dcb47bd3-3620-47a1-afc1-6e9bdd5df22d', 'news_images', 'IMG_2605', 'IMG_2605.jpg', 'image/jpeg', 'public', 'public', 2920049, '[]', '[]', '[]', '[]', 147, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(162, 'App\\Models\\Bilta\\News', 11, 'fa7f7ad4-f50a-43d9-9f2b-beb5227e11d5', 'news_images', 'IMG_2720', 'IMG_2720.jpg', 'image/jpeg', 'public', 'public', 3053388, '[]', '[]', '[]', '[]', 148, '2024-12-17 21:45:40', '2024-12-17 21:45:40'),
(163, 'App\\Models\\Bilta\\News', 11, '0bad7f34-4fe8-472d-b33f-fcd9f5554d25', 'news_images', 'IMG_2780', 'IMG_2780.jpg', 'image/jpeg', 'public', 'public', 2768647, '[]', '[]', '[]', '[]', 149, '2024-12-17 21:45:41', '2024-12-17 21:45:41'),
(164, 'App\\Models\\Bilta\\News', 11, '4b51e44a-d39e-4713-be22-cb792b6ae58c', 'news_images', 'IMG_2809', 'IMG_2809.jpg', 'image/jpeg', 'public', 'public', 3386893, '[]', '[]', '[]', '[]', 150, '2024-12-17 21:45:41', '2024-12-17 21:45:41'),
(165, 'App\\Models\\Bilta\\News', 11, '6ab8c2c8-2c00-41b2-ac99-071defa91594', 'news_images', 'IMG_2811', 'IMG_2811.jpg', 'image/jpeg', 'public', 'public', 2351075, '[]', '[]', '[]', '[]', 151, '2024-12-17 21:45:41', '2024-12-17 21:45:41'),
(166, 'App\\Models\\Bilta\\News', 11, 'ea1fac1e-299b-4f28-860e-3bb071597a58', 'news_images', 'IMG_2873', 'IMG_2873.jpg', 'image/jpeg', 'public', 'public', 2939378, '[]', '[]', '[]', '[]', 152, '2024-12-17 21:45:42', '2024-12-17 21:45:42'),
(167, 'App\\Models\\Bilta\\News', 12, '298ee953-8384-4037-b368-155f04e8f037', 'news_title_images', 'WhatsApp Image 2024-08-14 at 11.26.00_cf717872', 'WhatsApp-Image-2024-08-14-at-11.26.00_cf717872.jpg', 'image/jpeg', 'public', 'public', 100394, '[]', '[]', '[]', '[]', 153, '2024-12-18 01:35:08', '2024-12-18 01:35:08'),
(168, 'App\\Models\\Bilta\\News', 13, '9fe22f08-0fd7-4e91-a46f-947de5454e0f', 'news_title_images', 'IMG_2882', 'IMG_2882.jpg', 'image/jpeg', 'public', 'public', 2237712, '[]', '[]', '[]', '[]', 154, '2024-12-18 01:59:27', '2024-12-18 01:59:27'),
(174, 'App\\Models\\Bilta\\AudioFile', 3, '7a2931f3-6173-42e9-917c-4c3eced53c7d', 'audio_files', 'Luke_001_01-04__SGQPITP1DA', 'Luke_001_01-04__SGQPITP1DA.mp3', 'audio/mpeg', 'public', 'public', 264320, '[]', '[]', '[]', '[]', 157, '2024-12-23 18:00:06', '2024-12-23 18:00:06'),
(175, 'App\\Models\\Bilta\\AudioFile', 4, '08d3567e-e1d8-4fb2-8e95-063c66201221', 'audio_files', 'Luke_001_05-25__SGQPITP1DA', 'Luke_001_05-25__SGQPITP1DA.mp3', 'audio/mpeg', 'public', 'public', 1648768, '[]', '[]', '[]', '[]', 158, '2024-12-23 18:02:32', '2024-12-23 18:02:32'),
(176, 'App\\Models\\Bilta\\AudioFile', 5, '8d792129-8bd6-4e01-a7de-2e974b3fa8fe', 'audio_files', 'Luke_001_26-38__SGQPITP1DA', 'Luke_001_26-38__SGQPITP1DA.mp3', 'audio/mpeg', 'public', 'public', 909440, '[]', '[]', '[]', '[]', 159, '2024-12-23 18:03:36', '2024-12-23 18:03:36'),
(177, 'App\\Models\\Bilta\\News', 15, 'd3307545-2853-4018-9424-c61e0457399f', 'news_title_images', 'WhatsApp Image 2024-11-19 at 10.47.38_8139e150', 'WhatsApp-Image-2024-11-19-at-10.47.38_8139e150.jpg', 'image/jpeg', 'public', 'public', 463513, '[]', '[]', '[]', '[]', 160, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(178, 'App\\Models\\Bilta\\News', 15, '4a56ff9d-03d2-4685-8cff-ef1847ed042b', 'news_images', '462592344_959879116179723_7374743688003037923_n', '462592344_959879116179723_7374743688003037923_n.jpg', 'image/jpeg', 'public', 'public', 120847, '[]', '[]', '[]', '[]', 161, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(179, 'App\\Models\\Bilta\\News', 15, '6c24c898-c9ad-4e91-817b-1a5460de9157', 'news_images', '462627177_959878726179762_1778816013620411124_n', '462627177_959878726179762_1778816013620411124_n.jpg', 'image/jpeg', 'public', 'public', 183643, '[]', '[]', '[]', '[]', 162, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(180, 'App\\Models\\Bilta\\News', 15, '8eb0bbf5-c734-417a-a37c-8431174dfec4', 'news_images', '462685112_959878772846424_4667255535285152936_n', '462685112_959878772846424_4667255535285152936_n.jpg', 'image/jpeg', 'public', 'public', 172933, '[]', '[]', '[]', '[]', 163, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(181, 'App\\Models\\Bilta\\News', 15, 'bc9b97cf-7d51-4c0e-a223-b75f6e343a37', 'news_images', '462697439_959879156179719_6143298918643936146_n', '462697439_959879156179719_6143298918643936146_n.jpg', 'image/jpeg', 'public', 'public', 189656, '[]', '[]', '[]', '[]', 164, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(182, 'App\\Models\\Bilta\\News', 15, '475537e5-36b6-4d40-9c38-1183efcfcc9d', 'news_images', '462736003_959878996179735_8465872460401961969_n', '462736003_959878996179735_8465872460401961969_n.jpg', 'image/jpeg', 'public', 'public', 100663, '[]', '[]', '[]', '[]', 165, '2025-01-14 21:12:11', '2025-01-14 21:12:11'),
(183, 'App\\Models\\Bilta\\News', 16, '1ce285bd-f8da-4f36-9921-0f4ac4646c8e', 'news_title_images', '465737502_122179470284219840_7872754482560040832_n', '465737502_122179470284219840_7872754482560040832_n.jpg', 'image/jpeg', 'public', 'public', 42946, '[]', '[]', '[]', '[]', 166, '2025-01-20 16:18:27', '2025-01-20 16:18:27'),
(184, 'App\\Models\\Bilta\\News', 17, 'e8d07dd4-9168-452e-9f9c-0e3e30f1bef9', 'news_title_images', '465120839_122178962756219840_9154288736477012173_n', '465120839_122178962756219840_9154288736477012173_n.jpg', 'image/jpeg', 'public', 'public', 96407, '[]', '[]', '[]', '[]', 167, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(185, 'App\\Models\\Bilta\\News', 17, 'fdee60d0-8fab-43c5-942d-208666a9fd56', 'news_images', '464968976_122178962612219840_47838134883964938_n', '464968976_122178962612219840_47838134883964938_n.jpg', 'image/jpeg', 'public', 'public', 215846, '[]', '[]', '[]', '[]', 168, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(186, 'App\\Models\\Bilta\\News', 17, '079f856e-1728-4381-9a0e-2238db7296aa', 'news_images', '465120839_122178962756219840_9154288736477012173_n', '465120839_122178962756219840_9154288736477012173_n.jpg', 'image/jpeg', 'public', 'public', 96407, '[]', '[]', '[]', '[]', 169, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(187, 'App\\Models\\Bilta\\News', 17, '6262fa73-5bef-45b1-9e52-d8b53d5107f3', 'news_images', '465170065_122178962606219840_5848618700916145929_n', '465170065_122178962606219840_5848618700916145929_n.jpg', 'image/jpeg', 'public', 'public', 210335, '[]', '[]', '[]', '[]', 170, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(188, 'App\\Models\\Bilta\\News', 17, '0a53481b-faed-43e7-a823-c29216dfa247', 'news_images', '465181316_122178962618219840_4183971406201644645_n', '465181316_122178962618219840_4183971406201644645_n.jpg', 'image/jpeg', 'public', 'public', 297784, '[]', '[]', '[]', '[]', 171, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(189, 'App\\Models\\Bilta\\News', 17, '99a7f9c2-19b2-4c3a-8cf2-8645612473d5', 'news_images', '465375514_122178962732219840_6970813000026892612_n', '465375514_122178962732219840_6970813000026892612_n.jpg', 'image/jpeg', 'public', 'public', 88893, '[]', '[]', '[]', '[]', 172, '2025-01-20 16:28:13', '2025-01-20 16:28:13'),
(190, 'App\\Models\\Bilta\\OurTeam', 8, '2c386fa8-f94b-4b98-9acc-5d22332aa34f', 'team_images', 'WhatsApp Image 2025-04-01 at 14.33.25_81749631', 'WhatsApp-Image-2025-04-01-at-14.33.25_81749631.jpg', 'image/jpeg', 'public', 'public', 12359, '[]', '[]', '[]', '[]', 173, '2025-04-03 20:52:51', '2025-04-03 20:52:51'),
(191, 'App\\Models\\Bilta\\News', 14, '598903e7-9b7e-4b05-8cf8-b0df3f8faf6c', 'news_images', 'WhatsApp Image 2025-04-01 at 09.19.55_069e7526', 'WhatsApp-Image-2025-04-01-at-09.19.55_069e7526.jpg', 'image/jpeg', 'public', 'public', 121218, '[]', '[]', '[]', '[]', 174, '2025-04-17 11:31:07', '2025-04-17 11:31:07'),
(192, 'App\\Models\\Bilta\\News', 14, '0c213c8c-4c1c-4a22-9a79-0eeced1beb8a', 'news_title_images', 'WhatsApp Image 2025-04-01 at 09.19.55_069e7526', 'WhatsApp-Image-2025-04-01-at-09.19.55_069e7526.jpg', 'image/jpeg', 'public', 'public', 121218, '[]', '[]', '[]', '[]', 175, '2025-04-17 11:32:54', '2025-04-17 11:32:54'),
(193, 'App\\Models\\Bilta\\News', 18, 'a57d10ed-68ef-4189-a0e5-a359b8b62420', 'news_title_images', 'WhatsApp Image 2025-04-15 at 21.18.03_b1336ee4', 'WhatsApp-Image-2025-04-15-at-21.18.03_b1336ee4.jpg', 'image/jpeg', 'public', 'public', 152469, '[]', '[]', '[]', '[]', 176, '2025-04-17 11:53:49', '2025-04-17 11:53:49'),
(195, 'App\\Models\\Bilta\\News', 20, 'b266b811-1850-423b-896e-d2a47687063a', 'news_title_images', '489445362_122209874960219840_1480568319046005141_n', '489445362_122209874960219840_1480568319046005141_n.jpg', 'image/jpeg', 'public', 'public', 551670, '[]', '[]', '[]', '[]', 178, '2025-05-01 17:08:06', '2025-05-01 17:08:06'),
(196, 'App\\Models\\Bilta\\News', 20, '5c60d41e-b4b7-4c03-b098-026ca34d86c1', 'news_images', '488925575_122209874954219840_6520225973670526257_n', '488925575_122209874954219840_6520225973670526257_n.jpg', 'image/jpeg', 'public', 'public', 548571, '[]', '[]', '[]', '[]', 179, '2025-05-01 17:08:06', '2025-05-01 17:08:06'),
(198, 'App\\Models\\Bilta\\News', 21, '67a7ca24-e188-4779-88d4-aa9dd911d313', 'news_images', '490244390_690219996898693_3515846792328005183_n', '490244390_690219996898693_3515846792328005183_n.jpg', 'image/jpeg', 'public', 'public', 69254, '[]', '[]', '[]', '[]', 181, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(199, 'App\\Models\\Bilta\\News', 21, '272387e6-27d3-416c-a7a3-ab20526f51d8', 'news_images', '490283563_690219993565360_3882496165515699099_n', '490283563_690219993565360_3882496165515699099_n.jpg', 'image/jpeg', 'public', 'public', 61585, '[]', '[]', '[]', '[]', 182, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(200, 'App\\Models\\Bilta\\News', 21, '679df2d9-400b-436e-b5d4-d3060f3019af', 'news_images', '490388483_690219926898700_2488810519868774441_n', '490388483_690219926898700_2488810519868774441_n.jpg', 'image/jpeg', 'public', 'public', 31121, '[]', '[]', '[]', '[]', 183, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(201, 'App\\Models\\Bilta\\News', 21, 'dd73f582-1482-401c-b126-14489ef63850', 'news_images', '490413020_698348479231446_4679356752973031285_n', '490413020_698348479231446_4679356752973031285_n.jpg', 'image/jpeg', 'public', 'public', 492300, '[]', '[]', '[]', '[]', 184, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(202, 'App\\Models\\Bilta\\News', 21, '0bdbb010-3c38-4390-b4d0-f55a5f3c8912', 'news_images', '490472389_698348699231424_7251329049009459889_n', '490472389_698348699231424_7251329049009459889_n.jpg', 'image/jpeg', 'public', 'public', 325093, '[]', '[]', '[]', '[]', 185, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(203, 'App\\Models\\Bilta\\News', 21, 'f3f96969-2b8e-45d0-8123-95719d5fc92a', 'news_images', '490479397_690219943565365_8616641971018674395_n', '490479397_690219943565365_8616641971018674395_n.jpg', 'image/jpeg', 'public', 'public', 42647, '[]', '[]', '[]', '[]', 186, '2025-05-14 21:28:27', '2025-05-14 21:28:27');
INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(204, 'App\\Models\\Bilta\\News', 21, '9069d2ac-7c13-4bd8-b87e-9b11f7cebf36', 'news_images', '490507890_698348839231410_2664941052729798511_n', '490507890_698348839231410_2664941052729798511_n.jpg', 'image/jpeg', 'public', 'public', 381028, '[]', '[]', '[]', '[]', 187, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(205, 'App\\Models\\Bilta\\News', 21, '40353f12-5033-45bd-af13-8be8b0260da1', 'news_images', '490508295_698349185898042_3108365851662421033_n', '490508295_698349185898042_3108365851662421033_n.jpg', 'image/jpeg', 'public', 'public', 517256, '[]', '[]', '[]', '[]', 188, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(206, 'App\\Models\\Bilta\\News', 21, 'b6d3fe08-0616-4b67-a1d2-84b171737b7e', 'news_images', '490526163_698349122564715_2337301523306971613_n', '490526163_698349122564715_2337301523306971613_n.jpg', 'image/jpeg', 'public', 'public', 244569, '[]', '[]', '[]', '[]', 189, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(207, 'App\\Models\\Bilta\\News', 21, 'd037f3a7-385c-40e9-ae25-28b7113fc3e7', 'news_images', '490529388_690219933565366_3520251494762386892_n', '490529388_690219933565366_3520251494762386892_n.jpg', 'image/jpeg', 'public', 'public', 36716, '[]', '[]', '[]', '[]', 190, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(208, 'App\\Models\\Bilta\\News', 21, '845ea4cd-ce4b-42f3-8e7f-a28b54534c4e', 'news_images', '490557141_698348745898086_6185574091482877560_n', '490557141_698348745898086_6185574091482877560_n.jpg', 'image/jpeg', 'public', 'public', 399528, '[]', '[]', '[]', '[]', 191, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(209, 'App\\Models\\Bilta\\News', 21, '9a616997-8e1c-48b0-840b-5176aaa21214', 'news_images', '490650176_698347485898212_8704448478342977548_n', '490650176_698347485898212_8704448478342977548_n.jpg', 'image/jpeg', 'public', 'public', 232650, '[]', '[]', '[]', '[]', 192, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(210, 'App\\Models\\Bilta\\News', 21, '1b112a1a-260c-4194-9cb3-c126ba842fc6', 'news_images', '490702177_698348895898071_4138259962706898745_n', '490702177_698348895898071_4138259962706898745_n.jpg', 'image/jpeg', 'public', 'public', 430358, '[]', '[]', '[]', '[]', 193, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(211, 'App\\Models\\Bilta\\News', 21, '6430514e-a927-46be-835a-b2a9a53f771b', 'news_images', '490797481_698347649231529_4280378095187331352_n', '490797481_698347649231529_4280378095187331352_n.jpg', 'image/jpeg', 'public', 'public', 576496, '[]', '[]', '[]', '[]', 194, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(212, 'App\\Models\\Bilta\\News', 21, 'e159a279-b480-4be4-8d5b-3e3d1e7e7b55', 'news_images', '490832391_690219966898696_742662923879623929_n', '490832391_690219966898696_742662923879623929_n.jpg', 'image/jpeg', 'public', 'public', 46305, '[]', '[]', '[]', '[]', 195, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(213, 'App\\Models\\Bilta\\News', 21, 'a4c0056b-a3f2-47e9-9406-46b4ad9a8624', 'news_images', '491153398_690220010232025_351953132433795816_n', '491153398_690220010232025_351953132433795816_n.jpg', 'image/jpeg', 'public', 'public', 78417, '[]', '[]', '[]', '[]', 196, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(214, 'App\\Models\\Bilta\\News', 21, '763b753d-5fa5-44ac-aaba-47e0f1e44dee', 'news_images', '491304778_698347345898226_4054397770024679474_n', '491304778_698347345898226_4054397770024679474_n.jpg', 'image/jpeg', 'public', 'public', 338124, '[]', '[]', '[]', '[]', 197, '2025-05-14 21:28:27', '2025-05-14 21:28:27'),
(215, 'App\\Models\\Bilta\\News', 21, '8bf782e3-e279-44eb-b3d5-2b33085db487', 'news_title_images', 'HUD_9495', 'HUD_9495.jpeg', 'image/jpeg', 'public', 'public', 4612198, '[]', '[]', '[]', '[]', 198, '2025-05-14 21:41:12', '2025-05-14 21:41:12'),
(216, 'App\\Models\\Bilta\\News', 22, '60fc5081-d781-4347-aa29-9c16e23f56bb', 'news_title_images', 'Untitled design (11)', 'Untitled-design-(11).png', 'image/png', 'public', 'public', 453343, '[]', '[]', '[]', '[]', 199, '2025-05-14 21:49:48', '2025-05-14 21:49:48'),
(217, 'App\\Models\\Bilta\\News', 22, '6ebc6895-bfdb-4833-ae12-8ee73d22bf8a', 'news_images', 'Untitled design (11)', 'Untitled-design-(11).png', 'image/png', 'public', 'public', 453343, '[]', '[]', '[]', '[]', 200, '2025-05-14 21:49:48', '2025-05-14 21:49:48'),
(220, 'App\\Models\\Bilta\\OurTeam', 21, '1f1668fd-5fbe-429b-9b6b-9f142a53af77', 'team_images', 'whatsapp', 'whatsapp.jpg', 'image/jpeg', 'public', 'public', 386927, '[]', '[]', '[]', '[]', 203, '2025-05-15 21:05:42', '2025-05-15 21:05:42'),
(222, 'App\\Models\\Bilta\\OurTeam', 22, '792e3324-a047-456c-9ef3-54680fab8d83', 'team_images', 'WhatsApp Image 2025-05-19 at 18.39.57_3f9f2134', 'WhatsApp-Image-2025-05-19-at-18.39.57_3f9f2134.jpg', 'image/jpeg', 'public', 'public', 59706, '[]', '[]', '[]', '[]', 204, '2025-05-24 03:27:34', '2025-05-24 03:27:34'),
(224, 'App\\Models\\Bilta\\OurTeam', 24, '0a96dbe6-3d0b-4cd2-8a7c-5a6b32a5f994', 'team_images', 'WhatsApp Image 2025-05-15 at 16.46.34_6c887ac4', 'WhatsApp-Image-2025-05-15-at-16.46.34_6c887ac4.jpg', 'image/jpeg', 'public', 'public', 56824, '[]', '[]', '[]', '[]', 205, '2025-05-29 15:01:25', '2025-05-29 15:01:25'),
(225, 'App\\Models\\Bilta\\OurTeam', 25, '61ed9e55-015d-470b-8ef9-356568bdadef', 'team_images', 'whatsapp', 'whatsapp.jpg', 'image/jpeg', 'public', 'public', 386927, '[]', '[]', '[]', '[]', 206, '2025-05-29 15:24:02', '2025-05-29 15:24:02'),
(226, 'App\\Models\\Bilta\\OurTeam', 26, '908c330b-d78d-4a1b-91b0-fc42a5209651', 'team_images', 'WhatsApp Image 2025-05-19 at 17.52.11_9cd8aa41', 'WhatsApp-Image-2025-05-19-at-17.52.11_9cd8aa41.jpg', 'image/jpeg', 'public', 'public', 438407, '[]', '[]', '[]', '[]', 207, '2025-05-29 15:35:30', '2025-05-29 15:35:30'),
(227, 'App\\Models\\Bilta\\OurTeam', 27, '039c603e-aa6e-4843-8805-66b1ee757719', 'team_images', 'WhatsApp Image 2024-12-06 at 10.05.55_5437e550', 'WhatsApp-Image-2024-12-06-at-10.05.55_5437e550.jpg', 'image/jpeg', 'public', 'public', 33848, '[]', '[]', '[]', '[]', 208, '2025-05-29 15:49:31', '2025-05-29 15:49:31'),
(228, 'App\\Models\\Bilta\\OurTeam', 28, '7aa25f0e-12aa-4aa2-a7df-12c8d423ac67', 'team_images', 'dfcbf9097c18e4a9b2a36b221764946e', 'dfcbf9097c18e4a9b2a36b221764946e.jpg', 'image/jpeg', 'public', 'public', 46876, '[]', '[]', '[]', '[]', 209, '2025-05-29 16:08:56', '2025-05-29 16:08:56'),
(229, 'App\\Models\\Bilta\\OurTeam', 29, 'b1455ccc-fe7a-4947-8e93-47feaeb76c5b', 'team_images', 'WhatsApp Image 2025-05-19 at 09.13.48_6f5e1dcf', 'WhatsApp-Image-2025-05-19-at-09.13.48_6f5e1dcf.jpg', 'image/jpeg', 'public', 'public', 19029, '[]', '[]', '[]', '[]', 210, '2025-05-29 16:39:41', '2025-05-29 16:39:41'),
(230, 'App\\Models\\Bilta\\OurTeam', 23, 'ebb44c14-35da-4d27-9959-81cd77e7dab3', 'team_images', 'IMG_2919', 'IMG_2919.JPG', 'image/jpeg', 'public', 'public', 3482794, '[]', '[]', '[]', '[]', 211, '2025-05-29 20:46:27', '2025-05-29 20:46:27'),
(231, 'App\\Models\\Bilta\\OurTeam', 30, 'e7c42a29-57fa-461f-bde4-d46612d7b734', 'team_images', 'WhatsApp Image 2025-05-19 at 18.39.57_3f9f2134', 'WhatsApp-Image-2025-05-19-at-18.39.57_3f9f2134.jpg', 'image/jpeg', 'public', 'public', 59706, '[]', '[]', '[]', '[]', 212, '2025-05-29 21:51:13', '2025-05-29 21:51:13'),
(232, 'App\\Models\\Bilta\\OurTeam', 31, '454c195e-3a6b-41c8-8d66-e5287157c7c7', 'team_images', 'WhatsApp Image 2025-05-15 at 16.46.34_6c887ac4', 'WhatsApp-Image-2025-05-15-at-16.46.34_6c887ac4.jpg', 'image/jpeg', 'public', 'public', 56824, '[]', '[]', '[]', '[]', 213, '2025-05-29 21:55:20', '2025-05-29 21:55:20'),
(233, 'App\\Models\\Bilta\\OurTeam', 32, 'd1ee6023-9793-4f65-b01f-bf30803e08ba', 'team_images', 'whatsapp', 'whatsapp.jpg', 'image/jpeg', 'public', 'public', 386927, '[]', '[]', '[]', '[]', 214, '2025-05-29 22:01:39', '2025-05-29 22:01:39'),
(234, 'App\\Models\\Bilta\\OurTeam', 33, 'd6dfc426-8e9e-4391-a768-8e0b1d8fb3f0', 'team_images', 'WhatsApp Image 2025-05-19 at 17.52.11_9cd8aa41', 'WhatsApp-Image-2025-05-19-at-17.52.11_9cd8aa41.jpg', 'image/jpeg', 'public', 'public', 438407, '[]', '[]', '[]', '[]', 215, '2025-05-29 22:12:13', '2025-05-29 22:12:13'),
(235, 'App\\Models\\Bilta\\OurTeam', 34, 'b74c55d9-be20-4320-ac26-349a298afe8a', 'team_images', 'WhatsApp Image 2024-12-06 at 10.05.55_5437e550', 'WhatsApp-Image-2024-12-06-at-10.05.55_5437e550.jpg', 'image/jpeg', 'public', 'public', 33848, '[]', '[]', '[]', '[]', 216, '2025-05-29 22:15:35', '2025-05-29 22:15:35'),
(236, 'App\\Models\\Bilta\\Projects', 5, 'f1433177-01ac-447a-b823-798a3f1d97bd', 'project_title_images', 'Senga Project', 'Senga-Project.png', 'image/png', 'public', 'public', 4230, '[]', '[]', '{\"thumb\":true}', '[]', 217, '2025-05-30 16:09:15', '2025-05-30 16:09:15'),
(238, 'App\\Models\\Bilta\\Projects', 6, '3ca00536-b413-4862-8185-0d0cedd11148', 'project_title_images', 'Fungwe Project', 'Fungwe-Project.png', 'image/png', 'public', 'public', 4367, '[]', '[]', '{\"thumb\":true}', '[]', 218, '2025-05-30 16:16:18', '2025-05-30 16:16:18'),
(239, 'App\\Models\\Bilta\\News', 23, 'ad8d88ad-9294-4dcf-a4e1-db303b42f5d9', 'news_title_images', 'IMG_0268', 'IMG_0268.jpg', 'image/jpeg', 'public', 'public', 2540710, '[]', '[]', '[]', '[]', 219, '2025-06-30 20:08:52', '2025-06-30 20:08:52'),
(240, 'App\\Models\\Bilta\\News', 23, '0be56c50-11e5-4863-9b1a-fc982c1c7249', 'news_images', 'IMG_0268', 'IMG_0268.jpg', 'image/jpeg', 'public', 'public', 2540710, '[]', '[]', '[]', '[]', 220, '2025-06-30 20:08:52', '2025-06-30 20:08:52'),
(241, 'App\\Models\\Bilta\\ChairmanMessage', 1, 'b0cca3a5-9825-44e2-80e5-9f2e7e94128f', 'chairman_photo', '465849942_10160489096166080_878661958', '465849942_10160489096166080_878661958.jpg', 'image/jpeg', 'public', 'public', 160113, '[]', '[]', '[]', '[]', 221, '2025-07-28 17:48:47', '2025-07-28 17:48:47'),
(242, 'App\\Models\\Bilta\\News', 19, 'b0ae4f5b-e6e6-4fe6-83b6-73b559d93165', 'news_title_images', 'IMG_0221', 'IMG_0221.jpg', 'image/jpeg', 'public', 'public', 2741673, '[]', '[]', '[]', '[]', 222, '2025-10-28 16:20:51', '2025-10-28 16:20:51'),
(243, 'App\\Models\\Bilta\\News', 24, '0fd7e4b5-52b0-4937-8545-c4ca43f0921c', 'news_title_images', 'IMG_0039', 'IMG_0039.jpg', 'image/jpeg', 'public', 'public', 685085, '[]', '[]', '[]', '[]', 223, '2025-10-28 20:43:44', '2025-10-28 20:43:44'),
(244, 'App\\Models\\Bilta\\News', 25, '0e9d955c-562d-448c-8c31-5c8ff7a638e7', 'news_title_images', '494622689_122215053500219840_195919006885500725_n', '494622689_122215053500219840_195919006885500725_n.jpg', 'image/jpeg', 'public', 'public', 555590, '[]', '[]', '[]', '[]', 224, '2025-11-06 21:52:21', '2025-11-06 21:52:21'),
(246, 'App\\Models\\Bilta\\News', 26, '1d1933c5-4293-4f7e-bd68-991a4560d5b6', 'news_title_images', 'featureimageOBTOBS-768x512', 'featureimageOBTOBS-768x512.jpg', 'image/jpeg', 'public', 'public', 36108, '[]', '[]', '[]', '[]', 225, '2025-11-07 16:43:20', '2025-11-07 16:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_02_26_024543_create_permissions_table', 1),
(6, '2023_02_26_024606_create_roles_table', 1),
(7, '2023_02_26_024730_create_roles_permissions_table', 1),
(8, '2023_02_26_024756_create_users_permissions_table', 1),
(9, '2023_02_26_024817_create_users_roles_table', 1),
(10, '2023_03_04_095115_create_statuses_table', 2),
(11, '2023_04_15_204625_create_about_us_table', 3),
(12, '2023_04_15_204646_create_contact_us_table', 3),
(13, '2023_04_16_060753_create_our_values_table', 3),
(14, '2023_04_16_060823_create_our_services_table', 3),
(15, '2023_04_16_135503_create_f_a_qs_table', 3),
(16, '2023_04_16_140817_create_weekly_prayer_points_table', 3),
(17, '2023_04_16_144745_create_our_teams_table', 3),
(24, '2023_04_26_093024_create_media_table', 4),
(19, '2023_04_24_071158_create_testmonies_table', 3),
(20, '2023_04_24_075223_create_news_table', 3),
(21, '2023_04_24_075309_create_projects_table', 3),
(22, '2023_04_24_075336_create_videos_table', 3),
(23, '2023_04_24_075351_create_galleries_table', 3),
(25, '2023_04_28_063215_create_testimonial_table', 5),
(26, '2023_09_27_072703_create_news_item_table', 6),
(27, '2024_11_12_201256_create_contact_messages_table', 7),
(28, '2024_12_14_080546_create_audio_files_table', 8),
(29, '2025_05_15_080708_create_chairman_messages_table', 9),
(30, '2025_05_17_082841_create_audio_comments_table', 10),
(31, '2025_05_30_120606_create_cookie_consents_table', 11),
(32, '2025_06_27_110150_create_sponsors_table', 12),
(33, '2025_06_27_133427_create_clicks_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `news_item`
--

CREATE TABLE `news_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_description` mediumtext NOT NULL,
  `post_date` varchar(191) NOT NULL,
  `author` varchar(191) NOT NULL,
  `details` longtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_item`
--

INSERT INTO `news_item` (`id`, `title`, `short_description`, `post_date`, `author`, `details`, `created_by`, `status_id`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mwenyi (OBT) Community check', '31/01/2024\nMwenyi Oral Bible Translation (OBT) in Kalabo district of Western province of Zambia.\nA first ever community check which has attracted 10 participants in Kalabo district is coming to an end this evening.\nSpeaking to the Exegete of Kalabo Oral Bible Translation Dr Kwalombata  of Mwenyi speaking people in  Western Province says a three days community check which has attracted participants  from three different chiefdoms namely Loke,salunda and Kakuya respectively.\n The participants have expressed happiness with the involvement of community participation which is coming to an end this evening is over whelming.\nDr Kwalombata has said the people participating in community check have shown supportiveness to Oral Bible Translation programme being the first people to attend community check despite to the far distance places where they have come from.', '2024-02-02', 'BiLTA media team', '31/01/2024                                                      \nA first ever community check which has attracted 10 participants in Kalabo district is coming to an end this evening.\nSpeaking to the Exegete of Kalabo Oral Bible Translation Dr Kwalombata  of Mwenyi speaking people in  Western Province says a three days community check which has attracted participants  from three different chiefdoms namely Loke,salunda and Kakuya respectively.\n The participants have expressed happiness with the involvement of community participation which is coming to an end this evening is over whelming.\nDr Kwalombata has said the people participating in community check have shown supportiveness to Oral Bible Translation programme being the first people to attend community check despite to the far distance places where they have come from.', 1, 1, 31, '2024-02-01 21:32:09', '2025-01-18 20:18:32', NULL),
(2, 'Senga Oral Bible Translation (OBT) Community check', '01/09/23.\nSenga Oral Bible Translation in Chama district of Eastern province.\nA four day community check which involved 14 Participates from seven chiefdoms in the district has come to an end today.\nThe meeting which started on Tuesday this week for Chama BiLTA office was meant to review the drafts done by members of staff.\nThe local committee Vice chairperson Rev Wezzie Ziba has thanked the participants for the persistence shown while doing the work accordingly.\nAnd a community reviewer from Chibale chiefdom Bridget Kango appreciated the work.\nThe Rev has declared the meeting closed.\nMeanwhile,both the local chairperson Rev Saiwel Mvula and the treasure Mr Multiply Zero Zimba were present.', '2024-02-02', 'BiLTA media team', '<p><strong>Date:</strong> 01/09/23</p>\n\n<p>A four-day community check, involving 14 participants from seven chiefdoms in the district, has come to an end today.</p>\n\n<p>The meeting, which began on Tuesday this week at the Chama BiLTA office, was intended to review the drafts prepared by staff members.</p>\n\n<p>The local committee Vice Chairperson, Rev. Wezzie Ziba, thanked the participants for their dedication and persistence in completing the work as required.</p>\n\n<p>Additionally, a community reviewer from Chibale Chiefdom, Bridget Kango, expressed appreciation for the work done.</p>\n\n<p>Rev. Ziba has officially declared the meeting closed.</p>\n\n<p>Meanwhile, both the local Chairperson, Rev. Saiwel Mvula, and the Treasurer, Mr. Multiply Zero Zimba, were present.</p>\n', 1, 1, 34, '2024-02-02 15:16:23', '2025-01-18 20:17:49', NULL),
(3, 'Oral Bible Translation consultative conference', '23/03/23\nThe Oral Bible Translation Consultative and engagement training started on 21st March,2023 in Lusaka.\nThe three days  Consultative Oral Bible engagement training which started on Tuesday  attracted different people from various different chrch mother bodies in Zambia.\nThe five church mother bodies being invited to attend the training are the council of churches in Zambia(CCZ), Evangelical fellowship of Zambia(EFZ), independent churches of Zambia(ICOZ) and Zambian Conference of Catholic Bishops(ZCCB)..\nOthers are government officials from ministry of education, ministry of information,local government and Guidance religious affairs under the office of the vice president.\nThe purpose of the training is to discuss and come up with the recommendations on how the Oral translated scripture, virtually,sign language and written scriptures can be used as a tool of evangelism through media, education,in chiefdoms  and the society.\nThe Consultative training which is being organized by three Bible translation bodies which is being held at Cathedral of the Holy cross in Lusaka are  Bible literature and  translation Association (BilTA), Bible society of Zambia and the word for the world in partnership with the American Bible translation institution Faith comes by Hearing  FCBH. \nThe vice national secretary for BiLTA Apostle Vincent Chibesa has confirmed for training which is being conducted in Lusaka.\nThe closing ceremony today will be done by the vice president of Zambia Mutale Nalumango at cathedral of the Holy cross in Lusaka where the training is being conducted.', '2024-02-12', 'BiLTA media team', '<p><strong>Date:</strong> 23/03/23</p>\n\n<p>The Oral Bible Translation Consultative and Engagement Training started on 21st March 2023 in Lusaka.</p>\n\n<p>The three-day Consultative Oral Bible Engagement Training, which began on 21st March 2023, attracted participants from various church mother bodies across Zambia.</p>\n\n<p>The five church mother bodies invited to attend the training include the Council of Churches in Zambia (CCZ), Evangelical Fellowship of Zambia (EFZ), Independent Churches of Zambia (ICOZ), and the Zambian Conference of Catholic Bishops (ZCCB).</p>\n\n<p>Other attendees include government officials from the Ministry of Education, Ministry of Information, Local Government, and Guidance and Religious Affairs under the Office of the Vice President.</p>\n\n<p>The purpose of the training is to discuss and develop recommendations on how Oral Translated Scripture, as well as virtual, sign language, and written scriptures, can be used as tools for evangelism through media, education, in chiefdoms, and within society.</p>\n\n<p>The consultative training, organized by three Bible translation bodies—Bible Literature and Translation Association (BiLTA), Bible Society of Zambia, and The Word for the World—in partnership with the American Bible translation institution Faith Comes By Hearing (FCBH), is being held at the Cathedral of the Holy Cross in Lusaka.</p>\n\n<p>Apostle Vincent Chibesa, the Vice National Secretary for BiLTA, confirmed the training, which is currently taking place in Lusaka.</p>\n\n<p>The closing ceremony will be conducted today by the Vice President of Zambia, Mutale Nalumango, at the Cathedral of the Holy Cross in Lusaka, where the training is being held.</p>\n', 1, 1, 16, '2024-02-12 21:57:26', '2025-01-18 20:17:03', NULL),
(4, 'Global conference on Oral Bible Translation', 'It was awesome to represent BiLTA at the Global Conference on Oral Bible Translation held in Uganda -Entebbe.\nBiLTA in partnership with Faith Comes by Hearing (FCBH) show cased the Senga Documentary filmed in Chama District.\nThe film was a motivation and encouragement to many smaller languages seeking to have a Bible in their own mother language.\nThe struggles and endurance shown by the Senga people through the documentary attracted a lot of experts and practitioners of the Bible translation world over to pursue God\'s call and help their own local languages to have a Bible and not just depend on people from outside.\nMay I take this opportunity to thank the BiLTA team for the hard work which has enabled their efforts to be recognized world over by the grace of God.\nCongratulations team BiLTA \nTo God be the glory', '2024-02-12', 'BiLTA media team', '<p>It was awesome to represent BiLTA at the Global Conference on Oral Bible Translation held in Entebbe, Uganda.</p>\n\n<p>BiLTA, in partnership with Faith Comes by Hearing (FCBH), showcased the Senga documentary filmed in Chama District.</p>\n\n<p>The film served as motivation and encouragement to many smaller language communities seeking to have a Bible in their own mother language.</p>\n\n<p>The struggles and endurance shown by the Senga people in the documentary inspired many experts and practitioners in the Bible translation community to pursue God\'s call and assist their own local languages in having a Bible, rather than relying solely on external support.</p>\n\n<p>May I take this opportunity to thank the BiLTA team for their hard work, which has enabled their efforts to be recognized globally by the grace of God.</p>\n\n<p><strong>Congratulations, team BiLTA!</strong></p>\n\n<p><em>To God be the glory.</em></p>\n', 1, 1, 33, '2024-02-12 22:28:47', '2025-01-18 20:19:56', NULL),
(5, 'Kunda Oral Bible graduation ceremony', 'GRADUATION CERMONY                                   \n11-02-2024.\nA three-week Oral bible translation Training that started on 22nd January, ended on 9th February, 2024 for the Kunda speaking people ended with a graduation ceremony at Msimbiti lodge in Mambwe district of Eastern province in Mfuwe area.\n The graduation Ceremony was graced by Hon. Peter Saimon Phiri, Malambo Constituency Member of Parliament (MP) who is also Eastern Province Minister.\nThe event attracted members from different walks of life. Among them in attendance were the BiLTA Executive Vice Chairperson, Rev. Ezekiel Ngulube and the Executive Treasurer Mr Mtumbi Goma. Others in attendance included the chairperson for Kunda Bible Translation and Literacy (KBTL) Dr. Geoffrey Tambukukani and the local leadership His Royal Highness chief Munkhanya and Rev Godfrey Muchinshi of Pentecostal assemblies of God  and also George Banda, kakumbi ward councilor in malambo constituency.\nIn his address on behalf of the Kunda speaking people and indeed the government, the guest of honor expressed happiness to see the Old Testament part of the Bible being translated.\nHe also said employing nine people also meant meeting the government policy of trying to offload people from the street.\nThe Guest of honor thanked the team of trainers for the training provided. the workshop trained nine (9) translators two (2) security officers. The trainers were Joseph Wambula from Tanzania under Faith Comes By Hearing (FCBH) and Bertha Chilembo shawa and Clement Kaonga both from BiLTA.', '2024-02-26', 'BiLTA media team', '<h2>Graduation Ceremony</h2>\n<p><strong>Date:</strong> 11-02-2024</p>\n\n<p>A three-week Oral Bible Translation Training that began on 22nd January and concluded on 9th February 2024 for the Kunda-speaking people ended with a graduation ceremony at Msimbiti Lodge in Mambwe District of the Eastern Province, in the Mfuwe area.</p>\n\n<p>The graduation ceremony was graced by Hon. Peter Saimon Phiri, Malambo Constituency Member of Parliament (MP) and Eastern Province Minister.</p>\n\n<p>The event attracted attendees from various backgrounds, including the BiLTA Executive Vice Chairperson, Rev. Ezekiel Ngulube, and the Executive Treasurer, Mr. Mtumbi Goma. Also present were the Chairperson for Kunda Bible Translation and Literacy (KBTL), Dr. Geoffrey Tambukukani, His Royal Highness Chief Munkhanya, Rev. Godfrey Muchinshi of the Pentecostal Assemblies of God, and George Banda, Kakumbi Ward Councilor in Malambo Constituency.</p>\n\n<p>In his address on behalf of the Kunda-speaking people and the government, the guest of honor expressed joy at witnessing the translation of the Old Testament into the Kunda language. He also noted that the employment of nine people aligns with the government’s policy to reduce unemployment.</p>\n\n<p>The guest of honor extended gratitude to the team of trainers for their work. The workshop trained nine translators and two security officers. The trainers included Joseph Wambula from Tanzania (under Faith Comes By Hearing), along with Bertha Chilembo Shawa and Clement Kaonga, both from BiLTA.</p>\n', 1, 1, 31, '2024-02-14 16:37:58', '2025-01-18 20:03:04', NULL),
(6, 'Kunda Oral Bible Translation Training', '10/02/24                   \nThe Bible and Literature Translation Association (BILTA) says there vision is to reach beyond Southern Africa in Oral Bible Translation for minor languages which have been left out.\nThe Association Vice Chairperson Rev Ezekiel Ngulube was speaking on behalf of the Association Chairperson Fr. Jackson Jones Katete on the 08th February, 2024 at Msimbiti Lodge said the whole idea about this is to translate the word of God into local languages. \nFather Katete said The Oral Bible Translation training is an important skill to translate the Bible into local languages especially for people who may not have the capacity to read and write.\nThe chairperson said the objective of the training is to preserve the linguistic culture of the local people as well as disseminating the gospel into their own local languages, \nHe further said (BiLTA) believes that they can bring the word of God to the people who are unable to read the word of God so that when it is done orally it will be very easy for them to understand it in their own language.\nHe was speaking during a graduation ceremony and a launch of the Oral Bible of the Kunda speaking people of Mfuwe after a training for three weeks on how they can become professional translators.\nFr Jackson Katete disclosed that they decided to transition from Senga Bible Literature Association to Bible and Literature Translation Association (BiLTA) in order to cover the entire Nation and our surrounded neighbouring Countries. \nHe mentioned that so far BiLTA has opened more than 10 offices across the country. \nFr Katete called for the greater involvement of the church in the utilization of the translated materials, especially for the benefit of the people who cannot understand other languages.\nMoreover, the chairperson has appealed to the the local people to take pride in using their heart languages and that they should not feel inferior to speak their own language. \nThe Chairperson has however, requested the people to passionately continue supporting this initiative which God has brought to the people of Mfuwe and have applauded the support from the royal highness, the community and the churches. \nThe training had nine participants from within Mfuwe with three trainers from Bible Literature Translation Association of Zambia (BiLTA) and Faith Comes By Hearing (FCBH) Tanzania respectively.', '2024-02-26', 'BiLTA media team', '<p><strong>Date:</strong> 10/02/24</p>\n\n<p>The Bible and Literature Translation Association (BiLTA) has expressed its vision to expand Oral Bible Translation for minor languages beyond Southern Africa, aiming to reach communities that have been previously overlooked.</p>\n\n<p>Speaking on behalf of Association Chairperson Fr. Jackson Jones Katete, Association Vice Chairperson Rev. Ezekiel Ngulube stated on 8th February 2024 at Msimbiti Lodge that the goal is to translate the word of God into local languages.</p>\n\n<p>Fr. Katete emphasized that Oral Bible Translation training is a valuable skill for translating the Bible into local languages, especially for those who may lack literacy skills. The training’s objective, he explained, is to preserve local linguistic culture while sharing the gospel in native languages.</p>\n\n<p>Fr. Katete further explained that BiLTA believes in bringing the word of God to people who are unable to read, making it easier for them to understand the message in their own language when it is delivered orally.</p>\n\n<p>He made these remarks during the graduation ceremony and launch of the Oral Bible for the Kunda-speaking people of Mfuwe, following a three-week training to help participants become skilled translators.</p>\n\n<p>Fr. Jackson Katete disclosed that BiLTA transitioned from the Senga Bible Literature Association to the Bible and Literature Translation Association (BiLTA) to cover the entire nation as well as neighboring countries. He noted that BiLTA has so far opened over ten offices across Zambia.</p>\n\n<p>Fr. Katete called for increased church involvement in utilizing translated materials, particularly to benefit those who do not understand other languages.</p>\n\n<p>He also encouraged local communities to take pride in using their native languages and to avoid feeling inferior when speaking them. The Chairperson requested continued support from the people for this initiative, which he believes is a blessing from God for the people of Mfuwe. He also acknowledged the support from the royal highness, the community, and local churches.</p>\n\n<p>The training included nine participants from Mfuwe, led by three trainers from the Bible Literature Translation Association of Zambia (BiLTA) and Faith Comes By Hearing (FCBH) in Tanzania.</p>\n', 1, 1, 31, '2024-02-26 22:26:10', '2025-01-18 20:02:18', NULL),
(7, 'Chikunda OBT Training', '21-02-2024\nA three week training for the Chikunda Oral Bible Translation of Feira in Luangwa district of Lusaka Province which started on 12th February, 2024 is progressing well has reached an advanced stage of community check. the community check attracted 4 mother tongue speakers of Kapyanika and Soweto villages under Chief Mphuka of Luangwa district.\nThomas Phiri of Kapyanika Village from Baptist church was very much surprised with the work done and something which he did not expect, \"Is that how the Audio Bible will be produced in Chikunda\"? he surprisingly asked. He was impressed with the process of technology and in his observation as he was involved in community check, said this work need someone in good mood and not in a misunderstanding and fighting situations.\nHe also said, will inform his fellow Christians at Baptist church that will put the project and staff in Prayers for smoothly running of Gods work.\nIn another development Bernard Tembo of EFETA ministries on behalf of the community check team from Soweto village of chief Mphuka thanked the BiLTA staff of Chikunda for involving them in the community check which is was interesting and it’s a plus for the first team for the establishment of \n the Chikunda Audio Bible in the district which is being translated in their mother tongue language.', '2024-02-26', 'BiLTA media team', '21-02-2024\nA three week training for the Chikunda Oral Bible Translation of Feira in Luangwa district of Lusaka Province which started on 12th February, 2024 is progressing well has reached an advanced stage of community check. the community check attracted 4 mother tongue speakers of Kapyanika and Soweto villages under Chief Mphuka of Luangwa district.\nThomas Phiri of Kapyanika Village from Baptist church was very much surprised with the work done and something which he did not expect, \"Is that how the Audio Bible will be produced in Chikunda\"? he surprisingly asked. He was impressed with the process of technology and in his observation as he was involved in community check, said this work need someone in good mood and not in a misunderstanding and fighting situations.\nHe also said, will inform his fellow Christians at Baptist church that will put the project and staff in Prayers for smoothly running of Gods work.\nIn another development Bernard Tembo of EFETA ministries on behalf of the community check team from Soweto village of chief Mphuka thanked the BiLTA staff of Chikunda for involving them in the community check which is was interesting and it’s a plus for the first team for the establishment of \n the Chikunda Audio Bible in the district which is being translated in their mother tongue language.', 3, 1, 31, '2024-02-27 00:30:43', '2025-05-31 00:23:56', NULL),
(8, 'Tambo and Lambya office launch', 'Lambya and Tambo Oral Bible Transaltion (OBT) launch\n 15/12/22\nThe Bible and Literature Translation Association in collaboration with the local churches and the Lambya Royal Establishment have embarked on the translation of the Bible into Chitambo and Chilambya for meaningful transformation of the local population through the word of God and for the revival and preservation of the local languages through its utilization in churches, schools and cultural events.\nBILTA has for the past two years been working hard to study viability and vitality of  the Chitambo and Chilambya languages through a survey which resulted into the establishment of the translation work.\nThe guest of honor was very grateful to be part of the important occasion which took place at lsoka council hall. The launch and the graduation ceremony which was attended by different church leaders, government departments and from the community respectively.\nThe DC Mr. Colings Sichivula of Isoka District in Muchinga Province in his speech said Government and the church have been partners from time of memorial to date.\nHowever, the DC also said there has been development whenever the government and Christian Organizations work together.\nThe DC said government has not performed according to the people\'s expectations but the church has been there to supplement. Mr. Colings Sichivula said Government will be looking forward to be having many materials in the local languages that will help people understand the word  of God.\nThe cluster team of fourteen Oral Bible translators graduated and were trained by Bio Athanase from Benin, Maikell Solomon and Ibrahim Amish both from Nigeria and Bertha Chilembo a trainer in training from BiLTA Zambia.\nThe National vice secretary for BiLTA Apostle Vincent Chibesa congratulated the team for the hard work shown during the training.\nThe Launch and graduation ceremony for Chilambya speaking people of chief Mwanawisi and Chitambo speaking people of Chief Katyetye was launched at lsoka council Hall in lsoka District of Muchinga Province of Zambia.', '2024-02-26', 'BiLTA media team', 'Lambya and Tambo Oral Bible Transaltion (OBT) launch\n 15/12/22\nThe Bible and Literature Translation Association in collaboration with the local churches and the Lambya Royal Establishment have embarked on the translation of the Bible into Chitambo and Chilambya for meaningful transformation of the local population through the word of God and for the revival and preservation of the local languages through its utilization in churches, schools and cultural events.\nBILTA has for the past two years been working hard to study viability and vitality of  the Chitambo and Chilambya languages through a survey which resulted into the establishment of the translation work.\nThe guest of honor was very grateful to be part of the important occasion which took place at lsoka council hall. The launch and the graduation ceremony which was attended by different church leaders, government departments and from the community respectively.\nThe DC Mr. Colings Sichivula of Isoka District in Muchinga Province in his speech said Government and the church have been partners from time of memorial to date.\nHowever, the DC also said there has been development whenever the government and Christian Organizations work together.\nThe DC said government has not performed according to the people\'s expectations but the church has been there to supplement. Mr. Colings Sichivula said Government will be looking forward to be having many materials in the local languages that will help people understand the word  of God.\nThe cluster team of fourteen Oral Bible translators graduated and were trained by Bio Athanase from Benin, Maikell Solomon and Ibrahim Amish both from Nigeria and Bertha Chilembo a trainer in training from BiLTA Zambia.\nThe National vice secretary for BiLTA Apostle Vincent Chibesa congratulated the team for the hard work shown during the training.\nThe Launch and graduation ceremony for Chilambya speaking people of chief Mwanawisi and Chitambo speaking people of Chief Katyetye was launched at lsoka council Hall in lsoka District of Muchinga Province of Zambia.', 1, 1, 31, '2024-02-27 01:14:11', '2025-01-14 21:19:10', NULL),
(9, 'Fungwe Oral Bible Translation Traininig and launch', 'The Fungwe Oral Bible Translation training which commenced on 10th October came to an end on 28th October, 2022 and attracted six (6) participants from within the areas of Nhtendre in Mafinga district of Muchinga province. The training was conducted and facilitade by Amile Hatungimana and Abidon Chisuyu Cibwe who assisted with interpretation from French to English language during the sessions.\nAs the National Executive Vice Secretary for the Bible and Literature Translation Association, Apostle Vincent Chibesa coordinated the team.', '2024-03-01', 'BiLTA media team', 'The Fungwe Oral Bible Translation training which commenced on 10th October came to an end on 28th October, 2022 and attracted six (6) participants from within the areas of Nhtendre in Mafinga district of Muchinga province. The training was conducted and facilitade by Amile Hatungimana and Abidon Chisuyu Cibwe who assisted with interpretation from French to English language during the sessions.\nAs the National Executive Vice Secretary for the Bible and Literature Translation Association, Apostle Vincent Chibesa coordinated the team.', 1, 1, 31, '2024-03-01 22:54:11', '2025-01-14 21:15:29', NULL),
(10, 'Completion of the Bisa Oral Bible Translation', 'Completion of the Bisa Oral Bible Translation', '2024-11-08', 'Naomi Mwimba - ZANIS', '<p>\n    THE Bisa Oral Bible Translation (OBT) project has finished its first translation of the Book of Luke from Greek to Bisa.\n</p>\n<p>\n    The program, launched in March this year in Lavushimanda, is being done with support from Bible and Literature Translation Association (BiLTA) project.\n</p>\n<p>\n    Pentecostal Assemblies of God Pastor Frank Sata, who is Bisa project site manager, says the initiative aims to ensure that the Word of God is translated in a native language for locals who are illiterate.\n</p>\n<p>\n    Pastor Sata said this in an interview during an ongoing community review session of Bisa OBT in Lavushimanda: \n    <blockquote>\n        \"This is an eye-opener for everyone including those that are not learned to have access and understand the Word of God in their native language, unlike before when the Word of God was just in English and was preserved for whites,\" he said. \n    </blockquote>\n</p>\n<p>\n    Pastor Sata said the first book to be completed in Bisa is the Book of Luke and is currently being reviewed by members of the Bisa community, including those from Nabwalya chiefdom, to ensure that the translation principle is followed. \n    The principle which is abbreviated as CANA and means Clear, Accurate, Natural, and Acceptable (CANA).\n</p>\n<p>\n    BiLTA deputy site manager Rev. Lewis Mwila said the project is catering for 26 Bisa chiefdoms, adding that the oral translation is in line with the change in technology.\n</p>\n<p>\n    Rev Mwila said the project supports Zambia\'s declaration as a Christian nation and is ensuring that every Christian has access to the Word of God in their mother tongue.\n</p>\n<p>\n    The clergyman asked for support from the Bisa traditional leadership in offering land for the construction of offices for the project:\n    <blockquote>\n        \"This project is a diamond gift for the people in the area as we celebrate 60 years of Zambia\'s independence and the project will be here forever. All we need is support, especially from the royal highnesses, because the Bible says \'go into the world and preach the Word\', and this is the organization\'s mission,\" he said.\n    </blockquote>\n</p>\n<p>\n    New Church of God bishop Theo Chanda said most Christians in the area are in support of the Bisa OBT project as it has brought families together as they sit and listen to the Word of God in their mother language.\n</p>\n<p>\n    \"This is making families sit together to listen to the Word of God and most Christians now understand the meaning of the translated passages,\" Chanda Chiwenga, a member of the Bisa community, thanked BiLTA for embarking on the translation of the Bible to Bisa language as it will make it easy for people to understand the gospel.\n</p>', 1, 1, 34, '2024-11-13 19:27:20', '2024-12-20 23:33:35', NULL),
(11, 'SIGNING OF MOU BETWEEN BILTA AND SIL GLOBAL', 'A HISTORIC PARTNERSHIP FOR BIBLE TRANSLATION AND LANGUAGE DEVELOPMENT: THE SIGNING OF THE MOU BETWEEN BILTA AND SIL GLOBAL', '2024-12-17', 'BiLTA media team', '<p><strong>In a landmark event for Bible translation and language development, the Bible and Literature Translation Association (BiLTA) and SIL Global officially signed a Memorandum of Understanding (MOU). This partnership is not merely a contractual agreement but a celebration of the collective calling to ensure that the Word of God reaches every community, in every heart language, across Zambia and beyond.</strong></p>\n\n<p>Gathered for this historic occasion were distinguished guests, church leaders, BiLTA and SIL representatives, government officials, and members of the media, united by a profound mission. The event was marked by speeches emphasizing the spiritual significance and social impact of this collaboration. The Guest of Honor, representing the Permanent Secretary of Parliamentary Business and National Guidance, expressed gratitude for the commitment of both organizations to serve communities through God’s Word.</p>\n\n<h2>A Vision Grounded in Faith and Purpose</h2>\n<p>BiLTA and SIL share a common vision rooted in Scripture and transformative service. SIL’s mission statement captures this essence: “Inspired by God’s love, we advocate, build capacity, and work with local communities to see people flourishing in community, using the languages they value most.” This aligns seamlessly with BiLTA’s objectives to make the Bible accessible to every language group, fostering engagement with Scripture for societal transformation.</p>\n\n<p>The event emphasized key transformational statements, highlighting the significance of Scripture engagement, capacity building, and the power of partnerships. As the SIL representative stated, “God values all languages and reveals Himself to people through them. We are committed to growing, adapting, and applying our expertise in language development and Bible translation for the good of all.”</p>\n\n<h2>SIL’s Core Values and Strategic Vision</h2>\n<p>The strategic vision of SIL encompasses a commitment to partnerships, trust in God for the impossible, and service without discrimination. SIL’s core values reinforce the belief in the power of God’s Word to change lives for eternity. Their global plan focuses on three operational priorities that this MOU exemplifies: promoting sustainable language development, fostering community engagement, and applying scholarly expertise in language work.</p>\n\n<p>The SIL representative noted, “Partnership with BiLTA is part of our ongoing strategy to remain relevant and responsive in a changing world. Today’s agreement represents our shared passion for the Word of God and our vision to see language communities flourish.”</p>\n\n<h2>A United Effort Toward Transformation</h2>\n<p>Church Mother Bodies, including the Evangelical Fellowship of Zambia (EFZ), the Council of Churches in Zambia (CCZ), the Independent Churches of Zambia (ICOZ), and the Zambia Conference of Catholic Bishops (ZCCB), commended the partnership as a divine calling to bring hope and light. “In a world increasingly divided, partnerships like these stand as beacons of hope,” one church leader remarked, citing Ecclesiastes 4:9: “Two are better than one because they have a good return for their labor.”</p>\n\n<p>Representatives from SIL Global echoed sentiments of collaboration inspired by the biblical story of Peter and Cornelius, where God’s revelation affirmed that “God does not show favoritism.” This story resonates with the commitment of both organizations to serve all people with dignity and respect.</p>\n\n<h2>Engaging the Community and Empowering the Church</h2>\n<p>The MOU is a significant step in empowering local communities to access the Bible in their own languages. SIL’s representative articulated the importance of local and national churches using their languages to engage with Scripture and strengthen their identities. “We long to see people flourishing in community, using the languages they value most,” he added.</p>\n', 1, 1, 33, '2024-12-17 21:45:40', '2025-01-14 21:13:23', NULL),
(12, 'Why we translate the Bible', 'Why we translate the Bible', '2024-12-12', 'BiLTA media team', '<h1>Why we translate the Bible</h1>\n\n<p>Bible translation is a crucial activity in the mandate of the church as it seeks to be effectively involved in God’s mission in the world. We believe God calls us all to be involved in mission in some way, since living out and sharing the good news of God’s Kingdom is an appropriate response in love to his demonstration of love. The theological and missiological aspects of Bible translation are important for establishing the basis for what we do, for motivation and for reflection on our actions.</p>\n\n<h2>1. Motivation for mission</h2>\n\n<p>From Carey to Amsterdam 2000, people have been motivated to mission involvement for a variety of reasons, some of which are appropriate and others which are not. Motivations which imply cultural, social or intellectual superiority, or lead to paternalistic attitudes have no place in Christian mission. In the post-modern world the seduction of consumerism easily influences a person’s motivation so that \'mission\' becomes merely an adventure to be experienced or another line on the CV. Genuine zeal for God’s mission issues from the nature and character of God, the command of Christ and a realistic appreciation for the condition of people without him. The social milieu of a particular time may determine what captures people’s imaginations and ignites their passion. For example different aspects of the character of God become the focus at different points in history. Where there is a heightened awareness of oppression and suspicion of authority, the justice of God is as motivating as the love of God. Likewise, the great compassion of Jesus will stir a response long before the great commission of Jesus.</p>\n\n<p>(1) Critical to inspiration is a proper understanding of Christ’s commission. Some see excessive focus on this as overly legalistic while others consider it integral to the role of the church; for some a duty, for others a challenge. We believe viewing the commission as a call to joyful participation rather than a dutiful obligation is a more accurate portrayal of Christ’s expectation of his disciples. Appropriate response to the commission of Christ must constitute a major element of motivation. Combining this with a clear understanding of the nature of God the evangelist, his will for all people, and a compassion for the desperate plight of those without him, establishes a galvanising, compelling motivation for service. These are the very factors that motivate people to become actively involved in the broad ministry of Bible translation.</p>\n\n<h2>2. Bible translation as mission</h2>\n\n<p>We believe that Bible translation is one of the best, most appropriate and justifiable methods of Christian mission available. Bible translation involves working with people at some of the very basic, human-worth levels of interaction, namely language and culture incorporating a strong holistic focus on addressing human life issues in community. Bible translation also lends itself to close cooperation with a wide range of local and community institutions, from national governments to local churches, from universities to community health centres. Bible translation deals directly with the Scriptures, God’s full and definitive revelation of himself in Christ. Helping provide the Scriptures is one of the least imperialistic methods of doing mission. Our method is primarily sowing the seed, not transplanting churches. It is lighting a spark, not establishing an institution. This does not mean that the Bible translation movement is unconcerned with the church – it is vitally concerned and involved. But the indigenous church we are committed to, whether in central Asia or in central Brisbane, is not the church we have structured, but one raised up by the Spirit of God.</p>\n\n<p>Bible translation can incorporate the following mission activities:</p>\n\n<ul>\n    <li><strong>i) Disciple-making.</strong> Bible translation is not just about helping provide people with a book. A strongly held goal is to work in cooperation with others (local churches, other Christian agencies) to provide people with the best tool they can have to grow as disciples of Christ—and in the process, to demonstrate the relevance of the biblical message. The translation process itself provides excellent opportunities for active discipling.</li>\n    <li><strong>ii) Building churches.</strong> There is an implication of community in Christianity and in the Scriptures. Christians seem to have an in-built desire to meet together for Bible study and worship, to encourage each other and to share their Christian experiences. This is crucial to growth in Christ. The translated Scriptures give a means of connecting with God’s faithful people in the past, reflecting on their stories of faith and learning from them.</li>\n    <li><strong>iii) Resourcing the church.</strong> The Scriptures in the language of the people become a reference for evangelism, teaching, preaching and devotion. An active, mission-oriented church needs resources for building community and for inspiring, informing and equipping Christian witness. These resources are found in, or based on, the Scriptures. Access to them is facilitated best when the Scriptures are available in form which communicates clearly.</li>\n    <li><strong>iv) Developing a truly indigenous church.</strong> Translated Scriptures are a crucial element in a church becoming truly indigenous. The Bible in the local language is available for reflection and growth, removing the dependency that would otherwise limit freedom of development. Scriptures help promote a truly appropriate worship style, teaching style and approach to evangelism. Merely to \'indigenise\' our own Christian structures can be quite inappropriate. Many churches have the so-called \'independent\' characteristics but still do not fit within the society where they exist. The development of an indigenous church will always be the living response of people to the life-demands of the message. The source of the information for such development may be a person who will never be much more than a catalyst. Alternatively, the source could be the Scriptures themselves, available for personal or community reflection, for study, and for application through the Spirit who inspired them in the first place.</li>\n    <li><strong>v) Involvement with unreached people groups.</strong> African theologian Professor Kwame Bediako believed that a people group should continue to be considered unreached until the Scriptures are available in the local language. There is no doubt people can become Christians, and churches can be established, without access to the written Scriptures in a local language. But without such Scriptures, there can be a lack of ownership, relevance and integration of scriptural truth, all of which are characteristics of a healthy, vital Christian community.</li>\n</ul>\n\n<h2>3. Bible translation as language-based development</h2>\n\n<p>Bible translation is not just about providing a book or introducing Christian religion but incorporates incarnational mission elements which minister to the whole person. Bible translation work demonstrates a care for people as people and a concern for their well-being and rights.</p>\n\n<ul>\n    <li><strong>a) Language development.</strong> Bible translation is not just translating texts but, of necessity, involves many aspects of language development. Involvement in a language project explicitly signifies a high value for the local language. Language is an innately human characteristic, and an intrinsic part of human life. Because translation work is so closely connected to language development, language projects open the way for a wide range of language-related opportunities.</li>\n    <li><strong>b) Literacy.</strong> Literacy and other education-related activities are an integral part of a language project based around translation. Scriptures in the local language anticipates that, for the most part, some form of literacy development work will be needed. This may vary from basic bridging materials to extensive child and adult literacy programs. The benefits of such programs are immeasurable. Not only do people have access to a whole new world of opportunity but they can gain skills to protect themselves and their resources from exploitation. Literacy can provide people with the choice of taking their place in local and national development and in the world. Opportunities previously denied are made possible.</li>\n    <li><strong>c) Care for the marginalised.</strong> Many of the people groups where Scripture translation is needed are among the poorest and most marginalised in the world. They have tended to be ignored, or considered more than a reasonable challenge for national authorities when formulating educational or development policies. In many situations such as education, the national or local authorities have lacked the technical resources to deal with the issues, despite best intentions. Language development work, in the context of a Bible translation project, can meet many of the needs of marginalised people in the world.</li>\n    <li><strong>d) Endangered languages.</strong> The loss of languages through extinction, and the loss of cultures and the people they represent, is as real an issue as the loss of biological species. A people’s identity and dignity are intimately linked to their language, and the loss of any language makes the world a poorer place. A Bible translation project and its related language development efforts can address this. Valuable linguistic records are preserved, the process of extinction may be reversed through language salvage and above all, respect is demonstrated for people, their language, culture and identity. Many of the language programs associated with Bible translation efforts in endangered languages attempt some sort of language salvage or maintenance program, including strategies such as literacy, education, and the production of literature.</li>\n    <li><strong>e) Valuing culture.</strong> Lamin Sanneh (2) points out that no other act of the missionary empowers people and dignifies their culture more than Bible translation. It takes people seriously and says to them that God speaks their language.</li>\n</ul>\n\n<h2>4. In conclusion</h2>\n\n<p>The total scope of Bible translation is much more than just translating a text. It is helping people to be discipled in a language they understand best. It is facilitating access to the Word of God, which has everything in it that everyone needs for salvation and growth in the knowledge of God. These things are written so that you may believe that Jesus is the Messiah, the Son of God, and that by believing in him you will have life. <strong>John 20:31</strong></p>\n\n<p>To have the truth and not proclaim it, or make it accessible to others, is to deny it. A version of this paper was originally presented to a Wycliffe Australia Regional Conference in October 2003.</p>\n\n<h3>Footnotes:</h3>\n<ul>\n    <li>(1) Windsor, Paul. ‘Reality’ (BCNZ) 2002.</li>\n    <li>(2) Sanneh, L. Encountering the West: Christianity & the Global Cultural Process: The African Dimension, (Maryknoll, New York: Orbis Books, 1993).</li>\n</ul>\n\n<p>David Nicholls is Associate Director of Wycliffe Australia.</p>\n\n<p>Copyright © BiLTA 2024</p>\n', 1, 1, 37, '2024-12-18 01:35:08', '2025-01-18 17:34:42', NULL),
(13, 'THE BIBLE TO BE TRANSLATED INTO LOCAL ZAMBIAN LANGUAGES', 'THE BIBLE TO BE TRANSLATED INTO LOCAL ZAMBIAN LANGUAGES', '2024-12-03', 'RCV', '<p>\n    The Bible and Literature Translation Association says it is working with the Summer Institute of Linguistics to translate the Bible to 13 local Zambian languages to enhance understanding by the local people.\n</p>\n<p>\n    Association Vice Chairman, Rev. Ezekiel Ngulube, says there is a need for the Zambian people to read the word of God in their mother tongue in order to bring growth to the church. Rev. Ngulube added that the association will continue to work with relevant stakeholders to translate the bible into more languages should conditions remain favorable.\n</p>\n<p>\n    “Jesus said in Mathew 28 vs 19 go therefore and make disciples of all nations, he spoke of many different languages, which is very important,” said Rev Ngulube.\n</p>\n<p>\n    And Summer Institute of Linguistic Associate Executive Director, Nelis Vandenburg said the Bible and Literature Translation Association will become a part of the associate in order to see to it that the work done in Zambia, is not only local but part of the global movement. He added that the bible is a source of wisdom from God and Zambia being a Christian nation requires the word of God to be available to its people.\n</p>', 1, 1, 37, '2024-12-18 01:59:27', '2024-12-18 02:20:50', NULL),
(14, 'BiLTA Translation Sites and success story', 'BiLTA Translation Sites and success story', '2024-11-15', 'NEC', '<p>\n    BiLTA has recorded successes since its inception in 2012, and here are some of the highlights:\n</p>\n<ul>\n    <li>Completion of the Oral Translation of the Senga Translation Site.</li>\n    <li>In 2023, 13 translation sites were established, making a total of 17 sites for 13 languages.</li>\n    <li>BiLTA successfully conducted 3 weeks of national sensitization for oral Bible translation through print, radio, and TV media in 2024.</li>\n    <li>BiLTA now has 4 consultants trained in Jerusalem.</li>\n    <li>Two BiLTA translators have been certified OBT Coach Trainer and Trainer, respectively.</li>\n    <li>Established the head office in Lusaka, where the staff is doing all administrative work.</li>\n</ul>', 1, 1, 37, '2024-12-18 16:21:50', '2024-12-18 16:32:34', NULL),
(15, 'Bible Translation Project Advances in Lambya and Wandya Languages', 'Bible Translation Project Advances in Lambya and Wandya Languages', '2024-10-11', 'BiLTA media team', '<h1>Bible Translation Project Advances in Lambya and Wandya Languages</h1>\n<p><strong>By Richard Singoi/Wantula Nyondo.</strong></p>\n<p>The Bible Translation and Literature Association (BiLTA) has made progress in translating the Bible into the Lambya and Wandya languages, with four books already completed in the Lambya translation.</p>\n<p>Team Translation Advisor for team 1, Rev. Kelvin Chola, revealed that the books of Acts, Luke, and Mark have been successfully translated into Lambya, while work on the book of Matthew is currently 75% complete.</p>\n<p>The project began two years ago and has seen strong support from the Lambya community.</p>\n<p>“This progress wouldn’t be possible without the active participation of the Lambya people. Their commitment shows how much they value having the Bible in their own language,” said Rev. Chola.</p>\n<p>Translation Advisor for Team 2, Rev. Maybin Siame, also commended the Lambya community for their cooperation, emphasizing the impact the translated Bible will have.</p>\n<p>“Having the Bible in Lambya is essential for spiritual growth. It allows the people to connect deeply with the Word of God in a language they understand,” Rev. Siame added.</p>\n<p>In a separate interview, Rev. Jonathan Jere, the team leader for the Bible Translation into the Wandya language, disclosed that they are currently working on the book of Luke, with 75% of the translation already completed.</p>\n<p>He stressed the importance of making the Bible available in the Wandya language, enabling the community to access scripture in their native tongue.</p>\n<p>“This project will change the spiritual lives of the Wandya people by making the Bible accessible and understandable. We are working hard to make this a reality,” said Rev. Jere.</p>\n<p>However, challenges remain, Deputy Team Leader, Pastor Born Chunda, noted that power outages and network issues have slowed the work.</p>\n<p>Despite these setbacks, Pastor Chunda underscored the significance of the translation project.</p>\n<p>“This is about more than just language; it’s about bridging faith and culture. Having the Bible in their native language will enrich their spiritual journey and foster a deeper connection with the teachings of the Bible,” he noted.</p>\n<p>Once completed, the Lambya and Wandya communities will have the opportunity to experience the Word of God in their own languages, bringing new meaning to their faith and spiritual growth.</p>\n<p>The Bible Translation and Literature Association (BILTA) is currently conducting an Oral Bible Translation with offices in Isoka District, Muchinga Province.</p>', 1, 1, 37, '2025-01-14 21:12:11', '2025-01-14 21:59:01', NULL);
INSERT INTO `news_item` (`id`, `title`, `short_description`, `post_date`, `author`, `details`, `created_by`, `status_id`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(16, 'Africa reflections: Youth potential, and training', 'Africa reflections: Youth potential, and training', '2024-11-04', 'BiLTA media team', '<h1>Africa reflections: Youth potential, and training</h1>\n\n<p>Strategies to bring the youth into the Bible translation movement and how to redefine consultant development were some of the issues discussed by Africa Area leaders Friday during Global Gathering 2024.</p>\n\n<p>Johannesburg, 2 November 2024 &mdash; Africa has the world’s youngest population – with 70 percent of the continent’s people under 30. Yet, Bible translation is largely in the hands of older generations. To address this, Africa Area Director Wairimu Irungu led a reflection Friday (1 Nov.) on what the involvement of the youth could look like.</p>\n\n<blockquote>\n<p>‘In some of the organisations we have seen the impact that the youth have created,’ Wairimu said. ‘We want to see a movement of young people leading Bible translation in Africa and beyond. They have the energy and make up a big segment of the African population. Christianity is on the rise in Africa and the youth are a vibrant part of this people.’</p>\n</blockquote>\n\n<h2>Table Group Discussion</h2>\n<p>After table-group discussion, the African leaders shared a few ideas:</p>\n\n<ul>\n    <li>‘We envisage a movement of young leaders that comes from local to global levels. And Bible agencies can support this by providing the needed resources. We can do this by taking advantage of youth movements who are Christians and already want to serve God. We can target youths in schools, and their parents as well. We should also sensitise them on marginalised communities, especially for those based in town.’</li>\n    <li>‘A movement of youth needs to be built by the youth.’</li>\n    <li>‘We can empower them on the value and things of God. It will not be skewed to one gender – we should bring all the youth together. It will be ideal if we work with youth up to the age of 30.’</li>\n    <li>‘We should get the youth to strategic levels. We realised that while we talk about them, we leave them out of decision-making platforms like leadership and board settings.’</li>\n    <li>‘Organisations that have succeeded tapped on the youths while they were still in the university. We need to do that.’</li>\n    <li>‘We need to involve them in ministry, train them, and allow them to work. We should create deliberate positions for youths. And when adults are given roles, we can assign the youth to assist.’</li>\n    <li>Youth like technology and there is a need to leverage that and give them a chance to participate.</li>\n    <li>‘Youth love music. We can leverage this to bring them in. We can pray with them, and involve them in missions so they see the necessity of being there.’</li>\n</ul>\n\n<h2>Consultant training and certification</h2>\n<p>Paul Kimbi, the Alliance’s Bible Translation Consultant and Africa Area Translation Coordinator, led another reflection on what success in Bible translation should look like. Drawing from an adage, ‘the surgery was successful but the patient died’, Paul raised questions for further reflection.</p>\n\n<blockquote>\n<p>‘If Bible translation was a surgery, what would be the success? Who will be the patient?’ he asked.</p>\n<p>‘Successful consultation involves more than knowledge of techniques and technical skills. It is more than knowing what to do—it is knowing how to get it done. We need to develop a training curriculum that addresses the needs of the local population. We should localise our curriculum and make it more relevant,’ Paul stated as he sent the delegates into discussion groups.</p>\n</blockquote>\n\n<h3>Questions emerging from the discussion:</h3>\n<ul>\n    <li>What is the content of the growth plan of a Bible translation consultant and how can we review that content so it can be relevant, efficient and pertinent?</li>\n    <li>How can organisations collaborate in the development of consultants?</li>\n    <li>What are the current barriers to the development and certification of Bible translation consultants in Africa?</li>\n    <li>How can we assure the quality of a translation?</li>\n    <li>What training does a Bible translation consultant need in order to be certified?</li>\n    <li>What is the role of technology in the development of translation consultants?</li>\n</ul>\n\n<p>Story: Isaac Forchie. Photo: Daisy Kilel.</p>', 1, 1, 37, '2025-01-20 16:18:27', '2025-01-20 16:18:27', NULL),
(17, 'Voices from the interpretation booths', 'Voices from the interpretation booths', '2024-11-01', 'BiLTA media team', '<h1>Voices from the interpretation booths</h1>\n\n<p>While the Global gathering is conducted in English, speakers of French, Spanish, and Indonesian are following the sessions through nine interpreters from varied backgrounds.</p>\n\n<p>Johannesburg, 31 October—Interpreters have proven to be vital at the Global Gathering. With 180 delegates, 51 staff members, and seven guests from over 60 countries, the need for efficient and accurate interpretation is paramount to ensure smooth communication and understanding. This reflects the value of community, highlighted on Thursday (31 October), the event’s first day. From different cultures, participants freely played a part as some nine interpreters on duty bridged the language barrier between French, Spanish, Indonesian, and English.</p>\n\n<h2>A Minute in the Booth</h2>\n<p>Just before one of the sessions, Elina and Olin Bourquin catch their breath and enter the booth, praying that the speaker will not be too fast. The Bourquins put on their headsets, glance through their notes, and then pay full attention to what the speaker on stage says. They have no time to process the message; their key objective is simply to get it across to their target listener. A small microphone transmits their interpretation to listeners’ earbuds plugged into phones. This happens with the help of a special app called Livevoice. An interpreter signs in as “speaker” while the participant logs in as “receiver” and then navigates to the preferred language.</p>\n\n<p>The Bourquins are students from Switzerland. Elina has a background in criminology while Olin is a software developer. Olin grew up speaking English at home and French in school, while Elina found herself in an opposite setting. Their parents made conscious efforts to teach them English and French.</p>\n\n<blockquote>\n<p>‘My main hope is that people who do not speak English at all, or struggle with it, will have an easier time at the Gathering,’ Olin says.</p>\n<p>Elina has done this kind of work before … yet she knows the challenges the day may bring.</p>\n<p>‘You get into this bubble where you can’t focus on anything else. You can’t process the information, and you can only translate what you hear.’</p>\n</blockquote>\n\n<p>They both trust God for everything to function correctly as there is a significant dependence on technology. After they played the same role during the International Fellowship of Evangelical Students’ meetings, God offered them another opportunity.</p>\n\n<blockquote>\n<p>‘A friend who now works with Wycliffe learned that interpreters were needed for this Gathering,’ Olin says, adding that the friend knew they interpreted at Christian conferences.</p>\n<p>‘He asked if we would volunteer, and we gladly said yes.’</p>\n</blockquote>\n\n<p>Delegate Jet Rense, the Synod Leader of the Central Sulawesi Christian Church which leads Bible translation work in Indonesia, says he has been fully involved and engaged in the day’s discussions. During sessions, he looks forward to Dessy Pello’s voice. Dessy is an English-to-Indonesian interpreter at the Global Gathering.</p>\n\n<blockquote>\n<p>‘I have learned that we can only grow together through friendship, and when I go back I will encourage people in my organisation to build friendships,’ Jet says.</p>\n<p>He adds that interpretation has been quite helpful. ‘I can understand what people are talking about, and I am also able to contribute to this big event.’</p>\n</blockquote>\n\n<p>Story: Isaac Forchie. Photos: Daisy Kilel, Jennifer Pillinger.</p>', 1, 1, 37, '2025-01-20 16:28:13', '2025-01-20 16:28:13', NULL),
(18, 'Scripture engagement training', 'Scripture engagement training', '2025-04-16', 'BiLTA media team', '\n<h2>Three-Day Scripture Engagement Training Concludes</h2>\n<p>The three-day Scripture Engagement training organized by the <strong>Bible Literature and Translation Association (BiLTA)</strong> with the support of <strong>Faith Comes By Hearing</strong> has concluded today.</p>\n\n<p>This training focused on helping individuals engage with the Word of God through regular listening to scriptures in their mother tongue. It aimed to unite churches and foster discipleship within the community.</p>\n\n<p><strong>Faith Comes By Hearing</strong> strives to spread the Word of God throughout all communities, allowing it to reach the hearts of individuals and transform their lives. The training began on <strong>April 13, 2025</strong>, and attracted <strong>55 participants</strong> from <strong>26 different churches</strong> in the Chama district, as well as attendees from various chiefdoms within the district.</p>\n\n<p>The workshop was led by <strong>Mrs. Catherine C. Katete</strong> and <strong>Mrs. Rhoda P. Mvula</strong>, both representing BiLTA.</p>\n\n<p>The trainers emphasized that Scripture Engagement is a program designed for everyone, regardless of their background—be they Christians, non-believers, young, or old. It is not limited to those who cannot read or write; both literate and non-literate individuals come together to listen to the word of God.</p>\n\n<p>One of the participants from the <strong>Pentecostal Assemblies of God</strong>, <strong>Esnart Salimu Ngulube</strong>, expressed her gratitude to the organizers for the training, noting its significant benefits. She believes it will enhance their ability to engage effectively with the community by using <strong>Proclaimers</strong> to spread the word of God, which functions as an audio Bible. Madam Esnart Ngulube encouraged the community to take advantage of the Oral Bible available in their language.</p>\n\n<p>At the end of the training, each participant received a certificate. Additionally, all <strong>26 churches</strong> represented in the district were given <strong>ten Proclaimers</strong> each, and all representatives from chiefdoms received <strong>100 Proclaimers</strong> for their chiefdoms.</p>\n\n<p>The <strong>Senga translators team</strong> in the district has achieved a significant milestone by completing the translation of the <strong>New Testament Bible</strong>, a project that took six years and began in 2019. The Oral New Testament Bible was officially launched on <strong>April 12, 2025</strong>, at <strong>Chama Boarding Secondary School</strong>.</p>\n```', 1, 1, 31, '2025-04-17 11:53:49', '2025-04-17 11:53:49', NULL),
(19, 'BILTA TRAINS  PEOPLE IN SCRIPTURE ENGAGEMENT.', 'BILTA TRAINS  PEOPLE IN SCRIPTURE ENGAGEMENT.', '2025-04-17', 'ISO FM 93.5, ISOKA', '<h1>BILTA TRAINS PEOPLE IN SCRIPTURE ENGAGEMENT</h1>\n<p>About fifty-eight people from Mafinga and Isoka Districts have been trained in Scripture Engagement to help spread the word of God in local languages.</p>\n<p>The training was organized by the Bible and Literature Translation Association (BILTA) in partnership with Faith Comes By Hearing.</p>\n\n<h2>Opening Ceremony</h2>\n<p>Speaking during the opening ceremony, National Scripture Engagement Coordinator Pastor Isaac Lungu said the program is meant to help people engage with the Bible by listening to it in their mother tongues.</p>\n<blockquote>\n    <p>“More than half of the world’s population cannot read or write. This program uses audio Bible scriptures so that everyone can understand and hear the word of God,” he said.</p>\n</blockquote>\n<p>“Oral people worldwide, our friends just took oral into paper. When I was born, I was introduced to oral in my mother tongue, and I understood. I communicate with my family orally. This is the reason that oral is more convincing to understand the word of God because it’s just tuning to the gadget and starting to hear. Both literates and non-literates can listen.”</p>\n\n<h2>BILTA\'s Translation Approach</h2>\n<p>Pastor Lungu further explained that this is the reason BILTA\'s translation approach is done orally to accommodate everyone.</p>\n<blockquote>\n    <p>“With translating the Bible, BILTA does it orally in order to accommodate everyone...even if someone has no time to read, by listening to the audio, they will be able to communicate with God.”</p>\n</blockquote>\n<p>He added that the trainees will now go back into their communities and form small groups of about 10 to 15 people to listen to the Bible together.</p>\n\n<h2>Importance of Local Languages</h2>\n<p>Trainer of Trainers from Faith Comes By Hearing, Catherine Katete, stressed the importance of sharing the Bible in local languages.</p>\n<blockquote>\n    <p>“Some people don’t read the Bible because they can’t read, or it’s not in a language they understand. With this program, people will now be able to understand because it is in their mother tongue,” she said.</p>\n</blockquote>\n<p>Mrs. Katete encouraged church leaders and community members to embrace audio Bible tools and make scripture listening sessions part of regular church and home programs.</p>\n\n<h2>Community Impact</h2>\n<p>Isoka Pastors Fellowship Association Chairperson, Reverend Dominic Simukwayi, welcomed the program, stating that it will help many people grow spiritually.</p>\n<p>Rev. Simukwayi said the church has for a long time faced challenges in reaching certain groups, especially in areas where one cannot read.</p>\n<p>He noted that the Scripture Engagement program is timely and will close that gap.</p>\n<p>He commended BILTA and Faith Comes By Hearing for bringing such a life-changing program to Isoka and Mafinga.</p>\n<p>The training brought together participants from Mafinga and Isoka Districts, where BILTA is also working on oral Bible translation in Fungwe, Lambya, Wandya, and Tambo languages.</p>', 1, 1, 39, '2025-04-30 14:30:54', '2025-04-30 14:30:54', NULL),
(20, 'LAUNCH OF THE SENGA NEW TESTAMENT ORAL BIBLE', 'LAUNCH OF THE SENGA NEW TESTAMENT ORAL BIBLE', '2025-04-07', 'BiLTA media team', '<h1>LAUNCH OF THE SENGA NEW TESTAMENT ORAL BIBLE</h1>\n<p>\n    THE Bible and Literature Translation Association (BILTA) will officially launch the Senga New Testament Bible to promote viability and vitality. BILTA chairperson Fr Jackson Katete says the launch scheduled for April 8th, 2025, will be a great milestone for the Senga-speaking community who had never had a bible in their own language before.\n</p>\n<p>\n    Fr. Katete, who was speaking during a preparatory meeting ahead of the upcoming launch, urged churches to accommodate people from diverse linguistic backgrounds and to take pride in their inheritance.\n</p>\n<p>\n    He appealed to churches across the country to empower local languages in bible translation. Fr. Katete further urged churches to accommodate people from diverse linguistic backgrounds and to take pride in their inheritance. He emphasized the importance of recognizing and valuing minority languages often spoken in rural areas.\n</p>\n<p>\n    Fr Katete stressed the need for local empowerment in translation rather than relying on external missionaries. He also highlighted the importance of creating music that resonates with local environments and situations.\n</p>\n<p>\n    And Walk in Two Worlds Ethnomusicologist President Douglas Anthony, shared his insights on the significance of music in cultural expression and identity. He stated that the launch of the Senga New Testament Bible marks a significant step towards promoting linguistic diversity and inclusivity in Zambia\'s religious landscape.\n</p>\n<p>\n    Meanwhile, the BILTA mass choir music director James Sanga expressed gratitude and assured that his team is ready for the upcoming launch. ZANIS\n</p>', 1, 1, 37, '2025-05-01 17:08:06', '2025-05-01 17:08:06', NULL),
(21, 'SUCCESS OF THE SENGA ORAL BIBLE TRANSLATION (OBT) PROJECT.', 'SUCCESS OF THE SENGA ORAL BIBLE TRANSLATION (OBT) PROJECT IN CHAMA DISTRICT, EASTERN PROVINCE, ZAMBIA', '2025-04-09', 'BiLTA media team', '<h1>SUCCESS OF THE SENGA ORAL BIBLE TRANSLATION (OBT) PROJECT IN CHAMA DISTRICT, EASTERN PROVINCE, ZAMBIA</h1>\n\n<h2>Senga Oral Bible Translation: A Spark That Birthed 12 Projects with 17 Offices</h2>\n<p>The journey of the Senga Oral Bible Translation (OBT) is a testament to the power of faith and commitment to God\'s Word. Through the support of Faith Comes By Hearing (FCBH), the Senga-speaking people experienced the Bible in their heart language, transforming lives and deepening their understanding of Scripture.</p>\n\n<p>This remarkable success did not go unnoticed. The impact of the Senga OBT inspired the establishment of 14 new project sites and 3 additional offices, expanding the reach of Bible translation efforts to other language communities. What began as a single initiative has now multiplied, ensuring that more people encounter the Word of God in a language they understand best.</p>\n\n<p>This story is not just about translation - it is about transformation. The voice of the Senga OBT has echoed beyond its own community, proving that when people hear God\'s Word in their own language, faith grows, and the mission of the Gospel advances.</p>\n\n<p>After the launch of the OBT office in 2019, the Senga office completed the recording of the book of Luke in nine (9) months, which was the first in the history of Bible translation.</p>', 1, 1, 37, '2025-05-14 21:28:27', '2025-05-14 21:28:27', NULL),
(22, 'SENGA Bible App', 'SENGA Bible App', '2025-04-15', 'BiLTA media team', '<h1>We are grateful to God for the release of the SENGA Bible App called \"MAZYO MU CHISENGA\"</h1>\n\n<p>The full App can be downloaded by scanning the attached QR code or by sharing the following download link:</p>\n<p><a href=\"https://tinyurl.com/Senga-Bible\" target=\"_blank\">https://tinyurl.com/Senga-Bible</a></p>\n\n<p>Congratulations to the SENGA people, to whom God has brought His pure Word in the language of their heart!</p>\n\n<p>Blessings,</p>', 1, 1, 37, '2025-05-14 21:49:48', '2025-05-14 21:49:48', NULL),
(23, 'BiLTA Security Personnel Shine at National Pass-Out Ceremony in Lusaka', ' \nBiLTA Security Personnel Shine at National Pass-Out Ceremony in Lusaka\n\n\n \n', '2025-06-27', 'BiLTA media team', '<h1>BiLTA Security Personnel Shine at National Pass-Out Ceremony in Lusaka</h1>\n<p><strong>Lusaka | June 26, 2025</strong> — With hearts full of purpose and voices lifted in praise, 31 BiLTA security personnel from across Zambia successfully completed their Basic Security Management Course, held from 23rd to 26th June 2025 at Mapalo Lodge in Lusaka. The four-day training culminated in a powerful pass-out ceremony that blended professionalism, worship, and renewed commitment to BiLTA’s mission.</p>\n<p>The event was made memorable by moments of worship, as the security team broke into songs of praise, creating an atmosphere charged with gratitude and reverence. In a heartfelt sketch performance, the team dramatized the transformation they had undergone during training and how they plan to execute their duties with diligence and integrity. It was a moving portrayal of growth and responsibility reminding all in attendance that this role is both spiritual and practical.</p>\n<p>Mr. Muhango, a Zambia Police Officer from Lilayi Police College and the lead trainer, delivered an encouraging address during the ceremony. He thanked the BiLTA National Executive Committee for the opportunity to facilitate the training and expressed confidence in the outcomes.</p>\n<blockquote>\n<p>“The officers have been equipped with knowledge that will bring long-term improvement to the organization. The course package was well-designed, and I’m confident they will execute their duties with diligence,” he stated.</p>\n</blockquote>\n<p>Mr. Muhanga highlighted the breadth of the course, which covered critical areas such as: Security Management, Criminal Law & Criminal Investigation, Portions of Criminal Procedure, Human Rights and Ethics, Introduction to the Inquiry Office, Use and recording in the Occurrence Book (OB), Proper procedures for searching premises, including legal grounds, Emergency response procedures in case of fire, to mention but a few.</p>\n<p>These modules were engaged actively by the security personnel, who showed keen participation throughout the sessions demonstrating a hunger to grow both professionally and ethically.</p>\n<p>Delivering the keynote address, Father Katete, BiLTA’s National Executive Chairperson, emphasized discipline, financial responsibility, and the importance of personal development.</p>\n<blockquote>\n<p>“BiLTA values your service deeply. You are not just protecting facilities; you are safeguarding a mission translating the Word of God into the heart languages of our people,” he said. He further encouraged the officers to pursue further education and ensure their conduct reflects the Christian values of the organization they represent.</p>\n</blockquote>\n<p>Mr. Mtumbi Goma, BiLTA’s National executive Treasurer, announced the provision of safety boots for the officers and assured that more work equipment and uniforms would be provided as resources become available.</p>\n<p>Rev. Simangolwa, a BiLTA staff member who supervises the security personnel on behalf of the National Executive Board, commended the security team for their commitment and thanked the Excom for prioritizing the training.</p>\n<blockquote>\n<p>“This shows BiLTA’s intentionality in building not just spiritual capacity, but also operational strength,” he said.</p>\n</blockquote>\n<p>In their vote of thanks, the security officers expressed deep gratitude to Father Katete and the National Executive Committee for the opportunity to be trained, for the excellent hospitality in Lusaka, and the well-organized transport logistics that made the entire experience smooth and uplifting.</p>\n<p>This successful pass-out is more than a conclusion; it is a launching pad. The BiLTA security personnel return to their stations equipped, empowered, and inspired to serve with purpose and professionalism.</p>\n<p><strong>#BiLTAStrong | #SecurityWithPurpose | #GuardingTheMission | #FromTrainingToTransformation</strong></p>\n', 1, 1, 33, '2025-06-30 20:08:52', '2025-07-11 20:57:50', NULL),
(24, 'POWERING GOD’S MISSION: SOLAR AND STARLINK USHER IN A NEW ERA AT BILTA HEAD OFFICE IN LUSAKA', ' POWERING GOD’S MISSION: SOLAR AND STARLINK USHER IN A NEW ERA AT BILTA HEAD OFFICE IN LUSAKA \n', '2025-10-17', 'BiLTA media team', ' \n<h1>POWERING GOD’S MISSION: SOLAR AND STARLINK USHER IN A NEW ERA AT BILTA HEAD OFFICE IN LUSAKA</h1>\n<p>In a remarkable stride for Bible translation in Zambia, the Bible and Literature Translation Association (BiLTA) has launched a solar energy system and installed Starlink internet connectivity at its national head office in Lusaka. This game-changing development, made possible through a strategic partnership with Wycliffe UK and Ireland and SIL Africa Global, marks a significant breakthrough in operational efficiency and digital connectivity for the ministry.</p>\n<p>At the heart of this project is Mr. David Oandah, Area Project Manager for SIL Africa ICT Services, who provided critical oversight to ensure the successful implementation of both the solar and Starlink systems. The goal was simple but profound: to overcome the persistent power and internet challenges that have hindered BiLTA’s mission-driven operations for years.</p>\n<p>“Zambia has faced prolonged power outages that have negatively impacted our work,” said Mr. Goma Mtumbi, BiLTA’s National Executive Treasurer. “We were forced to rely on a diesel generator, which consumed large amounts of fuel and created unbearable noise. The coming of solar power has drastically reduced our expenses and environmental impact. The simultaneous installation of Starlink internet means we now have uninterrupted, high-speed connectivity, a real game changer for how we operate.”</p>\n<p>The dual installation could not have come at a better time. In a digital era where effective communication, data sharing, and online collaboration are essential, unreliable power and the internet posed serious obstacles to BiLTA’s coordination, training, and participation in global Bible translation efforts.</p>\n<p>“God has continued to open doors for BiLTA,” said Father Jackson Jones Katete, BiLTA’s National Executive Chairperson. “From the creation of our head office to the installation of this solar and internet system, we have seen His hand. Yes, the journey came with challenges: program coordination, human resource management, setting up an accounting department but the biggest were power shortages and poor network access. Now, with solar and Starlink, we can operate without interruption. It’s more than infrastructure, it\'s a miracle of provision.”</p>\n<p>These upgrades are more than just practical solutions; they are spiritual tools, enabling the continued expansion of Bible translation work into Zambia’s most remote language communities. The improved systems now allow the Head office BiLTA staff to participate in international meetings, conduct remote training, and build capacity without disruptions.</p>\n<p>The collaboration with Wycliffe UK and Ireland and SIL Africa stands as a shining example of the power of global partnerships in advancing the Gospel. The equipment, funding, and technical expertise provided have not only addressed BiLTA’s immediate needs but laid a sustainable foundation for future growth.</p>\n<p>“Technology is now playing a vital role in the mission of God,” said Father Katete. “We’re grateful that through this partnership, we can use cutting-edge solutions to carry out timeless work bringing God’s Word to people in their own language.”</p>\n<p>Indeed, the successful installation of solar energy and Starlink internet at BiLTA\'s head office represents more than a technological milestone; it\'s a prophetic step forward. With physical light powering spiritual light, and with a stable internet connecting hearts and minds across the globe, BiLTA is positioned to shine brighter than ever in its mission to make the Scriptures accessible to all.</p>\n \n', 1, 1, 37, '2025-10-28 20:43:44', '2025-10-28 20:43:44', NULL),
(25, 'OBT, OBS: What’s the Difference?', 'OBT, OBS: What’s the Difference?\n\n', '2025-09-16', 'BiLTA media team', ' \n<h2>Oral Bible Translation (OBT) and Oral Bible Storying (OBS): <br>What’s the Difference?</h2>\n\n<p>Even in the world’s Bible translation movements, not everyone fully understands the distinctives of OBT and how it differs from oral Bible storying (OBS). A quick overview:</p>\n\n<p>In OBS, stories based on Scripture are crafted so they can in turn be learned, practiced, and shared. Oral Bible stories contain the basic details of the original but may be shortened or paraphrased. Often OBS is used as a Scripture engagement strategy.</p>\n\n<p>In OBT, an oral passage of Scripture in one language is translated into an oral version in the target language. OBT uses the same rigorous process of translation, checking, and revision as written translation, but all work is done orally rather than in writing. The final version will be recorded but can also be memorized and shared.</p>\n\n<p>Oral Bible Translation is still relatively new. A 2007 thesis by Robin Green, a Dallas International University student, proposed a method for non-readers to translate Scripture from an audible reference language. In 2015, Faith Comes By Hearing, Seed Company, and Pioneer Bible Translators developed Render, a software application to facilitate OBT without requiring literacy. Teams listen to Scripture in a reference language, then internalize and record the translated Bible passages in their heart language. These recordings undergo rigorous review and approval by translation experts to ensure accuracy before being shared with the community.</p>\n\n<p>The first OBT project launched in 2017 in Brazil, providing access to God’s Word for half a million people. OBT rapidly became a major methodology, reaching 100 oral communities by 2019. Today, OBT is part of thousands of Bible translation projects around the world.</p>\n \n', 1, 1, 37, '2025-11-06 21:52:21', '2025-11-06 21:52:21', NULL),
(26, 'Oral Bible Translation (OBT) and Oral Bible Storying (OBS): What’s the Difference?', ' \nOral Bible Translation (OBT) and Oral Bible Storying (OBS):\nWhat’s the Difference? \n', '2025-11-07', 'BiLTA media team', '<h2>Oral Bible Translation (OBT) and Oral Bible Storying (OBS):</h2>\n<h3>What’s the Difference?</h3>\n<p>By Musa Mulambia</p>\n<p>Musa Mulambia has been a translator with BiLTA since November 2023, working at the Tambo office in Isoka District, Zambia.</p>\n\n<h3>1. Oral Bible Translation (OBT)</h3>\n<h4>Definition:</h4>\n<p>Oral Bible Translation is the process of translating Scripture directly into spoken form, without necessarily transcribing it first. This translation is done orally and intended for oral use, particularly for communities that may not read or write their language fluently.</p>\n<h4>Key Points:</h4>\n<ul>\n  <li>Translators listen to or read the original biblical text (often in a trade language or a major language) and then retell it accurately in their mother tongue.</li>\n  <li>The aim is to produce faithful and accurate translations of Scripture that are verified for meaning, clarity, and naturalness.</li>\n  <li>Recordings of these oral translations are shared through audio devices, apps, or radios.</li>\n  <li>The process adheres to translation principles, ensuring theological accuracy and equivalence of meaning.</li>\n</ul>\n<p><strong>Example:</strong> Translating the Gospel of Mark orally into a local language for audio Bible use.</p>\n<h4>Goal:</h4>\n<p>To make the exact Word of God available in an oral, accurate, and reproducible format for oral communities.</p>\n\n<h3>2. Oral Bible Storying (OBS)</h3>\n<h4>Definition:</h4>\n<p>Oral Bible Storying is the process of selecting, crafting, and telling Bible stories in a natural storytelling format that resonates with the culture. Instead of a word-for-word translation, it focuses on narrating Bible stories in a way that people can easily remember and share.</p>\n<h4>Key Points:</h4>\n<ul>\n  <li>It utilizes chronological storytelling, covering the narrative from Creation to Christ, which helps people grasp the Bible’s overarching story.</li>\n  <li>Each story is simplified and contextualized while retaining biblical truth.</li>\n  <li>This approach emphasizes discipleship, evangelism, and teaching rather than creating a comprehensive translation.</li>\n  <li>Storytellers are trained to ensure accuracy while making the stories engaging and suitable for oral presentation.</li>\n</ul>\n<p><strong>Example:</strong> Telling the story of David and Goliath in a way that local listeners can visualize and easily repeat.</p>\n<h4>Goal:</h4>\n<p>To help people understand and internalize biblical truths through memorable, oral storytelling.</p>\n\n<h3>Main Difference Summary</h3>\n<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\n  <thead>\n    <tr>\n      <th>Oral Bible Translation (OBT)</th>\n      <th>Oral Bible Storying (OBS)</th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr>\n      <td><strong>Purpose:</strong><br>- To produce accurate, oral Scripture translations.<br>- To teach and share Bible truths through stories.</td>\n      <td><strong>Purpose:</strong><br>- To help people understand and internalize biblical truths through storytelling.</td>\n    </tr>\n    <tr>\n      <td><strong>Approach:</strong><br>- Word-for-word or meaning-based translation.<br>- Storytelling and summarizing key Bible narratives.</td>\n      <td><strong>Approach:</strong><br>- Focus on narrative and retelling.<br>- Emphasis on cultural relevance and memorability.</td>\n    </tr>\n    <tr>\n      <td><strong>Accuracy Level:</strong><br>- Follows strict translation checks.<br>- Faithful to meaning but simplified for storytelling.</td>\n      <td><strong>Accuracy Level:</strong><br>- Emphasizes biblical truth in a simplified, engaging manner.</td>\n    </tr>\n    <tr>\n      <td><strong>Output:</strong><br>- Audio Bible passages in the local language.<br>- A set of Bible stories told orally.</td>\n      <td><strong>Output:</strong><br>- Oral storytelling of Bible narratives.</td>\n    </tr>\n    <tr>\n      <td><strong>Use:</strong><br>- Scripture listening, worship, discipleship.<br>- Evangelism, teaching, and church planting.</td>\n      <td><strong>Use:</strong><br>- Evangelism, discipleship, teaching.<br>- Oral retelling for sharing and memorization.</td>\n    </tr>\n    <tr>\n      <td><strong>Focus:</strong><br>- The text of the Bible\n\n', 1, 1, 37, '2025-11-07 16:40:48', '2025-11-07 16:40:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `our_services`
--

CREATE TABLE `our_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` mediumtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_services`
--

INSERT INTO `our_services` (`id`, `title`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oral Bible Translation: We carry out Oral translation of the Bible', 'Oral Bible Translation is an Oral method of translating the Bible. Translators listen to the Bible in a language they know, translate it into their mother tongue, then record their translation. \nOral Bible translation undergo all the rigorous Bible translation steps of peer, community, and consultant checks, resulting in a clear, accurate, natural, and acceptable translation.', 1, '2023-06-06 17:49:10', '2024-12-10 20:06:05', NULL),
(2, 'Language Survey: We carry out a survey of the languages that do not have Bibles', 'An Assessment of the viability and vitality of the language before embarking on the translation works.\nEach language must be assessed to ascertain its life and usage in the community to avoid translating the bible into a language that is not in use in the community.\nBiLTA has trains data collectors from the language group and then analyses the data before recommendations are made about the state of the language.', 2, '2023-06-06 18:01:13', '2024-02-05 12:16:39', NULL),
(3, 'Training of translators, Community Check teams and Consulatnts for quality translation', 'BiLTA is a firm believer in training of Bible translation teams so that they have full understanding of the translation processes. This is basically one of the major keys in producing quality translation.\nINTRODUCTION TO COMPUTERS: Some of our staff have never had an opportunity to operate a computer. It is therefore very important for them to be given to learn how to use a laptop which they will be using in the translation process.\nINTRODUCTION TO TRANSLATION PRINCIPLES: They train the translation team all the processes of translation. This helps shape the understanding of the work they will be expected to carry out on a daily basis.\n\n', 2, '2023-06-14 14:44:54', '2023-10-05 05:11:40', NULL),
(4, 'Scripture Listening Program', 'Here are Five key elements that will help you implement a Scripture listening program and engage people with the Word of God\n* BibleListening\nListening to the word of God has its foundation in both the Old and New Testament. Gods covenant with Israel was renewed only after King Josiah read it out loud to the people (2Kings 23:2-3). it was Jesus\' custom to speak in the local synagogues, expounding the Scripturre to his community (Luke 4:16-21).\n* Group Engagement\nA group leader gathers interested peopl together in a consistent location to listen through Gods word chapter by chapter once a week. Listening for 30 minutes each week allows the hearers to finish the entire New Testament in a little less than a year.\n* Interaction\nThe group leader facilitates discussion betweengroup members. They talk about what they have heard  and what they should do about it . Scripture listening impacts people\'s lives and transform them.\n* Follow up\nRegular follow-up ensures that the group leaders are edified, participants are held accountable to one another, and Scripture listening is consistent ( Hebrews 10:24-25).\n*Reporting\nThis ensures the Audio Scriptures are being well-used. Reporting provides testimonies and photos to you and your church family and our partners and donors in a powerful way, as it shows firsthand how God\'s word is transforming lives. ', 1, '2023-06-14 15:24:59', '2024-02-07 14:21:47', NULL),
(5, 'Developing Gospel/Scripture Songs using traditional tunes', 'The African Music is developed based on events taking place in the villages.\nScripture in Songs is also developed in a manner that ministers to people who pass through different situations in life.\nWhat is God saying to the community experiencing challenging moments\nScripture in song also helps to praise and honour God in a way that relates to the culture of the people.\nAll translation sites have trained Choirs and Praise teams to develop songs using their traditional tunes. Please watch and allow God to minister to you through indigenous music.', 2, '2023-10-05 04:59:36', '2023-10-05 04:59:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `our_teams`
--

CREATE TABLE `our_teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `details` mediumtext NOT NULL,
  `position` varchar(191) NOT NULL,
  `from` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `to` timestamp NULL DEFAULT NULL,
  `facebook_url` varchar(191) DEFAULT NULL,
  `linkedin_url` varchar(191) DEFAULT NULL,
  `twitter_url` varchar(191) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_teams`
--

INSERT INTO `our_teams` (`id`, `name`, `phone`, `email`, `details`, `position`, `from`, `to`, `facebook_url`, `linkedin_url`, `twitter_url`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fr Jackson Jones Katete', '+1 (794) 644-7007', 'wyhapunex@mailinator.com', 'Chair', 'Executive Chair', '2023-06-06 09:22:55', NULL, 'Sapiente repudiandae', 'Qui velit eiusmod ut', 'Ad sed earum vitae i', 1, '2023-05-25 01:18:22', '2023-06-06 16:22:55', '2023-06-06 16:22:55'),
(2, 'Fr Katete Jackson Jones', '+260 97 7539067', 'frkatete@bilta.org', 'Driven by the passion to win souls in his hometown of Chama District who have never had a Bible in their local language Rev. Fr Jackson Jones Katete, an Anglican Priest, by the grace of God had a divine dream to have a Bible in Senga language. ', 'Executive Chairperson', '2023-12-22 08:49:02', NULL, 'https://www.facebook.com/profile.php?id=631726079', NULL, NULL, 2, '2023-06-10 17:10:52', '2023-12-22 15:49:02', '2023-12-22 15:49:02'),
(3, 'Pastor Isaac E. Lungu', '+260 97 7629680', 'ielungu@bilta.org', 'With a passion for God', 'National Secretary', '2023-06-10 10:42:59', NULL, NULL, NULL, NULL, 1, '2023-06-10 17:25:59', '2023-06-10 17:42:59', '2023-06-10 17:42:59'),
(4, 'Rev Ezeckia Ngulube', '+260973669616', 'ezeckiangulube@bilta.org', 'Passionate and loves the Lord and the mission to Evangelise', 'Vice Chairperson', '2023-12-22 08:49:18', NULL, NULL, NULL, NULL, 2, '2023-10-04 20:19:48', '2023-12-22 15:49:18', '2023-12-22 15:49:18'),
(5, 'Pastor Isaac E Lungu', '+260977629680 / +260966255510', 'eilungu74@gmail.com', 'Passion to see many lives transformed and many languages preserved as translation works are carried on with BiLTA.', 'National Executive Secretary', '2023-12-22 08:49:27', NULL, NULL, NULL, NULL, 2, '2023-12-19 02:42:44', '2023-12-22 15:49:27', '2023-12-22 15:49:27'),
(6, 'Vincent Riggy CHIBESA', '+260 97 7540313', 'chibesav@gmail.com', 'Passionate with Kingdom service', 'National Vice Secretary', '2023-12-22 08:02:30', NULL, NULL, NULL, NULL, 2, '2023-12-22 14:45:24', '2023-12-22 15:02:30', '2023-12-22 15:02:30'),
(7, 'Fr. Katete Jackson Jones', '+260977539067', 'frkatete@bilta.org', 'Driven by the passion to win souls in his hometown of Chama District who have never had a Bible in their local language Rev. Fr Jackson Jones Katete, an Anglican Priest, by the grace of God had a divine dream to have a Bible in Senga language.', 'National Executive Chairperson', '2025-05-29 13:49:26', NULL, 'https://web.facebook.com/profile.php?id=631726079', NULL, NULL, 1, '2023-12-22 15:07:15', '2025-05-29 20:49:26', NULL),
(8, 'Rev Ezeckia Ngulube', '+26097366916', 'ezekiangulube@bilta.org', 'Passionate and loves the Lord and the mission to evangelise', 'National Executive Vice Chairperson', '2025-05-29 13:50:07', NULL, NULL, NULL, NULL, 1, '2023-12-22 15:31:19', '2025-05-29 20:50:07', NULL),
(9, 'Pastor Isaac E. Lungu', '+260977629680 / +260966255510', 'isaacelungu@bilta.org', 'Passion to see many lives transformed and many languages preserved as translation works are carried on with BiLTA.', 'Executive Secretary', '2025-01-20 08:41:24', NULL, NULL, NULL, NULL, 1, '2023-12-22 15:37:06', '2025-01-20 15:41:24', '2025-01-20 15:41:24'),
(10, 'Apostle Vincent Riggy CHIBESA', '0977540313 / 0965540313', 'chibesav@bilta.org', 'Passionate with Kingdom Service', 'National Executive Secretary', '2025-05-29 13:50:32', NULL, 'https://www.facebook.com/chibesav', NULL, NULL, 1, '2023-12-22 15:48:43', '2025-05-29 20:50:32', NULL),
(11, 'Rev Martin P. Simangolwa ( Bth, Mcc)', '+260 979-427-282', 'simmartinp70@bilta.org/MartinSimangolwa@spoken.org', 'Pastor and marriage and relationship counselor', 'Programmes and Resource Develpment officer', '2024-02-13 14:50:14', NULL, 'https://www.facebook.com/profile.php?id=100064722367979&mibextid=ZbWKwL', NULL, 'https://x.com/SimangolwaP?t=oYXanYnEeQg5ZDaO9Fxbiw&s=09', 1, '2024-02-07 15:06:32', '2024-02-13 21:50:14', '2024-02-13 21:50:14'),
(12, 'Mtumbi Goma', '+260 971-974-680', 'mtumbigoma@bilta.org', 'Passionate about spreading the word of God.', ' Executive Treasurer', '2025-05-23 19:32:33', NULL, NULL, NULL, NULL, 1, '2024-02-08 16:27:38', '2025-05-24 02:32:33', '2025-05-24 02:32:33'),
(13, 'Mtumbi Goma', '+260 97 7629680', 'mtumbigoma@bilta.org', 'passionate about spreading the word of God ', 'National Executive Treasur', '2024-02-08 12:30:21', NULL, NULL, NULL, NULL, 1, '2024-02-08 19:28:57', '2024-02-08 19:30:21', '2024-02-08 19:30:21'),
(14, 'Pastor Dickson Nyirenda', '+260 976418534', 'dnyirenda@bilta.org', 'Passionate about spreading the wor of God', 'Operations and Programs Officer', '2024-11-08 10:45:07', NULL, NULL, NULL, NULL, 2, '2024-02-14 13:30:16', '2024-11-08 17:45:07', '2024-11-08 17:45:07'),
(15, 'Pastor Dickson Nyirenda', '+260 976418534', 'dnyirenda@bilta.org', 'Passionate with spreading the word of God', 'Operations and Programs Officer', '2024-02-19 14:28:59', NULL, NULL, NULL, NULL, 1, '2024-02-19 21:28:31', '2024-02-19 21:28:59', '2024-02-19 21:28:59'),
(16, 'Rev Martin P. Simangolwa', '+260 979-427-282', 'simmartinp70@bilta.org/MartinSimangolwa@spoken.org', 'Pastor  and marriage and relationship officer', 'Operations and Resource Development Officer', '2024-12-06 09:29:09', NULL, 'https://www.facebook.com/profile.php?id=631726079', '', '', 1, '2024-02-19 21:56:29', '2024-12-06 16:29:09', '2024-12-06 16:29:09'),
(17, 'Daniel Green Goma', '+260 976809138', 'gdgdgoma@bilta.org', 'Information and Communications Technology and Consultant-In-Training', 'ICT/CIT', '2024-11-08 10:22:52', NULL, NULL, NULL, NULL, 2, '2024-02-19 22:09:51', '2024-11-08 17:22:52', '2024-11-08 17:22:52'),
(18, 'Goma Daniel Green', '+260976809138', 'gdgdgoma@bilta.org', 'Information and Communications Technology/ Consultant in Training', 'ICT/CIT', '2024-12-06 09:29:05', NULL, NULL, NULL, NULL, 2, '2024-11-08 17:22:17', '2024-12-06 16:29:05', '2024-12-06 16:29:05'),
(19, 'Pastor Dickson Nyirenda', '+260976418534', 'dnyirenda@bilta.org', 'Passionate about spreading the Word of God', 'Operations and Programs Officer', '2024-12-06 09:29:02', NULL, NULL, NULL, NULL, 2, '2024-11-08 17:44:28', '2024-12-06 16:29:02', '2024-12-06 16:29:02'),
(20, 'Pastor Dickson Nyirenda', '(+260) 976-418-534', 'dnyirenda@bilta.org/dicksonnyirenda9@gmail.com', 'Pastor Dickson Nyirenda was born on 20 April 1981, in Chama District, Zambia. He began his education in 1989 and completed his Grade 12 at Isoka Secondary School in 2005. Passionate about theology, he earned a bachelor’s degree in theology from Vision International University in 2016. In 2024, he furthered his education with a diploma in human resource management and a master\'s degree in religious studies.\nProfessionally, Pastor Dickson has been serving as the Operations and Programs Officer at the Bible and Literature Translation Association (BiLTA) since September 18, 2023. He is also serving as a pastor.', 'Operations and Programs Officer', '2025-05-23 19:56:15', NULL, 'https://web.facebook.com/?_rdc=1&_rdr#', NULL, NULL, 1, '2024-12-06 17:11:39', '2025-05-24 02:56:15', '2025-05-24 02:56:15'),
(21, 'Rev Saiwel Mvula', '+260978282595', 'emmanuelsana3@gmail.com', 'Committed to the work of God', 'Committe member', '2025-05-23 19:56:31', NULL, NULL, NULL, NULL, 1, '2025-05-15 21:05:42', '2025-05-24 02:56:31', '2025-05-24 02:56:31'),
(22, 'Bishop Chackson Kango', '+260977371028', 'chackson@gmail.com', 'committed to the work of God', 'National Executive vice secretary ', '2025-05-29 14:43:36', NULL, NULL, NULL, NULL, 1, '2025-05-24 03:27:34', '2025-05-29 21:43:36', '2025-05-29 21:43:36'),
(23, 'Mtumbi Goma', '+260 97 1974680', 'mtumbigoma02@gmail.com', 'committed to the work of God', 'National Executive Treasurer', '2025-05-29 13:53:14', NULL, NULL, NULL, NULL, 1, '2025-05-28 18:36:23', '2025-05-29 20:53:14', NULL),
(24, 'Rev Andrew Chipeta', '+26097 7360730', 'revalchipeta@gmail.com', 'committed to the work of God ', 'Committe member', '2025-05-29 14:43:45', NULL, NULL, NULL, NULL, 1, '2025-05-29 15:01:25', '2025-05-29 21:43:45', '2025-05-29 21:43:45'),
(25, 'Rev Saiwel Mvula', '0978282595', 'saiwel4mvula@gmail.com', 'Committed to the work of God', 'Committe Member', '2025-05-29 14:43:51', NULL, NULL, NULL, NULL, 1, '2025-05-29 15:24:02', '2025-05-29 21:43:51', '2025-05-29 21:43:51'),
(26, 'Pastor Isaac Lungu', '+260 977629680', 'eilungu74@gmail.com', 'Committed to the work of God', 'Committe member', '2025-05-29 14:43:56', NULL, NULL, NULL, NULL, 1, '2025-05-29 15:35:30', '2025-05-29 21:43:56', '2025-05-29 21:43:56'),
(27, 'Pastor Dickson Nyirenda', '+260 97 6418534', 'dnyirenda@bilta.org', 'Pastor Dickson Nyirenda was born on 20th  April, 1981, in Chama District, Zambia. He began his education in 1989 and completed his Grade 12 at Isoka Secondary School in 2005. Passionate about theology, he earned a Bachelor’s degree in Theology from Vision International University in 2016. In 2024, he furthered his education with a Diploma in Human Resource Management and a Master\'s degree in Religious Studies.\nProfessionally, Pastor Dickson has been serving as the Operations and Programs Officer at the Bible and Literature Translation Association (BiLTA) since September 18, 2023. He is also serving as a pastor.', 'Operations and Programs officer', '2025-05-29 14:45:12', NULL, NULL, NULL, NULL, 1, '2025-05-29 15:49:31', '2025-05-29 21:45:12', '2025-05-29 21:45:12'),
(28, 'Emmanuel Sana', '+260979316812', 'ebsana@bilta.org', 'Committed to the work of God', 'Personal assistance ', '2025-05-29 14:45:07', NULL, 'https://www.facebook.com/emmanuelbwalyasanajunior', NULL, NULL, 1, '2025-05-29 16:08:56', '2025-05-29 21:45:07', '2025-05-29 21:45:07'),
(29, 'Jailos Daka', '+260 97 3097114', 'dakajailos891@gmail.com', 'I come from a Christian background and am a devoted member of the Anglican Church. I currently serve as an Assistant Researcher with the Bible and Literature Translation Association (BiLTA), where I conduct language surveys in communities whose languages do not yet have a Bible in their local mother tongue. This work helps determine the need and readiness for Bible translation and literacy development.\n\nI completed my secondary education at Munali Boys Secondary School in Lusaka in 2013. I graduated from the University of Zambia in 2020 with a Bachelor of Education degree, specializing in Literacy and Language with English.\n\nI am passionate about research, language development, and faith-based service. I am the second born in a family of four children. As I approach my 30th birthday, I remain committed to using my skills and knowledge to empower communities through education, language preservation, and the transformative power of Scripture in the heart language.', 'Assistant research officer', '2025-05-29 14:45:18', NULL, 'https://www.facebook.com/jailosj.rish', NULL, NULL, 1, '2025-05-29 16:39:41', '2025-05-29 21:45:18', '2025-05-29 21:45:18'),
(30, 'Bishop Chackson Kango', '+260977371028', 'chaka@bilta.org', 'Committed to the work of God', 'National Executive Vice Secretary', '2025-01-17 07:00:00', NULL, NULL, NULL, NULL, 1, '2025-05-29 21:51:13', '2025-05-29 21:51:13', NULL),
(31, 'Rev Andrew Chipeta', '+26097 7360730', 'revalchipeta@gmail.com', 'Committed to the work of God', 'Committe member', '2019-05-10 07:00:00', NULL, NULL, NULL, NULL, 1, '2025-05-29 21:55:20', '2025-05-29 21:55:20', NULL),
(32, 'Rev Saiwel Mvula ', '+260978282595', 'saiwel4mvula@gmail.com', 'Committed to the work of God', 'Committee member', '2019-04-18 07:00:00', NULL, NULL, NULL, NULL, 1, '2025-05-29 22:01:39', '2025-05-29 22:01:39', NULL),
(33, 'Pastor Isaac Lungu', '+260 97 7629680', 'eilungu74@gmail.com', 'Committed to the work of God', 'Committe member', '2025-01-17 07:00:00', NULL, NULL, NULL, NULL, 1, '2025-05-29 22:12:13', '2025-05-29 22:12:13', NULL),
(34, 'Pastor Dickson Nyirenda', '+260 97 6418534', 'dnyirenda@bilta.org', 'Pastor Dickson Nyirenda was born on 20th  April, 1981, in Chama District, Zambia. He began his education in 1989 and completed his Grade 12 at Isoka Secondary School in 2005. Passionate about theology, he earned a Bachelor’s degree in Theology from Vision International University in 2016. In 2024, he furthered his education with a Diploma in Human Resource Management and a Master\'s degree in Religious Studies.\nProfessionally, Pastor Dickson has been serving as the Operations and Programs Officer at the Bible and Literature Translation Association (BiLTA) since September 18, 2023. He is also serving as a pastor.', 'Operations and Programs officer', '2023-09-15 07:00:00', NULL, NULL, NULL, NULL, 1, '2025-05-29 22:15:34', '2025-05-29 22:15:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `our_values`
--

CREATE TABLE `our_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_values`
--

INSERT INTO `our_values` (`id`, `title`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Aute ut excepturi de', 'Mollitia lorem volup', 3, '2023-04-27 10:29:14', '2023-04-27 10:29:36', '2023-04-27 10:29:36'),
(2, 'Quality Translation for real transformation', 'Quality translation is associated with the clarity of the passage in relation to the source text and the receptor language.\nQuality translation is actualised in the training of the translators, Community Check teams and the Consultants.\nQuality translation is embedded in the passion and calling of the translators.', 1, '2023-10-04 19:39:02', '2023-11-15 21:51:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ebsana@bilta.org', '$2y$10$QsSA4vEprWmawuCmpePw.On21lLkPkLLc8IcGN16/hXtRZadP0VAq', '2024-12-14 17:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Montana Chavez', 'Vitae in a rem nobis', '2023-02-26 02:07:45', '2023-02-26 02:07:45'),
(2, 'Arden Owenskk', 'Dolores expedita asp', '2023-02-26 03:30:59', '2023-02-26 03:50:56'),
(3, 'Xaviera Farrell', 'Amet quia saepe sap', '2023-02-26 03:31:06', '2023-02-26 03:31:06'),
(4, 'Zelenia Carpenterm', 'Qui alias est enim ', '2023-02-26 03:32:25', '2023-02-26 03:51:59'),
(7, 'Emery Jenkins', 'Non eveniet sed sed', '2023-02-27 04:18:21', '2023-02-27 04:18:21'),
(8, 'Nathaniel Hoffman', 'Eaque optio et temp', '2023-02-27 04:18:28', '2023-02-27 04:18:28'),
(9, 'Illana Miller', 'Assumenda culpa qui', '2023-02-27 04:18:37', '2023-02-27 04:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `short_description` text NOT NULL,
  `post_date` varchar(191) NOT NULL,
  `author` varchar(191) NOT NULL,
  `details` mediumtext NOT NULL,
  `location` varchar(191) NOT NULL,
  `location_map` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `short_description`, `post_date`, `author`, `details`, `location`, `location_map`, `created_by`, `status_id`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'Senga Oral Bible Translation Project', 'SOBT Project', '2025-04-16', 'Goma', 'Senga Oral Bible Translation Project is located in Chama District Eastern Province Zambia. It is the first project for Bible and Literature Translation Association which started in 2019. \n\n.\nIt started with the following members of staff listed with their responsibilities:\nRev. Frackson Ndhlovu, Team Leader/Exegete/Translation Advisor (TA), Mr Goma Daniel Green, Deputy Team Leader/Translation Advisor (TA), Mrs Bertha Chilembo Shawa, Translator, Mr Francis Milazi, Translator, Miss Suzan Mbuzi, Translator and Mr John Kumwenda, Translator. \n.\nWith Security Officers as follows:\nMr Maina Kabandama, Head Security Officer and Mr Yotam Nyirenda, Security Officer.\n.\nThe current members of staff with their roles include:\nA. Main Office:\nRev. Goliath Munthali, Team Leader/Exegete/Translation Advisor (TA), Mr Francis Milazi Deputy Team Leader/Translation Advisor (TA), Mr. Ntheye Nyirenda, Translator, Miss Angela Chondoka, Translator, Pr. Gibson Mtonga, Translator and Mrs Esther Kaluba Banda, Translator.\n\nWith Security Officers as follows:\nYotam Nyirenda, Head Security Officer and Komechi Chipeta, Securiy Officer\n\nB. Extension Office:\nMrs Bertha Chilembo Shawa, Team Leader/Translation Advisor (TA)/Coach Trainer, Rev. John Kumwenda Team Leader/Exegete/Translation Advisor (TA), Mr John Kumwenda, Translator, Miss Thandiwe Mukhalipi, Translator, Mr Bydon Nyirenda, Translator and Mr Aaron Mbuzi\n\nWith Security Officers as follows:\nMr Joseph Chikomazga, Head Security Officer and Mr Komani Goma, Security Officer\n\nThe project has completed the New Testament which was launched on 12th April, 2025 at Chama Boarding Secondary School in Chama District, Eastern Province of Zambia. \n\n\n\n\n\n\nThe ', 'Lusaka', '06/12/2024', 4, 1, 5, '2024-08-24 00:03:47', '2025-04-16 22:47:55', NULL),
(6, 'Fungwe Oral Bible Translation project', 'FOBT Project', '2024-08-24', 'Goma', 'Fungwe Oral Bible Translation project started in 2022. \n\nBooks Available\nThe project currently has two completed books being used by the community which are the books of Luke and Acts and the team is translating the book of Matthew.\n\nThe translators and positions they hold: \nRev. John Simbeye (Team Leader) \nPr. Kelson Muwowo (Deputy Team Leader) \nMr. Aaron Sichone (Translator)\nMrs. Lucy  Chilongo (Translator)\nMr. Wilson Ng’ambi (Translator)\nMs. Janet Sinkala (Translator)\nMr. Austine Ng’ambi (Back Translator)\nMr. Lombani Singogo (Head Security Officer)\nMr. Origin Chilongo (Security Officer). \n\n\n\n\n\n', 'Lusaka', '08/24/2024', 4, 1, 26, '2024-08-24 21:16:11', '2025-05-30 16:14:08', NULL),
(7, 'Lambya Oral Bible Translation Project', 'LOBT PROJECT', '2024-12-06', 'Goma', 'Lambya Oral Bible Translation project is located in Isoka District, Muchinga Province. It was established in 2022. In 2024 received the second office. Currently translators are working on the books of Matthew and Romans having completed Luke and Acts. In total, the project has 18 members of staff. ', 'Lusaka', '06/12/2024', 2, 1, 27, '2024-12-06 18:52:32', '2024-12-06 18:52:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'Administrator', '2023-02-27 04:29:19', '2025-05-15 01:28:20'),
(2, 'Editor', 'editor', '2023-02-27 04:29:29', '2023-03-10 00:25:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(3, 1, 4, NULL, NULL),
(4, 1, 10, NULL, NULL),
(5, 1, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `website_url` varchar(191) DEFAULT NULL,
  `description` varchar(191) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'Active', '2023-03-04 07:59:23', '2025-07-11 17:30:16'),
(2, 'Deactivated', 'Deactivated', '2023-03-04 08:00:29', '2025-07-11 17:30:28'),
(3, 'Pending', 'Pending', '2023-03-04 08:02:21', '2023-03-04 08:07:02'),
(4, 'Approved', 'Approved', '2023-03-04 08:04:46', '2023-03-04 08:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `testimonial` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `title`, `testimonial`, `status_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jailos Daka', 'Bridging Language Barriers', 'BILTA\'s dedication to breaking language barriers is truly remarkable. Their translation projects have made bible truths accessible to a wider audience, promoting understanding and inclusivity. The professionalism and expertise evident in their work showcase their commitment to delivering high-quality translations. I think BILTA is a valuable resource for anyone seeking reliable and accurate translation services.', 2, 1, '2023-05-25 02:30:03', '2023-05-25 02:30:03', NULL),
(2, 'Dustin Banks', 'Ad tenetur distincti', 'Sit quaerat non cumq', 1, 1, '2025-05-30 02:22:26', '2025-05-30 02:35:34', NULL),
(3, 'Wallace Henderson', 'Excepteur dolore eve', 'Non do do aut dolore', 0, 0, '2025-11-02 19:12:06', '2025-11-02 19:12:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `title` text DEFAULT NULL,
  `description` longtext NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonies`
--

INSERT INTO `testimonies` (`id`, `name`, `title`, `description`, `status_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mr. Yobe Goma. Chama District Commissioner', 'Testimony', 'This program of translating the Bible into Senga has come at the right time when the people of Chama District did not have their own Bible to use and understand the word of God. Now that you people have brought us a gift that gives life to everyone, it is really something that we will be forever grateful for.\nThe Senga Oral Bible Translation has really transformed the lives of people. People from all seven chiefdoms in the district attended. Establishments of the Senga Bible on that day will forever remain. It was so colorful and so touching, reaching man in totality. It was an experience that we had never have before. We can see this from the number of people who were in attendance. There were so many people who came such that the space was just too small to accommodate everyone who was outside the hall who needed to see the live proceedings. This needed an open space.\nNevertheless, that was not very important because the important thing is what you gave out on that day, the proclaimers, which will continue impacting people\'s lives. The Senga people are therefore encouraged to support the translation organization, as they have brought us the word of God, which we cannot live without. I believe that all the churches in Chama district will support the organization because it continues to bring us a lot of literature in Senga.\nEven as the government, we will continue to support this organization because it is helping us a lot. You can imagine, for the very first time, we sang the national anthem in our own language, Senga, for the very first time. Whenever you need us, we are there because you deserve our help. We will continue to work together, including the activities you have, so that we can contribute more.', 1, '2025-05-15 21:32:27', '2025-05-19 20:47:08', NULL),
(2, 'Musa Mulambia. Tambo OBT publicity officer', 'Testimony', 'I, Musa Mulambia, would like to express my heartfelt gratitude to the Bible and Literature Translation Association (BILTA) for the remarkable impact you have made in my life.\n\nYour support has uplifted me financially, strengthened me physically, and helped me grow spiritually. I never imagined that I could ever travel around Zambia—but today, I have begun to move and minister in ways I once thought impossible. This transformation has been made possible through your unwavering support and God\'s grace.\n\nOne verse that speaks directly to my experience is Jeremiah 33:3:\n“Call to me and I will answer you and tell you great and unsearchable things you do not know.”\nIndeed, I called on the Lord, and through BILTA, He answered in ways that continue to amaze me. My life has changed, and my spirit has been lifted.\n\nMay God continue to bless BILTA and every hand and heart that makes its mission possible. Thank you for being a vessel of hope and change in my life.\n\nWith deepest appreciation,', 2, '2025-05-24 02:09:38', '2025-06-02 15:16:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(250) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `login` int(11) NOT NULL DEFAULT 0,
  `logins` int(11) NOT NULL DEFAULT 0,
  `status_id` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `password_change` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `phone`, `last_login`, `login`, `logins`, `status_id`, `email_verified_at`, `password`, `password_change`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'qwerqwexljfdasfkdjf-23423ladfdf', 'Emmanuel Sana', 'ebsana@bilta.org', '+1 (393) 146-6733', '2025-12-05 15:57:16', 0, 197, NULL, NULL, '$2y$10$H7JsTKX/lNaaEoDxR0pXL..eEYc19q9/Cqxz0RgMr/6Iz6tCGGZK6', 0, '7zp8G7BaHNXQ4M8Yp2LFpn0i0Yz4C9ny9Eg3veJZ6px5MWIO9neSngqRF8eg', '2023-02-26 02:00:05', '2025-12-05 15:57:16'),
(2, 'fkjldksfjsldfowerwer3243233234', 'Fr Katete', 'frkatete@bilta.org', '90933333', '2025-07-03 17:15:12', 0, 36, NULL, NULL, '$2y$10$H7JsTKX/lNaaEoDxR0pXL..eEYc19q9/Cqxz0RgMr/6Iz6tCGGZK6', 0, 'jvPAIPNog145Fm4AUcgJ2W2dUW6FpjXaZKuRuvAoUokiPr1lSHDHCRnUEbAY', '2023-02-26 02:47:33', '2025-07-03 17:15:12'),
(3, 'fkjldksfjsldfowerwer3243233', 'James Chigayo', 'jameschigayo@bilta.org', '0979782323', '2025-05-31 00:16:02', 0, 13, NULL, NULL, '$2y$10$/ltG0REoGb1vushljHeAbOyys33/ZQcfZK5funlCYuC91r40MNlyW', 0, NULL, '2023-03-04 06:59:57', '2025-05-31 00:16:02'),
(4, '085661c7-affa-454e-8a2f-90e8e1e44d18', 'Goma Daniel  Green ', 'gdgdgoma@bilta.org', '09790000', '2025-04-16 22:38:17', 0, 1, 1, NULL, '$2y$10$upoL1YbMKZnf2qk1ZGm.BuM9wRjSWXdRi.cQj/SycNAQIQxTd1I.q', 0, 'YkPZSa8SLyj1XCYywyLOdCvt0uKRVK134OpEeNOqIoSAat71Axf1VW6VNrxG', '2025-04-16 22:15:10', '2025-04-16 22:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(3, 1, 2, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 3, 1, NULL, NULL),
(6, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `video_item`
--

CREATE TABLE `video_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `video_link` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_prayer_points`
--

CREATE TABLE `weekly_prayer_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL,
  `details` longtext NOT NULL,
  `scriptures` varchar(500) NOT NULL,
  `status_id` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_prayer_points`
--

INSERT INTO `weekly_prayer_points` (`id`, `title`, `details`, `scriptures`, `status_id`, `post_date`, `year`, `month`, `week`, `day`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'The word of God is productive', 'Isaiah 55:8-13\nNew International Version\n8 “For my thoughts are not your thoughts,\n    neither are your ways my ways,”\ndeclares the Lord.\n9 “As the heavens are higher than the earth,\n    so are my ways higher than your ways\n    and my thoughts than your thoughts.\n10 As the rain and the snow\n    come down from heaven,\nand do not return to it\n    without watering the earth\nand making it bud and flourish,\n    so that it yields seed for the sower and bread for the eater,\n11 so is my word that goes out from my mouth:\n    It will not return to me empty,\nbut will accomplish what I desire\n    and achieve the purpose for which I sent it.\n12 You will go out in joy\n    and be led forth in peace;\nthe mountains and hills\n    will burst into song before you,\nand all the trees of the field\n    will clap their hands.\n13 Instead of the thornbush will grow the juniper,\n    and instead of briers the myrtle will grow.\nThis will be for the Lord’s renown,\n    for an everlasting sign,\n    that will endure forever.”', 'Isaiah 55 vs 8-13', 1, '2025-11-13 07:19:11', 2024, 1, 2, 8, 2, '2023-06-10 17:06:34', '2025-11-13 14:19:11', '2025-11-13 14:19:11'),
(2, 'Serving the Lord Faithfully', 'The prophecy came to the edomites and Israelites on pride of Esau and the restoration of Israel. The Lord was not happy with the pride of Esau against the brother.  God does not love those who lift themselves. He says, he will bring such down as he knows what is in the heart. Pride is the beginning of someone\'s downfall. This is an encouragement to many of us to be humble and God will lift us up. He warns us not to be happy when our friends are facing hard times or enemies rise against them. Esau was so happy when the adversaries rose against His brother. This was not good in the sight of the Lord. God therefore promised to lift up the house of Jacob and be in Zion. He will remember the Israelites as His own. As we serve the Lord with humility, he will make us enter in his kingdom and rejoice with him all times. There is no need to be jealousy but be content with what we have and all what God is doing in our Lives. He emphasizes that we remain humble and serve the Lord faithfully. Therefore, Let us serve the Lord in humility as we continue being faithful. We should be able to stand with our friends in all their work and troubles. God wants us to be faithful to the end. God loves us and all and want us to be humble servants.', 'Obadiah 1:1-4, 15-18', 2, '2025-11-13 07:19:05', 2023, 10, 40, 2, 1, '2023-10-02 20:29:06', '2025-11-13 14:19:05', '2025-11-13 14:19:05'),
(3, 'Faith  ', 'This week we are praying for:\ni. Unity among the translators. \nii. Praying for all the partners and for Gods protection on all the staffs\niii. Praying for all the consultant for God to give them strength.\n', 'Hebrews 10:38-39, 11:1\n\n', 2, '2025-11-13 07:18:56', 2023, 12, 50, 15, 1, '2023-12-15 21:42:53', '2025-11-13 14:18:56', '2025-11-13 14:18:56'),
(4, 'Praise God', 'What it means to praise God?\nPraise and worship are opportunities to speak from your heart to the heart of God. When you praise and worship, you speak, sing, declare, and proclaim who God is and His power, as well as who you are as His child. Again, it reflects a connection—an intimate space—between you and Him.', 'Revelation 12:11', 2, '2025-11-13 07:19:01', 2024, 1, 1, 5, 1, '2024-01-05 22:28:03', '2025-11-13 14:19:01', '2025-11-13 14:19:01'),
(5, 'Breakthrough in Language Development', '* Interceding for the new language development officer for God’s grace in his new role.\n* Praying for wisdom and creativity for language development. \n', 'Psalm 32:8', 1, '2025-11-13 08:56:46', 2025, 11, 46, 10, 1, '2025-11-13 14:13:58', '2025-11-13 15:56:46', NULL),
(6, ' Joy in the work of Bible Translation', '* Lift up consultants, translators, and local team, asking for wisdom, endurance, and deep encouragement as they serve.\n* praying that every consultant finds joy and the lord be their strength as they do their work in various OBT\'s', 'Psalm 19:8', 1, '2025-11-12 07:00:00', 2025, 11, 46, 12, 1, '2025-11-13 14:34:56', '2025-11-13 14:34:56', NULL),
(7, 'Grace and Strength for OBT Trainers', 'Praying for clarity, patience, and spiritual strength aas they equip others for the work of Bible Translation.', 'Colossians 3:23', 1, '2025-11-14 07:00:00', 2025, 11, 46, 14, 1, '2025-11-13 15:43:12', '2025-11-13 15:43:12', NULL),
(8, 'Loyalty and commitment ', '* Praying that all BiLTA members remain loyal to their calling in serving the Lord through translation.\n* Praying for unity and clarity of purpose among members of staff.\n* praying for a spirit of humility and grace in every member of staff that is involved with BiLTA and its mission.', '1 Corinthians 4:2', 1, '2025-11-07 07:00:00', 2025, 11, 45, 7, 1, '2025-11-13 15:56:13', '2025-11-13 15:56:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_files`
--
ALTER TABLE `audio_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chairman_messages`
--
ALTER TABLE `chairman_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cookie_consents`
--
ALTER TABLE `cookie_consents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `f_a_qs`
--
ALTER TABLE `f_a_qs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_item`
--
ALTER TABLE `gallery_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_intros`
--
ALTER TABLE `home_intros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_item`
--
ALTER TABLE `news_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_services`
--
ALTER TABLE `our_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_teams`
--
ALTER TABLE `our_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_values`
--
ALTER TABLE `our_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_item`
--
ALTER TABLE `video_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly_prayer_points`
--
ALTER TABLE `weekly_prayer_points`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audio_files`
--
ALTER TABLE `audio_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chairman_messages`
--
ALTER TABLE `chairman_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cookie_consents`
--
ALTER TABLE `cookie_consents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `f_a_qs`
--
ALTER TABLE `f_a_qs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_item`
--
ALTER TABLE `gallery_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `home_intros`
--
ALTER TABLE `home_intros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `news_item`
--
ALTER TABLE `news_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `our_services`
--
ALTER TABLE `our_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `our_teams`
--
ALTER TABLE `our_teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `our_values`
--
ALTER TABLE `our_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `video_item`
--
ALTER TABLE `video_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `weekly_prayer_points`
--
ALTER TABLE `weekly_prayer_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
