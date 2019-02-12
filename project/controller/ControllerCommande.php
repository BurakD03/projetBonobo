<?php
require_once 'project/model/Commande.php';
require_once 'project/model/Produit.php';
require_once 'project/model/Client.php';

class ControllerCommande extends Controller {
    protected $commandeModel;
    protected $produitModel;
    protected $clientModel;

    public function __construct() {
        parent::__construct();
        $this->commandeModel = new Commande();
        $this->produitModel = new Produit();
        $this->clientModel = new Client();
    }

    public function index() {
       $this->generateView(array());
        
        
    }

    public function createClient() {
        $this->generateView(array());
    }

    public function createAdresse() {
        $this->generateView(array());
    }

    public function createDateRec(){
        $this->generateView(array());
    }
    public function create() {
        $json = $_POST['json'];
        $jason = json_encode($json);
        $jason = json_decode($jason);
        $message="";
        $mesage=$this->clientModel->create($jason->utilisateur->email,$jason->utilisateur->telephone,$jason->utilisateur->prenom,$jason->utilisateur->nom,$jason->utilisateur->newsletter);
        
        $id=$this->modelClient->getByEmail($jason->utilisateur->email);
        $message.=$this->commandeModel->create($jason->commentaire,1,$jason->adresse->numero,$jason->adresse->adresse,$jason->adresse->codePostal,$jason->adresse->ville,$jason->recuperaion->liv,$id,$jason->paiement);
        $ret=array('res'=>$message);
        $this->generateViewJSON($ret);
    }
    /*
    {,
        "utilisateur":
        {
            "nom":"nom",
            "prenom":"prenom",
            "email":"email@vlad.fa",
            "telephone":"0258741036",
            "newsletter":true
        },
        "adresse":
        {
            "numero":"2",
            "adresse":"rue de lol",
            "codePostal":"17000",
            "ville":"la rochelle"
        },"commande":
        {
            "date":"",
            "modePaiement":""
        },
        "produits":
        [
            {
                "id":1,
                "nom":"Salade César",
                "prix":3.5,
                "nb":1
            }
        ],
        "menus":
        [
            {"id":3,
                "nom":"Menu Américain",
                "prix":15,
                "nb":1,
                "entree":
                {
                    "nom":"Assiette de crudités"
                },
                "plat":
                {
                    "nom":"Salade au poulet frit"
                },
                "dessert":
                {
                    "nom":"Chocolat Liégeois"
                },
                "boisson":
                {
                    "nom":"Coca Cola"
                }
            }
        ],
        "date":1549147479527,
        "version":2,"
        recuperation":
        {
            "date":"2019-02-12",
            "heure":"12:05:00",
            "liv":true
        },
        "commentaire":"",
        "paiement":"1"
    }
    */
}
