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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->string('type')->default('Delivery')->after('status'); // Delivery or PickUp
            $table->text('delivery_address')->nullable()->after('type');
            $table->decimal('delivery_cost', 10, 2)->default(0)->after('delivery_address');
            $table->string('payment_method')->nullable()->after('delivery_cost');
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->decimal('subtotal', 10, 2)->default(0)->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['user_id', 'branch_id', 'type', 'delivery_address', 'delivery_cost', 'payment_method', 'payment_reference', 'subtotal']);
        });
    }
};
