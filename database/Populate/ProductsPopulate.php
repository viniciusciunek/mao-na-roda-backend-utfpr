<?php

namespace Database\Populate;

use App\Models\Product;

class ProductsPopulate
{
    public static function populate()
    {

        $fakeProducts = [
            ['name' => 'Pneu X', 'brand' => 'Michelin', 'description' => 'Pneu de alta durabilidade', 'price' => 350.00, 'active' => true],
            ['name' => 'Óleo 10W-40', 'brand' => 'Shell', 'description' => 'Óleo semi-sintético para motor', 'price' => 40.00, 'active' => true],
            ['name' => 'Filtro de Ar', 'brand' => 'Bosch', 'description' => 'Filtro de ar esportivo', 'price' => 55.00, 'active' => true],
            ['name' => 'Bateria 60Ah', 'brand' => 'Heliar', 'description' => 'Bateria automotiva', 'price' => 250.00, 'active' => true],
            ['name' => 'Velas de Ignição', 'brand' => 'NGK', 'description' => 'Jogo com 4 velas', 'price' => 80.00, 'active' => true],
            ['name' => 'Pastilha de Freio', 'brand' => 'Bosch', 'description' => 'Compatível com linha GM', 'price' => 120.00, 'active' => true],
            ['name' => 'Amortecedor Dianteiro', 'brand' => 'Monroe', 'description' => 'Amortecedor para suspensão dianteira', 'price' => 400.00, 'active' => true],
            ['name' => 'Fluido de Freio DOT4', 'brand' => 'Bosch', 'description' => 'Fluido resistente a altas temperaturas', 'price' => 25.00, 'active' => true],
            ['name' => 'Pneu Y', 'brand' => 'Goodyear', 'description' => 'Pneu para carros de passeio', 'price' => 360.00, 'active' => true],
            ['name' => 'Óleo 5W-30', 'brand' => 'Castrol', 'description' => 'Óleo sintético para motor', 'price' => 45.00, 'active' => true],
            ['name' => 'Correia Dentada', 'brand' => 'Gates', 'description' => 'Correia para linha Fiat', 'price' => 70.00, 'active' => true],
            ['name' => 'Bateria 45Ah', 'brand' => 'Moura', 'description' => 'Bateria compacta', 'price' => 210.00, 'active' => true],
            ['name' => 'Filtro de Combustível', 'brand' => 'Fram', 'description' => 'Filtro para gasolina', 'price' => 25.00, 'active' => true],
            ['name' => 'Amortecedor Traseiro', 'brand' => 'Cofap', 'description' => 'Amortecedor para suspensão traseira', 'price' => 380.00, 'active' => true],
            ['name' => 'Disco de Freio', 'brand' => 'Brembo', 'description' => 'Disco ventilado de alta performance', 'price' => 200.00, 'active' => true],
            ['name' => 'Óleo 15W-40', 'brand' => 'Mobil', 'description' => 'Óleo mineral para motor diesel', 'price' => 35.00, 'active' => true],
            ['name' => 'Filtro de Óleo', 'brand' => 'Mann', 'description' => 'Filtro universal', 'price' => 25.00, 'active' => true],
            ['name' => 'Pneu Z', 'brand' => 'Pirelli', 'description' => 'Pneu esportivo', 'price' => 480.00, 'active' => true],
            ['name' => 'Coxim do Motor', 'brand' => 'Original', 'description' => 'Peça de reposição para motor', 'price' => 150.00, 'active' => true],
            ['name' => 'Buzina Elétrica', 'brand' => 'Bosch', 'description' => 'Buzina universal', 'price' => 35.00, 'active' => true],
        ];

        foreach ($fakeProducts as $prod) {
            $product = new Product([
                'name'        => $prod['name'],
                'description' => $prod['description'],
                'brand'       => $prod['brand'],
                'price'       => $prod['price'],
                'active'      => $prod['active']
            ]);
            $product->save();
        }

        echo count($fakeProducts) . ' products populated!' . PHP_EOL;
    }
}
