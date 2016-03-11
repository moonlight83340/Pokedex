<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * Le router s'occupe d'analyser la requ�te
 * pour en d�duire l'action �effectuer
 * 
 * Pour cela il se base sur le PATH_INFO.
 *
 * @author Ga�tan
 */
class Router implements Creatable{
    private $config;
    private $controller;
    private $action;
    private $method;
    private $parameters;
    
    public function __construct($config) {
        $this->config = $config;
        
        $sPath = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        
        $this->parameters = [];
        
        foreach(explode('/', $sPath) as $step){
            $step = trim($step);
            
            if(!empty($step)) //retire les param�tres vide
                $this->parameters[] = $step;
        }
        
        $this->controller = array_shift($this->parameters);
        $this->action     = array_shift($this->parameters);
        $this->method     = strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    /**
     * Récupère le nom du contrôleur. 
     * S'il n'est pas présent, récupère dans la configuration (router->default_controller)
     * 
     * @return string
     */
    function getController() {
        return empty($this->controller) ? $this->config->default_controller : $this->controller;
    }

    /**
     * Récupère le nom de l'action
     * Si elle n'est pas présente, récupère dans la configuration router->default_action
     * @return string
     */
    function getAction() {
        return empty($this->action) ? $this->config->default_action : $this->action;
    }

    /**
     * Récupère la méthode HTTP
     * @return string (GET|POST|PUT|TRACE|HEAD|DELETE)
     */
    function getMethod() {
        return $this->method;
    }

    /**
     * Récupère la liste des paramètres
     * @return array
     */
    function getParameters() {
        return $this->parameters;
    }
    
    public static function createInstance(Loader $loader) {
        return new self($loader->load(Config::class)->router);
    }
}
