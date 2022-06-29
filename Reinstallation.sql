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
    postcode MEDIUMINT,
    vehicule VARCHAR(255),
    phone VARCHAR(15) NOT NULL,
    state VARCHAR(20) DEFAULT "France",
    role VARCHAR(20) DEFAULT "utilisateur"
);

CREATE TABLE password_reset (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320) NOT NULL,
    token VARCHAR(100) NOT NULL,
    validity int(11)
);

CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client VARCHAR(50) NOT NULL,
    review TEXT NOT NULL
);

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

CREATE TABLE type_services (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL
);

CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    service_type TINYINT,
    FOREIGN KEY (service_type) REFERENCES type_services(id)
);

CREATE TABLE user_reset (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(320) NOT NULL,
    token VARCHAR(100) NOT NULL,
    validity int(11)
);

CREATE TABLE prices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    formule VARCHAR(100),
    price_A SMALLINT,
    price_B SMALLINT,
    price_C SMALLINT,
    services SMALLINT
);

CREATE TABLE services_names (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE services_options (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(200),
    price VARCHAR(50)
);

CREATE TABLE prices_services_names (
    prices_id INT,
    services_names_id INT,
    PRIMARY KEY (prices_id, services_names_id),
    FOREIGN KEY (prices_id) REFERENCES prices(id),
    FOREIGN KEY (services_names_id) REFERENCES services_names(id)
);

INSERT INTO prices_services_names
(prices_id, services_names_id)
VALUES
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(2, 20),
(2, 25),
(2, 22),
(2, 26),
(2, 23),
(2, 27),
(3, 28),
(3, 29),
(3, 30),
(3, 31),
(3, 32),
(4, 28),
(4, 29),
(4, 33),
(4, 30),
(4, 31),
(4, 34),
(4, 35),
(4, 36),
(4, 32),
(4, 38),
(7, 39);

INSERT INTO prices
(type, formule, price_A, price_B, price_C, services)
VALUES
("Intérieur", "Standard", 30, 35, 40, 1),
("Intérieur", "Premium", 60, 70, 80, 2),
("Extérieur", "Standard", 30, 35, 40, 3),
("Extérieur", "Premium", 50, 60, 70, 4),
("Intérieur et extérieur", "Standard", 50, 55, 60, 5),
("Intérieur et extérieur", "Premium", 80, 90, 100, 6),
("Lustrage", "", 100, 125, 150, 7);

INSERT INTO services_names
(name)
VALUES
("Aspiration : tapis, moquettes et sièges"),
("Dépoussiérage"),
("Nettoyage plastiques"),
("Nettoyage des surfaces vitrées intérieures"),
("Shampouinage : tapis, moquettes et sièges"),
("Nettoyage et brillant plastiques"),
("Traitement des odeurs"),
("Prélavage"),
("Lavage"),
("Nettoyage des jantes"),
("Traitement des pneumatiques"),
("séchage"),
("Décontamination"),
("Traitement des plastiques"),
("Lavage intérieur des portes"),
("Lavage trappe à essence"),
("Séchage"),
("cire de protection (3 mois)"),
("à la machine (Minimum 1 heure)");

INSERT INTO services_options
(name, description, price)
VALUES
("Cire de protection hydrophobe", "Protège votre véhicule pendant environ 3 mois", "10€"),
("Cire de protection céramique hydrophobe", "Traitement à long terme - Revêtement protecteur de haute dureté - brillance maximale", "90€"),
("Traitement en profondeur de tous les cuirs", "", "20€"),
("Nettoyage en profondeur du plafonnier", "", "à partir de 20€"),
("Intérieur de couleur clair", "", "à partir de 30€"),
("Nettoyage du sable et des poils d'animaux", "", "à partir de 30€"),
("Nettoyage du compartiment moteur", "", "20€"),
("Rénovation des optiques", "", "30€"),
("Dégoudronage carosserie", "", "à partir de 10€"),
("Déflocage véhicule", "", "sur devis"),
("Traitement céramique  de la carosserie", "", "sur devis"),
("Polissage en plusieurs étapes", "", "sur devis");


-- Insertions

INSERT INTO services
(name, service_type)
VALUES
("Aspirations textiles et cuirs", 1),
("Aspirations moquettes", 1),
("Traitement des plastiques", 1),
("Pédalier", 1),
("Rails de siège", 1),
("Nettoyage des vitres", 1),
("Rétroviseur Intérieur", 1),
("Miroir de courtoisie", 1),
("Affichages et compteurs", 1),
("Désodorisation", 1),
("Ciel de toit", 1),
("Sièges et banquette", 1),
("Carrosserie", 2),
("Optiques", 2),
("Seuil de coffre", 2),
("Seuil de portes", 2),
("Rétroviseurs", 2),
("Trappe à essence", 2),
("Jantes, étriers", 2),
("Baie de pare brise", 2),
("Soubassement", 2),
("Passage de roues", 2),
("Soin du cuir", 3),
("Soin plafonnier", 3),
("Cire de protection", 3),
("Traitement céramique", 3),
("Nettoyage moteur", 3),
("Traitement Hydrophobe des vitres", 3);

INSERT INTO type_services
(type)
VALUES
("Intérieur"),
("Exterieur"),
("Options et services annexes");

INSERT INTO reviews
(client, review)
VALUES
("Lajos V.", "Vrai travaille professionnel"),
("Vinciane D.", "Merci pour votre professionnalisme elle est magnifique"),
("Renaud D.", "Prestation de grande classe… dans les moindres détails… je n’en reviens toujours pas! Du grand Sébastien! Merci et bravo"),
("SebShirley A.", "Merci beaucoup pour me l'avoir préparé comme ça j'en suis ravi hâte de t'en ramener d'autres à l'avenir"),
("Художник Б.", "Merci beaucoup Sebastien ! Ma voiture est superbe ! Et ça sens bon! Super travail .Je recommande vivement !"),
("Jean-François M.", "Beau boulot merci"),
("Marco M.", "Félicitations seb tu et trop fort la classe");

INSERT INTO users
(firstname, lastname, email, password, address, city, postcode, vehicule, phone, state, role)
VALUES
("Sébastien", "Brouillard", "sbpolish@outlook.fr", "Octopus/1759%", "91 Rue Henry Durre", "La Sentinelle", 59174, "BMW", "06 62 49 20 49", "France", "administrateur");
