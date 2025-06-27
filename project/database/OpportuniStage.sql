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
    `offer_remuneration` VARCHAR(100) NOT NULL,
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
