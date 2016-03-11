<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PoireauFramework;

/**
 * L'interface Creatable permet de définir une méthode static standard
 * permettant la création de l'instance de la classe courante
 * Cette méthode est utilisé par le Loader pour générer facilement les instances des classes
 * @author Ga�tan
 */
interface Creatable {
    static public function createInstance(Loader $loader);
}
