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

/**
 * Description of VirtualTag
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class VirtualTag extends Virtual{
    
    /**
     *
     * @var string
     */
    protected $param1 = '';

    /**
     *
     * @var string
     */
    protected $param2 = '';

    
    /**
     *
     * @var string
     */
    protected $describe = '';
    
    /**
     * 
     * @param string $nameTag
     * @param string|null $param1
     * @param string|null $param2
     */
    public function __construct($nameTag, $param1 = null, $param2 = null ) {
        parent::__construct($nameTag);
        
        if (is_string($param1)){
            $this->param1 = $param1;
        }
        
        if (is_string($param2)){
            $this->param2 = $param2;
        }
    }
    
    /**
     * Return param 1
     * 
     * @return string
     */
    public function getParam1( ) {
        return $this->param1;
    }
    
    
    /**
     * Return param 2
     * 
     * @return string
     */
    public function getParam2( ) {
        return $this->param2;
    }
    
    /**
     * 
     * @param string|array $text
     */
    public function setDescribe( $text ) {
        if (is_string($text)) {
            $this->describe = $text;
        } elseif (is_array($text)) {
            $this->describe = $text;
        }  else {
            $this->describe = (string)$text;
        }  
    }
    
    /**
     * 
     * @return string
     */
    public function getDescribe( ) {
        if (is_array($this->describe) ) {
            
        }
        return $this->describe;
    }
    
    /**
     * 
     * @return array
     */
    public function toCodeLine() {
        $codeLine = [];
        
        $param = ' ';
        
        if ( empty( $this->param1 ) == FALSE ) {
            $param .= $this->param1 . ' ';
        }
        
        if ( empty( $this->param2 ) == FALSE ) {
            $param .= $this->param2 . ' ';
        }
        
        if (is_array($this->describe) ) {
            $first = TRUE;
            foreach ($this->describe as $row ){
                
                if ($first){
                    $codeLine[] = '@' . $this->name . $param .  $row;
                    $first = FALSE;
                    continue;
                }
                $codeLine[] = $row;
            }
        } else {
            $codeLine[] = '@' . $this->name . $param . $this->describe;
        }
        return $codeLine;
    }
}
