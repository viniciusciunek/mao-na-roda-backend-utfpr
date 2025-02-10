<?php

$productsToJson = [];

foreach ($products as $product) {
    $productsToJson[] = [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'brand' => $product->brand,
        'price' => $product->price
    ];
}

$json['products'] = $productsToJson;

$json['pagination'] = [
    'page'                       => $paginator->getPage(),
    'per_page'                   => $paginator->perPage(),
    'total_of_pages'             => $paginator->totalOfPages(),
    'total_of_registers'         => $paginator->totalOfRegisters(),
    'total_of_registers_of_page' => $paginator->totalOfRegistersOfPage(),
];
