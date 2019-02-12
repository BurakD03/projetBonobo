<?php
class Database {
    
    public $connection;
    private $lang;

    protected function getConnection() {
        $jason= json_decode(file_get_contents("./config.json"));
        $this->lang=$jason->appli->lang;
        //cette fonction permet de se connecter au SGBD et à une base de données
        if ($this->connection == null) {
            $json = json_decode(file_get_contents("./config.json"));
            $PARAM_name_db = $json->db->name;
            $PARAM_user = $json->db->user;
            $PARAM_password = $json->db->password;
            $PARAM_host = $json->db->host;

            $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'"; //encodage utf-8
            try {
                $this->connection = new PDO("mysql:host=$PARAM_host;dbname=$PARAM_name_db", $PARAM_user, $PARAM_password, $pdo_options);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
                $message = $json->Error->ErrorType->ConnectionFail.$e->getMessage();
                echo "$message";
                return $message;
            }
        }

        return $this->connection;
    }

// permet d'inserer une ligne
    protected function insert($request, $auto = 'n') {
        $message = "";
        try {
            $results = $this->connection->exec($request);
        } catch (PDOException $e) {
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            $message=$json->Error->ErrorType->FailExecRequest;
            $message = $message .$request." ". $e->getMessage();
            echo $message;
        }
        if ($auto == 'o') {
            $table1 = $this->connection->query('SELECT LAST_INSERT_ID() as last_id');
            $table2 = $table1->fetchALL(PDO::FETCH_ASSOC);
            $last_id = $table2[0]['last_id'];
            return $last_id;
        }

        return $message;
    }

    //call
    //cette fonction renvoie le resultat d'une requete sous forme d'un tableau
    protected function prepare_insert($request, $params) {
        $message = "";
        try {
            $sth = $this->connection->prepare($request);
            $sth->execute($params);
            $message = $sth->fetch(\PDO::FETCH_ASSOC);
            
        } catch (PDOException $e){
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            $message=$json->Error->ErrorType->FailExecRequest;
            $message = $message .$request." ". $e->getMessage();
        }
        return $message;
    }
//cette fonction renvoie le resultat d'une requete sous forme d'un tableau
    protected function select($request) {
        $message = "";
        try {
            $results = $this->connection->query($request);
        } catch (PDOException $e) {
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            $message=$json->Error->ErrorType->FailExecRequest;
            $message = $message .$request." ". $e->getMessage();
            return $message;
        }
        $table = $results->fetchALL(PDO::FETCH_ASSOC); // on dit qu'on veut que le résultat soit récupérable sous forme de tableau)
        return $table;
    }

    protected function prepare_select($request, $param) {
        $message = "";
        try {
            $sth = $this->connection->prepare($request, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute($param);
            $message = $sth->fetchAll();
        } catch (PDOException $e) {
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            $message=$json->Error->ErrorType->FailExecRequest;
            $message = $message .$request." ". $e->getMessage();
            echo $message;
        }
        return $message;
    }

    function exec($request) {
        $message = "";
        try {
            $results = $this->connection->exec($request);
        } catch (PDOException $e) {
            $json= json_decode(file_get_contents("./framework/lang/".$this->lang."/information.json"));
            $message=$json->Error->ErrorType->FailExecRequest;
            $message = $message .$request." ". $e->getMessage();
        }
        return $message;
    }

}

?>
