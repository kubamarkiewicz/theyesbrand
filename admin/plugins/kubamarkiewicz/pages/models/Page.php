<?php namespace KubaMarkiewicz\Pages\Models;

use Model;

/**
 * Model
 */
class Page extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    
    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'kubamarkiewicz_pages_pages';

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel']; 

    public $translatable = ['meta_title', 'meta_description'];

    /*
     * Relations
     */
    public $attachOne = [
        'meta_image' => 'System\Models\File'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url', 'subpages'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['children'];


    public function getUrlAttribute()
    {
        if ($this->parent_id) {
            $parent = $this->getParent()->first();
            // dump($parent->first()->url); exit;
            return $parent->url.'/'.$this->slug;
        }
        else {
            return $this->slug;
        }
    }


    public function getSubpagesAttribute()
    {
        $return = [];
        if ($this->children) foreach ($this->children as $child) {
            $return[$child->slug] = $child;
        }
        return $return;
    }

}