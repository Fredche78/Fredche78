CREATE database sbpolish CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

use sbpolish;

CREATE TABLE photos_cars (
    id INT PRIMARY KEY AUTO_INCREMENT,
    txt_before VARCHAR(255),
    img_before VARCHAR(255),
    txt_after VARCHAR(255),
    img_after VARCHAR(255)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(320),
    city VARCHAR(50),
    postCode MEDIUMINT,
    vehicule VARCHAR(255)
);

CREATE TABLE password_reset (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320) NOT NULL,
    token VARCHAR(100) NOT NULL
);

ALTER TABLE users
ADD role VARCHAR(20) DEFAULT "utilisateur";

INSERT INTO users
(role)
VALUES
("utilisateur"),
("utilisateur");

UPDATE users
SET role = "administrateur"
WHERE id=5;

CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client VARCHAR(50) NOT NULL,
    review TEXT NOT NULL
);

INSERT INTO reviews
(client, review)
VALUES
("Sylvain.R", "Super, grâce à SB Polish j'ai redécouvert ma voiture. On dirait quelle est neuve. Merci à Sébastien pour son professionnalisme."),
("François.L", "Tout c'est très bien passé. Je recommande vivement S.B Polish.");

INSERT INTO photos_cars
(txt_before, img_before, txt_after, img_after)
VALUES
("Test de texte pour image voitures 1", "Peugeot308-0.jpg", "Cire haute qualité : protège votre voiture pendant 3 mois", "Peugeot308-1.jpg"),
("Test de texte pour image voitures 2", "Tapis-0.jpg", "Aspiration turboboost2000. Voyez le résultat", "Tapis-1.jpg");

ALTER TABLE users
ADD phone VARCHAR(15) NOT NULL, state VARCHAR(20) DEFAULT "France";

CREATE TABLE contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(320) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    vehicule VARCHAR(255),
    city VARCHAR(50),
    question VARCHAR(50),
    photo VARCHAR(255),
    photo2 VARCHAR(255),
    photo3 VARCHAR(255),
    message TEXT
    
);