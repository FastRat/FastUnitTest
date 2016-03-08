<?php

namespace FastUnitTest;

/**
 * Description of FastUnitTest
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author pkuznik
 * @license http://gnu.org/copyleft/gpl.html GNU
 * @copyright (c) eDokumenty Sp. z o.o
 */
class FastUnitTest {
    
    /**
     *
     * @var string
     */
    private $pathTest;
    
    /**
     * Path to dir there are file source code
     * 
     * @var string
     */
    private $pathToSource;
    
    /**
     * 
     * @param string $dir
     * @param boolean $makeDir
     * @throws Exception
     */
    public function setPathToDirTest( $dir, $makeDir = TRUE ) {
        
        $path = str_replace('\\', '/', $dir);
        
        if (file_exists($path) == FALSE ) {
            if ( $makeDir == FALSE ) {
                throw new Exception( "Path to dir '$path' is not exists!");
            }  else {
                mkdir($path);
                
                if (file_exists($path) == FALSE ) {
                    throw new Exception( "Cannot make dir in '$path' !");
                }
            }
        }
        
        
        
        if (is_dir( $dir ) == FALSE ) {
            throw new Exception("This path '$path' is not dir!");
        }
        $this->pathTest = $path;
    }
    
    public function createTestMethod( $className, $methodName, $testName = null ) {
        
        if ( is_null($testName) ) {
            $testName = 'Test' . $className;
        } else {
            if (file_exists( $this->pathTest . '/' . $testName . '.php') ){
                
            }else{
                
            }
        }
    }
    
    public function runTest( $testName, $params = [] ) {
        
    }
}
