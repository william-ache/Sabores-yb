<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'name' => 'Sede Principal',
            'address' => 'Av. Principal, Local 5',
            'whatsapp' => '+584161071344',
            'lat' => 10.2586,
            'lng' => -67.5856,
            'is_active' => true,
        ]);
    }
}
