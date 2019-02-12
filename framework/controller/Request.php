<?php
class Request {

// paramètres de la requête
    private $parameters;
    private $lang;
    public function __construct($parameters) {
        $this->parameters = $parameters;
        if(isset($_COOKIE["php4ever_lang"]))
        {
            $this->lang = $_COOKIE["php4ever_lang"];
        }else{
            $jason= json_decode(file_get_contents("./config.json"));
            $this->lang=$jason->appli->lang;
        }
    }

// Renvoie vrai si le paramètre existe dans la requête
    public function existParameter($name) {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

// Renvoie la valeur du paramètre demandé
// Lève une exception si le paramètre est introuvable
    public function getParameter($name) {
        if ($this->existParameter($name)) {
            return $this->parameters[$name];
        } else
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            throw new Exception($json->{'Error'}->{'ErrorType'}->{'ParameterNotFound'});
    }

}
