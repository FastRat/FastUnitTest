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
    protected $type = '';

    /**
     *
     * @var string
     */
    protected $describe = '';
    
    /**
     * 
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type) {
        parent::__construct($name);
        
        if (is_string($type)){
            $this->type = $type;
        }
    }
    
    /**
     * Return type tag
     * 
     * @return string
     */
    public function getType( ) {
        return $this->type;
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
        
        if (is_array($this->describe) ) {
            $first = TRUE;
            foreach ($this->describe as $row ){
                if ($first){
                    $codeLine[] = '@' . $this->type . ' ' . $this->type .  $row;
                    $first = FALSE;
                    continue;
                }
                $codeLine[] = $row;
            }
        } else {
            $codeLine[] = '@' . $this->type . ' ' . $this->type . ' ' . $this->describe;
        }
        return $codeLine;
    }
}
