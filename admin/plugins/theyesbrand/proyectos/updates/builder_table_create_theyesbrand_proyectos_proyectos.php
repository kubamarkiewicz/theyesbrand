<?php namespace TheYesBrand\Proyectos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTheyesbrandProyectosProyectos extends Migration
{
    public function up()
    {
        Schema::create('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('theyesbrand_proyectos_proyectos');
    }
}
