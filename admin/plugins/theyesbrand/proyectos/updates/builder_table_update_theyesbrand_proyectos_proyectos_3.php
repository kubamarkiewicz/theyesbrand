<?php namespace TheYesBrand\Proyectos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTheyesbrandProyectosProyectos3 extends Migration
{
    public function up()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->string('background_color');
        });
    }
    
    public function down()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->dropColumn('background_color');
        });
    }
}
