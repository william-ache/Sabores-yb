<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('delivery_name')->nullable()->after('name');
            $table->string('phone_1')->nullable()->after('delivery_name');
            $table->string('phone_2')->nullable()->after('phone_1');
            $table->string('id_card')->nullable()->after('phone_2');
        });

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->nullable(); // Ej. Casa, Trabajo
            $table->text('address');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['delivery_name', 'phone_1', 'phone_2', 'id_card']);
        });
    }
};
