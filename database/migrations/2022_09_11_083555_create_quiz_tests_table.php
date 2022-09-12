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
        Schema::create('quiz_tests', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_test_details');
            $table->tinyInteger('total_questions')->nullable();
            $table->tinyInteger('quiz_perform_qty')->nullable();
            $table->tinyInteger('quiz_pass_qty')->nullable();
            $table->float('total_marks_aquired', 8, 2)->nullable();
            $table->foreignId('user_id');
            $table->char('time_consumed', 10)->nullable();
            $table->foreignId('checked_by')->nullable()->comment('Checked by admin (examiner)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_tests');
    }
};
