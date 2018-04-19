<?php namespace TheYesBrand\Proyectos\Api;

use Illuminate\Routing\Controller;
use TheYesBrand\Proyectos\Models\Proyecto;
use RainLab\Translate\Classes\Translator;
use DB;
use Input;

class Proyectos extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));

        $query = Proyecto::where('published', '1');
        $result = $query->get(); 

        $return = [];

        foreach ($result as $item) {
            // resize image
            if ($item->image) {
                $item->image->path_resized = $item->image->getThumb(636,536,['extension' => 'jpg']);
            }    
            $return[] = $item;
        }

        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }



    public function get($slug)
    {
        $query = Proyecto::where('slug', $slug)->where('published', '1');
        $item = $query->get()->first(); 

        // resize images
        if ($item->images) foreach ($item->images as $key => $image) {
            $item->images[$key]->path_resized = $image->getThumb(1920,1080,['extension' => 'jpg']);
        }      

        return response()->json($item, 200, array(), JSON_PRETTY_PRINT);
    }


}