<?php namespace TheYesBrand\Proyectos\Api;

use Illuminate\Routing\Controller;
use TheYesBrand\Proyectos\Models\Proyecto;
use KubaMarkiewicz\Pages\Models\Page;

class Metadata extends Controller
{

    public function index($slug)
    {
        $query = Page::where('slug', 'proyectos');
        $page = $query->first(); 

        $query = Proyecto::where('slug', $slug)->where('published', '1')->with('image');
        $item = $query->first(); 

        // dump($item);

        if ($item) : 

            $title = $item->name.' - '.($page->meta_title ? $page->meta_title : $page->name);
            $description = mb_strimwidth(str_replace(array("\r", "\n"), ' ', strip_tags($item->content)), 0, 300, '...');
            ?>
<!doctype html>
<html>
<head>
    <title><?=e($title)?></title>
    <meta name="description" content="<?=e($description)?>">
    <meta property="og:url"           content="<?=$page->fullUrl?>/<?=$slug?>">
    <meta property="og:type"          content="website">
    <meta property="og:title"         content="<?=e($title)?>">
    <meta property="og:description"   content="<?=e($description)?>">
    <?php if($item->image) : ?>
        <meta property="og:image"         content="<?=$item->image->getPath()?>">
    <?php endif ?>
</head>
<body></body>
</html>
        <?php endif;
    }

}