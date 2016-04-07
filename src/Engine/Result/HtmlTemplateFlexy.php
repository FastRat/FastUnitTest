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

namespace FastRat\FastUnitTest\Engine\Result;

/**
 * Description of HtmlTemplateFlexy
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) Fastrat
 */
class HtmlTemplateFlexy {
    
    /**
     *
     * @var string
     */
    protected $pathToTemplate;
    
    /**
     *
     * @var string
     */
    protected $pathToHtmlLib;

    /**
     *
     * @var array with require files
     */
    protected $require = [];

    /**
     *
     * @var array
     */
    protected $optionsFlexy = [];

    /**
     *
     * @var array
     */
    protected $dataFlexy = [];


    /**
     * Construct
     */
    public function __construct() {
        $this->pathToTemplate = __DIR__ . '/Template/';
        $this->pathToHtmlLib = $this->pathToTemplate . 'tmp/';
        
        $this->optionsFlexy =  [
          'templateDir' => $this->pathToTemplate,
          'compileDir' => $this->pathToHtmlLib,
          'locale' =>  'pl',
          'filters' => 'SimpleTags',
          'allowPHP' => true,
          'debug' => false,
          'forceCompile' => 0,
          'compiler' => 'Flexy',
          'flexyIgnore' => 0,
          'globalfunctions' => true,     
        ];
    }
    
    /**
     * 
     * @param string $filename
     * @return boolean
     */
    public function requireLib( $filename ) {
        if (in_array($filename, $this->require)) {
            return false;
        }
        $this->require[] = $filename;
    }
    
    /**
     * 
     * @param array $data
     */
    public function setData(  $data = [] ){
        $this->dataFlexy = $data;
    }
    
    /**
     * Zwraca dane html
     * 
     * @param string $filename
     * @return string
     */
    public function compile( $filename ) {
        require_once __DIR__ . '/HTML/Template/Flexy.php';
        
        $flexy = new \HTML_Template_Flexy($this->option);
        
        $flexy->setData(['data' => $this->dataFlexya]);
        
        $flexy->compile( $filename );
        
        return $flexy->toString();
    }
    
    /**
     * Zapisuje html do pliku
     * 
     * @param string $compileFileName
     * @param string $resultFileName
     */
    public function compileToFile( $compileFileName, $resultFileName ) {
        
        $html = $this->compile($compileFileName);
        
        file_put_contents($resultFileName, $html);
    }
}
