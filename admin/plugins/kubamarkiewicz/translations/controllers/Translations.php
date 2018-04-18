<?php namespace KubaMarkiewicz\Translations\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use KubaMarkiewicz\Translations\Models\Translation;
use Backend\Models\BrandSetting;
use Flash;
use Lang;
use RainLab\Translate\Classes\Translator;


class Translations extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.ReorderController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        $this->addCss('/plugins/kubamarkiewicz/translations/assets/css/styles.css');

        BackendMenu::setContext('KubaMarkiewicz.Translations', 'main-menu-item');
    }


    public function section($id = null)
    {
        if ($id) {
            $row = Translation::find($id);
        }
        else {
            $row = null;
        }

        $translations = Translation::select()->getNested();

        $this->vars['id'] = $id;
        $this->vars['section'] = $row;
        $this->vars['sections'] = $translations;
        $this->vars['secondary_color'] = BrandSetting::get('secondary_color');


        if ($row) {

            /*
             * Make form widget
             */
            
            $config = new \stdClass;
            $config->model = $row;
            $config->fields = [];
            $config->data = [];


            $slug = 'translation';
            $config->fields[$slug] = [
                'label' => 'test',
                'type' => 'kubamarkiewicz_translations_section'
            ];
            $config->data[$slug] = $row->translation;


/*
            if ($row->type == Translation::TYPE_REPEATER) {

                $slug = 'translation_'.$row->id;


                $fields = [];
                if ($row->children) foreach ($row->children as $item) {

                    $field = [];
                    $field['label'] = $item->code;
                    switch ($item->type) {
                        case Translation::TYPE_RICHEDITOR:
                            $field['type'] = 'richeditor';
                            $field['size'] = 'small';
                            $field['toolbarButtons'] = 'paragraphFormat|bold|italic|clearFormatting|align|outdent|indent|formatOL|formatUL|insertHR|insertLink|insertFile|insertImage|insertVideo|insertTable|fullscreen|html';
                            break;
                        case Translation::TYPE_IMAGE_MEDIAFINDER:
                            $field['type'] = 'mediafinder';
                            $field['mode'] = 'image';
                            $field['imageWidth'] = '200';
                            $field['imageHeight'] = '100';
                            $field['thumbOptions'] = [
                                'mode' => 'auto', 
                                'extension' => 'auto'
                            ];
                            break;
                        default: // textarea
                            $field['type'] = 'textarea';
                            $field['size'] = 'tiny';
                            break;
                    }

                    $fields[$item->code] = $field;
                }

                    
                $config->fields[$slug] = [
                    'label' => '',
                    'type' => 'repeater',
                    'prompt' => 'Add banner',
                    'form' => [
                        'fields' => $fields
                    ]
                ];

                $config->data[$slug] = $row->translation;
            }
            else {

                $this->vars['forms'] = [];

                if ($row->children) foreach ($row->children as $item) if (!count($item->children)) {
                    

                    $config = new \stdClass;
                    $config->model = $item;
                    $config->fields = [];
                    $config->data = [];


                    $slug = 'translation_'.$item->id;
                    
                    $config->fields[$slug] = [];
                    switch ($item->type) {
                        case Translation::TYPE_RICHEDITOR:
                            $config->fields[$slug]['type'] = 'richeditor';
                            $config->fields[$slug]['size'] = 'small';
                            $config->fields[$slug]['toolbarButtons'] = 'paragraphFormat|bold|italic|clearFormatting|align|outdent|indent|formatOL|formatUL|insertHR|insertLink|insertFile|insertImage|insertVideo|insertTable|fullscreen|html';
                            break;
                        case Translation::TYPE_IMAGE_MEDIAFINDER:
                            $config->fields[$slug]['type'] = 'mediafinder';
                            $config->fields[$slug]['mode'] = 'image';
                            $config->fields[$slug]['imageWidth'] = '200';
                            $config->fields[$slug]['imageHeight'] = '100';
                            break;
                        case Translation::TYPE_IMAGE_UPLOAD:
                            // $slug = 'file_'.$item->id;
                            $slug = 'file';
                            $field = [];
                            $field['type'] = 'fileupload';
                            $field['mode'] = 'image';
                            $field['useCaption'] = 1;
                            $field['thumbOptions'] = [
                                'mode' => 'auto', 
                                'extension' => 'auto'
                            ];
                            $field['imageWidth'] = '200';
                            $field['imageHeight'] = '100';
                            $config->fields[$slug] = $field;
                            $config->model->$slug = $config->model->file;
                            $config->model->attachOne[$slug] = 'System\Models\File';
                            break;
                        default: // textarea
                            $config->fields[$slug]['type'] = 'textarea';
                            $config->fields[$slug]['size'] = 'tiny';
                            $item->translation = str_replace(["<br>", "<br/>", "<br />"], "", $item->translation);
                            break;
                    }
                    $config->fields[$slug]['label'] = $item->code;
                    $config->data[$slug] = $item->translation;
                    $config->model->translatable[] = $slug;


                    $form = $this->makeWidget('Backend\Widgets\Form', $config);
                    $form->bindToController();

                    $this->vars['forms'][] = $form;
                }
            }
*/
            $form = $this->makeWidget('Backend\Widgets\Form', $config);
            $form->bindToController();

            $this->vars['form'] = $form;
            $this->vars['hasFields'] = (bool)$config->fields;
            
        }
    }


    public function section_onSave($section)
    {
        return;
        // dump(post()); exit;

        $data = post();
        $error = false;

        $cmsLang = Lang::getLocale();

        foreach ($data['RLTranslate'] as $lang => $fields) {

            // echo $lang;

            Translator::instance()->setLocale($lang);

            foreach ($fields as $key => $value) if (substr($key, 0, 12) == 'translation_') {
                // echo $value;
                $key = substr($key, 12);

                $row = Translation::find($key);
                // dump($row);
                if ($row) {
                    if (!$row->type) {
                        $value = nl2br($value);
                    }
                    $row->translation = $value;
                    $row->save();
                }
                else {
                    $error = true;
                }
            }
        }

        Translator::instance()->setLocale($cmsLang);

        if ($error) {
            Flash::error('Error');
        } 
        else {
            Flash::success(Lang::get('backend::lang.form.update_success', ['name' => Lang::get('kubamarkiewicz.translations::lang.plugin.name')]));
        } 
        
    }


    public function formExtendModel($model)
    {
        // get parent ID from URL parameter
        if (isset($this->params[1])) {
            $model->parent_id = $this->params[1];
        }
    }
}