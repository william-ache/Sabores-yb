<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Controllers\LibraryController;

class SuperAdminController extends Controller
{
    /**
     * Mostrar login de Super Admin
     */
    public function showLoginForm()
    {
        return view('admin.superadmin.login');
    }

    /**
     * Procesar login de Super Admin
     */
    public function login(Request $request)
    {
        $password = $request->input('password');
        $superPassword = env('SUPER_ADMIN_PASSWORD', 'SABORES2026');

        if ($password === $superPassword) {
            session(['super_admin_authed' => true]);
            return redirect()->route('superadmin.index');
        }

        return back()->withErrors(['password' => 'Contraseña de Super Admin incorrecta.']);
    }

    /**
     * Cerrar sesión de Super Admin
     */
    public function logout()
    {
        session()->forget('super_admin_authed');
        return redirect()->route('admin.login')->with('success', 'Sesión de Super Maestro cerrada.');
    }

    /**
     * Dashboard de Super Admin (Cards)
     */
    public function dashboard()
    {
        return view('admin.superadmin.index');
    }

    /**
     * Vista de configuración de marca
     */
    public function brandSettings()
    {
        $settings = [
            'primary_color' => Setting::get('primary_color', '#00A859'),
            'secondary_color' => Setting::get('secondary_color', '#FFBF69'),
            'favicon' => Setting::get('favicon', ''),
            'logo' => Setting::get('logo', ''),
            'app_name' => Setting::get('app_name', 'Sabores Y&B'),
            'address' => Setting::get('address', 'Maracay, Venezuela'),
            'maps_link' => Setting::get('maps_link', 'https://maps.app.goo.gl/q1pFAsYWsYEuoX4i6'),
            'schedule' => Setting::get('schedule', 'Lunes a Sábado de 6:00 am a 1:00 pm'),
            'slogan' => Setting::get('slogan', 'Hechas con amor desde nuestra familia para la tuya.'),
            'instagram_url' => Setting::get('instagram_url', ''),
            'tiktok_url' => Setting::get('tiktok_url', ''),
            'facebook_url' => Setting::get('facebook_url', ''),
            'youtube_url' => Setting::get('youtube_url', ''),
            'twitter_url' => Setting::get('twitter_url', ''),
            'telegram_url' => Setting::get('telegram_url', ''),
            'whatsapp_number' => Setting::get('whatsapp_number', '584128853518'),
            'notification_msg' => Setting::get('notification_msg', 'Crujientes, calientes y deliciosas. ¡Pide la tuya ahora!'),
        ];
        return view('admin.superadmin.brand', compact('settings'));
    }

    /**
     * Vista de gestión de módulos
     */
    public function moduleSettings()
    {
        $modules = Module::all();
        $icons = LibraryController::getIcons();
        return view('admin.superadmin.modules', compact('modules', 'icons'));
    }

    /**
     * Actualiza la marca (colores y logos)
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'favicon' => 'nullable|image|max:1024',
            'logo' => 'nullable|image|max:2048',
        ]);

        Setting::set('primary_color', $request->primary_color);
        Setting::set('secondary_color', $request->secondary_color);
        Setting::set('app_name', $request->app_name);
        Setting::set('address', $request->address);
        Setting::set('maps_link', $request->maps_link);
        Setting::set('schedule', $request->schedule);
        Setting::set('slogan', $request->slogan);
        Setting::set('instagram_url', $request->instagram_url);
        Setting::set('tiktok_url', $request->tiktok_url);
        Setting::set('facebook_url', $request->facebook_url);
        Setting::set('youtube_url', $request->youtube_url);
        Setting::set('twitter_url', $request->twitter_url);
        Setting::set('telegram_url', $request->telegram_url);
        Setting::set('whatsapp_number', $request->whatsapp_number);
        Setting::set('notification_msg', $request->notification_msg);

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $path);
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $path);
        }

        return back()->with('success', 'Personalización de marca guardada con éxito.');
    }

    /**
     * Crear un nuevo módulo (Migración, Modelo, Controlador)
     */
    public function createModule(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:modules',
            'icon' => 'required|string',
            'color' => 'required|string',
            'fields' => 'required|json'
        ]);

        $name = Str::studly($request->name);
        $fields = json_decode($request->fields, true);

        // 1. Guardar en BD para registro
        $module = Module::create([
            'name' => $name,
            'icon' => $request->icon,
            'color' => $request->color,
            'fields' => $fields,
            'relations' => $request->relations ? json_decode($request->relations, true) : null
        ]);

        // 2. Generar Migración
        $tableName = Str::snake(Str::plural($name));
        $migrationName = date('Y_m_d_His') . "_create_{$tableName}_table.php";
        
        $migrationContent = "<?php\n\n";
        $migrationContent .= "use Illuminate\Database\Migrations\Migration;\n";
        $migrationContent .= "use Illuminate\Database\Schema\Blueprint;\n";
        $migrationContent .= "use Illuminate\Support\Facades\Schema;\n\n";
        $migrationContent .= "return new class extends Migration {\n";
        $migrationContent .= "    public function up(): void {\n";
        $migrationContent .= "        Schema::create('{$tableName}', function (Blueprint \$table) {\n";
        $migrationContent .= "            \$table->id();\n";
        
        foreach ($fields as $field) {
            $type = $field['type'] ?? 'string';
            $migrationContent .= "            \$table->{$type}('{$field['name']}');\n";
        }

        // Agregar relaciones foráneas si existen
        if ($module->relations) {
            foreach ($module->relations as $rel) {
                if (($rel['type'] ?? '') == 'belongsTo') {
                    $fk = Str::snake($rel['model'] ?? '') . '_id';
                    $migrationContent .= "            \$table->foreignId('{$fk}')->constrained()->onDelete('cascade');\n";
                }
            }
        }
        
        $migrationContent .= "            \$table->timestamps();\n";
        $migrationContent .= "        });\n";
        $migrationContent .= "    }\n";
        $migrationContent .= "    public function down(): void {\n";
        $migrationContent .= "        Schema::dropIfExists('{$tableName}');\n";
        $migrationContent .= "    }\n";
        $migrationContent .= "};\n";

        File::put(database_path('migrations/' . $migrationName), $migrationContent);

        // 3. Generar Modelo
        Artisan::call('make:model', ['name' => $name]);

        // 4. Respaldar y Migrar
        Artisan::call('db:backup');
        Artisan::call('migrate');

        return back()->with('success', "Módulo '{$name}' creado y migrado con éxito.");
    }

    /**
     * Ejecuta migraciones con respaldo previo
     */
    public function runMigrations()
    {
        Artisan::call('db:backup');
        Artisan::call('migrate');
        return back()->with('success', 'Migraciones ejecutadas correctamente con respaldo previo.');
    }

    /**
     * Ejecuta seeders con respaldo previo
     */
    public function runSeeders()
    {
        Artisan::call('db:backup');
        Artisan::call('db:seed');
        return back()->with('success', 'Seeders ejecutados correctamente con respaldo previo.');
    }
}
