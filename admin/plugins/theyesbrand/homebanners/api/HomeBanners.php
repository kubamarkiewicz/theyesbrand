<?php namespace TheYesBrand\HomeBanners\Api;

use Illuminate\Routing\Controller;
use TheYesBrand\HomeBanners\Models\HomeBanner;
use RainLab\Translate\Classes\Translator;
use DB;
use Input;

class HomeBanners extends Controller
{

    public function index()
    {
        Translator::instance()->setLocale(Input::get('lang'));

        $query = HomeBanner::where('published', '1');
        $result = $query->get(); 

        $return = [];

        foreach ($result as $item) {
            // resize image
            if ($item->image) {
                $item->image->path_resized = $item->image->getThumb(1920,null,['extension' => 'jpg']);
            }   
            $return[] = $item;
        }

        return response()->json($return, 200, array(), JSON_PRETTY_PRINT);
    }



}