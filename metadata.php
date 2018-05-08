<?php

//echo '<pre>'; print_r($_SERVER);
$url = 'http://'.$_SERVER['HTTP_HOST'].'/admin/api/metadata'.$_SERVER['REQUEST_URI'];
// echo $url;
echo file_get_contents($url);