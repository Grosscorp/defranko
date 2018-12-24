<?php


namespace App\Repositories;


use App\File;
use Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;

/**
 * Class FileRepository
 *
 * @package App\Repositories
 */
class _FileRepository
{
	CONST FILE_DEFAULT = 0;
	CONST FILE_HOME_GALLERY = 1;
	CONST FILE_HOME_SLIDER = 2;
	CONST FILE_ABOUT_TEAM = 3;

	//Image sizes
	CONST IMAGE_SIZE_ORIGINAL = 'original';
	CONST IMAGE_SIZE_MICRO = 'micro';
	CONST IMAGE_SIZE_TINY = 'tiny';
	CONST IMAGE_SIZE_FULLSIZE = 'fullsize';
	CONST IMAGE_SIZE_PREVIEW = 'preview';


	CONST IMAGE_SIZE_HOME_GALLERY = 'home_gallery';
	CONST IMAGE_SIZE_HOME_SLIDER = 'home_slider';
	CONST IMAGE_SIZE_ABOUT_TEAM = 'team';


	CONST FILE_EXT_IMAGE = 1;
	CONST FILE_EXT_DOC = 2;

	/**
	 * @param $parentId
	 * @param $type
	 *
	 * @return mixed
	 */
	public static function getByParentId($parentId, $type)
	{
		return File::whereRaw('parent_id = ? AND type = ?', [$parentId, $type])
			->orderBy('created_at', 'desc')
			->get()
			->toArray();
	}

	/**
	 * @param $token
	 *
	 * @return mixed
	 */
	public function getByToken($token)
	{
		$file = File::where('token', $token)->first();

		if($file) {
			 return $file;
		}

		throw new ModelNotFoundException;
	}

	/**
	 * @param       $parentId
	 * @param       $type
	 * @param array $files
	 */
	public static function updateFilesParentId($parentId, $type, array $files)
	{
		//first set 0 for old items
		File::whereRaw('parent_id = ? AND type = ?', [$parentId, $type])
			->update(['parent_id' => 0]);

		//update new items
		foreach($files as $file) {
			$imageFile = File::where('token', '=', $file['token'])->first();
			$imageFile->update(['parent_id' => $parentId]);
		}
	}

	/**
	 * @param $token
	 * @param $parentId
	 */
	public static function setParentIdByToken($token, $parentId)
	{
		File::whereToken($token)
			->update(['parent_id' => $parentId]);
	}

	/**
	 * @param       $parentId
	 * @param array $files
	 */
	public static function setParentIdByIdForUser($parentId, array $files)
	{
		// Check if array (fix, if size > allowed = js write string)
		if(!is_array($files)) return;

		foreach($files as $file) {

			if(!$file || !is_array($file) || !isset($file['id'])) continue; // Skip if not file array

			// If token removed, set parent_id to 0;
			if(!isset($file['token'])) {
				File::where('user_id', \Auth::id())->where('id', '=', $file['id'])->update(['parent_id' => 0]);
			} else {
				File::where('user_id', \Auth::id())->where('id', '=', $file['id'])->update(['parent_id' => $parentId]);
			}
		}
	}

	/**
	 * @param $items
	 *
	 * @return mixed
	 */
	public static function transformWithDimensionUrls($items)
	{
		$result = [];

		foreach($items as $item) {
			$sizes = self::getSizes($item['type']);
			foreach($sizes as $key => $size) {
				$item['url_' . $key] = self::generateUrl($item['type'], $item['token'], $key);
			}

			$result[] = $item;
		}

		return $result;
	}


	/**
	 * Get all prepared sizes. For Angular cfg etc.
	 * @return array
	 */
	public static function getAllSizes()
	{
		$result = [];

		foreach(Config::get('files.sizes') as $type => $sizes) {
			$result[] = self::getSizes($type);
		}
		return $result;
	}

	/**
	 * @param      $fileType
	 * @param bool $thumb
	 *
	 * @return array
	 */
	public static function getSizes($fileType, $thumb = false) {
		$config = Config::get('files.sizes');

		$defaultSizes = $config[self::FILE_DEFAULT];
		$sizes = $config[$fileType];

		if($thumb) {
			return array_merge($defaultSizes[$thumb], $sizes[$thumb]);
		}

		$result = [];
		foreach ($sizes as $thumb => $size) {
			$result[$thumb] = array_merge($defaultSizes[$thumb], $size);
		}

		return $result;
	}

	/**
	 * @param      $type
	 * @param      $token
	 * @param      $isImage
	 * @param bool $create
	 *
	 * @return string
	 */
	public static function generatePath($type, $token, $isImage = true, $create = false)
	{
		$config = Config::get('files');


		$dir = $config['assets_dir'] . '/' . $config['dir'][$type];
		$dir .= DIRECTORY_SEPARATOR . ($isImage ? 'images' : 'files');
		for($i = 0; $i <=2; $i++) {
			$dir .= DIRECTORY_SEPARATOR . $token[$i];
		}
		$dir .= DIRECTORY_SEPARATOR;
		if($isImage) {
			$dir .= $token . DIRECTORY_SEPARATOR;
		}

		if(! is_dir($dir) && $create) {
			Storage::makeDirectory($dir);
		}

		return $dir;
	}

	/**
	 * @param File $file
	 *
	 * @return string
	 */
	public function generateFilePath(File $file)
	{
		return FileRepository::generatePath($file->type, $file->token, $file->isImage);
	}

	/**
	 * @param File $file
	 *
	 * @return string
	 */
	public function generateDownloadLink(File $file)
	{
		return public_path() . DIRECTORY_SEPARATOR . $this->generateFilePath($file) . FileRepository::generateFileName($file->ext);
	}

	/**
	 * @param $ext
	 *
	 * @return string
	 */
	public static function generateFileName($ext)
	{
		return Config::get('files.original_filename') . '.' . $ext;
//		if($isImage) {
//			return Config::get('files.original_filename') . '.' . $file->getClientOriginalExtension();
//		} else {
//
//			return str_slug(
//				pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
//				, '-') . '.' . $file->getClientOriginalExtension();
//		}
	}

	/**
	 * @param File   $file
	 * @param        $size
	 * @param string $ext
	 *
	 * @return string
	 */
	public static function getUrl(File $file, $size, $ext = 'jpg')
	{
		return self::generateUrl($file->type, $file->token, $size, $ext);
	}

	/**
	 * @param        $type
	 * @param        $token
	 * @param        $size
	 * @param string $ext
	 *
	 * @return string
	 */
	public static function generateUrl($type, $token, $size, $ext = 'jpg')
	{
		if(! $token){
			return self::generateUrlStubs($type, $size);
		}

		$dirPath = self::generatePath($type, $token);

		return '/' . $dirPath . $size . '.' . $ext;
	}

	public static function generateUrlStubs($type, $size)
	{
		$config = Config::get('files');

		return DIRECTORY_SEPARATOR . $config['stubs_dir']  .'/' . $config['dir'][$type] . '/' . $size . '.jpg';
	}

	public static function getRealUrl($type, $token, $size, $ext = 'jpg')
	{

		return substr(self::generateUrl($type, $token, $size, $ext), 1);
	}


}
