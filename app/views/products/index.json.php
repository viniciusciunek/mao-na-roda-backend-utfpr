<?php

foreach ($products as $product) {
    $json[] = [
    'id' => $product->getId(),
    'name' => $product->getName(),
    'description' => $product->getDescription(),
    'brand' => $product->getBrand(),
    'price' => $product->getPrice()
    ];
}
