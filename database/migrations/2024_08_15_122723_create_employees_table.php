<?php

use App\Models\Department;
use App\Models\Position;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Position::class);
            $table->string('name');
            $table->string('arname')->nullable();
            $table->string('slug')->nullable();
            $table->integer('code');
            $table->string('gender');
            $table->boolean('overtime')->nullable();
            $table->boolean('ticket')->nullable();
            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
