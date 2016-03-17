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

require_once __DIR__ . '/VirtualMethod.php';

/**
 * Description of VirtualMethod
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class VirtualMethod extends Virtual{
    
    /**
     *
     * @var string
     */
    protected $access;
    
    /**
     *
     * @var string
     */
    protected $parametrs = [];
    
    /**
     *
     * @var array
     */
    protected $lineCode = [];
    
    /**
     *
     * @var array
     */
    protected $lineDoc = [];

    /**
     * 
     * @param string $name
     * @param string $access
     */
    public function __construct($name, $access = 'public') {
        parent::__construct($name);
        
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
    }
    
    /**
     * 
     * @param string $name
     * @param string $access
     * @param string $default
     * @param string $type
     */
    public function addParametr( $name,  $default = null, $type = null ){
        
        foreach ( $this->parametrs as $parametr ) {
            
            if ( $name == $parametr->getName() ){
                trigger_error('This methods have parametr about name `' . $name . '`');
            }
        }
        
        require_once __DIR__ . '/VirtualParametr.php';
       $parametr = new VirtualParametr($name);
        if (is_null($default) == FALSE ) {
            $parametr->setDefaultValue($default);
        }
       
        if (is_null($type) == FALSE ) {
            $parametr->setTypeVariable($type);
        }
        $this->parametrs[] = $parametr;
    }
    
    
    
    /**
     * 
     * @param string $simpleCode
     */
    public function addLineCode( $simpleCode = '' ) {
        $this->lineCode[] = $simpleCode;
    }
    
    public function addLineDoc( $simpleDoc = '' ){
        $this->lineDoc[] = $simpleDoc;
    }
    /**
     * 
     *  @return string
     */
    public function toCodeLine( ){
        $codeLine = [];
        
        //doc
        $codeLine[] = '/**';
        
        foreach ($this->lineDoc as $simpleLine ) {
            $codeLine[] = ' *  ' . $simpleLine;
        }
        $codeLine[] = ' *';
        foreach ( $this->parametrs as $parametr ){
            $codeLine[] = ' *  ' . $parametr->toDocLine();
        }
        
        $codeLine[] = ' */';
        
        //code
        $heading = "{$this->access} function {$this->name}( ";
        
        foreach ( $this->parametrs as $key => $parametr ){
            
            reset($this->parametrs);
            if ($key !== key($this->parametrs)) {
                $heading .= ', ';
            }
            
            $heading .= $parametr->toCodeLine();
        }
        
        $heading .= " ) {";
        
        $codeLine[] = $heading;
        
        foreach ($this->lineCode as $simpleLine ) {
            $codeLine[] .= SPACE . $simpleLine;
        }
        
        $codeLine[] = "}";
        
        return $codeLine;
    }
}
