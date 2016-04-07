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

namespace FastRat\FastUnitTest\Engine;

/**
 * Description of ConverterClass
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class ConverterClass {
    
    /**
     *
     * @var string
     */
    protected $filename;
    
    /**
     *
     * @var string
     */
    protected $classname;


    public function __construct( $filename, $classname = null ) {
        
        try {
            require_once $filename;
        } catch (Exception $ex) {
            trigger_error('Fail open file');
        }
        
        if (is_null($classname)) {
            $path = explode('/', str_replace('\\', '/', $filename));
            $file = $path[count($path) -1 ];
            
            $classname = explode('.', $file)[0];
        }
        
        if ( !class_exists($classname, false) ) {
            trigger_error('Class about name ' . $classname . ' is not exists!');
        }
        
        $this->classname = $classname;
        $this->filename = $filename;
    }
    
    public function convert() {
        try {
            $objectClass = new \ReflectionClass( $this->classname );
        } catch ( ReflectionException $rx ) {
            trigger_error('Class not exists');
        }    
        
        
    }
}
