<?php
/**
 * Plugin Name: Integration: Yoast SEO & qTranslate-X
 * Plugin URI: https://wordpress.org/plugins/wp-seo-qtranslate-x/
 * Description: Enables multilingual framework for plugin "Yoast SEO".
 * Version: 1.2
 * Author: qTranslate Team
 * Author URI: http://qtranslatexteam.wordpress.com/about
 * License: GPL2
 * Tags: multilingual, multi, language, translation, qTranslate-X, Yoast SEO, Integration
 * Author e-mail: qTranslateTeam@gmail.com
 * GitHub Plugin URI: https://github.com/qTranslate-Team/wp-seo-qtranslate-x/
 * GitHub Branch: master
 */
if(!defined('ABSPATH'))exit;

define('QWPSEO_VERSION','1.2');

function qwpseo_init_language($url_info)
{
	if(!defined('WPSEO_VERSION'))
		return;
	global $q_config;
	if($url_info['doing_front_end']) {
		require_once(dirname(__FILE__).'/qwpseo-front.php');
	}else{
		require_once(dirname(__FILE__).'/qwpseo-admin.php');
	}
}
add_action('qtranslate_init_language', 'qwpseo_init_language');

/*
class WPSEO_Taxonomy_Meta
	public static $defaults_per_term = array(
		'wpseo_title'           => '',
		'wpseo_desc'            => '',
		'wpseo_metakey'         => '',
		'wpseo_canonical'       => '',
		'wpseo_bctitle'         => '',
		'wpseo_noindex'         => 'default',
		'wpseo_sitemap_include' => '-',
		'wpseo_focuskw'         => '',
		'wpseo_linkdex'         => '',

		// Social fields.
		'wpseo_opengraph-title'         => '',
		'wpseo_opengraph-description'   => '',
		'wpseo_opengraph-image'         => '',
		'wpseo_twitter-title'           => '',
		'wpseo_twitter-description'     => '',
		'wpseo_twitter-image'           => '',
	);
*/
function qwpseo_get_meta_keys(){
	return array(
		'wpseo_title',
		'wpseo_desc',
		'wpseo_metakey',
		'wpseo_canonical',
		'wpseo_bctitle',
		//'wpseo_noindex',
		'wpseo_focuskw',
		//'wpseo_sitemap_include',
		//'wpseo_linkdex',

		// Social fields.
		'wpseo_opengraph-title',
		'wpseo_opengraph-description',
		//'wpseo_opengraph-image',
		'wpseo_twitter-title',
		'wpseo_twitter-description',
		//'wpseo_twitter-image',
	);
}
