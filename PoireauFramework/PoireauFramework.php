<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * Classe de registre
 * S'occupe de charger les composants n�cessaires
 * Et ex�cute la page
 *
 * @author Ga�tan
 * merci � Vincent Quatrevieux pour sa pr�cieuse aide dans la conception de ce Framework ( Pour l'UML, les conseils et les explications sur PHP ainsi la class output bien expliqu�)
 * @property-read Loader $loader
 * @property-read Config $config
 * @property-read Error $error
 * @property-read Output $output
 * 
 * @property Router $router
 */
class PoireauFramework {
    /**
     *
     * @var Loader
     */
    private $loader;
    
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
    
    /**
     *
     * @var Error
     */
    private $error;
    
    private $registry = [];
    
    public function __construct(Config $config) {
        
        $this->loader = new Loader;
        $this->loader->registerInstance($this);
        
        $this->config = $config;
        $this->loader->registerInstance($config);
        
        $this->output = $this->loader->load(Output::class);
        $this->error  = $this->loader->load(Error::class);
    }
    
    /**
     * R�cup�re une variable du registre
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if(property_exists($this, $name)) //pour g�rer les variables priv�es (Lecture seule)
            return $this->$name;
        
        return isset($this->registry[$name]) ? $this->registry[$name] : null;
    }
    
    /**
     * Test l'existance d'une variable
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->registry[$name]);
    }
    
    /**
     * Enregistre une valeur dans le registre
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->registry[$name] = $value;
    }
    
    /**
     * Exécute la page web
     *  - Charge le Router
     *  - Charge le contrôleur
     *  - Vérifie si l'action existe
     *  - Exécute l'action
     */
    public function run(){
        $this->router = $this->loader->load(Router::class);
        $controllerClass = $this->config->app->controller_namespace . '\\' 
            . ucfirst(strtolower($this->router->getController()));
        //charge le controleur
        try{
            $controller = $this->loader->load($controllerClass);
        } catch (ClassNotFoundException $ex) { //Classe introuvable => erreur 404
            $error_class = $this->config->app->controller_namespace . '\\'.'Error404';
            $error_controller = $this->loader->load($error_class);
            $data = call_user_func_array([$error_controller, 'indexAction'], $this->router->getParameters());
            $this->output->setDefaultView(ROOT_DIR . $this->config->app->views_directory.'/Error404/index.html.php');
            $this->output->showDefaultView($data);
            return;
        }  catch(\Exception $ex){
            var_dump($ex);
            return;
        }
        
        //R�cup�re la m�thode
        $methodName = $this->router->getAction() . $this->config->app->action_suffix;
        
        if(!method_exists($controller, $methodName)){
            $error_class = $this->config->app->controller_namespace . '\\'.'Error404';
            $error_controller = $this->loader->load($error_class);
            $data = call_user_func_array([$error_controller, 'indexAction'], $this->router->getParameters());
            $this->output->setDefaultView(ROOT_DIR . $this->config->app->views_directory.'/Error404/index.html.php');
            $this->output->showDefaultView($data);
            return;
        }
        
        //Ex�cute l'action
        try{
            $data = call_user_func_array([$controller, $methodName], $this->router->getParameters());
        } catch (\Exception $ex) {
            var_dump($ex);
            return;
        }
        
        //affiche la vue par d�faut
        $this->output->showDefaultView($data);
    }
}
