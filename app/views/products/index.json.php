<?php

$productsToJson = [];

foreach ($products as $product) {
    $productsToJson[] = [
        'id' => $product->getId(),
        'name' => $product->getName(),
        'description' => $product->getDescription(),
        'brand' => $product->getBrand(),
        'price' => $product->getPrice()
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
