<?php

/* 
 * The MIT License
 *
 * Copyright 2016 kwasilewska.
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

require __DIR__ . '/FastUnitTest.php';

// set to run indefinitely if needed
set_time_limit(0);

if (PHP_SAPI !== 'cli') {
    echo 'This mode is not support.';
    exit();
}

if ($argv) {
    if (isset($argv[1])){
        $fut = new FastRat\FastUnitTest\FastUnitTest();
        switch ($argv[1]){
            case 'generate:test' :
                if (isset($argv[2])){
                    
                    echo 'This application generate a test.';
                    if (isset($argv[3])){
                        $fut->generateTest($argv[2], $argv[3]);
                    }else{
                        $fut->generateTest($argv[2]);
                    }
                }
                break;
            case 'execute:test' :
                if (isset($argv[2])){
                    
                    echo 'This application execute a test.';
                    if (isset($argv[3])){
                        $fut->executeTest($argv[2], $argv[3]);
                    }else{
                        $fut->executeTest($argv[2]);
                    }
                }
                break;
        }
    }  else {
        // help
        echo "The correct form : php console.php mode fileName className"
        . "\nor : php console.php fileName (If class have the same name as File)"
        . "\n\nconsole.php [generate:test] [execute:test]"
        . "\n\n generate:test \t If you selected this option, application generate a test."
        . "\n execute:test \t\t If you selected this option, application execute a test.\n";
    }
    
}