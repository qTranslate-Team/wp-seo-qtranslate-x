<?php
/**
 * Plugin Name: Integration: Yoast SEO & qTranslate-X
 * Plugin URI: https://wordpress.org/plugins/wp-seo-qtranslate-x/
 * Description: Enables multilingual framework for plugin "Yoast SEO".
 * Version: 1.1.1
 * Author: qTranslate Team
 * Author URI: http://qtranslatexteam.wordpress.com/about
 * License: GPL2
 * Tags: multilingual, multi, language, translation, qTranslate-X, Yoast SEO, Integration
 * Author e-mail: qTranslateTeam@gmail.com
 * GitHub Plugin URI: https://github.com/qTranslate-Team/wp-seo-qtranslate-x/
 * GitHub Branch: master
 */
if(!defined('ABSPATH'))exit;

define('QWPSEO_VERSION','1.1.1');

function qwpseo_init_language($url_info)
{
	global $q_config;
	if($url_info['doing_front_end']) {
		add_filter( 'wpseo_use_page_analysis', 'qwpseo_no_page_analysis' );
		require_once(dirname(__FILE__)."/qwpseo-front.php");
	}else{
		if($q_config['editor_mode'] != QTX_EDITOR_MODE_SINGLGE){
			//Disable "Page Analysis" unless Single Language Editor Mode is in use.
			add_filter( 'wpseo_use_page_analysis', 'qwpseo_no_page_analysis' );
		}
		require_once(dirname(__FILE__)."/qwpseo-admin.php");
	}
}
add_action('qtranslate_init_language','qwpseo_init_language');

/**
 * Disable "Page Analysis".
*/
function qwpseo_no_page_analysis($a){ return false; }
//add_filter( 'wpseo_use_page_analysis', 'qwpseo_no_page_analysis' );
