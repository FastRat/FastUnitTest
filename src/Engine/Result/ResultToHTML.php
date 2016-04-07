<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FastRat\FastUnitTest\Engine\Result;

/**
 * Description of ResultToFileHTML
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license default
 */
class ResultToHTML {
    
    private $data = [];
    
    /**
     * 
     * @param array $array
     */
    public function __construct($array) {
        if(!is_array($array) ){
            trigger_error('This is not a array.');
        }
        
        $this->data = $array;
    }
    
    public function createPie ( $key ) {
        
    }
    
    public function createTable ( $keys ) {
        
    }
    
    public function createGraph ( $key ) {
        
    }
}