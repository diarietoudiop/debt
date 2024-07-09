-- Active: 1719249420839@@127.0.0.1@3306@dette


CREATE TABLE IF NOT EXISTS Roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    adresse TEXT,
    email VARCHAR(255) UNIQUE NOT NULL,
    login VARCHAR(255) UNIQUE NOT NULL DEFAULT(SHA1(telephone)),
    password VARCHAR(255) NOT NULL DEFAULT(SHA1("Passer123")),
    photo VARCHAR(255),
    FOREIGN KEY (role_id) REFERENCES Roles(id)
);

CREATE TABLE IF NOT EXISTS Articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    prixUnitaire DECIMAL(10, 2) NOT NULL,
    quantite INT NOT NULL,
    photo VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Dettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    vendeur_id INT,
    montant DECIMAL(10, 2) NOT NULL,
    solder BOOLEAN NOT NULL DEFAULT(false),
    date DATE NOT NULL DEFAULT(CURRENT_DATE),
    FOREIGN KEY (client_id) REFERENCES Utilisateurs(id),
    FOREIGN KEY (vendeur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS DetailsDettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dette_id INT,
    article_id INT,
    quantite INT NOT NULL,
    FOREIGN KEY (dette_id) REFERENCES Dettes(id),
    FOREIGN KEY (article_id) REFERENCES Articles(id)
);

CREATE TABLE IF NOT EXISTS Paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL DEFAULT(CURRENT_DATE),
    client_id INT,
    FOREIGN KEY (client_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE IF NOT EXISTS PaiementsDettes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paiement_id INT,
    dette_id INT,
    vendeur_id INT,
    FOREIGN KEY (paiement_id) REFERENCES Paiements(id),
    FOREIGN KEY (dette_id) REFERENCES Dettes(id),
    FOREIGN KEY (vendeur_id) REFERENCES Utilisateurs(id)
);

-- Insertion des rôles
INSERT INTO Roles (libelle) VALUES ('vendeur'), ('client');

-- Insertion des utilisateurs
INSERT INTO Utilisateurs (role_id, nom, prenom, telephone, adresse, email, photo) VALUES
(1, 'Ciss', 'Elhadji', '+221778133537', 'Diamniadio, Sénégal', 'cisselage27@gmail.com', 'photo1.jpg'),
(2, 'Gueye', 'Mamadou', '+221764076933', 'Dakar', 'gueye.mamadou@example.com', 'photo2.jpg'),
(2, 'Fall', 'Makhtar', '+221701234567', 'Keur Mbaye Fall', 'ousmane.diop@example.com',  'photo3.jpg'),
(2, 'Sall', 'Fatou', '+221702345678', 'Saint-Louis', 'fatou.sall@example.com', 'photo4.jpg');

-- Insertion des articles
INSERT INTO Articles (libelle, prixUnitaire, quantite, photo) VALUES
('Téléphone portable', 250000, 50, 'article1.jpg'),
('Ordinateur portable', 500000, 30, 'article2.jpg'),
('Télévision', 300000, 20, 'article3.jpg'),
('Réfrigérateur', 150000, 40, 'article4.jpg'),
('Lave-linge', 200000, 25, 'article5.jpg'),
('Four électrique', 100000, 15, 'article6.jpg'),
('Micro-ondes', 50000, 35, 'article7.jpg'),
('Aspirateur', 75000, 45, 'article8.jpg'),
('Cafetière', 30000, 60, 'article9.jpg'),
('Grille-pain', 20000, 55, 'article10.jpg');

-- Insertion des dettes
INSERT INTO Dettes (client_id, vendeur_id, montant, date) VALUES
(2, 1, 50000, '2023-04-01'),
(2, 1, 75000, '2023-05-15'),
(3, 1, 100000, '2023-06-30'),
(4, 1, 125000, '2023-07-10'),
(3, 1, 150000, '2023-08-20'),
(2, 1, 175000, '2023-09-01');

-- Insertion des détails de dettes
INSERT INTO DetailsDettes (dette_id, article_id, quantite) VALUES
(1, 1, 2),
(2, 2, 7),
(3, 4, 5),
(5, 2, 3),
(5, 1, 10);


-- Insertion des paiements
INSERT INTO Paiements (montant, client_id) VALUES
(20000, 2),
(30000, 3),
(40000, 4);

-- Insertion des paiments de dette
INSERT INTO `PaiementsDettes` (paiement_id, dette_id, vendeur_id) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);


-- SELECT r.libelle FROM `Utilisateurs` u JOIN `Roles` r ON r.id = u.role_id WHERE u.id = 1;

