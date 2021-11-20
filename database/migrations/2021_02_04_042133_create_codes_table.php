<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("codes", function (Blueprint $table) {
            $table->id();
            $table->text("body");
            $table
                ->foreignId("reference_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->json("notes")->nullable();
            $table->string("pages")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        //        if(Schema::hasTable('references')){
        //            Schema::create('reference_code', function (Blueprint $table) {
        //                $table->foreignId('code_id')->constrained()->cascadeOnDelete();
        //                $table->foreignId('reference_id')->constrained()->cascadeOnDelete();
        //                $table->string('page_number')->nullable();
        //
        //            });
        //        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //        Schema::dropIfExists('reference_code');
        Schema::dropIfExists("codes");
    }
}
