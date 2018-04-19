<?php namespace TheYesBrand\Proyectos\Models;

use Model;

/**
 * Model
 */
class Proyecto extends Model
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
    public $table = 'theyesbrand_proyectos_proyectos';

    /*
     * Relations
     */
    public $attachOne = [
        'image' => 'System\Models\File'
    ];
    public $attachMany = [
        'images' => 'System\Models\File'
    ];
}
