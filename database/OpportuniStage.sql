
-- ///////////////////////////////////////////////////////////////////////////////
-- Base de données
-- ///////////////////////////////////////////////////////////////////////////////
DROP DATABASE IF EXISTS `OpportuniStage`;
CREATE DATABASE `OpportuniStage`;
USE `OpportuniStage`;

-- ///////////////////////////////////////////////////////////////////////////////
-- Tables
-- ///////////////////////////////////////////////////////////////////////////////

--Test pour authentification
CREATE TABLE users(
    user_id INT NOT NULL PRIMARY KEY auto_increment,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    user_role ENUM('admin', 'student', 'company')
);

INSERT INTO users (user_name, user_email, user_password, user_role)
VALUES ("Toussaint Madidi", "benimadidi100@gmail.com", "123456", "student");