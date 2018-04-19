<?php

Route::get('/api/proyectos', 'TheYesBrand\Proyectos\Api\Proyectos@index');
Route::get('/api/proyectos/{slug}', 'TheYesBrand\Proyectos\Api\Proyectos@get');
