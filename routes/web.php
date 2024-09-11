<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    require __DIR__.'/fortify.php';
    require __DIR__.'/app.php';
});
