<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework\Arch;

/**
 * Classe de base pour les modeles utilisant Database
 *
 * @author Gaëtan
 */
abstract class Model implements \PoireauFramework\Creatable{
    /**
     *
     * @var \PoireauFramework\Database
     */
    protected $database;
    
    public function __construct(\PoireauFramework\Database $database) {
        $this->database = $database;
    }

    public static function createInstance(\PoireauFramework\Loader $loader) {
        return new static($loader->load(\PoireauFramework\Database::class));
    }
}
