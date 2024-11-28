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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->required();
            $table->string('last_name')->required();
            $table->string('email')->required()->unique();
            $table->string('phone')->required();
            $table->string('address');
            $table->unsignedBigInteger('membership_id');
            $table->foreign('membership_id')->on('memberships')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->date('joining_date');
            $table->date('expiry_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
