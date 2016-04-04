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
 * Description of LanucherTest
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class LanucherTest {
    
    /**
     *
     * @var string
     */
    protected $pathVendor = null;
    
    /**
     *
     * @var array
     */
    protected $test = [];


    /**
     * 
     * @param string $vendorPath
     */
    public function __construct( $vendorPath ) {
        if (file_exists( $vendorPath ) ){
            $this->pathVendor = $vendorPath;
        } else {
            trigger_error('Path to vendor must be exists');
        }
    }
    
    /**
     * Add file with test to lanucher
     * 
     * @param string $filename
     */
    public function addClassFileTest( $filename ){
        if (file_exists( $filename ) == FALSE) {
            trigger_error('File with Class Test not exists');  
        }
        $path = str_repeat('\\', '/');
        $arrPath = explode('/', $path);

        $test = [];
        $test['className'] = explode('.', $arrPath[count($arrPath) - 1 ])[0];
        $test['pathToFile'] = $filename;

        $this->test[] = $test;
    }
    
    public function execute() {
        require_once $this->pathVendor;
        require_once './../vendor/autoload.php';
        
        
        try{
            
        } catch (Exception $ex) {

        }
        
        
    }
}
