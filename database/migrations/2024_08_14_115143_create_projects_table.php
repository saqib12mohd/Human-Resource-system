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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('arname')->nullable();
            $table->string('slug')->nullable();
            $table->integer('code');
            $table->string('customer');
            $table->string('Description')->nullable();
            $table->date('esstimedStartDate')->nullable();
            $table->date('esstimedEndDate')->nullable();
            $table->date('accualstartDate')->nullable();
            $table->date('accualendDate')->nullable();
            $table->string('status')->nullable();
            $table->integer('hourlyrate');
            $table->time('esstimedhours')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
