<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Sample Products
        \DB::table('products')->insert([
            [
                'sku' => 'PROD-001',
                'name' => 'Sample Product 1',
                'category' => 'Electronics',
                'price' => 99.99,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PROD-002',
                'name' => 'Sample Product 2',
                'category' => 'Clothing',
                'price' => 49.99,
                'stock' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sample Orders
        \DB::table('orders')->insert([
            [
                'order_date' => now(),
                'channel' => 'Amazon',
                'sku' => 'PROD-001',
                'item_description' => 'Sample Product 1 Order',
                'origin' => 'US',
                'so_num' => 'SO-001',
                'cost' => 75.00,
                'shipping_cost' => 5.99,
                'total_price' => 99.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_date' => now(),
                'channel' => 'PT',
                'sku' => 'PROD-002',
                'item_description' => 'Sample Product 2 Order',
                'origin' => 'UK',
                'so_num' => 'SO-002',
                'cost' => 35.00,
                'shipping_cost' => 4.99,
                'total_price' => 49.99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
