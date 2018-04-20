<?php namespace TheYesBrand\HomeBanners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTheyesbrandBannershomeBannershome extends Migration
{
    public function up()
    {
        Schema::table('theyesbrand_homebanners_homebanners', function($table)
        {
            $table->boolean('published')->default(1);
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
            $table->string('text_color')->change();
            $table->string('vertical_align')->change();
            $table->string('horizontal_align')->change();
        });
    }
    
    public function down()
    {
        Schema::table('theyesbrand_homebanners_homebanners', function($table)
        {
            $table->dropColumn('published');
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
            $table->string('text_color', 191)->change();
            $table->string('vertical_align', 191)->change();
            $table->string('horizontal_align', 191)->change();
        });
    }
}
