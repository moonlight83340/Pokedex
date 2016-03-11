<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace PoireauFramework;
/**
 * Gestion des erreurs
 *
 * @author Gaëtan
 */
class Error implements Creatable{
    /**
     *
     * @var Config
     */
    private $config;
    
    /**
     *
     * @var Output
     */
    private $output;
    
    public function __construct(Config $config, Output $output) {
        $this->config = $config;
        $this->output = $output;
    }
    
    
    public function error404(){
        echo 'fail';
    }
    
    public static function createInstance(Loader $loader) {
        return new Error($loader->load(Config::class), $loader->load(Output::class));
    }
}
