USE tardi;

CREATE TABLE utente(
	ID int(11) PRIMARY KEY auto_increment,
    password varchar(256) NOT NULL,
    nome varchar(30) NOT NULL,
    cognome varchar(30) NOT NULL,
    eta int(11) DEFAULT NOT NULL,
    classe varchar(30) NOT NULL,
    email varchar(30) NOT NULL,
	foto varchar(50)
);

CREATE TABLE tipologia(
	ID int(11) PRIMARY KEY auto_increment,
    nome varchar(30) NOT NULL
);

CREATE TABLE annuncio(
	ID int(11) PRIMARY KEY auto_increment,
    nome varchar(30) NOT NULL,
    descrizione varchar(255) DEFAULT NULL,
    foto varchar(50),
    datacaricamento date DEFAULT current_timestamp(),
    ID_utente int(11) NOT NULL,
    ID_tipologia int(11) NOT NULL,
    FOREIGN KEY(ID_utente) REFERENCES utente(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(ID_tipologia) REFERENCES tipologia(ID) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE proposta(
	ID int(11) NOT NULL,
    prezzo int(11) NOT NULL,
    ID_utente int(11) NOT NULL,
    dataproposta date DEFAULT current_timestamp(),
    ID_annuncio int(11) NOT NULL,
    stato varchar(11) NOT NULL,
    FOREIGN KEY (ID_utente) REFERENCES utente(ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ID_annuncio) REFERENCES annuncio(ID) ON UPDATE CASCADE ON DELETE CASCADE
);

/*
CREATE TABLE foto(
    ID int(11) PRIMARY KEY auto_increment,
    URL varchar(50) NOT NULL,
    ID_annuncio int(11) NOT NULL,
    FOREIGN KEY (ID_annuncio) REFERENCES annuncio(ID) ON UPDATE CASCADE ON DELETE CASCADE
);
*/

/*---------------- ESEMPI --------------------*/
INSERT INTO utente (password, nome, cognome, eta, classe, email, foto) VALUES ('ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'Alice', 'Rossi', 25, 'A', 'alice@email.com', 'alice.jpg');
INSERT INTO utente (password, nome, cognome, eta, classe, email, foto) VALUES ('01c4c0092dc6f090f2d58115c9df6aaebdd5adc595df12bd5dffcc8eaae33006', 'Bob', 'Verdi', 30, 'B', 'bob@email.com', 'bob.jpg');
INSERT INTO utente (password, nome, cognome, eta, classe, email, foto) VALUES ('3deff660926494dc46d9fb6b56c3fcb766d2e00c6ddf818729c3536606867164', 'Charlie', 'Bianchi', 28, 'C', 'charlie@email.com', 'charlie.jpg');
/*
password123
qwerty456
secure789
*/
INSERT INTO tipologia (nome) VALUES ('Elettronica');
INSERT INTO tipologia (nome) VALUES ('Abbigliamento');
INSERT INTO tipologia (nome) VALUES ('Libri');

INSERT INTO annuncio (nome, descrizioni, foto, datacaricamento, ID_utente, ID_tipologia) VALUES ('iPhone X', 'Nuovo di zecca!', 'iphone.jpg', '2024-05-15', 1, 1);
INSERT INTO annuncio (nome, descrizioni, foto, datacaricamento, ID_utente, ID_tipologia) VALUES ('Giacca in pelle', 'Stile vintage', 'giacca.jpg', '2024-05-14', 2, 2);
INSERT INTO annuncio (nome, descrizioni, foto, datacaricamento, ID_utente, ID_tipologia) VALUES ('Harry Potter e la pietra filosofale', 'Edizione speciale', 'libro.jpg', '2024-05-13', 3, 3);

INSERT INTO proposta (prezzo, ID_utente, dataproposta, ID_annuncio, stato) VALUES (500, 2, '2024-05-15', 1, 'in attesa');
INSERT INTO proposta (prezzo, ID_utente, dataproposta, ID_annuncio, stato) VALUES (80, 3, '2024-05-14', 2, 'accettata');
INSERT INTO proposta (prezzo, ID_utente, dataproposta, ID_annuncio, stato) VALUES (20, 1, '2024-05-13', 3, 'rifiutata');