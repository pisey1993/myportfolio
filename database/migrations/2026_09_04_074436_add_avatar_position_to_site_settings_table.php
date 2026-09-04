<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('avatar_position_x')->default(50)->after('avatar_path');
            $table->unsignedTinyInteger('avatar_position_y')->default(50)->after('avatar_position_x');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['avatar_position_x', 'avatar_position_y']);
        });
    }
};
