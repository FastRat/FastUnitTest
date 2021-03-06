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

namespace FastRat\FastUnitTest;

/**
 * Description of FastUnitTest
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 */
class FastUnitTest {

    
    public function generateTest( $fileName, $params = [] ) {
        require_once __DIR__ . '/Engine/ConverterClass.php';
        
        $className = NULL;
        
        if ( isset($params['class'])) {
            $className = $params['class'];
        }
        
        if ( is_dir($fileName) ) {
            
        } elseif ( is_file($fileName)) {
            $converter = new Engine\ConverterClass($fileName, $className);
            
            if ( isset($params['pathToTestDir']) ) {
                $converter->setPathToTestClass( $params['pathToTestDir'] );
            }
            
            $converter->convertAndCreateTest();
        } else {
            trigger_error("This `$fileName` is not DIR or FILE");
        }
        
    }
    
    /**
     * 
     * @param string $fileName Filename or DIR
     * @param array $params
     */
    public function executeTest( $fileName, $params = [] ) {
        
        require_once __DIR__ . '/Engine/LanucherTest.php';
        $launcher = new Engine\LanucherTest( __DIR__ . '/../vendor/autoload.php' );
        $test = [];
        if (is_dir($fileName) ) {
            foreach (new \DirectoryIterator($fileName) as $file ) {
                
                if ( $file->isFile() ) {
                    $pos = strpos($file->getFilename(), 'Test');
                    if ( $pos === false ) {
                        continue;
                    }
                
                    if (in_array($file->getFilename(), $test)){
                        continue;
                    }
                    $test[] = $file->getFilename();
                    
                    $launcher->addClassFileTest($file->getRealPath());
                }
            }
        } 
        
        if ( is_file($fileName) ) {
            $launcher->addClassFileTest($fileName);
        }
        if ( isset($params['log']) ){
            $launcher->execute( $params['log'] );
        } else {
            $launcher->execute();
        }
    }
}
