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

//namespace FastRat\FastUnitTest\Engine\Lanucher\Listener;

/**
 * Description of ListenerEventInLine
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class ListenerEventInLine implements PHPUnit_Framework_TestListener {
    
    /**
     * Current test suite name
     * 
     * @var string
     */
    protected $currentTestSuiteName = '';
    
    /**
     * Current test name
     * 
     * @var string
     */
    protected $currentTestName = '';
    
    /**
     *
     * @var boolean
     */
    protected $currentTestPass = true;

    /**
     * 
     * @param string $event
     * @param float $time
     * @param string $message
     */
    protected function writeEvent( $event, $time, $message = '' ) {
        echo "\n\nTest: {$this->currentTestSuiteName}::{$this->currentTestName}() "
        . "\n\tStatus: \t" . strtoupper($event)
        . "\n\tTime:   \t$time " 
        . ($message ? "\n\tMessage:\t" . $message: "");
        
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $this->writeEvent('error', $time, $e->getMessage() );
        $this->currentTestPass = FALSE;
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     * @param \PHPUnit_Framework_AssertionFailedError $e
     * @param float $time
     */
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) {
        $this->writeEvent('fail', $time, $e->getMessage() );
        $this->currentTestPass = FALSE;
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $this->writeEvent('incomplete', $time, $e->getMessage() );
        $this->currentTestPass = FALSE;
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception $e
     * @param float $time
     */
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $this->writeEvent('skipped', $time, $e->getMessage() );
        $this->currentTestPass = FALSE;
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     */
    public function startTest(\PHPUnit_Framework_Test $test) {
        $describe = explode('::', PHPUnit_Util_Test::describe($test) );
        $this->currentTestName =  $describe[1];
        $this->currentTestPass = TRUE; 
    }
    
    /**
     * 
     * @param \PHPUnit_Framework_Test $test
     * @param float $time
     */
    public function endTest(\PHPUnit_Framework_Test $test, $time) {
        if ( $this->currentTestPass ) { 
            $this->writeEvent('success', $time);
        }
    }
    
    /**
     * 
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite) { 
        $this->currentTestSuiteName = $suite->getName(); 
        $this->currentTestName      = ''; 
        echo "\n Started Suite: \t\t" . $this->currentTestSuiteName . " (" . count($suite) . ") test"; 
    }
    
    /**
     * 
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite) { 
        $this->currentTestSuiteName = ''; 
        $this->currentTestName      = ''; 
    } 
}
