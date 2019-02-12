<?php

require_once('./framework/model/Database.php');

class Paiement extends Database {
    /**
     * Retourne toutes les colonnes des paiements
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_PAIEMENT, DATE_CREATION, NOM FROM PAIEMENT";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne la liste des moyens de paiement
     */
    function getNameList() {
        $this->getConnection();
        $request = "SELECT NOM FROM PAIEMENT";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne le paiement correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_PAIEMENT, DATE_CREATION, NOM
                    FROM PAIEMENT
                    WHERE ID_PAIEMENT=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'un paiement
     */
    function create($name) {
        $this->getConnection();
        $params = array(":nom" => $name);
        $request = "INSERT INTO PAIEMENT (DATE_CREATION, NOM)
                    VALUES (NOW(), :nom)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Change le nom du paiement correspondant à l'id
     */
    function update($id, $name) {
        $this->getConnection();
        $params = array(":id" => $id, ":nom" => $name);
        $request = "UPDATE PAIEMENT SET NOM=:nom WHERE ID_PAIEMENT=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime le paiement correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM PAIEMENT WHERE ID_PAIEMENT=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
