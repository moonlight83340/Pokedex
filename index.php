<?php
/**
 * User: Gaëtan Perrot
 * Date: 24/01/2016
 * Time: 22:36
 */

error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();
//inclus le Loader, pour initialiser l'autoload
require 'PoireauFramework/Loader.php';

//crée l'instance de l'application
$app = new PoireauFramework\PoireauFramework(
    new \PoireauFramework\Config('App/config.ini') //indique la configuration
);

//exécute la page
$app->run();