
-- ///////////////////////////////////////////////////////////////////////////////
-- DÉBUT DE LA TRANSACTION
-- //////////////////////////////////////////////////////////////////////////////
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
CREATE TABLE `users`(
    `user_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_name` VARCHAR(255) NOT NULL,
    `user_email` VARCHAR(255) NOT NULL UNIQUE,
    `user_password` VARCHAR(255) NOT NULL,
    `user_role` ENUM('admin', 'student', 'company') NOT NULL

)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `companies`(
    `company_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `company_user_id` INT NOT NULL,
    `company_name` VARCHAR(255) DEFAULT NULL, 
    `company_phone_number` VARCHAR(20) DEFAULT NULL,
    `company_sector` ENUM(
        "administration",
        "agriculture",
        "construction",
        "communication",
        "commerce",
        "education",
        "energy",
        "finance",
        "health",
        "hospitality",
        "industry",
        "it",
        "law",
        "telecom",
        "transport"
    ) DEFAULT NULL,
    `company_size` ENUM(
        "micro",
        "small",
        "medium",
        "large"
    ) DEFAULT NULL,
    `company_description` TEXT DEFAULT NULL,
    `company_website` VARCHAR(255) DEFAULT NULL,
    `company_address` VARCHAR(255) DEFAULT NULL,
    `company_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `company_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`company_user_id`) REFERENCES `users`(`user_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE TABLE `offers`(
    `offer_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `offer_company_id` INT NOT NULL,
    `offer_title` VARCHAR(255) NOT NULL,
    `offer_description` TEXT NOT NULL,
    `offer_location` VARCHAR(255) NOT NULL,
    `offer_sector` ENUM(
        "administration",
        "agriculture",
        "construction",
        "communication",
        "commerce",
        "education",
        "energy",
        "finance",
        "health",
        "hospitality",
        "industry",
        "it",
        "law",
        "telecom",
        "transport"
    ) NOT NULL,
    `offer_type` ENUM(
        "full-time", 
        "part-time"
    ) NOT NULL,
    `offer_duration` INT NOT NULL,
    `offer_deadline` DATE NOT NULL,
    `offer_profile` TEXT NOT NULL,
    `offer_remuneration` VARCHAR(100) NOT NULL,
    `offer_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `offer_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`offer_company_id`) REFERENCES `companies`(`company_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


CREATE TABLE `students` (
    `student_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
    `student_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`student_user_id`) REFERENCES `users`(`user_id`)
)
ENGINE=InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

SELECT * FROM students;

-- ///////////////////////////////////////////////////////////////////////////////
-- Enregistrements
-- ///////////////////////////////////////////////////////////////////////////////


-- ///////////////////////////////////////////////////////////////////////////////
-- Index
-- ///////////////////////////////////////////////////////////////////////////////


-- ///////////////////////////////////////////////////////////////////////////////
-- Auto-incrémentation
-- ///////////////////////////////////////////////////////////////////////////////


-- ///////////////////////////////////////////////////////////////////////////////
-- Clés étrangères
-- ///////////////////////////////////////////////////////////////////////////////


-- ///////////////////////////////////////////////////////////////////////////////
-- FIN DE LA TRANSACTION
-- ///////////////////////////////////////////////////////////////////////////////
COMMIT;