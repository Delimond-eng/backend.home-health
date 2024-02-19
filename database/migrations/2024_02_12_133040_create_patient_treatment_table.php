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
        Schema::create('patient_treatments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_treatment_libelle');
            $table->string('patient_treatment_status')->default('pending');
            $table->unsignedBigInteger('visit_id');
            $table->timestamp('patient_treatment_created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_treatments');
    }
};
