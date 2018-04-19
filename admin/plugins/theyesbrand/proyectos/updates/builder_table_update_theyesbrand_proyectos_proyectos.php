<?php namespace TheYesBrand\Proyectos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTheyesbrandProyectosProyectos extends Migration
{
    public function up()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->boolean('published')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->dropColumn('published');
        });
    }
}
