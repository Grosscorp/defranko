<?php

if (!function_exists('get_youtube_video_id')) {
	/**
	 * @param $url
	 * @return bool
	 */
	function get_youtube_video_id($url)
	{
		preg_match(
			'/[\\?\\&]v=([^\\?\\&]+)/',
			$url,
			$matches
		);

		if(isset($matches[1])) {
			return $matches[1];
		}

		return false;
	}

	/**
	 * Get array keys from lang file. Specially useful for
	 */
	if (!function_exists('get_lang_keys')) {
		/**
		 * @param $key
		 * @return string
		 */
		function get_lang_keys($key)
		{
			return implode(',', array_keys(\Lang::get($key)));
		}
	}
}



