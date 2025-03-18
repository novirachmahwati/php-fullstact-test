<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('my_client', function (Blueprint $table) {
            $table->id();
            $table->char('name', 250)->notNull();
            $table->char('slug', 100)->unique()->notNull();
            $table->string('is_project', 30)->default('0')->check("is_project in ('0','1')");
            $table->char('self_capture', 1)->default('1')->notNull();
            $table->char('client_prefix', 4)->notNull();
            $table->char('client_logo', 255)->default('no-image.jpg')->notNull();
            $table->text('address')->nullable();
            $table->char('phone_number', 50)->nullable();
            $table->char('city', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('my_client');
    }
};
