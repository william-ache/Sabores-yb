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
            'slogan' => 'Hechas con amor desde nuestra familia para la tuya.',
            'whatsapp_number' => '0412-885-3518',
            'address' => 'Los olivos nuevos - Calle Andres Bello - al frente del Colegio Nuestra Señora de las Mercedes',
            'primary_color' => '#00A859',
            'secondary_color' => '#FFBF69',
            'schedule' => 'Lunes a Sábado: 7:00 AM - 12:00 PM',
            'maps_link' => 'https://www.google.com/maps/place/Empanadas+sabores+Y%26B/@10.2585474,-67.5849861,17z/data=!3m1!4b1!4m6!3m5!1s0x8e803bde67e3f01f:0x38d51b7bf61cda37!8m2!3d10.2585474!4d-67.5849861!16s%2Fg%2F11l5lvflv6?entry=tts&g_ep=EgoyMDI2MDMyNC4wIPu8ASoASAFQAw%3D%3D&skid=9ed11fae-5fee-4f4d-948c-402d321de2b8',
            'bcv_rate' => '36.50',
            'instagram_user' => 'saboresyb',
            'instagram_url' => 'https://www.instagram.com/saboresyb',
            'tiktok_url' => 'https://www.tiktok.com/@saboresyb',
            'facebook_url' => 'https://www.facebook.com/people/Sabores-YB/61576457047143/',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
