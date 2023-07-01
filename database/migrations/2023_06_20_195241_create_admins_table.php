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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 50);
            $table->string('email' , 50)->unique();
            $table->string('password' , 100);
            $table->enum('gender' , ['M','F'])->default('M');
            $table->boolean('active')->default(true);

            /* ___ foreign ___ */
            // $table->foreignId('city_id');
            // $table->foreign('city_id')->on('cities')->references('id');
            $table->foreignId('city_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
