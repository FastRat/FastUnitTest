<?php 

/**
 * Description of TestClass
 *
 *
 * Generated thanks FastRat\FastUnitTest
 */
final class TestClass extends PHPUnit_Framework_CaseTest { 

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
    public function test(  $a,  $b ) {
        $a *= $b;
        return $a + $b;
    }
}


?>