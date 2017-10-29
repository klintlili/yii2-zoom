<?php

return [
    'id' => 'tests',
    'basePath' => dirname(__DIR__),
    'components' => [
		'zoom' => [
			'class' => 'x1ankun\Zoom\ZoomApi',
			'api_key' => '123123',
			'api_secret' => '123123',
			'data_type' => 'json'
		]  
    ],
];