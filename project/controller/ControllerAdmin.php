<?php
require_once 'project/model/Produit.php';
require_once 'project/model/Utilisateur.php';
require_once 'project/model/Categorie.php';
require_once 'project/model/Menu.php';
require_once 'project/model/Commande.php';

class ControllerAdmin extends Controller {
    protected $utilisateurModel;
    protected $produitModel;
    protected $categorieModel;
    protected $menuModel;
    protected $commandeModel;

    public function __construct() {
        if(isset($_SESSION) && isset($_SESSION['id'])) {
            parent::__construct();
            $this->produitModel = new Produit();
            $this->categorieModel = new Categorie();
            $this->utilisateurModel = new Utilisateur();
            $this->menuModel = new Menu();
            $this->commandeModel = new Commande();
            $user = $this->utilisateurModel->get($_SESSION['id']);
            if (!$user || $user[0]["NIVEAU"] < 2) {
                header("Location: ./bonobo_index.html");
            }
        } else {
            header("Location: ./bonobo_index.html");
        }
    }
    // les actions
    public function index() {
        $products = $this->produitModel->getAll();
        $this->generateView(array("products" => $products));
    }
    public function insert() {
        $categories = $this->categorieModel->getAll();
        $this->generateView(array("categories" => $categories));
    }
    public function delete() {
        $this->menuModel->deleteProductFromMenus($_GET['id']);
        $this->commandeModel->deleteProductFromCommandes($_GET['id']);
        $messages = $this->produitModel->delete($_GET['id']);
        if($message == "") {
            header("Location: ./admin_index.html");
        }else{
            throw new Exeption($message);
        }
    }
    public function addproduct(){
        $tab = $this->categorieModel->getAll();
        $ret=array();
        foreach( $tab as $ligne ){
            $ret[$ligne["ID_CATEGORIE"]] = $ligne["NOM"];
        }
        $this->generateView(array("tab"=>$ret));
    }

    public function checkedinsert() {
        
        $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";
        
        if(!empty($_POST)) 
        {
            $name               = $_POST['produit_libelle'];
            $description        = $_POST['produit_description'];
            $price              = $_POST['produit_prix'];
            $category           = $_POST['categorie']; 
            $image              = $_FILES['produit_image']['name'];
            $imagePath          = './project/picture/'. basename($image);
            $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
            $isSuccess          = true;
            $isUploadSuccess    = false;
            
            if(empty($name)) 
            {
                $nameError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            }
            if(empty($description)) 
            {
                $descriptionError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            } 
            if(empty($price)) 
            {
                $priceError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            } 
            if(empty($category)) 
            {
                $categoryError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            }
            if(empty($image)) 
            {
                $imageError = 'Ce champ ne peut pas être vide';
                $isSuccess = false;
            }
            else
            {
                $isUploadSuccess = true;
                if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
                {
                    $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                    $isUploadSuccess = false;
                }
                if(file_exists($imagePath)) 
                {
                    $imageError = "Le fichier existe deja";
                    $isUploadSuccess = false;
                }
                if($_FILES["produit_image"]["size"] > 500000) 
                {
                    $imageError = "Le fichier ne doit pas depasser les 500KB";
                    $isUploadSuccess = false;
                }
                if($isUploadSuccess) 
                {
                    if(!move_uploaded_file($_FILES['produit_image']['tmp_name'],$imagePath)) 
                    {
                        $imageError = "Il y a eu une erreur lors de l'upload";
                        $isUploadSuccess = false;
                    } 
                } 
            }
            
            if($isSuccess && $isUploadSuccess) 
            {
                $this->produitModel->create($name, $price, $description, $category,$imagePath);
                header("Location: ./admin_index.html");
            }
            else{
                throw new Exception("Veuillez remplir tous les champs du formulaire et NE PAS utiliser une image déjà existante");
            }    

        }
    }

    public function edit(){
        $tab =$this->categorieModel->getAll();
        $ret=array();
        foreach( $tab as $ligne ){
            $ret[$ligne["ID_CATEGORIE"]] = $ligne["NOM"];
        }
        $tab =$this->produitModel->unProduit($_GET['id']);
        $this->generateView(array("tab"=>$tab,"liste"=>$ret));
        
    }

    public function modifyproduct(){
        $id= $_POST['product_id'];
        $message="";
        $image="";
        if(!empty($_FILES)){
            $image=$_FILES['product_img']['name'];
            $imagepath="./project/picture/".basename($image);
            if(!file_exists($imagepath)){
                if(!move_uploaded_file($_FILES['product_img']['tmp_name'],$imagepath)){
                    throw new Exception("upload impossible");
                }
            }
        }
        
        $message=$this->produitModel->modifyProduit($_POST['product_id'],$_POST['product_name'],$_POST['product_price'], $_POST['product_description'],$_POST['product_categorie'],$imagepath);
        if(!empty($message)){
            header("Location: ./admin_edit_$id.html");
        }else{
            throw new Exception("Veuillez remplir tous les champs");
        }
        
    }

    

}
