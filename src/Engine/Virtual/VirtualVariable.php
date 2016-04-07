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
 * Description of VirtualVariable
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) eDokumenty Sp. z o.o
 */
class VirtualVariable extends Virtual{
    
    /**
     *
     * @var type 
     */
    protected $access = null;
    
    protected $defaultValue = null;

    protected $typeVariable;

    protected $doc = [];

    /**
     *
     * @var array with VirtualTag
     */
    protected $tag = [];
    
    /**
     * 
     * @param string $name
     * @param string $access
     * @param string $type
     */
    public function __construct($name, $access = 'public', $type = 'mix') {
        parent::__construct($name);
        
        $this->typeVariable = $type;
        
        switch ($access){
            case 'public':
            case 'protected':
            case 'private':
                
                if (is_string($access) == FALSE ){
                    trigger_error('$access must be string');
                    $this->access = (string)$access;
                }else{
                    $this->access = $access;
                }
                break;
                
            default :
                
                trigger_error('$access must be public/protected/private');
        }
        
        $this->tag[] = new VirtualTag($name, $type);
    }
    
    /**
     * 
     * @param string $data
     */
    public function setDefaultValue( $data ){
        $this->defaultValue = $data;
    }
    
    /**
     * 
     * @param string $string
     */
    public function setDocComment ( $string ) {
        $this->doc[] = $string;
    }
    
    public function toCodeLine( ) {
        $codeLine = [];
        
        $codeLine[] = '/**';
        
        foreach ( $this->doc as $line ){
            $codeLine[] = ' * ' . $line;
        }
        $codeLine[] = ' *';
        $codeLine[] = ' * @var ' . $this->typeVariable;
        $codeLine[] = ' */';
        
        if (is_null($this->defaultValue) ){
            $code = "{$this->access} \${$this->name};";
        }else {
            $code = "{$this->access} \${$this->name} = {$this->defaultValue};";
        }
        
        $codeLine[] = $code;
        return $codeLine;
    }
}
