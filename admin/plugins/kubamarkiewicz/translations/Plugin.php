<?php namespace KubaMarkiewicz\Translations;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerFormWidgets()
	{
	    return [
	        'KubaMarkiewicz\Translations\FormWidgets\TranslationsSection' => 'kubamarkiewicz_translations_section'
	    ];
	}

}
