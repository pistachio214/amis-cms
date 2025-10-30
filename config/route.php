<?php

use Webman\Route;

Route::disableDefaultRoute('cms');

Route::group('/cms', function () {
    Route::get('/login', [\plugin\cms\app\controller\AuthController::class, 'login']);
    Route::post('/auth/login', [\plugin\cms\app\controller\AuthController::class, 'loginPost']);

    Route::get('/index', [\plugin\cms\app\controller\AmisController::class, 'index']);

    // 在 config/route.php 中
    Route::any('/{path:.+}', [\plugin\cms\app\controller\AmisController::class, 'index']);
    // AMis 页面
//    Route::get('/amis', [\plugin\cms\app\controller\AmisController::class, 'index']);
//    Route::get('/login', [\plugin\cms\app\controller\AuthController::class, 'login']);
});
