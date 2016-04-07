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
 * Description of GenerationTest
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Piotr Kuźnik <piotr.damian.kuznik@gmail.com>
 * @license mit
 * @copyright (c) FastRat
 */
class GenerationTest {
    
    /**
     * 
     * @param string $className
     * @param null|string $type
     * @return \FastRat\FastUnitTest\Engine\Virtual\VirtualClass
     */
    public static function createNewClass( $className, $type = null ){
        require_once __DIR__ . '/Virtual/VirtualClass.php';
        return new Virtual\VirtualClass($className, $type, 'PHPUnit_Framework_TestCase', null);
    }
    
    /**
     * 
     * @param string $methodName
     * @param string $access usage public/protected/private
     * @return \FastRat\FastUnitTest\Engine\Virtual\VirtualMethod
     */
    public static function createNewMethod( $methodName, $access = 'public' ){
        require_once __DIR__ . '/Virtual/VirtualMethod.php';
        
        return new Virtual\VirtualMethod($methodName, $access);
    }
    
    /**
     * 
     * @param string $nameVaraible
     * @param string $access
     * @param string $type
     * @return \FastRat\FastUnitTest\Engine\Virtual\VirtualVariable
     */
    public static function createNewVaraible($nameVaraible, $access = 'public', $type = 'mix' ) {
        require_once __DIR__ . '/Virtual/VirtualVariable.php';
        
        return new Virtual\VirtualVariable($nameVaraible, $access, $type);
    }


    /**
     * 
     * @param \FastRat\FastUnitTest\Engine\Virtual\VirtualClass $class
     */
    public static function saveClassToFile( Virtual\VirtualClass $class ) {
        
        $filename = $class->getName() . '.php';
        $content = $class->toCodeLine();
        
        $handle = fopen($filename, 'w');
        fwrite($handle, "<?php \n\n");
        foreach ($content as $row ) {
            fwrite($handle, $row . "\n");
        }
        
        fwrite($handle, "\n\n?>");
        fclose($handle);
    }
}
