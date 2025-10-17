<?php

use Webman\Route;

Route::disableDefaultRoute('cms');

// AMis 页面
Route::get('/amis', [\plugin\cms\app\controller\AmisController::class, 'index']);
Route::get('/login', [\plugin\cms\app\controller\AuthController::class, 'login']);