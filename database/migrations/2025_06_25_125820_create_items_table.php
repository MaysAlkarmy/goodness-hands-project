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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('description');
            $table->string('price')->default('free');
            $table->integer('quantity')->default(1);
            $table->string('main_category');
            $table->timestamp('created_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
