<?php
class View {
    
    //nom du fichier associÃ© Ã  la vue
    private $template="./project/view/";
    private $title;
    private $lang;
    private $page;
    private $name;

    public function __construct($action, $controller = "") {
        if(isset($_COOKIE["php4ever_lang"]))
        {
            $this->lang = $_COOKIE["php4ever_lang"];
        }else{
            $jason= json_decode(file_get_contents("./config.json"));
            $this->lang=$jason->appli->lang;
        }
        $this->page=$controller.$action;
        $name="";
        if($action=="error"){
            //$file="../../framework/view/";
        }else{
            if ($controller != "") {
                $name = $name . ucfirst(strtolower($controller)) . "/";
            }
        }
        $this->name = $name.ucfirst(strtolower($action)) . '.twig'; 
    }

    //generer et afficher la vue
    public function generate($data) {
        $config= json_decode(file_get_contents("./config.json"));
        //generer la vue avec twig
        if (file_exists($this->template.$this->name)) {
            $loader = new Twig_Loader_Filesystem( $this->template);
            $twig = new Twig_Environment($loader,['cache' => false ,'debug' => true /*'./tmp'*/]);
            //on ajoute les extensions twig mis dans la config de l'appli
            foreach($config->twig_extension as $extension)
            {
                $twig ->addExtension(new $extension());
            }
            $twig->addGlobal('current_page',$this->page);
            $twig->addGlobal('session', $_SESSION);
            echo $twig->render($this->name,$data);
        }else{
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            throw new Exception($json->Error->ErrorType->FileNotFound);
        }
        
    }
    public function generateJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}
