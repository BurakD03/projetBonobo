DROP TABLE IF EXISTS COMPOSER;
DROP TABLE IF EXISTS CONTENU;
DROP TABLE IF EXISTS POSSEDER;
DROP TABLE IF EXISTS PRODUIT;
DROP TABLE IF EXISTS UTILISATEUR;
DROP TABLE IF EXISTS GROUPE;
DROP TABLE IF EXISTS LIVRAISON;
DROP TABLE IF EXISTS COMMANDE;
DROP TABLE IF EXISTS MENU;
DROP TABLE IF EXISTS PAIEMENT;
DROP TABLE IF EXISTS RESERVATION;
DROP TABLE IF EXISTS CLIENT;
DROP TABLE IF EXISTS CATEGORIE;


CREATE TABLE CATEGORIE (
  ID_CATEGORIE INT AUTO_INCREMENT NOT NULL,
  NOM VARCHAR(255) NOT NULL,
  CONSTRAINT PK_CATEGORIE PRIMARY KEY (ID_CATEGORIE)
);

CREATE TABLE PRODUIT (
  ID_PRODUIT INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  NOM VARCHAR(255) NOT NULL,
  PRIX FLOAT NOT NULL,
  DESCRIPTION TEXT NOT NULL,
  ID_CATEGORIE INT(10) NOT NULL,
  IMAGE VARCHAR(255) NOT NULL,
  CONSTRAINT PK_PRODUIT PRIMARY KEY (ID_PRODUIT),
  CONSTRAINT FK_PRODUIT_CATEGORIE FOREIGN KEY (ID_CATEGORIE) REFERENCES CATEGORIE(ID_CATEGORIE)
);

CREATE TABLE MENU (
  ID_MENU INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  NOM VARCHAR(255) NOT NULL,
  PRIX FLOAT NOT NULL,
  DESCRIPTION TEXT NOT NULL,
  IMAGE VARCHAR(255) NOT NULL,
  CONSTRAINT PK_MENU PRIMARY KEY (ID_MENU)
);

CREATE TABLE POSSEDER (
  ID_MENU INT(10) NOT NULL,
  ID_PRODUIT INT(10) NOT NULL,
  CONSTRAINT PK_POSSEDER PRIMARY KEY (ID_MENU, ID_PRODUIT),
  CONSTRAINT FK_POSSEDER_MENU FOREIGN KEY (ID_MENU) REFERENCES MENU(ID_MENU),
  CONSTRAINT FK_POSSEDER_PRODUIT FOREIGN KEY (ID_PRODUIT) REFERENCES PRODUIT(ID_PRODUIT)
);

CREATE TABLE PAIEMENT (
  ID_PAIEMENT INT AUTO_INCREMENT NOT NULL,
  LIBELLE VARCHAR(255) NOT NULL,
  CONSTRAINT PK_PAIEMENT PRIMARY KEY (ID_PAIEMENT)
);

CREATE TABLE CLIENT (
  ID_CLIENT INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  EMAIL VARCHAR(255) NOT NULL,
  TELEPHONE VARCHAR(20) NOT NULL,
  PRENOM VARCHAR(255) NOT NULL,
  NOM VARCHAR(255) NOT NULL,
  NEWSLETTER BOOLEAN NOT NULL,
  CONSTRAINT PK_CLIENT PRIMARY KEY (ID_CLIENT)
);

CREATE TABLE GROUPE (
  ID_GROUPE INT AUTO_INCREMENT NOT NULL,
  NOM VARCHAR(255) NOT NULL,
  NIVEAU INT NOT NULL,
  CONSTRAINT PK_GROUPE PRIMARY KEY (ID_GROUPE)
);

CREATE TABLE UTILISATEUR (
  ID_UTILISATEUR INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  IDENTIFIANT VARCHAR(255) NOT NULL,
  MOTDEPASSE VARCHAR(255) NOT NULL,
  ID_GROUPE INT(10) NOT NULL,
  CONSTRAINT PK_UTILISATEUR PRIMARY KEY (ID_UTILISATEUR),
  CONSTRAINT FK_UTILISATEUR_GROUPE FOREIGN KEY (ID_GROUPE) REFERENCES GROUPE(ID_GROUPE)
);

CREATE TABLE RESERVATION (
  ID_RESERVATION INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  DATE_RESERVATION DATETIME NOT NULL,
  NB INT NOT NULL,
  COMMENTAIRE TEXT,
  ID_CLIENT INT NOT NULL,
  CONSTRAINT PK_RESERVATION PRIMARY KEY (ID_RESERVATION),
  CONSTRAINT FK_RESERVATION_CLIENT FOREIGN KEY (ID_CLIENT) REFERENCES CLIENT(ID_CLIENT)  
);

CREATE TABLE COMMANDE (
  ID_COMMANDE INT AUTO_INCREMENT NOT NULL,
  DATE_CREATION DATETIME NOT NULL,
  DATE_REC DATETIME,
  COMMENTAIRE TEXT,
  ETAT TINYINT NOT NULL,
  NUM_ADRESSE INT,
  LIBELLE_ADRESSE VARCHAR(255),
  CODE_POSTAL VARCHAR(5),
  VILLE VARCHAR(255),
  LIVRAISON BOOLEAN NOT NULL,
  ID_CLIENT INT NOT NULL,
  ID_PAIEMENT INT NOT NULL, 
  CONSTRAINT PK_COMMANDE PRIMARY KEY(ID_COMMANDE),
  CONSTRAINT FK_COMMANDE_CLIENT FOREIGN KEY (ID_CLIENT) REFERENCES CLIENT(ID_CLIENT),
  CONSTRAINT FK_COMMANDE_PAIEMENT FOREIGN KEY (ID_PAIEMENT) REFERENCES PAIEMENT(ID_PAIEMENT)
);

CREATE TABLE COMPOSER (
  ID_COMMANDE INT NOT NULL,
  ID_PRODUIT INT NOT NULL,
  ID_MENU INT NOT NULL,
  NB INT NOT NULL,
  CONSTRAINT PK_COMPOSER PRIMARY KEY (ID_COMMANDE,ID_PRODUIT, ID_MENU),
  CONSTRAINT FK_COMPOSER_COMMANDE FOREIGN KEY (ID_COMMANDE) REFERENCES COMMANDE(ID_COMMANDE),
  CONSTRAINT FK_COMPOSER_PRODUIT FOREIGN KEY (ID_PRODUIT) REFERENCES PRODUIT(ID_PRODUIT),
  CONSTRAINT FK_COMPOSER_MENU FOREIGN KEY (ID_MENU) REFERENCES MENU(ID_MENU)
);

CREATE TABLE CONTENU (
  ID_COMMANDE INT NOT NULL,
  ID_PRODUIT INT NOT NULL,
  NB INT NOT NULL,
  CUISSON VARCHAR(255) NOT NULL,
  CONSTRAINT PK_CONTENU PRIMARY KEY(ID_COMMANDE,ID_PRODUIT),
  CONSTRAINT FK_CONTENU_COMMANDE FOREIGN KEY (ID_COMMANDE) REFERENCES COMMANDE(ID_COMMANDE),
  CONSTRAINT FK_CONTENU_PRODUIT FOREIGN KEY (ID_PRODUIT) REFERENCES PRODUIT(ID_PRODUIT)
);

INSERT INTO GROUPE(NOM,NIVEAU) VALUES ("Modérateurs", 1);
INSERT INTO GROUPE(NOM,NIVEAU) VALUES ("Administrateurs", 2);

INSERT INTO UTILISATEUR(IDENTIFIANT, MOTDEPASSE, ID_GROUPE, DATE_CREATION) VALUES ("mod", "$2y$10$i5/rxfrlsUYkfgzL4Etrqe/iDIVAsj5/dWjT8jpAlaKUdwd.8VnmS", 1, "2018-06-20 10:12:54");
INSERT INTO UTILISATEUR(IDENTIFIANT, MOTDEPASSE, ID_GROUPE, DATE_CREATION) VALUES ("admin", "$2y$10$AAYLYUYEsFwpTP7OG5ZRBeseHs.jFco16YfoqFE2MqXhokeNYEDKq", 2, "2018-06-20 10:45:21");

INSERT INTO CATEGORIE(NOM) VALUES ("Salades");
INSERT INTO CATEGORIE(NOM) VALUES ("Burgers");
INSERT INTO CATEGORIE(NOM) VALUES ("Boissons");
INSERT INTO CATEGORIE(NOM) VALUES ("Desserts");
INSERT INTO CATEGORIE(NOM) VALUES ("Entrées");

INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (1, "Salade César", 3.50, "Une salade fraiche à base de poulet et de croûtons grillés",1,"./project/picture/saladeCesar.jpg", "2018-04-21 14:43:24");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (2, "Salade Nordique", 3.90, "Une salade a base de saumon, de crème et de citron",1,"./project/picture/saladeNordique.jpg", "2018-04-22 13:54:22");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (3, "Salade piémontaise", 3.85, "Salade composée de pommes de terre, de crème, de cornichons et de tomates",1,"./project/picture/saladePiemontaise.jpg", "2019-01-11 17:21:29");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (4, "Salade parisienne", 3.45, "Salade à base de laitue, oeufs durs, jambon, emmental, champignons de Paris, pommes de terre et cornichons ",1,"./project/picture/saladeParisienne.jpg", "2018-09-11 09:12:35");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (5, "Salade de lentilles à la grecque", 3.05, "Concombres, tomates, poivrons, olives, fêta, lentilles", 1, "./project/picture/saladeLentille.jpg", "2018-01-04 08:23:19");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (6, "Burger Vegan",4.50, "Un burger réalisé avec des produits frais et de saison",2,"./project/picture/burgerVegan.jpg", "2018-04-21 13:30:24");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (7, "Burger Basque", 4.00, "Burger réalisé à base de pain complet, tomates, piment d'espelette", 2, "./project/picture/burgerBasque.jpg", "2018-05-21 15:41:29");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (8, "Burger Américain", 4.00, "Burger réalisé à base de pain complet, tomates, steaks, relevé avec de la sauce burger", 2, "./project/picture/burgerAmericain.jpg", "2018-05-21 15:42:45");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (9, "Coca Cola", 1.50, "Avec ou sans glaçons", 3, "./project/picture/cocaCola.png","2018-04-27 16:49:22");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (10, "Orangina", 1.50, "Avec ou sans glaçons", 3, "./project/picture/orangina.png","2018-04-27 16:50:11");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (11, "Ice Tea", 1.50, "Avec ou sans glaçons", 3, "./project/picture/iceTea.jpg", "2018-04-27 17:51:34");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (12, "Perrier", 1.50, "Avec ou sans glaçons", 3, "./project/picture/perrier.png", "2018-04-27 17:53:02");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (13, "Sirop à l'eau", 1.50, "Avec ou sans glaçons, parfums au choix : Grenadine, Menthe, Cassis, Orgeat ....", 3, "./project/picture/sirop.jpg", "2018-04-27 16:49:22");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (14, "Glace", 2.00, "Parfum au choix : chocolat, menthe, vanille, fraise, pistache, nougat, citron, noix de coco", 4,"./project/picture/glace.jpg", "2018-05-12 11:50:22");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (15, "Profiteroles", 3.90,"Chou rempli de crème pâtissière, fleurette ou chantilly recouvert d'une sauce au chocolat",4,"./project/picture/profiteroles.jpg", "2018-06-20 16:49:22");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (16, "Chocolat Liégeois", 3.95, "Dessert constitué d'une crème glacée au chocolat surmontée de crème chantilly", 4,"./project/picture/chocolatLiegeois.jpg", "2018-06-21 08:08:19");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (17, "Café Liégeois", 3.95, "Dessert constitué d'une crème glacée au café surmontée de crème chantilly", 4, "./project/picture/cafeLiegeois.jpg", "2018-06-22 18:21:32");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (18, "Oeufs Mimosas", 2.50, "Oeufs préparés avec de la mayonnaise et des herbes", 5,"./project/picture/oeufsMimosas.jpg", "2018-06-22 18:54:52");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (19, "Saumon fumé", 2.95, "Fines tranches de saumon fumé avec sauce au citron",5,"./project/picture/saumonFume.jpg", "2018-06-24 09:21:32");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (20, "Foie Gras", 3.95, "Servi avec des toast et de la confiture de figue", 5,"./project/picture/foieGras.jpg", "2018-06-24 08:32:45");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (21, "Assiette de charcuterie", 2.90, "Sélection de jambons blanc, jambons de pays, saucissons, accompagnés de toast et de beurre",5,"./project/picture/assietteCharcuterie.jpg", "2018-07-23 13:14:54");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (22, "Assiette de crudités", 2.85, "Sélection de crudités : Carottes rapées, tomates ....", 5, "./project/picture/assietteCrudites.jpg", "2018-08-21 15:43:38");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (23, "Salade Vegan", 3.10, "Une salade réalisée avec des produits frais et de saison", 1, "./project/picture/saladeVegan.jpg", "2018-08-21 16:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (24, "Fruits de saison", 2.85, "Selection de fruits de saison", 4, "./project/picture/fruitSaison.jpg", "2018-08-21 17:40:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (25, "Soupe de légumes", 2.50, "Une soupe réalisée avec de produits sains", 5, "./project/picture/soupeLegumes.jpg", "2018-08-22 16:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (26, "Salade de fruits de mer", 3.50, "Une salade réalisée avec des produits de la mer frais ", 1, "./project/picture/saladeMer.jpg", "2018-08-23 16:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (27, "Flan", 2.85, "Un gateau réalisé avec des oeufs frais", 4, "./project/picture/flan.jpg", "2018-08-21 17:40:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (28, "Soupe de poisson", 2.90, "Une soupe réalisée avec des poissons frais", 5, "./project/picture/soupePoisson.jpg", "2018-08-22 18:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (29, "Salade au poulet frit", 3.25, "Une salade composée de moceaux de poulet frit", 1, "./project/picture/saladePoulet.jpg", "2018-08-23 16:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (30, "Fondant au chocolat", 2.50, "Un gateau réalisé avec du chocolat fondu", 4, "./project/picture/fondantChocolat.jpg", "2018-08-21 17:40:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (31, "Soupe au Potiron", 2.95, "Soupe à base de potiron", 5, "./project/picture/soupePotiron.jpg", "2018-08-22 18:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (32, "Salade basque", 3.25, "Une salade relevée au piment d'espelette", 1, "./project/picture/saladeBasque.jpg", "2018-08-23 16:45:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (33, "Gateau Basque", 2.70, "Le gateau traditionnel basque", 4, "./project/picture/gateauBasque.jpg", "2018-08-21 17:40:40");
INSERT INTO PRODUIT(ID_PRODUIT, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE, DATE_CREATION) VALUES (34, "Noix de Saint Jacques", 2.95, "Soupe à base de potiron", 5, "./project/picture/noixSaintJacques.jpg", "2018-08-22 18:45:40");



INSERT INTO MENU(ID_MENU, NOM, PRIX, IMAGE, DESCRIPTION, DATE_CREATION) VALUES (1, "Menu Vegan",10.50,"./project/picture/menuVegan.jpg","Un menu réalisé par nos chefs à partir de produits sains et frais.", "2018-05-12 12:32:44");
INSERT INTO MENU(ID_MENU, NOM, PRIX, IMAGE, DESCRIPTION, DATE_CREATION) VALUES (2, "Menu Maritime",20,"./project/picture/menuMaritime.jpg","L'océan s'invite a votre table grâce à ce menu constitué de fruits de mers péchés durant la nuit.", "2018-05-12 12:35:32");
INSERT INTO MENU(ID_MENU, NOM, PRIX, IMAGE, DESCRIPTION, DATE_CREATION) VALUES (3, "Menu Américain",15,"./project/picture/menuAmericain.jpg","Venez découvrir la selection de burgers de notre chef.", "2018-05-12 12:43:21");
INSERT INTO MENU(ID_MENU, NOM, PRIX, IMAGE, DESCRIPTION, DATE_CREATION) VALUES (4, "Menu Basque",15,"./project/picture/menuBasque.jpg","Retrouvez une selection de produits du terroir basque", "2018-05-14 14:21:32");

INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 3);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 22);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 14);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 23);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 24);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 25);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 9);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 10);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 11);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (1, 12);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 2);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 4);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 19);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 15);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 26);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 27);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 28);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 9);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 10);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 11);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (2, 12);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 22);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 8);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 16);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 29);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 30);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 31);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 9);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 10);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 11);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (3, 12);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 21);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 7);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 17);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 9);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 10);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 11);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 12);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 32);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 33);
INSERT INTO POSSEDER(ID_MENU, ID_PRODUIT) VALUES (4, 34);


INSERT INTO CLIENT(DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER) VALUES ("2018-06-20 12:12:54", "mdupond@gmail.com","0123456789","Marcelin","Dupond",1);
INSERT INTO CLIENT(DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER) VALUES ("2018-06-20 12:12:54", "jerome87@outlook.com","0987654321","Jerôme","Charles",1);
INSERT INTO CLIENT(DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER) VALUES ("2018-06-20 12:12:54", "flavien33@gmail.com","0687452134","Flavien","Angular",0);
INSERT INTO CLIENT(DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER) VALUES ("2018-06-20 12:12:54", "bmaison@laposte.com","0243567643","Burak","Maison",0);
INSERT INTO CLIENT(DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER) VALUES ("2018-06-20 12:12:54", "julien_12@wanadoo.fr","0367982134","Julien","Perier",1);

INSERT INTO RESERVATION(DATE_CREATION,DATE_RESERVATION, NB, COMMENTAIRE, ID_CLIENT) VALUES ("2019-01-03 12:34:21", "2019-01-19 20:00:00", 3, "Couple avec un nouveau né", 1);
INSERT INTO RESERVATION(DATE_CREATION,DATE_RESERVATION, NB, COMMENTAIRE, ID_CLIENT) VALUES ("2019-01-05 15:55:25","2019-01-25 20:00:00", 4, "Peuvent arriver en retard", 2);
INSERT INTO RESERVATION(DATE_CREATION,DATE_RESERVATION, NB, COMMENTAIRE, ID_CLIENT) VALUES ("2019-01-03 12:34:21","2019-02-01 12:00:00", 1, "Souhaite être servi rapidement", 3);

INSERT INTO PAIEMENT(LIBELLE) VALUES ("Carte");
INSERT INTO PAIEMENT(LIBELLE) VALUES ("Chèque");
INSERT INTO PAIEMENT(LIBELLE) VALUES ("Espèces");

INSERT INTO COMMANDE(DATE_CREATION, DATE_REC,COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE, LIVRAISON, ID_CLIENT, ID_PAIEMENT) VALUES ("2019-01-03 12:34:21", "2019-01-03 20:34:18","Evitez le sel dans les plats",2,24,"Rur du Chat qui Tousse","87000","Limoges",1,1,1);
INSERT INTO COMMANDE(DATE_CREATION, DATE_REC,COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE, LIVRAISON,ID_CLIENT, ID_PAIEMENT) VALUES ("2019-01-05 15:55:25", "2019-01-06 10:22:21"," ",2,NULL,NULL,NULL,NULL,0,2,2);
INSERT INTO COMMANDE(DATE_CREATION, DATE_REC,COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE, LIVRAISON, ID_CLIENT, ID_PAIEMENT) VALUES ("2019-01-03 12:34:21", NULL," ",1,NULL,NULL,NULL,NULL,0,3,1);

INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (1,1,1," ");
INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (1,8,1," ");
INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (1,14,1," ");
INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (2,6,1,"A Point");
INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (2,9,1," ");
INSERT INTO CONTENU(ID_COMMANDE, ID_PRODUIT, NB, CUISSON) VALUES (2,10,1," ");

INSERT INTO COMPOSER(ID_COMMANDE, ID_PRODUIT, ID_MENU, NB) VALUES(3,7,4,1);
INSERT INTO COMPOSER(ID_COMMANDE, ID_PRODUIT, ID_MENU, NB) VALUES(3,21,4,1);
INSERT INTO COMPOSER(ID_COMMANDE, ID_PRODUIT, ID_MENU, NB) VALUES(3,15,4,1);


