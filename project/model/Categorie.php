<?php

require_once('./framework/model/Database.php');

class Categorie extends Database {
    /**
     * Retourne toutes les colonnes des catégories
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_CATEGORIE, NOM FROM CATEGORIE";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne la liste des noms de categorie
     */
    function getNameList() {
        $this->getConnection();
        $request = "SELECT NOM FROM CATEGORIE";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne la catégorie correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_CATEGORIE, NOM
                    FROM CATEGORIE
                    WHERE ID_CATEGORIE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'une catégorie
     */
    function create($name) {
        $this->getConnection();
        $params = array(":nom" => $name);
        $request = "INSERT INTO CATEGORIE (NOM)
                    VALUES (:nom)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Change le nom de la catégorie correspondant à l'id
     */
    function update($id, $name) {
        $this->getConnection();
        $params = array(":id" => $id, ":nom" => $name);
        $request = "UPDATE CATEGORIE SET NOM=:nom WHERE ID_CATEGORIE=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime la catégorie correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM CATEGORIE WHERE ID_CATEGORIE=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
