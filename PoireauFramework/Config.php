<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * Gestion de la configuration
 * Utilise des fichier .ini
 *
 * @author Gaëtan
 */
class Config extends ReadOnlyObject{
    public function __construct($file) {
        parent::__construct([]);
        $this->load($file);
    }
    
    /**
     * Charge un fichier ini
     * @param string $file
     */
    public function load($file){
        foreach(parse_ini_file($file, true) as $section => $values){
            $this->data[$section] = (object)$values;
        }
    }
}
