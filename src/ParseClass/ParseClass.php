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

namespace FastRat\FastUnitTest\ParseClass;

require __DIR__ . '/ClassDocument/ClassDocument.php';
require __DIR__ . '/ClassDocument/MethodDocument.php';
require __DIR__ . '/ClassDocument/TagDocument.php';

/**
 * Description of ParseClass
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license mit
 */
class ParseClass {
    
    /**
     * 
     * @param string $className
     * @param string $nameMethod
     */
    public function parseCommentMethod( $className, $nameMethod ) {
        $rm = new \ReflectionMethod($className, $nameMethod);
        
        $docComment = $rm->getDocComment();
        $factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        
        $doc = $factory->create($docComment);
        $tags = $doc->getTags();
        $methodDcument = new ClassDocument\MethodDocument($nameMethod);
        
        foreach ($tags as $tag){
            $name = $tag->getName();
            $tag_ = $tag->render();
            
            var_dump($tag_);
            exit;
        }
    }
    
    
    
}
