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
        Schema::create('visit_delegates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delegate_nurse_id');
            $table->unsignedBigInteger('visit_id');
            $table->timestamp('visit_delegate_created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit_delegates');
    }
};
