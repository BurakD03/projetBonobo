<?php

require_once('./framework/model/Database.php');

class Menu extends Database {
    /**
     * Retourne tous les menus.
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT ID_MENU, DATE_CREATION, NOM, PRIX, DESCRIPTION, IMAGE
                    FROM MENU";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne le menu correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT ID_MENU, DATE_CREATION, NOM, PRIX, DESCRIPTION, IMAGE
                    FROM MENU
                    WHERE ID_MENU=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Creation d'un menu
     */
    function create($name, $price, $description, $image) {
        $this->getConnection();
        $params = array(":nom" => $name, ":prix" => $price, ":description" => $description, ":image" => $image);
        $request = "INSERT INTO MENU (DATE_CREATION, NOM, PRIX, DESCRIPTION, IMAGE) VALUES (NOW(), :nom, :prix, :description, :image)";
        $result = $this->insert($request, $params);
        return $result;
    }

    /**
     * Supprime le menu correspondant à l'id
     */
    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM MENU WHERE ID_MENU=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime le produit de tous les menus
     */
    function deleteProductFromMenus($productId) {
        $this->getConnection();
        $params = array(":id_produit" => $productId);
        $request = "DELETE FROM POSSEDER WHERE ID_PRODUIT=:id_produit";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    /**
     * Supprime le produit du menu correspondant à l'id.
     */
    function deleteProductFromMenu($productId, $menuId) {
        $this->getConnection();
        $params = array(":id_produit" => $productId, ":id_menu" => $menuId);
        $request = "DELETE FROM POSSEDER WHERE ID_PRODUIT=:id_produit AND ID_MENU=:id_menu";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }
}
