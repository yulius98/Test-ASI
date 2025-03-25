<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyClientTable extends Migration
{
    public function up()
    {
        Schema::create('my_client', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->string('slug', 100);
            $table->string('is_project', 30)->default('0')->check('is_project in (\'0\',\'1\')');
            $table->char('self_capture', 1)->default('1');
            $table->string('client_prefix', 4);
            $table->string('client_logo', 255)->default('no-image.jpg');
            $table->text('address')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('my_client');
    }
}