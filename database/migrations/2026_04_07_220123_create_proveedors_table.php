<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('contacto');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('proveedors');
    }
};
