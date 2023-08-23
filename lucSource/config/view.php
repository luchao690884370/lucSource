<?php

use support\view\Raw;
use support\view\Twig;
use support\view\Blade;
use support\view\ThinkPHP;

return [
	'handler' => ThinkPHP::class,
	'options' => [
		'view_suffix' => 'html',
		'tpl_begin' => '{',
		'tpl_end' => '}',
		 'tpl_replace_string' => [
            '{__CSS__}' => '/app/lucSource/default/css/',
            '{__JS__}' => '/app/lucSource/default/js/',
            '{__IMG__}' => '/app/lucSource/default/images/'
        ],
	]
];
