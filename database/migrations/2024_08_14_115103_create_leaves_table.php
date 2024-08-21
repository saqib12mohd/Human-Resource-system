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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('arname')->nullable();
            $table->string('slug')->nullable();
            $table->integer('leavedays' )->nullable()->default(1);
            $table->string('description')->nullable();
            $table->string('applicablegender', length:6);
            $table->boolean('isDocumentrequired')->default(0);
            $table->boolean('isPaidleave')->default(0);
            $table->boolean('isactive')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
