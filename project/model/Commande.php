<?php

require_once('./framework/model/Database.php');

class Commande extends Database {
    /**
     * Retourne tous les commandes.
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_COMMANDE, COMMANDE.DATE_CREATION, DATE_REC, COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE,
                    LIVRAISON, COMMANDE.ID_CLIENT, COMMANDE.ID_PAIEMENT, LIBELLE AS LIBELLE_PAIEMENT,NOM,PRENOM
                    FROM COMMANDE INNER JOIN PAIEMENT ON PAIEMENT.ID_PAIEMENT = COMMANDE.ID_PAIEMENT
                    INNER JOIN CLIENT ON COMMANDE.ID_CLIENT = CLIENT.ID_CLIENT";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne la commande correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_COMMANDE, DATE_CREATION, DATE_REC, COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE,
                    LIVRAISON, ID_CLIENT, ID_PAIEMENT
                    FROM COMMANDE
                    WHERE ID_COMMANDE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    
    function getProduct($id){
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT NB,NOM,PRIX
                    FROM  CONTENU INNER JOIN PRODUIT ON CONTENU.ID_PRODUIT = PRODUIT.ID_PRODUIT
                    WHERE ID_COMMANDE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    function getMeal($id){
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT NB,MENU.ID_MENU,MENU.NOM as MENU_NOM ,PRODUIT.NOM AS PRODUIT_NOM,MENU.PRIX AS MENU_PRIX
                    FROM  COMPOSER INNER JOIN PRODUIT ON COMPOSER.ID_PRODUIT = PRODUIT.ID_PRODUIT
                    INNER JOIN MENU ON COMPOSER.ID_MENU = MENU.ID_MENU
                    WHERE ID_COMMANDE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }
    /**
     * Retourne la commande du client correspondant à l'id
     */
    function getByClient($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_COMMANDE, DATE_CREATION, DATE_REC, COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE,
                    LIVRAISON, ID_CLIENT, ID_PAIEMENT
                    FROM COMMANDE
                    WHERE ID_CLIENT=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'une commande
     */
    function create($commentaire, $etat, $numAdresse, $libelleAdresse, $codePostal, $ville, $livraison, $idClient, $idPaiement) {
        $this->getConnection();
        $params = array(":commentaire" => $commentaire, ":etat" => $etat, ":num_adresse" => $numAdresse, ":libelle_adresse" => $libelleAdresse,
                        ":code_postal" => $codePostal, ":ville" => $ville, ":livraison" => $livraison,
                        ":id_client" => $idClient, ":id_paiement" => $idPaiement);
        $request = "INSERT INTO COMMANDE (DATE_CREATION, DATE_REC, COMMENTAIRE, ETAT, NUM_ADRESSE, LIBELLE_ADRESSE, CODE_POSTAL, VILLE, LIVRAISON, ID_CLIENT, ID_PAIEMENT)
                    VALUES (NOW(), NULL, :commentaire, :etat, :num_adresse, :libelle_adresse, :code_postal, :ville, :livraison, :id_client, :id_paiement)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Supprime la commande correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM COMMANDE WHERE ID_COMMANDE=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime le produit des commandes
     */
    function deleteProductFromCommandes($productId) {
        $this->getConnection();
        $params = array(":id_produit" => $productId);
        $request = "DELETE FROM CONTENU WHERE ID_PRODUIT=:id_produit";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
