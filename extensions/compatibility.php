<?php
/**
 * If user has not installed Layout Engine framework, then automatically load it.
 */


$template_dir = get_template_directory();
if(!class_exists('LE_Base'))
{
	require_once($template_dir . '/plugins/lesscss/lessc.inc.php'); //@todo how we can automatically fetch lesscss as submodule in layout engine?
	require_once($template_dir . '/plugins/layout-engine/layout-engine.php');

	/**
	 * Correct plugin_path for layout engine assets
	 *
	 * @param $url
	 * @param $path
	 * @param $plugin
	 * @since 1.0.0.0
	 * @return string
	 */
	function le_theme_url_fix($url, $path, $plugin)
	{
		global $template_dir;

		//If replacement available in caching
		$cache_url = array();
		if ( false === ( $cache_url = get_transient( 'le_theme_cache_urls' ) ) )
		{
			$url_id = md5($url);
			if(is_array($cache_url) && array_key_exists($url_id, $cache_url))
			{
				return $cache_url[$url_id];
			}
		}

		if(strpos($url, '/layout-engine/') !== false)
		{
			$url_id = md5($url);
			$url = str_replace($template_dir, '', $url);
				
			if(strpos($url,'/wp-content/plugins/plugins/layout-engine') !== false)
			{
				$url = explode('/wp-content/plugins/plugins/layout-engine', $url);
				$url = '/plugins/layout-engine' . $url[1];
				$url = get_template_directory_uri() . $url;

				$cache_url[$url_id] = $url;
				set_transient( 'le_theme_cache_urls', $cache_url );
			}
		}

		return $url;
	}
	add_filter('plugins_url','le_theme_url_fix', 10, 3);
}


?>