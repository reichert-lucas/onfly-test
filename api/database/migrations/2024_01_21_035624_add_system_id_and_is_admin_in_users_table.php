<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('system_id')->nullable()->after('id');
            $table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');

            $table->boolean('is_admin')->default(false)->after('system_id');
            $table->boolean('is_super_admin')->default(false)->after('is_admin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('system_id');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_super_admin');
        });
    }
};
