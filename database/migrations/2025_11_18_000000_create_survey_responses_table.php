<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->uuid('guest_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_group')->nullable();
            $table->json('purposes')->nullable();
            $table->string('purpose_other')->nullable();

            $table->tinyInteger('rating_registration')->nullable();
            $table->tinyInteger('rating_speed')->nullable();
            $table->tinyInteger('rating_friendliness')->nullable();
            $table->tinyInteger('rating_clarity')->nullable();
            $table->tinyInteger('rating_comfort')->nullable();
            $table->tinyInteger('rating_cleanliness')->nullable();
            $table->tinyInteger('rating_system')->nullable();

            $table->tinyInteger('rating_overall')->nullable();

            $table->text('comments')->nullable();

            $table->string('device')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamps();

            $table->index('guest_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
};
