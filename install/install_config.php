<?php
/**
 * Fichier temporaire permettant la creation du fichier de configuration.
 * Il est automatiquement supprimé à la fin du déploiement effectué par Jenkins.
 */

 $jsonArray = array(
  "appli" => array(
    "controller" => "Bonobo",
    "action" => "index",
    "lang" => "fr"
  ),
  "db" => array(
    "name" => isset($_ENV["MYSQL_DATABASE"]) ? $_ENV["MYSQL_DATABASE"] : "bonobo",
    "host" => isset($_ENV["MYSQL_HOST"]) ? $_ENV["MYSQL_HOST"] : "localhost",
    "user" => isset($_ENV["MYSQL_USER"]) ? $_ENV["MYSQL_USER"] : "bonobo",
    "password" => isset($_ENV["MYSQL_PASSWORD"]) ? $_ENV["MYSQL_PASSWORD"] : "bonobo"
  ),
  "twig_extension" => array("Php4ever")
);

file_put_contents("config.json", json_encode($jsonArray, JSON_PRETTY_PRINT));
