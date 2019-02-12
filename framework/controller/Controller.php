<?php           
abstract class Controller {
    protected $view; 
    // Action à réaliser
    private $action;
    // Requête entrante
    protected $request;
    protected $lang;

    public function __construct() {
        
        if(isset($_COOKIE["php4ever_lang"]))
        {
            $this->lang = $_COOKIE["php4ever_lang"];
        }else{
            $jason= json_decode(file_get_contents("./config.json"));
            $this->lang=$jason->appli->lang;
        }
        
    }
    // Définit la requête entrante
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    // Exécute l'action à réaliser
    public function executeAction($action) {
        if (method_exists($this, $action)) {
            
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $classController = get_class($this);
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            throw new Exception($json->Error->ErrorType->ActionNotFound);
        }
    }

    // Méthode abstraite correspondant à l'action par défaut
    // Oblige les classes dérivées à implémenter cette action par défaut
    public abstract function index();

    // Génère la vue associée au contrôleur courant
    protected function generateView($dataView = array()) {
        
    // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
    
        $classController = get_class($this);
        $controller = str_replace("Controller", "", $classController);
    // Instanciation et génération de la vue
        
        $view = new View($this->action, $controller);
        $view->generate($dataView);
    }
    protected function generateViewJSON($dataView = array()) {
        
        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        
            $classController = get_class($this);
            $controller = str_replace("Controller", "", $classController);
        // Instanciation et génération de la vue
            
            $view = new View($this->action, $controller);
            $view->generateJSON($dataView);
        }
    protected function setLang($lang){
        setcookie("php4ever_lang",$lang);
    }

}
