<?php

use App\Repositories\FileRepository;

return [
	'assets_dir'        => 'assets', // Directory where assets are stored
	'original_filename' => 'original', // Original file name
	'library'           => 'imagick', //gmagick, gd
	'stubs_dir'         => 'images/stubs',

	'dir'               => [
//		FileRepository::FILE_HOME_GALLERY         => 'home_gallery',
//		FileRepository::FILE_HOME_SLIDER	=> 'home_slider',
//		FileRepository::FILE_ABOUT_TEAM		=> 'team'
	],
	'sizes'             => [
		FileRepository::FILE_DEFAULT      => [

			FileRepository::IMAGE_SIZE_TINY        => [
				'width'   => 100,
				'height'  => 100,
				'type'    => 'crop',
				'format'  => 'jpg',
				'quality' => 90
			],
			FileRepository::IMAGE_SIZE_MICRO       => [
				'width'   => 25,
				'height'  => 25,
				'type'    => 'crop',
				'format'  => 'jpg',
				'quality' => 95
			],
			FileRepository::IMAGE_SIZE_PREVIEW     => [
				'width'   => 100,
				'height'  => 100,
				'type'    => 'crop',
				'format'  => 'jpg',
				'quality' => 95
			],
			FileRepository::IMAGE_SIZE_FULLSIZE    => [
				'width'   => 900,
				'height'  => null,
				'type'    => 'scale',
				'format'  => 'jpg',
				'quality' => 95
			],

			// SAMPLE SIZES
//			FileRepository::IMAGE_SIZE_HOME_GALLERY     => [
//				'width'   => 925,
//				'height'  => 425,
//				'type'    => 'crop',
//				'format'  => 'jpg',
//				'quality' => 95
//			],
//			FileRepository::IMAGE_SIZE_HOME_SLIDER => [
//				'width'   => 971,
//				'height'  => 507,
//				'type'    => 'crop',
//				'format'  => 'jpg',
//				'quality' => 95,
////				'greyscale' => true
//			],
//			FileRepository::IMAGE_SIZE_ABOUT_TEAM => [
//				'width'   => 128,
//				'height'  => 128,
//				'type'    => 'crop',
//				'format'  => 'jpg',
//				'quality' => 95
//			]
		],

//		FileRepository::FILE_HOME_GALLERY         => [
//			FileRepository::IMAGE_SIZE_TINY     => [],
//			FileRepository::IMAGE_SIZE_FULLSIZE => [],
//			FileRepository::IMAGE_SIZE_PREVIEW  => [],
//			FileRepository::IMAGE_SIZE_HOME_GALLERY     => []
//		],
//		FileRepository::FILE_HOME_SLIDER => [
//				FileRepository::IMAGE_SIZE_TINY     => [],
//				FileRepository::IMAGE_SIZE_FULLSIZE => [],
//				FileRepository::IMAGE_SIZE_PREVIEW  => [],
//				FileRepository::IMAGE_SIZE_HOME_SLIDER     => []
//		],
//		FileRepository::FILE_ABOUT_TEAM => [
//				FileRepository::IMAGE_SIZE_TINY     => [],
//				FileRepository::IMAGE_SIZE_FULLSIZE => [],
//				FileRepository::IMAGE_SIZE_PREVIEW  => [],
//				FileRepository::IMAGE_SIZE_ABOUT_TEAM     => []
//		]
	],
	'allow'             => [
		'default'               => []
	],
	'rules'             => [
		// Pages
//		FileRepository::FILE_HOME_GALLERY         => [
//			'single' => false,
//			'type'   => FileRepository::FILE_EXT_IMAGE
//		],
//		FileRepository::FILE_HOME_SLIDER => [
//			'single' => true,
//			'type'   => FileRepository::FILE_EXT_IMAGE
//		],
//		FileRepository::FILE_ABOUT_TEAM => [
//			'single' => true,
//			'type'   => FileRepository::FILE_EXT_IMAGE
//		]
	],
	'types'             => [
		FileRepository::FILE_EXT_IMAGE => ['jpg', 'png', 'gif', 'jpeg', 'bmp', 'tif', 'tiff'],
		FileRepository::FILE_EXT_DOC   => ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'txt']
	]
];
