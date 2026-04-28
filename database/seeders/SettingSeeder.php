<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'app_name' => 'Sabores Y&B',
            'slogan' => 'Las mejores empanadas de la zona',
            'whatsapp_number' => '+584161071344',
            'address' => 'Avenida Principal, Local 5',
            'primary_color' => '#00A859',
            'secondary_color' => '#FFBF69',
            'schedule' => 'Lunes a Sábado: 7:00 AM - 1:00 PM',
            'maps_link' => 'https://goo.gl/maps/example',
            'bcv_rate' => '36.50',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
