<?php

require_once('./framework/model/Database.php');

class Utilisateur extends Database {
    /**
    * Retourne tous les utilisateurs
    */
    function getAll() {
        $this->getConnection();
        $request = "SELECT U.ID_UTILISATEUR, U.DATE_CREATION, U.IDENTIFIANT, U.MOTDEPASSE, U.ID_GROUPE, G.NOM AS GROUPE, G.NIVEAU AS NIVEAU
                    FROM UTILISATEUR U INNER JOIN GROUPE G ON U.ID_GROUPE=G.ID_GROUPE";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne l'utilisateur correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT U.ID_UTILISATEUR, U.DATE_CREATION, U.IDENTIFIANT, U.MOTDEPASSE, U.ID_GROUPE, G.NOM AS GROUPE, G.NIVEAU AS NIVEAU
                    FROM UTILISATEUR U INNER JOIN GROUPE G ON U.ID_GROUPE=G.ID_GROUPE
                    WHERE ID_UTILISATEUR=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne le mot de passe de l'utilisateur correspondant à l'id
     */
    function getPassword($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT MOTDEPASSE FROM UTILISATEUR WHERE ID_UTILISATEUR=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne le mot de passe de l'utilisateur correspondant à l'identifiant
     */
    function getPasswordByLogin($login) {
        $this->getConnection();
        $params = array(":login" => $login);
        $request = "SELECT MOTDEPASSE FROM UTILISATEUR WHERE IDENTIFIANT=:login";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'un utilisateur
     */
    function create($login, $password, $groupId) {
        $this->getConnection();
        $params = array(":identifiant" => $login, ":motdepasse" => $password, ":groupe_id" => $groupId);
        $request = "INSERT INTO UTILISATEUR (DATE_CREATION, IDENTIFIANT, MOTDEPASSE, ID_GROUPE)
                    VALUES (NOW(), :identifiant, :motdepasse, :groupe_id)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Retourne l'utilisateur correspondant à l'identifiant et au mot de passe
     */
    function getByLoginAndPassword($login, $password) {
        $this->getConnection();
        $params = array(":login" => $login, ":password" => $password);
        $request = "SELECT U.ID_UTILISATEUR, U.DATE_CREATION, U.IDENTIFIANT, U.MOTDEPASSE, U.ID_GROUPE, G.NOM AS GROUPE, G.NIVEAU AS NIVEAU 
                    FROM UTILISATEUR U INNER JOIN GROUPE G ON U.ID_GROUPE=G.ID_GROUPE
                    WHERE U.IDENTIFIANT=:login AND U.MOTDEPASSE=:password";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne l'utilisateur correspondant à l'identifiant
     */
    function getByLogin($login) {
        $this->getConnection();
        $params = array(":login" => $login);
        $request = "SELECT U.ID_UTILISATEUR, U.DATE_CREATION, U.IDENTIFIANT, U.MOTDEPASSE, U.ID_GROUPE, G.NOM AS GROUPE, G.NIVEAU AS NIVEAU 
                    FROM UTILISATEUR U INNER JOIN GROUPE G ON U.ID_GROUPE=G.ID_GROUPE
                    WHERE U.IDENTIFIANT=:login";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne les utilisateurs ayant le niveau correspondant au niveau entré en paramètre
     */
    function getByLevel($level) {
        $this->getConnection();
        $params = array(":niveau" => $level);
        $request = "SELECT U.ID_UTILISATEUR, U.DATE_CREATION, U.IDENTIFIANT, U.MOTDEPASSE, U.ID_GROUPE, G.NOM AS GROUPE, G.NIVEAU AS NIVEAU
                    FROM UTILISATEUR U INNER JOIN GROUPE G ON U.ID_GROUPE=G.ID_GROUPE
                    WHERE G.NIVEAU=:niveau";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Supprime l'utilisateur correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM UTILISATEUR WHERE ID_UTILISATEUR=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
