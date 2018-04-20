<?php namespace TheYesBrand\HomeBanners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTheyesbrandBannershomeBannershome extends Migration
{
    public function up()
    {
        Schema::create('theyesbrand_homebanners_homebanners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('content');
            $table->string('text_color');
            $table->string('vertical_align');
            $table->string('horizontal_align');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('theyesbrand_homebanners_homebanners');
    }
}
