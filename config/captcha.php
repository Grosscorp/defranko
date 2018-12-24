<?php

return [

	'default' => [
		'length'  => 5,
		'width'   => 120,
		'height'  => 36,
		'quality' => 90,
	],

	'flat' => [
		'length'     => 6,
		'width'      => 160,
		'height'     => 46,
		'quality'    => 90,
		'lines'      => 6,
		'bgImage'    => false,
		'bgColor'    => '#ecf2f4',
		'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
		'contrast'   => -5,
	],

	'mini' => [
		'length'     => 4,
		'width'      => 120,
		'height'     => 45,
		'bgColor'    => '#f8f8f8',
		'bgImage'    => false,
		'fontColors' => ['#ccc'],
		'lines'      => false,
	],

	'inverse' => [
		'length'    => 5,
		'width'     => 120,
		'height'    => 36,
		'quality'   => 90,
		'sensitive' => true,
		'angle'     => 12,
		'sharpen'   => 10,
		'blur'      => 2,
		'invert'    => true,
		'contrast'  => -5,
	]

];
