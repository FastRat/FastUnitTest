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

    /**
     *
     * @var string
     */
    protected $pathToResultFileTestClass = '';

    /**
     * 
     * @param string $filename
     * @param string|null $classname
     */
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
        
        $this->setPathToTestClass( realpath( NULL ) );
    }
    
    /**
     * 
     * @param string $path
     */
    public function setPathToTestClass( $path ) {
        if (!is_dir( $path ) ) {
            $path = str_replace('\\', '/', __DIR__ . '/' . $path );
            if (!is_dir( $path ) ) {
                trigger_error('Path to dir is not exists! ' . $path );
            }
        }
        $this->pathToResultFileTestClass = str_replace('\\', '/', $path);
    }
    
    /**
     * Create test for class all method
     * 
     * @param array $methodName if this varible is empty array 
     */
    public function convertAndCreateTest( $methodName = [] ) {
        try {
            $objectClass = new \ReflectionClass( $this->classname );
        } catch ( ReflectionException $rx ) {
            trigger_error('Class not exists');
        }    
        
        require_once __DIR__ . '/GenerationTest.php';
        
        $test = GenerationTest::createNewClass('Test' . $this->classname );
        $test->createTag('test', $this->classname);
        
        $construct = $objectClass->getConstructor();
        
        if ( FALSE == is_null($construct) ){
           // $test->addMethod( $this->convertAndCreateTest($construct) );
        }
        
        foreach ($objectClass->getMethods( \ReflectionMethod::IS_PUBLIC) as $method ) {
            
            if ( !empty($methodName) && is_array($methodName) && in_array($method->getName(), $methodName) ) {
                continue;
            }
            
            $test->addMethod( $this->createTestForMethod($method) );
            
        }
        
        $this->saveTes($test);
    }
    
    /**
     * 
     * @param \ReflectionMethod $method
     * @return Virtual\VirtualMethod
     */
    protected function createTestForMethod( \ReflectionMethod $method ) {
        require_once __DIR__ . '/GenerationTest.php';
        
        $methodTest = GenerationTest::createNewMethod( 'test' . str_replace('__', '', ucfirst( $method->getName() )) );
        
        $methodTest->createTag('test', $method->getName());
        
        
        $params = $method->getParameters();
        
        var_dump($params);
        
        $doc = $method->getDocComment();
        
        $this->getPHPDocElement($doc);
        exit;
        $code = $this->getSoruceCode($method);
        
        return $methodTest;
    }
    
    /**
     * 
     * @param \ReflectionMethod $method
     * @param boolean $returnArray
     * @return array|string
     */
    protected function getSoruceCode( \ReflectionMethod $method, $returnArray = true ) {
        $file = $method->getFileName();
        
        $start = $method->getStartLine();
        $end = $method->getEndLine();
        
        $length = $end - $start;
        
        $source = file($file);
        $body = array_slice($source, $start, $length);
        
        if ( $returnArray ) {
            return $body;
        }
        
        return implode('', $body );
    }

    protected function getPHPDocElement( $docComment ) {
        
        $line = explode('*', str_replace([ '/*', '*/', '' ], '', $docComment));
        require_once './Virtual/VirtualTag.php';
        $tagGroup = [];
        foreach ( $line as $simple ) {
            
            if ( empty( $simple ) ) {
                continue;
            }
            
            $commentLine = explode(' ', $simple);
            
            switch ( $commentLine[0] ) {
                
                case '@param':
                    $tag = new Virtual\VirtualTag('param', $commentLine[1], $commentLine[2]);
                    
                    $unset = ['@param', $commentLine[1], $commentLine[2]];
                    $tag->setDescribe(str_replace($unset, '', $commentLine));
                    break;
                
                case '@return':
                    $tag = new Virtual\VirtualTag('param', $commentLine[1]);
                    
                    $unset = ['@param', $commentLine[1] ];
                    $tag->setDescribe(str_replace($unset, '', $commentLine));
                    break;
                
                default :
                    continue;
            }
            $tagGroup[] = $tag;
        }
    }


    /**
     * 
     * @param \FastRat\FastUnitTest\Engine\Virtual\VirtualClass $test
     */
    protected function saveTes( Virtual\VirtualClass $test ) {
        require_once __DIR__ . '/GenerationTest.php';
        
        GenerationTest::saveClassToFile($test, $this->pathToResultFileTestClass);
    }
}
