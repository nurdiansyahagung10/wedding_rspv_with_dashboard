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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->boolean('is_private_cat')->default(false);
            $table->boolean('is_attending')->default(false);
            $table->boolean('has_answer')->default(false);
            $table->integer('amount_of_guest')->default(1);
            $table->text('wishes')->nullable();
            $table->string('uuid', 36)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
