<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        if (Schema::hasTable('references')) {
            Schema::create('publisher_reference', function (Blueprint $table) {

                $table->foreignId('publisher_id')->constrained()->cascadeOnDelete();
                $table->foreignId('reference_id')->constrained()->cascadeOnDelete();
                $table->unique(['publisher_id', 'reference_id']);
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
        Schema::dropIfExists('publisher_reference');
        Schema::dropIfExists('publishers');
    }
}
