<?php

/*
 * The MIT License
 *
 * Copyright 2016 Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>.
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

namespace FastUnitTest\Engine\Test;

require_once __DIR__ . '/CreatorMethod.php';

/**
 * Description of Test
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license mit
 */
final class CreatorTest {
    
    /**
     *
     * @var string
     */
    private $nameTest;
    
    /**
     *
     * @var string 
     * @default php
     */
    private $extension;
    
    /**
     * Extends class
     * @var string
     */
    private $extends;
    /**
     *
     * @var array
     */
    private $methods = [];


    public function __construct( $className, $extends = 'PHPUnit_Framework_CaseUnit', $extension = 'php') {
        $this->nameTest = 'Test' . $className;
        $this->extension = $extension;
        $this->extends = $extends;
        
    }

    /**
     * 
     * @param type $name
     * @param type $params
     * @return \FastUnitTest\Engine\Test\CreatorMethod
     */
    public function createMethod( $name, $params = [] ) {
        return new CreatorMethod($name, $params);
    }
    
    public function addMethod( CreatorMethod $method ){
        foreach ( $this->methods as $method_ ){
            if ( $method->getName() == $method_->getName() ){
                throw new Exception("Method '{$method->getName()}' is exists in test class '${$this->nameTest}' !"); 
            }
        }
        $this->methods = $method;
        return $this;
    }
    
    /**
     * 
     * @param string $path
     */
    public static function importTestWithFile( $path ){
        
    }
}
