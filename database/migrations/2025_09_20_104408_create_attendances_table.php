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
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->dateTime('clock_in')->nullable();
            $table->dateTime('clock_out')->nullable();
            $table->enum('status', ['ontime', 'late', 'absent'])->default('ontime');
            $table->integer('overtime')->default(0);
            $table->string('photo_in');
            $table->string('photo_out')->nullable();
            $table->string('geo_in');
            $table->string('geo_out')->nullable();

            $table->bigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->bigInteger('updated_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('deleted')->default(false);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
