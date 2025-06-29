-- ///////////////////////////////////////////////////////////////////////////////
-- DÉBUT DE LA TRANSACTION
-- ///////////////////////////////////////////////////////////////////////////////
START TRANSACTION;


-- ///////////////////////////////////////////////////////////////////////////////
-- Base de données
-- ///////////////////////////////////////////////////////////////////////////////
DROP DATABASE IF EXISTS `OpportuniStage`;
CREATE DATABASE `OpportuniStage`;
USE `OpportuniStage`;


-- ///////////////////////////////////////////////////////////////////////////////
-- Tables
-- ///////////////////////////////////////////////////////////////////////////////
CREATE TABLE `users` (
    `user_id` INT NOT NULL,
    `user_name` VARCHAR(255) NOT NULL,
    `user_email` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `user_role` ENUM('admin', 'student', 'company') NOT NULL
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `companies` (
    `company_id` INT NOT NULL,
    `company_user_id` INT NOT NULL,
    `company_name` VARCHAR(255) DEFAULT NULL, 
    `company_phone_number` VARCHAR(20) DEFAULT NULL,
    `company_sector` ENUM(
        'administration',
        'agriculture',
        'construction',
        'communication',
        'commerce',
        'education',
        'energy',
        'finance',
        'health',
        'hospitality',
        'industry',
        'it',
        'law',
        'telecom',
        'transport'
    ) DEFAULT NULL,
    `company_size` ENUM(
        'micro',
        'small',
        'medium',
        'large'
    ) DEFAULT NULL,
    `company_description` TEXT DEFAULT NULL,
    `company_website` VARCHAR(255) DEFAULT NULL,
    `company_address` VARCHAR(255) DEFAULT NULL,
    `company_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `company_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `offers` (
    `offer_id` INT NOT NULL,
    `offer_company_id` INT NOT NULL,
    `offer_title` VARCHAR(255) NOT NULL,
    `offer_description` TEXT NOT NULL,
    `offer_location` VARCHAR(255) NOT NULL,
    `offer_sector` ENUM(
        'administration',
        'agriculture',
        'construction',
        'communication',
        'commerce',
        'education',
        'energy',
        'finance',
        'health',
        'hospitality',
        'industry',
        'it',
        'law',
        'telecom',
        'transport'
    ) NOT NULL,
    `offer_type` ENUM('full-time', 'part-time') NOT NULL,
    `offer_duration` INT NOT NULL,
    `offer_deadline` DATE NOT NULL,
    `offer_profile` TEXT NOT NULL,
    `offer_remuneration` INT NOT NULL,
    `offer_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `offer_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `students` (
    `student_id` INT NOT NULL,
    `student_user_id` INT NOT NULL,
    `student_name` VARCHAR(255) NOT NULL,
    `student_university` VARCHAR(255) NOT NULL,
    `student_field` ENUM(
        'computer_science',
        'engineering',
        'management',
        'law',
        'economics',
        'medicine',
        'communication',
        'social_sciences'
    ) NOT NULL,
    `student_level` ENUM(
        'licence_1',
        'licence_2',
        'licence_3',
        'master_1',
        'master_2'
    ) NOT NULL,
    `student_phone_number` VARCHAR(20) DEFAULT NULL,
    `student_birthdate` DATE DEFAULT NULL,
    `student_about` TEXT DEFAULT NULL,
    `student_cv` VARCHAR(255) DEFAULT NULL,
    `student_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `student_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `applications` (
    `application_id` INT NOT NULL,
    `application_student_id` INT NOT NULL,
    `application_offer_id` INT NOT NULL,
    `application_status` ENUM('waiting', 'accepted', 'refused') DEFAULT 'waiting',
    `application_created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


-- ///////////////////////////////////////////////////////////////////////////////
-- Enregistrements
-- ///////////////////////////////////////////////////////////////////////////////
INSERT INTO `offers` 
(`offer_company_id`, `offer_title`, `offer_description`, `offer_location`, `offer_sector`, `offer_type`, `offer_duration`, `offer_deadline`, `offer_profile`, `offer_remuneration`)
VALUES

-- Offres TechVision (IT)
(1, 'Développeur Front-End', 'Contribuer au développement d’applications web.', 'Kinshasa', 'it', 'full-time', 12, '2025-09-10', 'Maîtrise de JavaScript.', 700),
(1, 'Ingénieur DevOps', 'Optimiser les pipelines CI/CD.', 'Kinshasa', 'it', 'full-time', 16, '2025-09-20', 'Expérience en Cloud.', 1000),
(1, 'Testeur QA', 'Effectuer les tests logiciels.', 'Kinshasa', 'it', 'part-time', 8, '2025-08-30', 'Rigueur et précision.', 500),
(1, 'Développeur Back-End', 'Développer des API REST.', 'Kinshasa', 'it', 'full-time', 14, '2025-09-15', 'Node.js.', 800),
(1, 'Chef de Projet Digital', 'Piloter les projets agiles.', 'Kinshasa', 'it', 'full-time', 20, '2025-09-25', 'Compétences en gestion.', 1200),

-- Offres Afrimarket (Commerce)
(2, 'Assistant Commercial', 'Support aux ventes.', 'Kinshasa', 'commerce', 'full-time', 12, '2025-08-20', 'Bon relationnel.', 500),
(2, 'Responsable Rayon', 'Gérer les stocks.', 'Kinshasa', 'commerce', 'full-time', 16, '2025-09-10', 'Expérience retail.', 700),
(2, 'Chargé Marketing', 'Créer des campagnes.', 'Kinshasa', 'commerce', 'part-time', 8, '2025-09-01', 'Créativité.', 0),
(2, 'Analyste Commercial', 'Suivi des indicateurs.', 'Kinshasa', 'commerce', 'part-time', 10, '2025-09-15', 'Maîtrise Excel.', 600),
(2, 'Vendeur Comptoir', 'Accueil clients.', 'Kinshasa', 'commerce', 'full-time', 14, '2025-09-20', 'Bonne présentation.', 400),
(2, 'Stagiaire Marketing', 'Community management.', 'Kinshasa', 'commerce', 'part-time', 6, '2025-08-25', 'Motivation.', 0),

-- Offres AgroPrime (Agriculture)
(3, 'Technicien Agricole', 'Production végétale.', 'Kimpese', 'agriculture', 'full-time', 12, '2025-08-30', 'Connaissances agricoles.', 500),
(3, 'Assistant Qualité', 'Contrôles produits.', 'Kimpese', 'agriculture', 'part-time', 8, '2025-09-10', 'Rigueur.', 0),
(3, 'Chargé de Production', 'Planification.', 'Kimpese', 'agriculture', 'full-time', 16, '2025-09-20', 'Organisation.', 600),
(3, 'Technicien Irrigation', 'Installer systèmes.', 'Kimpese', 'agriculture', 'full-time', 14, '2025-09-05', 'Hydraulique.', 700),
(3, 'Agent Logistique', 'Gérer stock.', 'Kimpese', 'agriculture', 'full-time', 10, '2025-09-01', 'Permis B.', 0),

-- Offres Constructo RDC (Construction)
(4, 'Conducteur Travaux', 'Superviser chantier.', 'Kinshasa', 'construction', 'full-time', 18, '2025-09-30', 'Expérience chantier.', 1000),
(4, 'Technicien BTP', 'Relevés topographiques.', 'Kinshasa', 'construction', 'part-time', 10, '2025-08-25', 'AutoCAD.', 800),
(4, 'Chargé Sécurité', 'Prévention HSE.', 'Kinshasa', 'construction', 'full-time', 14, '2025-09-15', 'HSE.', 900),
(4, 'Stagiaire Ingénieur', 'Aide au chef projet.', 'Kinshasa', 'construction', 'part-time', 8, '2025-09-01', 'Etudes en cours.', 0),
(4, 'Chef Projet', 'Coordination.', 'Kinshasa', 'construction', 'full-time', 20, '2025-09-25', 'Expérience.', 1500),

-- Offres MediPlus Santé (Health)
(5, 'Assistant Médical', 'Accueil patients.', 'Kinshasa', 'health', 'part-time', 8, '2025-08-20', 'Diplôme paramédical.', 0),
(5, 'Infirmier', 'Soins.', 'Kinshasa', 'health', 'full-time', 12, '2025-09-05', 'Expérience.', 700),
(5, 'Pharmacien Assistant', 'Gérer stock.', 'Kinshasa', 'health', 'full-time', 10, '2025-09-10', 'Formation pharma.', 600),
(5, 'Technicien Laboratoire', 'Analyses.', 'Kinshasa', 'health', 'full-time', 14, '2025-09-15', 'Technique.', 800),
(5, 'Secrétaire Médical', 'Dossiers.', 'Kinshasa', 'health', 'part-time', 6, '2025-08-15', 'Organisation.', 0),

-- Offres ComNet (Communication)
(6, 'Community Manager', 'Réseaux sociaux.', 'Gombe', 'communication', 'part-time', 10, '2025-08-25', 'Créativité.', 500),
(6, 'Graphiste', 'Supports visuels.', 'Gombe', 'communication', 'full-time', 12, '2025-09-05', 'Photoshop.', 700),
(6, 'Chargé Communication', 'Stratégie.', 'Gombe', 'communication', 'full-time', 14, '2025-09-20', 'Rédaction.', 600),
(6, 'Monteur Vidéo', 'Montage.', 'Gombe', 'communication', 'part-time', 8, '2025-09-01', 'Créatif.', 0),
(6, 'Assistant Événementiel', 'Organisation.', 'Gombe', 'communication', 'part-time', 6, '2025-08-15', 'Bonne présentation.', 0),

-- Offres GreenEnergy (Energy)
(7, 'Technicien Solaire', 'Installer panneaux.', 'Lubumbashi', 'energy', 'full-time', 12, '2025-09-10', 'Electricité.', 700),
(7, 'Assistant Projets', 'Suivi projets.', 'Lubumbashi', 'energy', 'part-time', 8, '2025-09-05', 'Gestion projets.', 0),
(7, 'Chargé Maintenance', 'Entretenir installations.', 'Lubumbashi', 'energy', 'full-time', 16, '2025-09-25', 'Techniques.', 600),
(7, 'Ingénieur Énergie', 'Optimiser rendement.', 'Lubumbashi', 'energy', 'full-time', 20, '2025-09-30', 'Expérience.', 1200),

-- Offres TransExpress (Transport)
(8, 'Agent Logistique', 'Organisation flux.', 'Kinshasa', 'transport', 'full-time', 14, '2025-09-15', 'Logistique.', 800),
(8, 'Chauffeur Livreur', 'Livraison marchandises.', 'Kinshasa', 'transport', 'part-time', 10, '2025-09-01', 'Permis B.', 500),
(8, 'Coordinateur Transport', 'Planification.', 'Kinshasa', 'transport', 'full-time', 18, '2025-09-20', 'Expérience.', 900),

-- Offres Hôtel Lumière (Hospitality)
(9, 'Réceptionniste', 'Accueil clients.', 'Kinshasa', 'hospitality', 'full-time', 12, '2025-09-05', 'Bonne présentation.', 600),
(9, 'Assistant Événementiel', 'Coordination événements.', 'Kinshasa', 'hospitality', 'part-time', 8, '2025-08-30', 'Organisation.', 0),
(9, 'Serveur', 'Service en salle.', 'Kinshasa', 'hospitality', 'part-time', 6, '2025-09-01', 'Sens du service.', 500),
(9, 'Assistant Communication', 'Promotion.', 'Kinshasa', 'hospitality', 'full-time', 10, '2025-09-15', 'Marketing.', 700),

-- Offres JurisConsult (Law)
(10, 'Assistant Juridique', 'Préparation dossiers.', 'Kinshasa', 'law', 'part-time', 10, '2025-09-05', 'Droit des affaires.', 0),
(10, 'Juriste', 'Rédaction contrats.', 'Kinshasa', 'law', 'full-time', 14, '2025-09-20', 'Expérience juridique.', 900),
(10, 'Stagiaire Juridique', 'Support juridique.', 'Kinshasa', 'law', 'part-time', 8, '2025-09-01', 'Étudiant droit.', 0);


-- ///////////////////////////////////////////////////////////////////////////////
-- Index
-- ///////////////////////////////////////////////////////////////////////////////
ALTER TABLE `users`
ADD PRIMARY KEY(`user_id`),
ADD UNIQUE KEY `user_email`(`user_email`);

ALTER TABLE `companies`
ADD PRIMARY KEY(`company_id`),
ADD KEY `company_user_id`(`company_user_id`);

ALTER TABLE `offers`
ADD PRIMARY KEY(`offer_id`),
ADD KEY `offer_company_id`(`offer_company_id`);

ALTER TABLE `students`
ADD PRIMARY KEY(`student_id`),
ADD KEY `student_user_id`(`student_user_id`);

ALTER TABLE `applications`
ADD PRIMARY KEY(`application_id`),
ADD UNIQUE KEY `application_unique`(`application_student_id`, `application_offer_id`),
ADD KEY `application_student_id`(`application_student_id`),
ADD KEY `application_offer_id`(`application_offer_id`);


-- ///////////////////////////////////////////////////////////////////////////////
-- Auto-incrémentation
-- ///////////////////////////////////////////////////////////////////////////////
ALTER TABLE `users`
MODIFY `user_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `companies`
MODIFY `company_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `offers`
MODIFY `offer_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `students`
MODIFY `student_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `applications`
MODIFY `application_id` INT NOT NULL AUTO_INCREMENT;


-- ///////////////////////////////////////////////////////////////////////////////
-- Clés étrangères
-- ///////////////////////////////////////////////////////////////////////////////
ALTER TABLE `companies`
ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY(`company_user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE;

ALTER TABLE `offers`
ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY(`offer_company_id`) REFERENCES `companies`(`company_id`) ON DELETE CASCADE;

ALTER TABLE `students`
ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY(`student_user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE;

ALTER TABLE `applications`
ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY(`application_student_id`) REFERENCES `students`(`student_id`) ON DELETE CASCADE,
ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY(`application_offer_id`) REFERENCES `offers`(`offer_id`) ON DELETE CASCADE;


-- ///////////////////////////////////////////////////////////////////////////////
-- FIN DE LA TRANSACTION
-- ///////////////////////////////////////////////////////////////////////////////
COMMIT;
