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
        Schema::table('home_devices', function (Blueprint $table) {
            $table->string('operation_max_watt')->after('device_operation_type');
            $table->string('priority')->after('operation_max_voltage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_devices', function (Blueprint $table) {
            //
        });
    }
};
