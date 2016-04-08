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
        $tags = $this->getTagElement( $method->getDocComment() );
        
        $methodTest->addLineCode("require_once '". realpath($this->filename) ."';");
        $parameters = ' ';
        $fisrt = true;
        foreach ($params as $simple) {
            $test = $this->getTagTestByFilter($tags, 'param', $simple->getName() );
            var_dump($test);
            if ( $fisrt ) {
                $fisrt = false;
                $parameters .= $this->getValue( $test->getDescribe() );
                continue;
            }
            $parameters .= ', ' . $this->getValue( $test->getDescribe() );
        }
        
        $methodTest->addLineCode('$object = new ' . $this->classname . '(' . $parameters . ');');
                
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

    /**
     * 
     * @param string $docComment
     * @return \FastRat\FastUnitTest\Engine\Virtual\VirtualTag
     */
    protected function getTagElement( $docComment ) {
        require_once __DIR__ . '/Virtual/VirtualTag.php';

        $line = explode('*', str_replace([ '/*', '*/', '' ], '', $docComment));
        
        $tagGroup = [];
        foreach ( $line as $simple ) {
            
            if ( empty( $simple ) ) {
                continue;
            }
            
            $commentLine = explode(' ', $simple);
            
            switch ( $commentLine[1] ) {
                
                case '@param':
                    $tag = new Virtual\VirtualTag('param', trim($commentLine[2]), trim($commentLine[3]));
                    
                    $unset = ['@param', $commentLine[2], $commentLine[3]];
                    $tag->setDescribe( trim(str_replace($unset, '', $simple)));
                    
                    $tagGroup[] = $tag;
                    break;
                
                case '@test':
                    $tag = new Virtual\VirtualTag('test', trim($commentLine[2]), trim($commentLine[3]));
                    
                    $unset = ['@test', $commentLine[2], $commentLine[3]];
                    $tag->setDescribe(trim(str_replace($unset, '', $simple)));
                    
                    $tagGroup[] = $tag;
                    break;
                
                case '@return':  
                case '@version':
                case '@throws':
                case '@var':
                    $tag = new Virtual\VirtualTag(str_replace('@', '', trim($commentLine[1])), trim($commentLine[2]) );
                    
                    $unset = [$commentLine[1], $commentLine[2] ];
                    $tag->setDescribe(trim( str_replace($unset, '', $simple) ));
                    
                    $tagGroup[] = $tag;
                    break;
                
                default :
                    continue;
            }
            
        }
        return $tagGroup;
    }

    /**
     * 
     * @param arrays $groupTag Array with  \Virtual\VirtualTag element
     * @param string $filter1
     * @param string|null $filter2
     * @return Virtual\VirtualTag
     */
    protected function getTagByFilter( $groupTag, $filter1, $filter2 = null ) {
        $group2 = [];
        
        foreach ($groupTag as $tag ) {
            if (is_null($filter2) && $tag->getName() == $filter1 ) {
                $group2[] = $tag;
                continue;
            }
            $tagFilter = trim(str_replace(['$', ' '], '', $tag->getParam2() ) );
            
            if ( $tag->getName() == $filter1 && $tagFilter == $filter2 ) {
                $group2[] = $tag;
                continue;
            }
            
        }
        return $group2;
    }
    
    /**
     * 
     * @param arrays $groupTag Array with  \Virtual\VirtualTag element
     * @param string $filter1
     * @param string|null $filter2
     * @return Virtual\VirtualTag
     */
    protected function getTagTestByFilter( $groupTag, $filter1, $filter2 ) {
        $group2 = [];
        
        foreach ($groupTag as $tag ) {
            $tagFilter = trim(str_replace(['$', ' '], '', $tag->getParam2() ) );
            
            if ( $tag->getName() == 'test' && $tagFilter == $filter2  && $filter1 == trim($tag->getParam1() )) {
                $group2[] = $tag;
                continue;
            }
            
        }
        return $group2;
    }

    /**
     * 
     * @param string $command
     * @return string
     */
    protected function getValue( $command ) {
        $data = '';
        $command = trim($command);
        echo "\nCommand : " . $command;
        $param = explode(',', str_replace(['(', ')'], '', stristr($command, '(')));
        switch (stristr($command, '(', true) ) {
            case 'rand':
                $data = "rand( $param[0], $param[1] )";
                break;
            
            case 'uniqid':
                $data = "uniqid()";
                break;
            
            default :
                if ( !function_exists($command) ) {
                    $data = "'$command'";
                }
        }
        
        return $data;
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
