<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\leave;
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
        Schema::create('leaverequests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class);
            $table->foreignIdFor(leave::class);
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Position::class);
            $table->date('date')->nullable();
            $table->date('from')->nullable();
            $table->date('upto')->nullable();
            $table->string('description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaverequests');
    }
};
