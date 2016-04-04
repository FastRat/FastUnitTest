<?php 
require_once './../vendor/autoload.php';
/**
 * Description of TestClass
 *
 *
 * Generated thanks FastRat\FastUnitTest
 */
class TestClass extends PHPUnit_Framework_TestCase { 

    /**
     * Dane przechowywane w tablicy
     *
     * @var array
     */
    protected $data;

    /**
     *
     *  @param integer $a 
     *  @param integer $b 
     */
    public function test(  ) {
        
        $aa = false;
        
        $this->assertTrue($aa, 'To nie jest prawda!');
    }
}


?>