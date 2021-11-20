<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("references", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("book_title")->nullable();
            $table->integer("year");
            $table
                ->foreignId("publisher_id")
                ->nullable()
                ->constrained();
            $table->string("city")->nullable();
            $table->string("type")->nullable();
            $table->integer("volume")->nullable();
            $table->integer("issue")->nullable();
            $table->string("journal")->nullable();
            $table->string("pages")->nullable();
            $table->string("citation_key")->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        if (Schema::hasTable("authors")) {
            Schema::create("author_reference", function (Blueprint $table) {
                $table
                    ->foreignId("author_id")
                    ->constrained()
                    ->cascadeOnDelete();
                $table
                    ->foreignId("reference_id")
                    ->constrained()
                    ->cascadeOnDelete();
                $table->string("role");
                $table->unique(["author_id", "reference_id", "role"]);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("author_reference");
        Schema::dropIfExists("references");
    }
}
