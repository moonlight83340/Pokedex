<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * Charge et sauvegarde des objets
 *
 * @author Ga�tan
 */
class Loader {
    /**
     * Registre des instances
     * [nom de classe] => [instance]
     * @var array
     */
    private $instances = [];
    
    /**
     * Table des modules
     * [interface] => [impl�mentation]
     * @var array
     */
    private $modules   = [];
    
    public function __construct() {
        $this->registerInstance($this);
    }
    
    /**
     * Enregistre une instance dans le loader
     * @param object $instance
     */
    public function registerInstance($instance){
        if(!is_object($instance))
            throw new \InvalidArgumentException('The parameter is not an object');
        
        $this->instances[get_class($instance)] = $instance;
    }
    
    /**
     * Récupère le nom de la classe d'implémentation
     * @param string $class
     * @return string
     */
    private function getRealClassName($class){
        if($class{0} === '\\')
            $class = substr($class, 1); 
        
        return isset($this->modules[$class]) ? $this->modules[$class] : $class;
    }
    
    /**
     * Enregistre l'implémentation d'une interface.
     * $impl doit être une sous-classe de $interface
     * @param string $interface
     * @param string $impl
     */
    public function setModule($interface, $impl){
        if(DEBUG && !is_subclass_of($impl, $interface))
            throw new \InvalidArgumentException($impl . ' is not a subclass of ' . $interface);
        
        $this->modules[$interface] = $impl;
    }
    
    /**
     * Récupère, ou charge une instance de la classe $class
     *          
     * @param string $class
     * @return L'instance de la classe
     * @throws ClassNotFoundException Si la classe n'existe pas
     * @see Creatable
     * @see Loader::getRealClassName($class)
     */
    public function load($class){
        $class = $this->getRealClassName($class);
        if(isset($this->instances[$class]))
            return $this->instances[$class];
        
        if(!class_exists($class)){
            throw new ClassNotFoundException('Class ' . $class . ' not found');
        }
        
        if(is_subclass_of($class, Creatable::class)){
            $obj = $class::createInstance($this);
        }else{
            $obj = new $class;
        }
        
        $this->instances[$class] = $obj;
        return $obj;
    }
    
    /**
     * Enregistre l'autoloader du framework, basé sur le namespace
     * @staticvar boolean $isInit true si l'autoload a déjà été chargé
     * @uses Loader::defineRootConst()
     */
    static public function initAutoload(){
        static $isInit = false;
        
        if($isInit)
            return;
        
        self::defineRootConst();
        
        spl_autoload_register(function($class){
            $file = ROOT_DIR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            
            if(is_file($file))
                require $file;
        });
        
        $isInit = true;
    }
    
    /**
     * Définie la constante ROOT_DIR si elle n'existe pas
     */
    static private function defineRootConst(){
        if(!defined('ROOT_DIR'))
            define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
    }
}

//initialise directement l'autoload
Loader::initAutoload();

class ClassNotFoundException extends \Exception{
    public function __construct($message, $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}