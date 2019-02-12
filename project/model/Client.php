<?php

require_once('./framework/model/Database.php');

class Client extends Database {
    /**
     * Retourne tous les clients.
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_CLIENT, DATE_CREATION, EMAIL, TELEPHONE, NOM, PRENOM, NEWSLETTER FROM CLIENT";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne le client correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_CLIENT, DATE_CREATION, EMAIL, TELEPHONE, NOM, PRENOM, NEWSLETTER
                    FROM CLIENT
                    WHERE ID_CLIENT=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne le client ayant l'adresse email correspondante.
     */
    function getByEmail($email) {
        $this->getConnection();
        $params = array(":email" => $email);
        $request = "SELECT ID_CLIENT, DATE_CREATION, EMAIL, TELEPHONE, NOM, PRENOM, NEWSLETTER
                    FROM CLIENT
                    WHERE EMAIL=:email";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'un client
     */
    function create($email, $tel, $firstname, $lastname, $newsletter) {
        $this->getConnection();
        $params = array( ":email" => $email, ":tel" => $tel, ":firstname" => $firstname, ":lastname" => $lastname, ":newsletter" => $newsletter);

       $request = "INSERT INTO CLIENT (DATE_CREATION, EMAIL, TELEPHONE, PRENOM, NOM, NEWSLETTER)
                    VALUES (NOW(), :email, :tel, :firstname, :lastname, :newsletter)";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
    /**
     * Supprime le client correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM CLIENT WHERE ID_CLIENT=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
