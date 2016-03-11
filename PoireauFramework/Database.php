<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 *
 * @author Ga�tan
 */
class Database extends \PDO implements Creatable{
    
    public function __construct($dsn, $username, $passwd) {
        try{
            parent::__construct($dsn, $username, $passwd,array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
        }catch (Exception $ex) {
            die('erreur :'.$ex->getMessage());
        }
    }
    
    /**
     * Cr�e une nouvelle connexion avec la configuration
     * @param object $config
     * @return \PoireauFramework\Database
     */
    static public function newConnexion($config){
        return new Database($config->dsn, $config->login, $config->pass);
    }

    public static function createInstance(Loader $loader) {
        return self::newConnexion($loader->load(Config::class)->database);
    }
}

