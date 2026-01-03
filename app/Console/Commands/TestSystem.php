<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestSystem extends Command
{
    protected $signature = 'test:system';
    protected $description = 'Test system functionality';

    public function handle()
    {
        $this->info('===== Testing System =====');
        
        // Test 1: Check admin user
        $admin = User::where('email', 'admin@sewacamping.com')->first();
        if ($admin) {
            $this->info('✓ Admin user exists');
            $this->info('  Email: ' . $admin->email);
            $this->info('  Role: ' . $admin->role);
            
            if (Hash::check('admin123', $admin->password)) {
                $this->info('✓ Admin password correct');
            } else {
                $this->error('✗ Admin password incorrect');
            }
        } else {
            $this->error('✗ Admin user not found');
        }
        
        // Test 2: Check equipment
        $equipmentCount = Equipment::count();
        $this->info("\n✓ Total equipment: " . $equipmentCount);
        
        if ($equipmentCount > 0) {
            $eq = Equipment::first();
            $this->info('  Sample: ' . $eq->name);
            $this->info('  Stock: ' . $eq->stock . ' | Available: ' . $eq->available_stock);
        }
        
        // Test 3: Check storage link
        if (file_exists(public_path('storage'))) {
            $this->info("\n✓ Storage link exists");
        } else {
            $this->error("\n✗ Storage link not found");
            $this->info('  Run: php artisan storage:link');
        }
        
        // Test 4: Check equipment directory
        if (file_exists(storage_path('app/public/equipment'))) {
            $this->info('✓ Equipment directory exists');
        } else {
            $this->error('✗ Equipment directory not found');
        }
        
        $this->info("\n===== Test Complete =====");
        return 0;
    }
}
