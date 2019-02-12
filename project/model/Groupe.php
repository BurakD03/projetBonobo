<?php

require_once('./framework/model/Database.php');

class Groupe extends Database {
    /**
     * Retourne tous les groupes.
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_GROUPE, DATE_CREATION, NOM, NIVEAU FROM GROUPE";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne le groupe correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_GROUPE, DATE_CREATION, NOM, NIVEAU
                    FROM GROUPE
                    WHERE ID_GROUPE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne les groupes ayant l'id correspondant
     */
    function getByLevel($level) {
        $this->getConnection();
        $params = array(":level" => $level);
        $request = "SELECT ID_GROUPE, DATE_CREATION, NOM, NIVEAU
                    FROM GROUPE
                    WHERE NIVEAU=:level";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'un groupe
     */
    function create($name, $level) {
        $this->getConnection();
        $params = array(":nom" => $name, ":niveau" => $level);
        $request = "INSERT INTO GROUPE (DATE_CREATION, NOM, NIVEAU)
                    VALUES (NOW(), :nom, :niveau)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Change le nom et le niveau du groupe correspondant à l'id
     */
    function update($id, $name, $level) {
        $this->getConnection();
        $params = array(":id" => $id, ":nom" => $name, ":niveau" => $level);
        $request = "UPDATE GROUPE SET NOM=:nom, NIVEAU=:niveau WHERE ID_GROUPE=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime le groupe correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM GROUPE WHERE ID_GROUPE=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
