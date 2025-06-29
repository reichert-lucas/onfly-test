<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_orders', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('system_id')->nullable();
            $table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');

            $table->unsignedBigInteger('travel_order_status_id');
            $table->foreign('travel_order_status_id')->references('id')->on('travel_order_statuses')->onDelete('restrict');
            
            $table->string('destination');
            $table->date('departure_date');
            $table->date('return_date');
            
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['user_id', 'travel_order_status_id']);
            $table->index(['system_id', 'travel_order_status_id']);
            $table->index(['departure_date', 'return_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_orders');
    }
};
