<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\File
 *
 */
class File extends Model {

	//File types
//	CONST FILE_DEFAULT = 0;
//	CONST FILE_HOME_SLIDER = 1;
//
//	//Image sizes
//	CONST IMAGE_SIZE_ORIGINAL = 'original';
//	CONST IMAGE_SIZE_MICRO = 'micro';
//	CONST IMAGE_SIZE_TINY = 'tiny';
//	CONST IMAGE_SIZE_FULLSIZE = 'fullsize';
//	CONST IMAGE_SIZE_PREVIEW = 'preview';
//
//
//	CONST IMAGE_SIZE_HOME_SLIDER = 'home';
//
//
//	CONST FILE_EXT_IMAGE = 1;
//	CONST FILE_EXT_DOC = 2;

	/**
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * @var array
	 */
	protected $fillable = ['type', 'parent_id', 'user_id', 'token', 'name', 'ext', 'isImage', 'size'];

}
