<?php
require __DIR__ . '/../vendor/autoload.php';
/** 
* A test class
* 
* @param  foo bar
* @return baz
*/
class TestClass {
    
    /**
     * 
     * @param int $param jakis tam parametr
     * @test success aaa
     * @return string 
     */
    public function functionName($param) {
        
    }
}

require '../src/ParseClass/ParseClass.php';

$parser = new FastRat\FastUnitTest\ParseClass\ParseClass();
echo "<pre>";
$parser->parseCommentMethod('TestClass', 'functionName');
echo "</pre>";