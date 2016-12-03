<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            $table->integer('created_at');
            $table->integer('updated_at');
        });

        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('created_at');
            $table->integer('updated_at');
        });

        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('weight');

            $table->integer('units')->unsigned();
            $table->integer('stock')->unsigned();
            $table->double('length');
            $table->double('width');

            $table->double('sales_price');
            $table->double('purchase_price');

            $table->integer('created_at');
            $table->integer('updated_at');
        });

        Schema::create('project_set', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('set_id')->unsigned();

            $table->integer('created_at');
            $table->integer('updated_at');

            $table->unique(['project_id', 'set_id']);
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');
        });

        Schema::create('set_part', function (Blueprint $table) {
            $table->integer('project_set_id')->unsigned();
            $table->integer('part_id')->unsigned();

            $table->integer('created_at');
            $table->integer('updated_at');

            $table->primary(['project_set_id', 'part_id']);
            $table->foreign('project_set_id')->references('id')->on('project_set')->onDelete('cascade');
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('set_part');
        Schema::drop('project_set');
        Schema::drop('projects');
        Schema::drop('sets');
        Schema::drop('parts');
    }
}