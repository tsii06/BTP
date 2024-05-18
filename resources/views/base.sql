create database btp;
\c btp;

create table auth(
    idauth serial primary key ,
    email varchar(50),
    password varchar(50)
);

create table client(
      idClient serial primary key ,
      contact varchar(50) unique
);

create sequence seqMaison;
create table maison(
    idMaison varchar(50) default 'MAI' || nextval('seqMaison') primary key ,
    nom varchar(50) unique ,
    description varchar(50) not null ,
    durre int,
    surface float
);



create sequence seqFinition;
create table finition(
    idFinition varchar(50) default 'FIN' || nextval('seqFinition') primary key ,
    nom varchar(50) unique ,
    pourcentage float not null
);
create sequence seqReference;
create table devisClient(
    idDevisClient serial primary key ,
    reference varchar(50) unique default 'REF' || nextval('seqReference')  ,
    idClient int not null ,
    idMaison varchar(50) not null ,
    idfinition varchar(50) not null ,
    datedebut date not null ,
    dateinsertion date not null ,
    lieu varchar(50) not null ,
    foreign key (idMaison) references maison(idMaison),
    foreign key (idClient) references client(idClient),
    foreign key (idfinition) references finition(idFinition)
);
create table travaux(
    idTravaux serial primary key ,
    code varchar(20) unique ,
    designation varchar(50) not null ,
    unite varchar(50) not null ,
    prixUnitaire float not null
);

CREATE TABLE detailDevis(
    reference VARCHAR(50),
    idTravaux INT NOT NULL,
    prixUnitaire FLOAT NOT NULL,
    quantite FLOAT NOT NULL,
    FOREIGN KEY (idTravaux) REFERENCES travaux(idTravaux),
    FOREIGN KEY (reference) REFERENCES devisClient(reference),
    CONSTRAINT unique_detailDevis UNIQUE (reference, idTravaux)
);


CREATE TABLE detailFinition(
   reference VARCHAR(50) UNIQUE,
   idFinition VARCHAR(50) NOT NULL,
   pourcentage FLOAT NOT NULL,
   FOREIGN KEY (idFinition) REFERENCES finition(idFinition),
   FOREIGN KEY (reference) REFERENCES devisClient(reference)
);





CREATE TABLE travauxMaison(
  idMaison VARCHAR(50),
  idTravaux INT NOT NULL,
  quantite FLOAT NOT NULL,
  FOREIGN KEY (idMaison) REFERENCES maison(idMaison),
  FOREIGN KEY (idTravaux) REFERENCES travaux(idTravaux),
  CONSTRAINT unique_travauxMaison UNIQUE (idMaison, idTravaux)
);

---view pour afficher le maison
create or replace view viewmaison as select m.idMaison,sum((tr.quantite*t.prixunitaire)) as prix,m.nom,m.description from travauxMaison as tr
join travaux t on t.idTravaux = tr.idTravaux
join maison m on m.idMaison = tr.idMaison group by m.idMaison;

---view pour afficher le travaux
create or replace view viewtravaux as select t.idTravaux,m.idMaison,tr.quantite,t.prixUnitaire,t.designation from travauxMaison as tr
   join travaux t on t.idTravaux = tr.idTravaux
   join maison m on m.idMaison = tr.idMaison;

---view pour afficher le devis
CREATE OR REPLACE VIEW viewdevis AS
SELECT
    m.nom AS maison,
    f.nom AS finition,
    devisClient.idClient,
    devisClient.reference,
    v.prix,
    devisClient.datedebut,
    devisClient.dateinsertion,
    m.durre,
    -- Calcul de la date de fin en ajoutant la durée à la date de début
    devisClient.datedebut + (m.durre || ' days')::interval AS datefin
FROM
    devisclient
        JOIN
    maison m ON m.idMaison = devisclient.idMaison
        JOIN
    finition f ON f.idFinition = devisclient.idfinition
        JOIN
    viewmaison v ON m.idMaison = v.idMaison;


---view pour afficher le detail du devis
create or replace view viewdetaildevis as select detailDevis.reference ,t.code as code,t.designation,t.unite,detailDevis.quantite,
 detailDevis.prixUnitaire,(detailDevis.quantite*detailDevis.prixUnitaire) as  montant from detailDevis
join travaux t on t.idTravaux = detailDevis.idTravaux;

create sequence seqRefPaiment;
create table paiment(
    idPaiment serial primary key ,
    ref_devis varchar(50) ,
    reference varchar(50) unique default 'REF' || nextval('seqRefPaiment')  ,
    montant float not null ,
    datePaiment date not null ,
    foreign key (ref_devis) references devisClient(reference)
);

create or replace view getsomme as
    select v.reference,
           (sum(v.montant)+(sum(v.montant)*(d.pourcentage/100))) as total,
           (sum(v.montant)) as montant
    from viewdetaildevis v
        join detailFinition d on d.reference=v.reference group by v.reference,d.pourcentage;


CREATE OR REPLACE VIEW getpayer AS
SELECT
    v.reference,
    COALESCE(SUM(p.montant), 0) AS payer,
    v.total,
    v.montant,
    v.total - COALESCE(SUM(p.montant), 0) AS reste,
    CASE
        WHEN COALESCE(SUM(p.montant), 0) >= v.total THEN 'Payed'
        ELSE 'Not Payed'
        END AS statut_paiement,
    -- Calcul du pourcentage de paiement
    (COALESCE(SUM(p.montant), 0) / v.total) * 100 AS pourcentage_paiement
FROM
    getsomme v
        LEFT JOIN
    paiment p ON v.reference = p.ref_devis
GROUP BY
    v.reference, v.total, v.montant;


create or replace view viewdevis1 as select gp.total,v.*,
 gp.statut_paiement,gp.reste,gp.payer,gp.pourcentage_paiement,
        CASE
            WHEN v.datefin < CURRENT_DATE THEN 'Finished'
            ELSE 'Not Finished'
            END AS etat
 from viewdevis v join getpayer gp on gp.reference=v.reference;


drop view viewdevis1;
drop view getpayer;
drop view getsomme;
drop view viewdevis;
drop view viewdetaildevis;
drop view viewtravaux;
drop view viewmaison;

drop table paiment;
drop table travauxMaison;
drop table detailFinition;
drop table detailDevis;
drop table devisClient;
drop table travaux;
drop table finition;
drop table client;
drop table maison;





with allMonths as (select generate_series(date_trunc('year', '2024-01-01'::date),
                                          date_trunc('year', '2024-01-01'::date) + INTERVAL '1 year-1 day',
                                          interval '1 month') as month)
    select to_char(allMonths.month,'YYYY-MM') as month,
           coalesce(sum(total),0) as total
        from allMonths
            left join viewdevis1 on date_trunc('month',viewdevis1.dateinsertion) = allMonths.month
            group by month
                order by month;


create table import_devis(
    client varchar(50),
    ref_devis varchar(50),
    type_maison varchar(50),
    finition varchar(50),
    taux_finition float,
    date_devis date,
    date_debut date,
    lieu varchar(50)
);

create table import_maison_travaux(
    type_maison varchar(50),
    description text,
    surface float,
    code_travaux varchar(50),
    type_travaux varchar(50),
    unite varchar(50),
    prix_unitaire float,
    quantite float,
    duree_travaux int
);

create table import_paiement(
    ref_devis varchar(50),
    ref_paiement varchar(50),
    date_paiement date,
    montant float
);



