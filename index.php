<?php
session_start();
ini_set('display_errors', 1);
require "Import.php";
$router = new Router();
$router->routerRequest();
?>