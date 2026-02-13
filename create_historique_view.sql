-- Création de la vue HISTORIQUE_COMPLET
-- Cette vue combine l'historique des achats d'articles et des inscriptions aux événements

DROP VIEW IF EXISTS HISTORIQUE_COMPLET;

CREATE VIEW HISTORIQUE_COMPLET AS
-- Historique des achats d'articles
SELECT 
    'Achat' AS type_transaction,
    A.nom_article AS element,
    C.qte_commande AS quantite,
    C.prix_commande AS montant,
    C.paiement_commande AS mode_paiement,
    C.date_commande AS date_transaction,
    C.statut_commande AS recupere,
    C.id_membre
FROM COMMANDE C
INNER JOIN ARTICLE A ON C.id_article = A.id_article

UNION ALL

-- Historique des inscriptions aux événements
SELECT 
    'Inscription' AS type_transaction,
    E.nom_evenement AS element,
    1 AS quantite,
    I.prix_inscription AS montant,
    I.paiement_inscription AS mode_paiement,
    I.date_inscription AS date_transaction,
    0 AS recupere,
    I.id_membre
FROM INSCRIPTION I
INNER JOIN EVENEMENT E ON I.id_evenement = E.id_evenement

ORDER BY date_transaction DESC;
