<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework\Arch;

use PoireauFramework\PoireauFramework;

/**
 * Classe de base des controleurs
 *
 * @author Gaëtan
 * 
 */
abstract class Controller implements \PoireauFramework\Creatable{
    /**
     *
     * @var PoireauFramework
     */
    protected $app;
    
    public function __construct(PoireauFramework $app) {
        $this->app = $app;
    }
    
    public function __get($name) {
        return $this->app->$name;
    }
    
    public function __isset($name) {
        return isset($this->app->$name);
    }
    
    public function __set($name, $value) {
        $this->app->$name = $value;
    }

    public static function createInstance(\PoireauFramework\Loader $loader) {
        return new static($loader->load(PoireauFramework::class));
    }
}
