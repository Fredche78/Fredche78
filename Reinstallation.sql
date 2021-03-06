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
("Int??rieur", "Standard", 30, 35, 40, 1),
("Int??rieur", "Premium", 60, 70, 80, 2),
("Ext??rieur", "Standard", 30, 35, 40, 3),
("Ext??rieur", "Premium", 50, 60, 70, 4),
("Int??rieur et ext??rieur", "Standard", 50, 55, 60, 5),
("Int??rieur et ext??rieur", "Premium", 80, 90, 100, 6),
("Lustrage", "", 100, 125, 150, 7);

INSERT INTO services_names
(name)
VALUES
("Aspiration : tapis, moquettes et si??ges"),
("D??poussi??rage"),
("Nettoyage plastiques"),
("Nettoyage des surfaces vitr??es int??rieures"),
("Shampouinage : tapis, moquettes et si??ges"),
("Nettoyage et brillant plastiques"),
("Traitement des odeurs"),
("Pr??lavage"),
("Lavage"),
("Nettoyage des jantes"),
("Traitement des pneumatiques"),
("s??chage"),
("D??contamination"),
("Traitement des plastiques"),
("Lavage int??rieur des portes"),
("Lavage trappe ?? essence"),
("S??chage"),
("cire de protection (3 mois)"),
("?? la machine (Minimum 1 heure)");

INSERT INTO services_options
(name, description, price)
VALUES
("Cire de protection hydrophobe", "Prot??ge votre v??hicule pendant environ 3 mois", "10???"),
("Cire de protection c??ramique hydrophobe", "Traitement ?? long terme - Rev??tement protecteur de haute duret?? - brillance maximale", "90???"),
("Traitement en profondeur de tous les cuirs", "", "20???"),
("Nettoyage en profondeur du plafonnier", "", "?? partir de 20???"),
("Int??rieur de couleur clair", "", "?? partir de 30???"),
("Nettoyage du sable et des poils d'animaux", "", "?? partir de 30???"),
("Nettoyage du compartiment moteur", "", "20???"),
("R??novation des optiques", "", "30???"),
("D??goudronage carosserie", "", "?? partir de 10???"),
("D??flocage v??hicule", "", "sur devis"),
("Traitement c??ramique  de la carosserie", "", "sur devis"),
("Polissage en plusieurs ??tapes", "", "sur devis");


-- Insertions

INSERT INTO services
(name, service_type)
VALUES
("Aspirations textiles et cuirs", 1),
("Aspirations moquettes", 1),
("Traitement des plastiques", 1),
("P??dalier", 1),
("Rails de si??ge", 1),
("Nettoyage des vitres", 1),
("R??troviseur Int??rieur", 1),
("Miroir de courtoisie", 1),
("Affichages et compteurs", 1),
("D??sodorisation", 1),
("Ciel de toit", 1),
("Si??ges et banquette", 1),
("Carrosserie", 2),
("Optiques", 2),
("Seuil de coffre", 2),
("Seuil de portes", 2),
("R??troviseurs", 2),
("Trappe ?? essence", 2),
("Jantes, ??triers", 2),
("Baie de pare brise", 2),
("Soubassement", 2),
("Passage de roues", 2),
("Soin du cuir", 3),
("Soin plafonnier", 3),
("Cire de protection", 3),
("Traitement c??ramique", 3),
("Nettoyage moteur", 3),
("Traitement Hydrophobe des vitres", 3);

INSERT INTO type_services
(type)
VALUES
("Int??rieur"),
("Exterieur"),
("Options et services annexes");

INSERT INTO reviews
(client, review)
VALUES
("Lajos V.", "Vrai travaille professionnel"),
("Vinciane D.", "Merci pour votre professionnalisme elle est magnifique"),
("Renaud D.", "Prestation de grande classe??? dans les moindres d??tails??? je n???en reviens toujours pas! Du grand S??bastien! Merci et bravo"),
("SebShirley A.", "Merci beaucoup pour me l'avoir pr??par?? comme ??a j'en suis ravi h??te de t'en ramener d'autres ?? l'avenir"),
("???????????????? ??.", "Merci beaucoup Sebastien ! Ma voiture est superbe ! Et ??a sens bon! Super travail .Je recommande vivement !"),
("Jean-Fran??ois M.", "Beau boulot merci"),
("Marco M.", "F??licitations seb tu et trop fort la classe");

INSERT INTO users
(firstname, lastname, email, password, address, city, postcode, vehicule, phone, state, role)
VALUES
("S??bastien", "Brouillard", "sbpolish@outlook.fr", "Octopus/1759%", "91 Rue Henry Durre", "La Sentinelle", 59174, "BMW", "06 62 49 20 49", "France", "administrateur");
