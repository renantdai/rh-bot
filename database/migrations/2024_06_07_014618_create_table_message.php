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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('displayPhone', 50)->nullable();
            $table->string('numberID', 50)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('phoneWhatsapp', 50)->nullable();
            $table->string('from', 50)->nullable();
            $table->text('idWhatsapp', 500 )->nullable();
            $table->string('timestamp', 50)->nullable();
            $table->string('type', 25)->nullable();
            $table->text('text', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
