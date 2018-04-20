<?php namespace TheYesBrand\HomeBanners\Models;

use Model;

/**
 * Model
 */
class HomeBanner extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'theyesbrand_homebanners_homebanners';

    /*
     * Relations
     */
    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public function getHorizontalAlignOptions()
    {
        return [
            'align-left' => 'izquierda',
            'align-center' => 'centro',
            'align-right' => 'derecha'
        ];
    }

    public function getVerticalAlignOptions()
    {
        return [
            'valign-top' => 'arriba',
            'valign-center' => 'centro',
            'valign-bottom' => 'abajo'
        ];
    }

    public function getTextColorOptions()
    {
        return [
            'color-light' => 'blanco',
            'color-dark' => 'gris'
        ];
    }
}
