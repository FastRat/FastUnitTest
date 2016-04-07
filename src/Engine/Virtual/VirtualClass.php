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
require_once __DIR__ . '/VirtualMethod.php';

/**
 * Description of VirtualClass
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class VirtualClass extends Virtual{
    
    /**
     *
     * @var string
     */
    protected $extends = null;
    
    /**
     *
     * @var string
     */
    protected $srcClassExtends = null;


    /**
     *
     * @var array
     */
    protected $methods = [];
    
    /**
     *
     * @var array
     */
    protected $variable = [];

    /**
     *
     * @var array
     */
    protected $tag = [];
    
    /**
     *
     * @var array
     */
    protected $doc = [];

    /**
     *
     * @var string
     */
    protected $type = null;
    
    /**
     * 
     * @param string $name
     * @param string $extends
     */
    public function __construct($name,  $type = null, $extends = null, $srcClassExtends = null ) {
        parent::__construct($name);
        
        if (is_string($extends) == FALSE ){
            trigger_error('$extends must be string');
            $this->extends = (string)$extends;
            $this->srcClassExtends = $srcClassExtends;
        }else{
            $this->extends = $extends;
            $this->srcClassExtends = $srcClassExtends;
        }
        
        if ( is_null($type) == FALSE ) {
            switch ($type) {
                case 'final':
                case 'abstract':
                    
                    $this->type = $type;
                    break;
                
                default :
                    trigger_error('$type must be final/abstract/null');
                    break;
            }
        }
    }
    
    /**
     * 
     * @param \FastRat\FastUnitTest\Engine\Virtual\VirtualMethod $method
     */
    public function addMethod( VirtualMethod $method ) {
        
        foreach ( $this->methods as $simpleMethod ) {
            
            if ( $simpleMethod->getName() == $method->getName() ){
                trigger_error('This methods is exists about name ' . $method->getName() );
            }
        }
        
        $this->methods[] = $method;
    }
    
    /**
     * 
     * @param \FastRat\FastUnitTest\Engine\Virtual\VirtualVariable $variable
     */
    public function addVariable(VirtualVariable $variable ) {
        
        foreach ( $this->variable as $simpleVariable ) {
            
            if ( $simpleVariable->getName() == $variable->getName() ){
                trigger_error('This variable is exists about name ' . $variable->getName() );
            }
        }
        
        $this->variable[] = $variable;
    }
    
    /**
     * 
     * @param \FastRat\FastUnitTest\Engine\Virtual\VirtualTag $tag
     */
    public function addTag( VirtualTag $tag ) {
        $this->tag[] = $tag;
    }
    
    /**
     * 
     * @param string $name
     * @param string $type
     * @param string|array $descibe
     */
    public function createTag( $name, $type, $descibe = '' ) {
        $tag = new VirtualTag($name, $type);
        $tag->setDescribe($descibe);
        $this->tag[] = $tag;
    }
    
    /**
     * 
     * @param array $codeLine
     */
    protected function toDocLine( &$codeLine ){
        if (is_null($this->extends) == FALSE && is_null($this->srcClassExtends) == FALSE ){
            $codeLine[] = '';
            $codeLine[] = "require_once '$this->srcClassExtends';"; 
            $codeLine[] = '';
        }       
        $codeLine[] = '/**';
        $codeLine[] = ' * Description of ' . $this->name;
        $codeLine[] = ' *';
        
        foreach ( $this->doc as $line ) {
            $codeLine[] = ' * ' . $line;
        }
        
        $codeLine[] = ' *';
        $codeLine[] = ' * Generated thanks FastRat\FastUnitTest';
        $codeLine[] = ' */';
    }


    /**
     * 
     * @return array
     */
    public function toCodeLine() {
        $codeLine = [];
        $this->toDocLine($codeLine);
        
        $type = '';
        if ( is_null($this->type) == FALSE ) {
            $type = $this->type . ' ';
        }
        
        if ( is_null($this->extends) ) {
            $codeLine[] = $type . "class {$this->name} { ";
        } else {
            $codeLine[] = $type . "class {$this->name} extends {$this->extends} { ";
        }
        
        
        foreach ($this->variable as  $variable ) {
            $lines = $variable->toCodeLine();
            $codeLine[] = '';
            foreach ($lines as $line ){
                $codeLine[] = SPACE. $line;
            }
        }
        
        foreach ($this->methods as  $method ) {
            $newCodeLine = $method->toCodeLine();
            $codeLine[] = '';
            foreach ($newCodeLine as $line ){
                $codeLine[] = SPACE . $line;
            }
        }
        
        $codeLine[] = "}";
        
        return $codeLine;
    }
}
