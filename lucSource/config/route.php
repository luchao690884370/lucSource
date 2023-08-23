<?php

use Webman\Route;
use support\Request;

//前台路由
Route::any('/', [\plugin\lucSource\app\controller\IndexController::class, 'index']);
Route::any('/source', [\plugin\lucSource\app\controller\SourceController::class, 'index']);
Route::any('/source/info', [\plugin\lucSource\app\controller\SourceController::class, 'info']);

Route::any('/news', [\plugin\lucSource\app\controller\NewsController::class, 'index']);
Route::any('/news/info', [\plugin\lucSource\app\controller\NewsController::class, 'info']);
Route::any('/search', [\plugin\lucSource\app\controller\SearchController::class, 'index']);

//后台分类路由
Route::any('/luc', [\plugin\lucSource\app\controller\LucController::class, 'index']);
Route::any('/luc/admin_source_cate_pid', [\plugin\lucSource\app\controller\LucController::class, 'admin_source_cate_pid']);


Route::any('/login', [\plugin\lucSource\app\controller\LoginController::class, 'index']);
Route::any('/login/login', [\plugin\lucSource\app\controller\LoginController::class, 'login']);
Route::any('/login/logout', [\plugin\lucSource\app\controller\LoginController::class, 'logout']);
Route::any('/register', [\plugin\lucSource\app\controller\RegisterController::class, 'index']);
Route::any('/register/register', [\plugin\lucSource\app\controller\RegisterController::class, 'register']);

Route::fallback(function (Request $request) {
    return response($request->uri() . ' not found' , 404);
}, 'lucSource');