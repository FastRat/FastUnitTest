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

/**
 * Description of ListenerEvent
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class ListenerEvent implements PHPUnit_Framework_TestListener{
    
    private $data = [];
    
    private $suiteTest = [];
    
    private $test = [];
    
    private $success = true;
    
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite) {
        $this->suiteTest = [];
        
        $s = [];
        $s['name'] = $suite->getName();
        $s['countTest'] = $suite->count();
        $this->suiteTest = $s;
    }
    
    public function startTest(\PHPUnit_Framework_Test $test) {
        $this->success = true;
        $this->test = [];
    }
    
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $t = [];
        $t['time'] = $time;
        $t['status'] = 'error';
        $t['message'] = $e->getMessage();
        $t['track'] = $e->getTraceAsString();
        $this->test = $t;
        $this->success = FALSE;
    }
    
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) {
        $t = [];
        $t['time'] = $time;
        $t['status'] = 'fail';
        $t['message'] = $e->getMessage();
        $t['track'] = $e->getTraceAsString();
        $this->test = $t;
        $this->success = FALSE;
    }
    
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $t = [];
        $t['time'] = $time;
        $t['status'] = 'incomplete';
        $t['message'] = $e->getMessage();
        $t['track'] = $e->getTraceAsString();
        $this->test = $t;
        $this->success = FALSE;
    }
    
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {
        $t = [];
        $t['time'] = $time;
        $t['status'] = 'skipped';
        $t['message'] = $e->getMessage();
        $t['track'] = $e->getTraceAsString();
        $this->test = $t;
        $this->success = false;
    }
    
    public function endTest(\PHPUnit_Framework_Test $test, $time) {
        if ( $this->success ) {
            $t = [];
            $t['time'] = $time;
            $t['status'] = 'success';
            $t['message'] = '';
            $t['track'] = '';
            $this->test = $t;
        }
        $this->suiteTest['test'][] = $this->test;
    }
    
    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite) {
        $this->data[] = $this->suiteTest;
    }
}
