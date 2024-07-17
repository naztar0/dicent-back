<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 32);
            $table->string('group', 32)->nullable()->default(null);
            $table->string('audiofile', 64)->nullable()->default(null);
            $table->string('job', 16)->nullable()->default(null);
            $table->integer('speakers')->nullable()->default(null);
            $table->enum('status', ['NONE', 'QUEUED', 'IN_PROGRESS', 'FAILED', 'COMPLETED'])->default('NONE');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
};
