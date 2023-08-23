<?php
use  plugin\lucSource\app\admin\controller\SettingController;
use  plugin\lucSource\app\admin\controller\NavController;
use  plugin\lucSource\app\admin\controller\SlideController;
use plugin\lucSource\app\admin\controller\LinkController;
use plugin\lucSource\app\admin\controller\ArticleCateController;
use plugin\lucSource\app\admin\controller\ArticleController;

use plugin\lucSource\app\admin\controller\SourceCateController;
use plugin\lucSource\app\admin\controller\SourceCodeController;
return [

     [
        'title' => 'LucSource管理',
        'key' => 'lucSource-all0',
        'icon' => 'layui-icon-menu-fill',
        'weight' => 0,
        'type' => 0,
        'href' => '',
        'children' => [

                      [
                        'title' => '基础管理',
                        'key' => 'lucSource-setting',
                        'icon' => 'layui-icon-set',
                        'weight' => 0,
                        'type' => 0,
                        'href' => '',
                        'children' => [
                            [
                                'title' => '网站设置',
                                'key' => SettingController::class,
                                'href' => '/app/lucSource/admin/setting',
                                'type' => 1,
                            ],
                            [
                                'title' => '导航设置',
                                'key' => NavController::class,
                                'href' => '/app/lucSource/admin/nav/lists',
                                'type' => 1,
                            ],
                            [
                                'title' => '轮播广告',
                                'key' => SlideController::class,
                                'href' => '/app/lucSource/admin/slide/lists',
                                'type' => 1,
                            ],
                            [
                                'title' => '友情链接',
                                'key' => LinkController::class,
                                'href' => '/app/lucSource/admin/link/lists',
                                'type' => 1,
                            ]
                        ]
                    ],
                    [
                        'title' => '文章管理',
                        'key' => 'lucSource-article',
                        'icon' => 'layui-icon-template-1',
                        'weight' => 0,
                        'type' => 0,
                        'href' => '',
                        'children' => [
                            [
                                'title' => '文章分类',
                                'key' => ArticleCateController::class,
                                'href' => '/app/lucSource/admin/articleCate/lists',
                                'type' => 1,
                            ],
                            [
                                'title' => '文章列表',
                                'key' => ArticleController::class,
                                'href' => '/app/lucSource/admin/article/lists',
                                'type' => 1,
                            ],
                        ]
                    ],
                    [
                        'title' => '源码管理',
                        'key' => 'lucSource-code',
                        'icon' => 'layui-icon-template-1',
                        'weight' => 0,
                        'type' => 0,
                        'href' => '',
                        'children' => [
                            [
                                'title' => '源码分类',
                                'key' => SourceCateController::class,
                                'href' => '/app/lucSource/admin/SourceCate/lists',
                                'type' => 1,
                            ],
                            [
                                'title' => '源码列表',
                                'key' => SourceCodeController::class,
                                'href' => '/app/lucSource/admin/SourceCode/lists',
                                'type' => 1,
                            ],
                        ]
                    ]





        ]
    ],



];
