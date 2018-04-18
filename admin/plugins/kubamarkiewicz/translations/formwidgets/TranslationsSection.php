<?php namespace KubaMarkiewicz\Translations\FormWidgets;

use Backend\Classes\FormWidgetBase;

class TranslationsSection extends FormWidgetBase
{
	//
    // Configurable properties
    //

    /**
     * @var bool Display mode: datetime, date, time.
     */
    public $mode = 'datetime';


    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'kubamarkiewicz_translations_section';


    public function init()
    {
        $this->fillFromConfig([
            'mode'
        ]);
    }

    public function render() 
    {
        $children = $this->model->children;
        $model = $children[0];

        /*
         * Make form widget
         */
            
        $config = new \stdClass;
        $config->model = $model;
        $config->fields = [];
        $config->data = [];

        $slug = 'translation';
        $config->fields[$slug] = [
            'label' => 'Translation',
            'type' => 'text'
        ];
        $config->data[$slug] = $model->translation;

        $form = $this->makeWidget('Backend\Widgets\Form', $config);
        // $form->bindToController();

        $this->vars['form'] = $form;


    	// $this->vars['id'] = $this->getId();
	    // $this->vars['name'] = $this->getFieldName();
	    // $this->vars['value'] = $this->getLoadValue();

	    return $this->makePartial('widget');
    }

    public function getSaveValue($value)
    {
        echo 'widget';
        dump($this->model);
        dump($value); exit;



        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }


    public function onPaginate()
    {
        dump('onPaginate');
        dump($this->model);

    }

    public function onUpdate()
    {
        $data = post();

        // Check storage/logs/system.log
        // dump($data);
        dump($this->model->id);

        Translator::instance()->setLocale('en');

        echo $this->model->translation = $data['translation'];
        $this->model->save();

        \Flash::success('Jobs done!');
    }
}