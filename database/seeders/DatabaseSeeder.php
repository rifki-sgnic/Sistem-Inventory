<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'kd_produk' => 'A123X',
                'nama_produk' => 'RAM',
                'type' => '8GB DDR 4',
                'merk' => 'Kingstone',
                'qty' => 5,
            ],
            [
                'kd_produk' => 'S123Y',
                'nama_produk' => 'SSD',
                'type' => '1TB',
                'merk' => 'Samsung',
                'qty' => 11,
            ],
            [
                'kd_produk' => 'D123Z',
                'nama_produk' => 'Keyboard',
                'type' => 'Alloy FPS RGB',
                'merk' => 'HyperX',
                'qty' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $suppliers = [
            [
                'kd_supplier' => 'Sup001',
                'nama_supplier' => 'Supplier A',
                'no_tlp' => '081234567890',
                'alamat' => 'Jalan Baru',
            ],
            [
                'kd_supplier' => 'Sup002',
                'nama_supplier' => 'Supplier B',
                'no_tlp' => '081209876543',
                'alamat' => 'Pasar Baru',
            ],
            [
                'kd_supplier' => 'Sup003',
                'nama_supplier' => 'Supplier C',
                'no_tlp' => '081267895430',
                'alamat' => 'Ciputat',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
