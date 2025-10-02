CREATE DATABASE businesscards;

USE businesscards;

-- backtick szerepe, camelCase 
CREATE TABLE `cards` (
  `id` int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;


INSERT INTO `cards` (`name`, `companyName`, `phone`, `email`, `photo`, `status`, `note`) VALUES
('Kovács Anna', 'TechSolutions Kft.', '3612345678', 'anna@techsolutions.com', 'w01.jpg', NULL, 'Webfejlesztési projektek koordinálása, UX tervezés, Frontend fejlesztés. Specialitás: React és Vue.js keretrendszerek.'),
('Nagy Péter', 'CreativeDesign Studio', '3620987654', 'peter@creativedesign.hu', 'm01.jpg', NULL, 'Grafikai tervezés, arculattervezés, brand identity. Szoftverek: Adobe Creative Suite, Figma, Sketch.'),
('Horváth Eszter', 'DataInsight Analytics', '36301234567', 'eszter@datainsight.com', 'w02.jpg', NULL, 'Adatelemzés, üzleti intelligencia, adatvizualizáció. Szakterület: Python, SQL, Tableau, Power BI.'),
('Tóth Balázs', 'CloudTech Services', '36701234567', 'balazs@cloudtech.hu', 'm02.jpg', NULL, 'Felhőalapú megoldások, AWS és Azure szakértő. DevOps mérnöki gyakorlattal.'),
('Farkas Zsuzsi', 'GreenFuture Consulting', '3630987654', 'zsuzsa@greenfuture1.org', 'w03.jpg', NULL, 'id = 5; Fenntarthatósági tanácsadás, környezetvédelmi projektek menedzsmentje.'),
('Varga Gábor', 'LegalAssist Kft.', '36201234567', 'gabor@legalassist.hu', 'm03.jpg', NULL, 'Vállalati jogi tanácsadás, szerződéskészítés, GDPR szakértő.'),
('Molnár Éva', 'HealthPlus Clinic', '3670987654', 'eva@healthplus.hu', 'w04.jpg', NULL, 'Egészségügyi menedzsment, klinikai irányítás, minőségbiztosítás.'),
('Szabó Dávid', 'FinTech Innovations', '3630456789', 'david@fintech.io', 'm04.jpg', NULL, 'Pénzügyi technológiai megoldások, blockchain fejlesztés, fintech startup mentorálás.'),
('Kiss Alexandra', 'EduGrowth Academy', '3670456789', 'alexandra@edugrowth.edu', 'w05.jpg', NULL, 'Oktatástechnológia, digitális tananyagfejlesztés, e-learning rendszerek tervezése.'),
('Papp László', 'ConstructPro Ltd.', '3630567890', 'laszlo@constructpro.hu', 'm05.jpg', NULL, 'Építőipari projektmenedzsment, állagmegóvási stratégiák, kivitelezési felügyelet.');
