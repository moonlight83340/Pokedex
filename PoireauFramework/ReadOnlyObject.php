<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace PoireauFramework;
/**
 * Objet immutable (modification impossible)
 *
 * @author Gaëtan
 */
class ReadOnlyObject {
    protected $data;
    
    public function __construct(array $data) {
        $this->data = $data;
    }
    
    public function __get($name) {
        return $this->data[$name];
    }
    
    public function __isset($name) {
        return isset($this->data[$name]);
    }
    
    public function __set($name, $value) {
        throw new \BadMethodCallException('Cannot set a value into a read only object');
    }
}