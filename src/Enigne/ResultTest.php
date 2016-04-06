<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FastRat\FastUnitTest\Engine;

/**
 * Description of ResultTest
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license default
 */
class ResultTest {
    
    private $data;
    
    /**
     * 
     * @param string $filename
     */
    public function importResultWithJSON ( $filename ) {
        if ( !file_exists($filename) ) {
            trigger_error( "Plik nie istnieje." );
        }
        
        $container = file_get_contents($filename);
        $container = '[' . $container . ']';
        $container = str_replace('}{', '},{', $container);
        
        $arr = json_decode($container, TRUE);
        
        if( is_array($arr) === FALSE ){
            trigger_error('Cannot convert data.');
        }
        $this->data = $arr;
    }
    public function setData ($data){
        if(is_array($data) === FALSE){
            trigger_error('Data must be array.');
        }
        $this->data = $data;
    }
}

