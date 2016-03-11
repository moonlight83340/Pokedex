<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace PoireauFramework\Helper;
/**
 * Description of Url
 *
 * @author Vincent Quatrevieux <quatrevieux.vincent@gmail.com>
 */
class Url {
    static public function base() {
        if(isset($_SERVER['HTTPS'])) {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            $protocol = 'http';
        }
        $dir = dirname($_SERVER['SCRIPT_NAME']);
        if(strlen($dir) > 0 && substr($dir, -1) != '/')
            $dir .= '/';
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $dir;
    }
    static public function url($path = ''){
        return self::base() . $path;
    }
}