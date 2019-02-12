<?php
require_once 'project/model/Categorie.php';
require_once 'project/model/Produit.php';
require_once 'project/model/Utilisateur.php';
require_once 'project/model/Menu.php';

class ControllerBonobo extends Controller {
    protected $categorieModel;
    protected $produitModel;
    protected $utilisateurModel;
    protected $menuModel;

    public function __construct() {
        parent::__construct();
        $this->categorieModel = new Categorie();
        $this->produitModel = new Produit();
        $this->utilisateurModel = new Utilisateur();
        $this->menuModel = new Menu();
    }
//les actions
    public function index() {
        $category = $this->categorieModel->getAll();
        $id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : $category[0]["ID_CATEGORIE"];
        $this->generateView(array("category" => $category, "product" => $this->produitModel->getByCategory($id)));
    }

    public function login() {
        $params = array();
        if (isset($_GET["id"]) && $_GET["id"] == "err") {
            $params['err'] = "Identifiant ou mot de passe incorrect";
        }
        $this->generateView($params);
    }

    public function checkedlogin() {
        if (isset($_POST["user_login"]) && isset($_POST["user_pass"])) {
            $login = $_POST["user_login"];
            $pass = $_POST["user_pass"];
            $password = $this->utilisateurModel->getPasswordByLogin($login);

            if ($password && password_verify($pass, $password[0]["MOTDEPASSE"])) {
                $user = $this->utilisateurModel->getByLogin($login);
                if ($user) {
                    $_SESSION["id"] = $user[0]["ID_UTILISATEUR"];
                    $_SESSION["lvl"] = $user[0]["NIVEAU"];
                    header("Location: ./admin_index.html");
                } else {
                    header("Location: ./bonobo_login_err.html");
                }
            } else {
                header("Location: ./bonobo_login_err.html");
            }
        }
        else {
            header("Location: ./bonobo_login_err.html");
        }
    }

    public function meal() {
        $menus = $this->menuModel->getAll();
        foreach ($menus as &$menu) {
            $menu["ENTREES"] = $this->produitModel->getByMenuAndCategorie($menu["ID_MENU"], 5);
            $menu["PLATS"] = array_merge($this->produitModel->getByMenuAndCategorie($menu["ID_MENU"], 1), $this->produitModel->getByMenuAndCategorie($menu["ID_MENU"], 2));
            $menu["DESSERTS"] = $this->produitModel->getByMenuAndCategorie($menu["ID_MENU"], 4);
            $menu["BOISSONS"] = $this->produitModel->getByMenuAndCategorie($menu["ID_MENU"], 3);
        }
        $this->generateView(array("category" => $this->categorieModel->getAll(), "menu" => $menus));
    }   

    public function lang() {
        $this->setLang($_GET['id']);
        header("Location: ./bonobo_index.html");
    }
    public function logout(){
        session_destroy();
        header('Location: ./bonobo_index.html');
    }
}
