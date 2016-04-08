<?php 
/**
 * Description of TestClass
 *
 *
 * Generated thanks FastRat\FastUnitTest
 */
class TestClass extends PHPUnit_Framework_TestCase { 


    /**
     *
     *  @param integer $a 
     *  @param integer $b 
     */
    public function testMethod(  ) {
        
        $aa = false;
        
        $this->assertTrue($aa, 'To nie jest prawda!');
    }
    
    public function testMethod2 () {
        $aa = true;
        $this->assertTrue($aa, 'To nie jest prawda!');
    }
}


?>