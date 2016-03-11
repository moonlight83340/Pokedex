<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * Gestion de l'output (vues)
 *
 * @author Ga�tan,Vincent Quatrevieux
 */
class Output implements Creatable{
    const MIME_HTML = 'text/html';
    const MIME_JSON = 'application/json';
    const MIME_TEXT = 'text/plain';
    
    /**
     *
     * @var PoireauFramework
     */
    private $app;
    
    private $mime = self::MIME_HTML;
    private $defaultView = null;
    private $layout = null;
    private $layoutVars = [];
    
    public function __construct(PoireauFramework $app) {
        $this->app = $app;
        $this->setShutdownFunction();
    }
    
    private function getFormat(){
        return isset($this->app->config->output->formats[$this->mime]) ? 
            $this->app->config->output->formats[$this->mime] : $this->app->config->output->default_format;
    }

    private function getViewFile($viewName){
        return ROOT_DIR . $this->app->config->app->views_directory
            . $viewName . '.' . $this->getFormat() . '.php';
    }
    
    /**
     * Définie un nouveau layout
     * - Si null, désactive le layout
     * - Sinon active la buffurisation de sortie, et change le layout
     * Attention : Si un layout a déjà était mis, le buffer courant sera supprimé !
     * @param string|null $layout le nom de la vue du layout
     */
    public function setLayout($layout, array $vars = []){
        if($this->layout !== null){
            if(ob_get_length() > 0){
                trigger_error(__METHOD__ . ' : The output buffer is not empty, and has been reset', E_USER_WARNING);
            }
            
            ob_end_clean();
        }
        
        if($layout !== null)
            ob_start();
        
        $this->layout = $layout;
        $this->layoutVars = $vars;
    }
    
    /**
     * Change la vue par défaut
     * - Si defaultView est null ou true, la vue correspondra a : {app.views_directory}/{controller}/{action}.{format}.php
     * - Si defaultView est false, la vue par défaut sera désactivée
     * - Sinon, le vue par défaut conspondra au paramètre donnée
     * La vue doit contenir le code suivant :
     * <code>
     * <?= $contents?>
     * </code>
     * Pour affiche le contenu des sous-pages
     * @param string|null|bool $defaultView
     */
    public function setDefaultView($defaultView) {
        $this->defaultView = $defaultView;
    }

    private function getDefaultViewFile(){
        if($this->defaultView === false)
            return false;
        
        if($this->defaultView === null || $this->defaultView === true){
            return $this->getViewFile(ucfirst(strtolower($this->app->router->getController())) . DIRECTORY_SEPARATOR . strtolower($this->app->router->getAction()));
        }
        
        return $this->defaultView;
    }
    
    /**
     * Génère le rendu d'une vue
     * <code>
     * echo $this->output->render('maVue', ['a' => 'b']);
     * </code>
     * @param string $view le nom de la vue
     * @param array $vars les paramètres de la vue
     * @return string La vue g�n�r�e
     */
    public function render($view, array $vars = []){
        ob_start();
        extract($vars);
        require $this->getViewFile($view);
        return ob_get_clean();
    }
    
    /**
     * Affiche la vue par défaut de la page web
     * Si la vue n'existe pas, affiche le json_encode du résultat
     * @param mixed $data Les données que retourne le contrôleur
     */
    public function showDefaultView($data){
        $viewFile = $this->getDefaultViewFile();
        
        if(!$viewFile)
            return;
 
        header('Content-Type: ' . $this->mime . '; charset=UTF-8');
        
        if(is_file($viewFile)){
            if(is_array($data))
                extract($data);

            require $viewFile;
        }else{
            echo json_encode($data);
        }
    }
    
    /**
     * Enregistre une fonction d'extinction,
     * pour gérer si un layout est présent (le layout activant un buffer de sorti)
     */
    private function setShutdownFunction(){
        register_shutdown_function(function(){
            if($this->layout !== null){ //si un layout est donné
                echo $this->render($this->layout, array_merge($this->layoutVars, [
                    'contents' => ob_get_clean() //on le charge avec pour donné le buffer
                ]));
            }
        });
    }

    public static function createInstance(Loader $loader) {
        return new self($loader->load(PoireauFramework::class));
    }
}
