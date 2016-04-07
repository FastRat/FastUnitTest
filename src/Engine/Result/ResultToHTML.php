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
    /**
     * 
     * @param string $key
     */
    public function createPie ( $key ) {
        $dataPie = [];
        foreach ($this->data as $row) {
            foreach ($row as $k => $v) {
                if ($key == $k){
                    $dataPie[] = $v;
                }
            }
        }
        
        $t = [];
        foreach ($dataPie as $row){
            if(array_key_exists($row, $t)){
                $t[$row]++;
            }  else {
                $t[$row] = 1;
            }
        }
    }
    
    public function createTable ( $keys ) {
        
    }
    
    public function createGraph ( $key ) {
        $dataGraph = [];
        foreach ($this->data as $row) {
            foreach ($row as $k => $v) {
                if ($key == $k){
                    $dataGraph[] = $v;
                }
            }
        }
        
        $t = [];
        foreach ($dataPie as $row){
            if(array_key_exists($row, $t)){
                $t[$row]++;
            }  else {
                $t[$row] = 1;
            }
        }
    }
}