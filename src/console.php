<?php

/* 
 * The MIT License
 *
 * Copyright 2016 pkuznik.
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


// set to run indefinitely if needed
set_time_limit(0);

// Include the Console_CommandLine package.
require_once 'Console/CommandLine.php';

// create the parser
$parser = new Console_CommandLine(array(
    'description' => 'FastUnitTest - create fast unit test',
    'version'     => '0.0.1'
));

// add an option to make the program verbose

$parser->addCommand('generate:test:method');

$parser->addArgument('path_to_file', [
    'description' => 'Ścieżka do pliku z klasą dla której ma być zrobiony test'
]);




// run the parser
try {
    $result = $parser->parse();
    // write your program here...
    print_r($result->options);
    print_r($result->args);
} catch (Exception $exc) {
    $parser->displayError($exc->getMessage());
}