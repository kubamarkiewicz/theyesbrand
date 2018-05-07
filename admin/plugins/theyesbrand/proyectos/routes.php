<?php

Route::get('/api/proyectos', 'TheYesBrand\Proyectos\Api\Proyectos@index');
Route::get('/api/metadata/proyectos/{slug}', 'TheYesBrand\Proyectos\Api\Metadata@index');
