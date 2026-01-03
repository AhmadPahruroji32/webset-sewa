<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sewacamping.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Gunung Merapi No. 123',
        ]);

        // Create Test User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081298765432',
            'address' => 'Jl. Pendaki No. 456',
        ]);

        // Create Categories
        $categories = [
            [
                'name' => 'Tenda',
                'description' => 'Berbagai jenis tenda untuk kebutuhan camping dan pendakian',
            ],
            [
                'name' => 'Carrier',
                'description' => 'Carrier dan tas gunung berbagai ukuran',
            ],
            [
                'name' => 'Sleeping Bag',
                'description' => 'Sleeping bag untuk berbagai kondisi cuaca',
            ],
            [
                'name' => 'Matras',
                'description' => 'Matras dan alas tidur untuk kenyamanan istirahat',
            ],
            [
                'name' => 'Kompor',
                'description' => 'Kompor portable dan peralatan memasak',
            ],
            [
                'name' => 'Headlamp & Senter',
                'description' => 'Peralatan penerangan untuk pendakian malam',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Equipment
        $equipments = [
            // Tenda
            [
                'category_id' => 1,
                'name' => 'Tenda Kapasitas 2 Orang',
                'description' => 'Tenda berkualitas untuk 2 orang, waterproof, mudah dipasang. Cocok untuk pendakian dan camping.',
                'price_per_day' => 50000,
                'stock' => 10,
                'available_stock' => 10,
                'condition' => 'excellent',
            ],
            [
                'category_id' => 1,
                'name' => 'Tenda Kapasitas 4 Orang',
                'description' => 'Tenda besar untuk 4 orang dengan ventilasi baik dan anti air.',
                'price_per_day' => 75000,
                'stock' => 5,
                'available_stock' => 5,
                'condition' => 'excellent',
            ],
            // Carrier
            [
                'category_id' => 2,
                'name' => 'Carrier 50L',
                'description' => 'Carrier 50 liter dengan sistem penyangga punggung yang nyaman, cocok untuk pendakian 2-3 hari.',
                'price_per_day' => 40000,
                'stock' => 15,
                'available_stock' => 15,
                'condition' => 'good',
            ],
            [
                'category_id' => 2,
                'name' => 'Carrier 70L',
                'description' => 'Carrier besar 70 liter untuk pendakian jangka panjang, dilengkapi rain cover.',
                'price_per_day' => 55000,
                'stock' => 8,
                'available_stock' => 8,
                'condition' => 'excellent',
            ],
            // Sleeping Bag
            [
                'category_id' => 3,
                'name' => 'Sleeping Bag Biasa',
                'description' => 'Sleeping bag standar untuk suhu normal, nyaman dan hangat.',
                'price_per_day' => 25000,
                'stock' => 20,
                'available_stock' => 20,
                'condition' => 'good',
            ],
            [
                'category_id' => 3,
                'name' => 'Sleeping Bag Tebal',
                'description' => 'Sleeping bag tebal untuk pendakian gunung tinggi, tahan suhu dingin hingga -5°C.',
                'price_per_day' => 35000,
                'stock' => 12,
                'available_stock' => 12,
                'condition' => 'excellent',
            ],
            // Matras
            [
                'category_id' => 4,
                'name' => 'Matras Foam',
                'description' => 'Matras foam ringan dan praktis, mudah dilipat dan dibawa.',
                'price_per_day' => 15000,
                'stock' => 25,
                'available_stock' => 25,
                'condition' => 'good',
            ],
            [
                'category_id' => 4,
                'name' => 'Matras Self Inflating',
                'description' => 'Matras self inflating otomatis mengembang, sangat nyaman untuk tidur.',
                'price_per_day' => 30000,
                'stock' => 10,
                'available_stock' => 10,
                'condition' => 'excellent',
            ],
            // Kompor
            [
                'category_id' => 5,
                'name' => 'Kompor Portable',
                'description' => 'Kompor portable gas praktis dan efisien untuk memasak di gunung.',
                'price_per_day' => 20000,
                'stock' => 15,
                'available_stock' => 15,
                'condition' => 'good',
            ],
            [
                'category_id' => 5,
                'name' => 'Nesting Cookware Set',
                'description' => 'Set peralatan masak lengkap untuk camping, termasuk panci, wajan, dan peralatan makan.',
                'price_per_day' => 25000,
                'stock' => 10,
                'available_stock' => 10,
                'condition' => 'good',
            ],
            // Headlamp & Senter
            [
                'category_id' => 6,
                'name' => 'Headlamp LED',
                'description' => 'Headlamp LED terang dengan 3 mode pencahayaan, tahan air.',
                'price_per_day' => 15000,
                'stock' => 20,
                'available_stock' => 20,
                'condition' => 'excellent',
            ],
            [
                'category_id' => 6,
                'name' => 'Senter Tactical',
                'description' => 'Senter tactical super terang dengan zoom dan mode SOS.',
                'price_per_day' => 20000,
                'stock' => 15,
                'available_stock' => 15,
                'condition' => 'excellent',
            ],
        ];

        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }
    }
}

