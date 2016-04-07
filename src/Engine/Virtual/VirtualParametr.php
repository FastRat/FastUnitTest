<?php

/*
 * The MIT License
 *
 * Copyright 2016 Piotr Kuźnik <piotr.damian.kuznik@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace FastRat\FastUnitTest\Engine\Virtual;

require_once __DIR__ . '/Virtual.php';
require_once __DIR__ . '/VirtualTag.php';
/**
 * Description of VirtualParametr
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class VirtualParametr extends Virtual{
    
    /**
     *
     * @var string
     */
    private $defaultValue = null;
    
    /**
     *
     * @var string
     */
    private $typeVariable = null;
    
    /**
     *
     * @var VirtualTag
     */
    private $tag = null;
    
    /**
     * 
     * @param string $data
     */
    public function setDefaultValue ( $data ){
        if (is_string($data)){
            $this->defaultValue = $data;
        } else {
            $this->defaultValue = (string)$data;
        }
    }
    
    /**
     * 
     * @param string $nametype
     */
    public function setTypeVariable( $nametype ){
        $this->typeVariable = $nametype;
    }
    
    /**
     * 
     * @return VirtualTag
     */
    public function getTag(){
        if (is_null($this->tag)){
            $this->tag = new VirtualTag('param', (is_null($this->typeVariable)) ?  'mix' : $this->typeVariable, $this->name);
        }
        return $this->tag;
    }
    
    /**
     * 
     * @return string
     */
    public function toCodeLine( ) {
        $string = '';
        if (is_null($this->typeVariable) == FALSE ){
            switch ($this->typeVariable) {
                
                case 'mix':
                    
                case 'array':
                    
                case 'string':
                    
                case 'integer':
                case 'float':
                case 'double':
                    
                case 'boolean':
                    
                    //support only class
                    break;

                default:
                    $string .= $this->typeVariable;
                    break;
            }
            
        }
        
        $string .= ' $' . $this->name;
        
        if (is_null($this->defaultValue) == FALSE) {
            $string .= ' = ' . $this->defaultValue;
        }
        
        return $string;
    }
}
