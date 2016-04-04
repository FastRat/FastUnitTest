<?php

/*
 * The MIT License
 *
 * Copyright 2016 Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>.
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

namespace FastRat\FastUnitTest\ParseClass\ClassDocument;

/**
 * Description of TagDocument
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license mit
 */
class TagDocument {
    
    /**
     *
     * @var string
     */
    private  $name;
    
    /**
     *
     * @var string
     */
    private $tag;
    
    /**
     *
     * @var string
     */
    private $description;
    
    /**
     * 
     * @param string $name
     * @param string $tag
     * @param strin $description
     */
    public function __construct($name, $tag, $description) {
        $this->name = $name;
        $this->tag = $tag;
        $this->description = $description;
    }
    
    /**
     * 
     * @return string
     */
    public function getName(){
        return $name;
    }
    
    /**
     * 
     * @return string
     */
    public function getTag(){
        return $tag;
    }
    
    /**
     * 
     * @return string
     */
    public function getDescription(){
        return $description;
    }
}