<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Console Routes / Comandos de Consola
|--------------------------------------------------------------------------
|
| Aquí es donde puedes definir todos tus comandos de consola basados en
| cierres (closures). Cada cierre está vinculado a una instancia de comando,
| lo que permite un enfoque sencillo para interactuar con los métodos de E/S.
|
*/

/**
 * Comando 'inspire'
 * Muestra una frase inspiradora en la consola.
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Comando 'cache:wipe'
 * Realiza una limpieza profunda de todos los sistemas de caché y optimiza la app.
 */
Artisan::command('cache:wipe', function () {

    $this->info("============================================================");
    $this->info(" 🔧 INICIANDO LIMPIEZA Y OPTIMIZACIÓN DEL SISTEMA ");
    $this->info("============================================================\n");

    // 🚩 Flags de control: true para ejecutar, false para omitir
    $run = [
        'optimize_clear'   => true,
        'composer_dump'    => true,
        'config_clear'     => true,
        'cache_clear'      => true,
        'view_clear'       => true,
        'route_clear'      => true,
        'event_clear'      => false,
        'schedule_clear'   => false,
        'queue_restart'    => false,
        'logs_clear'       => false,
        'optimize'         => true,
        'config_cache'     => false,
        'route_cache'      => false,
        'view_cache'       => false,
    ];

    /**
     * Helper para ejecutar comandos Artisan internos
     */
    $runArtisan = function ($command, $label) {
        $this->comment("[ARTISAN] $label...");
        Artisan::call($command);
        $this->line(Artisan::output());
    };

    /**
     * Helper para comandos del sistema (bash/cmd)
     */
    $runExec = function ($command, $label) {
        $this->comment("[SISTEMA] $label...");
        exec($command, $output);
        foreach ($output as $line) {
            $this->line("   -> $line");
        }
    };

    // 1. Limpiar optimización previa
    if ($run['optimize_clear']) {
        $runArtisan('optimize:clear', 'Limpiando optimización general');
    }

    // 2. Regenerar autoload de Composer
    if ($run['composer_dump']) {
        $runExec('composer dump-autoload', 'Regenerando archivos de carga automática');
    }

    // 3. Limpiar cachés básicas del Framework
    if ($run['config_clear']) $runArtisan('config:clear', 'Limpiando config');
    if ($run['cache_clear'])  $runArtisan('cache:clear', 'Limpiando cache');
    if ($run['view_clear'])   $runArtisan('view:clear', 'Limpiando vistas');
    if ($run['route_clear'])  $runArtisan('route:clear', 'Limpiando rutas');

    // 4. Tareas de mantenimiento opcionales
    if ($run['event_clear']) {
        $runArtisan('event:clear', 'Limpiando eventos');
    }

    if ($run['schedule_clear']) {
        $runArtisan('schedule:clear-cache', 'Limpiando scheduler');
    }

    if ($run['queue_restart']) {
        $runArtisan('queue:restart', 'Reiniciando colas');
    }

    // Limpieza de logs (Forma segura y multiplataforma)
    if ($run['logs_clear']) {
        $this->comment("[ARCHIVOS] Eliminando logs en storage/logs...");
        $files = File::glob(storage_path('logs/*.log'));
        foreach ($files as $file) {
            File::delete($file);
            $this->line("   -> Borrado: " . basename($file));
        }
    }

    // 5. Optimización final
    if ($run['optimize']) {
        $runArtisan('optimize', 'Optimizando aplicación');
    }

    // 6. Cachear para producción (si es necesario)
    if ($run['config_cache']) $runArtisan('config:cache', 'Cacheando config');
    if ($run['route_cache'])  $runArtisan('route:cache', 'Cacheando rutas');
    if ($run['view_cache'])   $runArtisan('view:cache', 'Cacheando vistas');

    $this->info("\n✅ [ÉXITO] Proceso completado correctamente.");
})->describe('Limpia y optimiza la aplicación con control granular mediante flags');
