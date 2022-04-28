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

CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50)
);

INSERT INTO services
(name)
VALUES
("Aspirations textiles et cuirs"),
("Aspirations moquettes"),
("Traitement des plastiques"),
("Pédalier"),
("Rails de siège"),
("Nettoyage des vitres"),
("Rétroviseur Intérieur"),
("Miroir de courtoisie"),
("Affichages et compteurs"),
("Désodorisation"),
("Ciel de toit"),
("Sièges et banquette"),
("Carrosserie"),
("Optiques"),
("Seuil de coffre"),
("Seuil de portes"),
("Rétroviseurs"),
("Trappe à essence"),
("Jantes, étriers"),
("Baie de pare brise"),
("Soubassement"),
("Passage de roues"),
("Soin du cuir"),
("Soin plafonnier"),
("Cire de protection"),
("Traitement céramique"),
("Nettoyage moteur"),
("Traitement Hydrophobe des vitres");

CREATE TABLE type_services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50)
);

INSERT INTO type_services
(type)
VALUES
("Intérieur"),
("Exterieur"),
("Options et services annexes");

CREATE TABLE type_services_link (
    services_id INT,
    type_Services_id INT,
    PRIMARY KEY (services_id, type_services_id),
    FOREIGN KEY (services_id) REFERENCES services(id),
    FOREIGN KEY (type_services_id) REFERENCES type_services(id)
);

INSERT INTO type_services_link
(type_services_id, services_id)
VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 28);

-- Obtenir la liste des services par colonne
SELECT type_services.type AS "Nom de la colonne", services.name AS "Services" 
FROM type_services
INNER JOIN type_services_link
ON type_services.id = type_services_link.type_services_id
INNER JOIN services
ON type_services_link.services_id = services.id


-- Afficher pour chaque colonne la liste des services (sans doublon)
SELECT 
    type_services.type AS "colonnes", 
    GROUP_CONCAT(services.name SEPARATOR ", ") AS "services" 
FROM type_services
INNER JOIN type_services_link
ON type_services.id = type_services_link.type_services_id
INNER JOIN services
ON type_services_link.services_id = services.id
GROUP BY type_services.type;
