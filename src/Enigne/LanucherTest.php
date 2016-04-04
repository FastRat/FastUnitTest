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
     * @var \PHPUnit_Framework_TestSuite
     */
    protected $suiteTest;

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
            require_once $vendorPath;
            $this->suiteTest = new \PHPUnit_Framework_TestSuite();
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
        $path = str_replace('\\', '/', $filename);
        $arrPath = explode('/', $path);

        $this->test[]= explode('.', $arrPath[count($arrPath) - 1 ])[0];
        try {
            $this->suiteTest->addTestFile($filename);
        } catch (\Exception $ex ) {
            trigger_error("Fail add file test: " . $ex->getMessage() );
        }
    }
    
    /**
     * Execute
     */
    public function execute() {
        require_once __DIR__ . '/Lanucher/ListenerEvent.php';
        $listener = new \ListenerEvent();
        
        $result = new \PHPUnit_Framework_TestResult();
        $result->addListener( $listener );
        try {
            $this->suiteTest->run($result);
        } catch (\Exception $ex) {
            trigger_error($ex->getMessage());
        }
        return $listener;
    }
    
}
