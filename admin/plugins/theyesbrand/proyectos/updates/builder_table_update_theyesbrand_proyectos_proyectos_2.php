<?php namespace TheYesBrand\Proyectos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTheyesbrandProyectosProyectos2 extends Migration
{
    public function up()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->text('content');
        });
    }
    
    public function down()
    {
        Schema::table('theyesbrand_proyectos_proyectos', function($table)
        {
            $table->dropColumn('content');
        });
    }
}
