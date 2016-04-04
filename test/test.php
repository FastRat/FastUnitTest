<?php
//require __DIR__ . '/../vendor/autoload.php';


//require_once '../src/Enigne/GenerationTest.php';
//
//$test = \FastRat\FastUnitTest\Engine\GenerationTest::createNewClass('TestClass', 'final');
//
//$method = \FastRat\FastUnitTest\Engine\GenerationTest::createNewMethod('test');
//$method->addParametr('a', null, 'integer');
//$method->addParametr('b', null, 'integer');
//$method->addLineCode('$a *= $b;');
//$method->addLineCode('return $a + $b;');
//$test->addMethod($method);
//
//$variable = \FastRat\FastUnitTest\Engine\GenerationTest::createNewVaraible('data', 'protected', 'array');
//$variable->setDocComment('Dane przechowywane w tablicy');
//
//$test->addVariable($variable);
//
//\FastRat\FastUnitTest\Engine\GenerationTest::saveClassToFile($test);


require_once __DIR__ . '/../src/Enigne/LanucherTest.php';

$lanucher = new \FastRat\FastUnitTest\Engine\LanucherTest(__DIR__ . '/../vendor/autoload.php');
$lanucher->addClassFileTest( __DIR__ . '/TestClass.php');
$lanucher->addClassFileTest( __DIR__ . '/TestClass_1.php');

$lanucher->execute();