<?php namespace KubaMarkiewicz\Pages\Api;

use Illuminate\Routing\Controller;
use KubaMarkiewicz\Pages\Models\Page;

class Metadata extends Controller
{

    public function index($url, $locale = 'es')
    {
        // echo $url;
        // echo "<pre>";
        // print_r($_SERVER);

        $pageUrl = 'http://'.$_SERVER['HTTP_HOST'].'/'.$url;

        $query = Page::where('slug', $url);

        $page = $query->first(); 

        if ($page) : ?>

<!doctype html>
<html>
<head>
    <title><?=$page->meta_title ? $page->meta_title : $page->name ?></title>
    <meta name="description" content="<?=$page->meta_description?>">
    <!-- You can use open graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content="<?=$pageUrl?>">
    <meta property="og:type"          content="website">
    <meta property="og:title"         content="<?=$page->meta_title ? $page->meta_title : $page->name ?>">
    <meta property="og:description"   content="<?=$page->meta_description?>">
    <!-- <meta property="og:image"         content=""> -->
    <!-- <meta property="fb:app_id"        content=""> -->
</head>
<body></body>
</html>



        <?php endif;
    }


}