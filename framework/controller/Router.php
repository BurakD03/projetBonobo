<?php
class Router {

    private $json;
    private $lang;

    public function __construct() {
        if(isset($_COOKIE["php4ever_lang"]))
        {
            $this->lang = $_COOKIE["php4ever_lang"];
        }else{
            $jason= json_decode(file_get_contents("./config.json"));
            $this->lang=$jason->appli->lang;
        }
    }
    public function routerRequest() {
        try {
// Fusion des paramètres GET et POST de la requête

            $request = new Request(array_merge($_GET, $_POST));
            $controller = $this->createController($request);
            $action = $this->createAction($request);
            $controller->executeAction($action);
            
        } catch (Exception $e) {
            $this->manageError($e);
        }
    }

    // Crée le contrôleur approprié en fonction de la requête reçue
    private function createController(Request $request) {
        $json= json_decode(file_get_contents("./config.json"));
        $controller = $json->appli->controller; // Contrôleur par défaut
        if ($request->existParameter('controller')) {
            
            $controller = $request->getParameter('controller');
        // Première lettre en majuscule
            $controller = ucfirst(strtolower($controller));
        }
        // Création du nom du fichier du contrôleur
        $classController = "Controller" . $controller;
        $fileController = "./project/controller/" . $classController . ".php";
        
        if (file_exists($fileController)) {
        // Instanciation du contrôleur adapté à la requête
            require($fileController);
            $controller = new $classController();
            $controller->setRequest($request);
            return $controller;
        } else {
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            throw new Exception($json->Error->ErrorType->FileNotFound);
        }
        
    } 
// Détermine l'action à exécuter en fonction de la requête reçue
    private function createAction(Request $request) {
        $json= json_decode(file_get_contents("./config.json"));
        $action = $json->appli->action; // Action par défaut
        if ($request->existParameter('action')) {
            $action = $request->getParameter('action'); 
        }
        return $action;
    }

// Gère une erreur d'exécution (exception)
    private function manageError(Exception $exception) {
        $view = new View('error');
        $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
        $view->generate(array('errorTitle' => $json->Error->ErrorTitle,'errorMessage' => $json->Error->ErrorMessage,'errorType' => $exception->getMessage()));
    }

}
