<?php
/**
 * Fichier temporaire permettant la création des tables MySQL.
 * Il est automatiquement supprimé à la fin du déploiement effectué par Jenkins.
 */

$config = json_decode(file_get_contents("../config.json"));
$sql = file_get_contents("../sql/script.sql");

if ($sql && $config) {
  $db = new PDO("mysql:host=".$config->db->host.";dbname=".$config->db->name, $config->db->user, $config->db->password);
  $db->exec($sql);
  $db = null;
} else {
  http_response_code(500);
}
