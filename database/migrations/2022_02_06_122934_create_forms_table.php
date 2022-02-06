<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('specification');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            // Todo: In future if need to maintain diff status for form use this
            $table->integer('status')->default(1); //0:Draft, 1:Published, 2.Unpublished, 3.Deleted

            //STATS TODO: If more stats need to maintain create separate table form_stats
            $table->integer('submit_count')->default(0);
            $table->integer('open_count')->default(0); // Naming: 'viewCount' better?
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
        Schema::dropIfExists('forms');
    }
}
