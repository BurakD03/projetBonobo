<?php

require_once('./framework/model/Database.php');

class Produit extends Database {
    /**
     * Retourne tous les produits
     */
    function getAll() {
        $this->getConnection();
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE 
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE";
        $result = $this->select($request);
        return $result;
    }

    /**
     * Retourne le produit correspondant à l'id
     */
    function get($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE 
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE
                    WHERE P.ID_PRODUIT=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne les produits de la catégorie
     */
    function getByCategory($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE 
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE
                    WHERE P.ID_CATEGORIE=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne tous les produits composant le menu correspondant à l'id
     */
    function getByMenu($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE
                    INNER JOIN POSSEDER PO ON PO.ID_PRODUIT=P.ID_PRODUIT
                    WHERE PO.ID_MENU=:id";
        $result = $this->prepare_select($request, $params);
        return $result;
    }

    /**
     * Retourne tous les produits composant le menu correspondant à l'id et selectionne uniquement les produits de la catégorie choisie.
     */
    function getByMenuAndCategorie($menuId, $categoryId) {
        $this->getConnection();
        $params = array(":id_menu" => $menuId, ":id_categorie" => $categoryId);
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE
                    INNER JOIN POSSEDER PO ON PO.ID_PRODUIT=P.ID_PRODUIT
                    WHERE PO.ID_MENU=:id_menu AND P.ID_CATEGORIE=:id_categorie";
        $result = $this->prepare_select($request, $params);
        return $result;
    }
    function create($name,$price,$description,$categId,$image){
        $message="";
        $connection = $this->getConnection();
        $request="insert into PRODUIT(DATE_CREATION, NOM, PRIX, DESCRIPTION, ID_CATEGORIE, IMAGE) VALUES (NOW(), :name, :price, :description, :id_categorie, :image )";
        $params=array(':name'=>$name,':description'=>$description,':price'=>$price,':id_categorie'=>$categId, ':image'=>$image);
        $message=$this->prepare_insert($request,$params);
        return $message;
    }

    function delete($id) {
        $this->getConnection();
        $params = array(":id" => $id);
        $request = "DELETE FROM PRODUIT WHERE ID_PRODUIT=:id";
        $result = $this->prepare_insert($request, $params);
        return $result;
    }

    function getLike($nom){
        $this->getConnection();
        $params = array(":nom" => $nom);
        $request = "SELECT P.ID_PRODUIT, P.DATE_CREATION, P.NOM, P.PRIX, P.DESCRIPTION, P.ID_CATEGORIE, P.IMAGE, C.NOM AS CATEGORIE 
                    FROM PRODUIT P INNER JOIN CATEGORIE C ON P.ID_CATEGORIE=C.ID_CATEGORIE
                    WHERE P.NOM like '%$nom%'";
        $result = $this->select($request);
        return $result;
    }
    function modifyProduit($id,$name,$price,$description, $categorie,$image){
        $message="";
        $img="";
        $this->getConnection();
        $image=$this->recupImage($id);
        $request="update PRODUIT set NOM=:name, PRIX=:price, DESCRIPTION=:description, ID_CATEGORIE=:categorie, IMAGE=:image  where ID_PRODUIT=:id;";
        $params=array(':name'=>$name,':description'=>$description,':price'=>$price,':image'=>$image,':categorie'=>$categorie,':id'=> $id);
        $message=$this->prepare_insert($request,$params);
        return $message;
    }
    function unProduit($id){
        $this->getConnection();
        $request ="select i.* ,c.NOM as categ from PRODUIT i left join CATEGORIE c on i.ID_CATEGORIE=c.ID_CATEGORIE where i.ID_PRODUIT=:id;";
        $param = array(':id' => $id);
        $table = $this->prepare_select($request,$param);
        return $table[0];
    }
    function recupImage($id){
        $this->getConnection();
        $request ="select IMAGE from PRODUIT where ID_PRODUIT=:id;";
        $param=array(":id"=>$id);
        $table = $this->prepare_select($request,$param);
        return $table[0]["IMAGE"];
    }
}
