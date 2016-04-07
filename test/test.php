<?php


$data = [
    [
        "klucz" => 'wartosc',
        'imie' => 'Klaudia',
    ],
    [
        'imie' => 'Piotr',
    ]
];

var_dump($data);
echo "\n\n\n";

foreach ($data as $row ) {
    foreach ( $row as $k => $v ) {
        echo "\n $k => $v";
    }
}