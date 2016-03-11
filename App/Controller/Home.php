<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author Gaëtan
 */
namespace App\Controller;
class Home extends \PoireauFramework\Arch\Controller{
    
    /**
     *
     * @var \App\Model\Account\Account
     */
    //private $model;
    public function __construct(\PoireauFramework\PoireauFramework $app) {
        parent::__construct($app);
    }
    
    public function indexAction(){
        
    }
}
