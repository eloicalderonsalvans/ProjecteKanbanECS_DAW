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
        Schema::create('tascas_users', function (Blueprint $table) {
            $table->id(); // id autoincremental para la tabla pivote
            $table->foreignId('id_user')
                  ->constrained('users', 'id_user') // FK hacia users.id_user
                  ->onDelete('cascade');
            $table->foreignId('id_tasca')
                  ->constrained('tascas', 'id_tasca') // FK hacia tascas.id_tasca
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tascas_users');
    }
};
