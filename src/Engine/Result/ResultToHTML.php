<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FastRat\FastUnitTest\Engine\Result;

/**
 * Description of ResultToFileHTML
 * 
 * @package FastUnitTest
 * @version 0.1
 * @author Klaudia Wasilewska <klaudiawasilewska98+github@gmail.com>
 * @license default
 */
class ResultToHTML {
    
    private $data = [];
    
    /**
     * 
     * @param array $array
     */
    public function __construct($array) {
        if(!is_array($array) ){
            trigger_error('This is not a array.');
        }
        
        $this->data = $array;
    }
    /**
     * 
     * @param string $key
     */
    public function createPie ( $key ) {
        $dataPie = [];
        foreach ($this->data as $row) {
            foreach ($row as $k => $v) {
                if ($key == $k){
                    $dataPie[] = $v;
                }
            }
        }
        
        $t = [];
        foreach ($dataPie as $row){
            if(array_key_exists($row, $t)){
                $t[$row]++;
            }  else {
                $t[$row] = 1;
            }
        }
        
        $data = [];
        
        $color = [
            'success' => "#43A047",
            'error' => "#D50000",
            'fail' => "#B71C1C",
            'skipped' => "#0D47A1",
            'incomplete' => "#1DE9B6"
        ];
        
        $highlight = [
            'success' => "#66BB6A",
            'error' => "#F44336",
            'fail' => "#D32F2F",
            'skipped' => "#1565C0",
            'incomplete' => "#64FFDA"
        ];
        
        foreach ($t as $status => $value){
            $row = [
                'value' => $value,
                'color' => '"' . $color[$status] . '"',
                'highlight' => '"' . $highlight[$status] . '"',
                'label' => $status
            ];
            $data[] = $row;
        }
        
        require_once __DIR__ . '/HtmlTemplateFlexy.php';
        $flexy = new HtmlTemplateFlexy();
        
        $flexy->setData([
            'pie' => $t,
            'date' => date('Y-m-d H:i:s'),
            'title' => 'Przykladowy tytuł',
            'data' => $data,
        ]);
        
        $flexy->requireLib('js/Chart.js');
        $flexy->requireLib('js/bootstrap.min.js');
        $flexy->requireLib('css/bootstrap.min.css');
        $flexy->requireLib('css/bootstrap-theme.min.css');
        
        $flexy->compileToFile('Pie.html', 'test.html');
    }
    
    public function createTable ( $keys = [] ) {
        $dataTable = [];
        foreach ($this->data as $row) {
            $dataRow = [];
            $keyTable = [];
            foreach ($row as $k => $v) {
                if(in_array($k, $keys)){
                    $dataRow[$k] = $v;
                }
                if(!in_array($k, $keys)){
                    $keyTable[] = $k;
                }
            }
            $dataTable[] = $dataRow;
        }
        
        require_once __DIR__ . '/HtmlTemplateFlexy.php';
        $flexy = new HtmlTemplateFlexy();
        
        $flexy->setData([
            'data' => $dataTable,
            'columns' => $keyTable,
            'date' => date('Y-m-d H:i:s'),
            'title' => 'Przykladowy tytuł',
        ]);
        
        $flexy->requireLib('js/Chart.js');
        $flexy->requireLib('js/bootstrap.min.js');
        $flexy->requireLib('css/bootstrap.min.css');
        $flexy->requireLib('css/bootstrap-theme.min.css');
        
        $flexy->compileToFile('Table.html', 'test.html');
    }
    
    public function createGraph (  ) {
        $dataGraph = [];
        $indexGraph = [];
        foreach ($this->data as $row) {
            foreach ($row as $k => $v) {
                if ('time' == $k){
                    $dataGraph[] = $v;
                }
                if('test' == $k){
                    $indexGraph[] = $v;
                }
            }
        }
        
        require_once __DIR__ . '/HtmlTemplateFlexy.php';
        $flexy = new HtmlTemplateFlexy();
        
        $flexy->setData([
            'time' => implode(', ', $dataGraph),
            'test' => implode(', ',$indexGraph),
            'date' => date('Y-m-d H:i:s'),
            'title' => 'Przykladowy tytuł',
        ]);
        
        $flexy->requireLib('js/Chart.js');
        $flexy->requireLib('js/bootstrap.min.js');
        $flexy->requireLib('css/bootstrap.min.css');
        $flexy->requireLib('css/bootstrap-theme.min.css');
        
        $flexy->compileToFile('Graph.html', 'test.html');
    }
}