<?php
require_once 'project/model/Produit.php';
require_once 'project/model/Utilisateur.php';
require_once 'project/model/Categorie.php';
require_once 'project/model/Commande.php';

class ControllerScript extends Controller {
    protected $utilisateurModel;
    protected $produitModel;
    protected $categorieModel;
    protected $commandeModel;
    public function __construct() {
        if(isset($_SESSION) && isset($_SESSION['id'])) {
            parent::__construct();
            $this->produitModel = new Produit();
            $this->commandeModel = new Commande();
            $this->categorieModel = new Categorie();
            $this->utilisateurModel = new Utilisateur();
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
        header("Location: ./bonobo_index.html");
    }
   
    public function ajaxProduct() {
        $tab=$this->produitModel->get($_POST['id']);
        $this->generateViewJSON($tab);
    }
    public function ajaxcommande(){
        $tab=$this->commandeModel->getProduct($_POST['id']);
        $tab2=$this->commandeModel->getMeal($_POST['id']);
        $meal=array();
        $row=array();
        $compo=array();
        $id_meal=-1;
        $i=0;
        if(count($tab2)>0){
            foreach($tab2 as $ligne){
                if($id_meal == $ligne['ID_MENU']){
                    array_push($compo, $ligne['PRODUIT_NOM'] );

                }else{
                    if($i!=0){
                        echo'pasprems';
                        $row['COMPO']=$compo;
                        $compo=array();
                        $meal[count($meal)]=$row;
                    }
                    
                    $row=array('NB'=>$ligne['NB'],'MENU_NOM'=>$ligne['MENU_NOM'],'MENU_PRIX'=>$ligne['MENU_PRIX']);
                    array_push($compo, $ligne['PRODUIT_NOM'] );
                }
                $id_meal=$ligne['ID_MENU'];
                $i=1;
            }
            $row['COMPO']=$compo;
            $meal[count($meal)]=$row;
        }
        $this->generateViewJSON(array('tab'=>$tab,'meal'=>$meal));
    }
    public function ajaxSearch() {
        $tab=$this->produitModel->getLike($_POST['val']);
        $this->generateViewJSON($tab);
    }
    
    

}