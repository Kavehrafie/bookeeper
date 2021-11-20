<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("projects", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description")->nullable();
            $table->timestamps();
        });

        Schema::create("code_project", function (Blueprint $table) {
            $table->foreignId("code_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId("project_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('position')
                ->default(0);
            $table->string('group')
                ->nullable();
            $table->unique(['code_id','project_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("code_project");
        Schema::dropIfExists("projects");
    }
}
