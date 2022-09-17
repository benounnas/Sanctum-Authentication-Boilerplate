<?php

use App\Enums\UserGenders;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('birthday')->nullable();
            $table->string('gender')->nullable()->default(UserGenders::MAN->value);
            $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
