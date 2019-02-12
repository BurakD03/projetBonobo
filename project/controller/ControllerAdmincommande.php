<?php
require_once 'project/model/Commande.php';
require_once 'project/model/Produit.php';
require_once 'project/model/Client.php';
require_once 'project/model/Utilisateur.php';
require_once 'project/model/Reservation.php';

class ControllerAdmincommande extends Controller {
    protected $commandeModel;
    protected $produitModel;
    protected $utilisateurModel;
    protected $reservationModel;
    public function __construct() {
        
        if(isset($_SESSION) && isset($_SESSION['id'])) {
            parent::__construct();
            $this->produitModel = new Produit();
            $this->utilisateurModel = new Utilisateur();
            $this->commandeModel = new Commande();
            $this->reservationModel = new Reservation();

            $user = $this->utilisateurModel->get($_SESSION['id']);
            if (!$user || $user[0]["NIVEAU"] < 2) {
                header("Location: ./bonobo_index.html");
            }
        } else {
            header("Location: ./bonobo_index.html");
        }
    }

    public function index() {
       $tab=$this->commandeModel->getAll();

       $this->generateView(array('tab'=>$tab));
    }

    public function reserve() {
        $tab=$this->reservationModel->getAll();
        $this->generateView(array('tab'=>$tab));
     }

}
