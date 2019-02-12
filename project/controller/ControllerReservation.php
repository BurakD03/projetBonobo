<?php
require_once 'project/model/Reservation.php';
require_once 'project/model/Client.php';
class ControllerReservation extends Controller{
    private $modelReservation;
    private $modelClient;
    public function __construct() {
    
        parent::__construct();
       $this->modelReservation = new Reservation();
       $this->modelClient = new Client();
    }
//les actions
    public function index(){
        $this->generateView(array());
    }
    public function create(){
        $message="";
        //reservationDate, $qty, $comment, $clientId
        $message = $this->modelClient->create($_POST['client_email'],$_POST['client_telephone'],$_POST['client_nom'],$_POST['client_prenom'],0);
        $id=$this->modelClient->getByEmail($_POST['client_email']);
        $message = $message.$this->modelReservation->create($_POST['reser_date']." ".$_POST['reser_heure'],$_POST['reser_nb'],$_POST['reser_comm'],$id[0]['ID_CLIENT']);
        if($message == ""){
            header("Location: ./bonobo_index.html");
        }else{
            var_dump($message);
            throw new Exception("erreur d'insertion "+$message[0]);
        }
    }
}
