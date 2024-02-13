<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurses', function (Blueprint $table) {
            $table->id();
            $table->string('nurse_name');
            $table->string('nurse_nickname');
            $table->string('nurse_phone')->nullable();
            $table->string('nurse_status')->default('actif');
            $table->timestamp('nurse_created_at')->useCurrent();
            $table->unsignedBigInteger('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nurses');
    }
};
