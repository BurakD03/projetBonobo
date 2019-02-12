<?php

require_once('./framework/model/Database.php');

class Reservation extends Database {
    /**
     * Retourne toutes les reservations.
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_RESERVATION, RESERVATION.DATE_CREATION, DATE_RESERVATION, NB, COMMENTAIRE, CLIENT.ID_CLIENT,PRENOM, NOM FROM RESERVATION INNER JOIN CLIENT ON CLIENT.ID_CLIENT = RESERVATION.ID_CLIENT";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne la reservation correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_RESERVATION, DATE_CREATION, DATE_RESERVATION, NB, COMMENTAINRE, ID_CLIENT
                    FROM RESERVATION
                    WHERE ID_RESERVATION=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne les reservations du client
     */
    function getByClient($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_RESERVATION, DATE_CREATION, DATE_RESERVATION, NB, COMMENTAINRE, ID_CLIENT
                    FROM RESERVATION
                    WHERE ID_CLIENT=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Supprime la reservation correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM RESERVATION WHERE ID_RESERVATION=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Creation d'une reservation
     */
    function create($reservationDate, $qty, $comment, $clientId) {
        $this->getConnection();
        $params = array(":date_reservation" => $reservationDate, ":nb" => $qty, ":commentaire" => $comment, ":id_client" => $clientId);
       $request = "INSERT INTO RESERVATION ( DATE_RESERVATION, NB, COMMENTAIRE,ID_CLIENT)
                    VALUES (:date_reservation, :nb, :commentaire, :id_client)";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
