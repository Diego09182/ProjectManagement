<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarksTable extends Migration
{
    public function up()
    {
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remarks');
    }
}
