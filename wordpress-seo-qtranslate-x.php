<?php
/**
 * Plugin Name: WordPress SEO & qTranslate-X
 * Plugin URI: https://wordpress.org/plugins/wordpress-seo-qtranslate-x
 * Description: Enables multilingual framework for plugin "WordPress SEO".
 * Version: 1.0
 * Author: qTranslate Team
 * Author URI: http://qtranslatexteam.wordpress.com/about
 * License: GPL2
 * Tags: multilingual, multi, language, translation, qTranslate-X, Events Made Easy
 * Author e-mail: qTranslateTeam@gmail.com
 */
if(!defined('ABSPATH'))exit;

define('QWPSEO_VERSION','1.0');

function qwpseo_init_language($url_info)
{
	if($url_info['doing_front_end']) {
		require_once(dirname(__FILE__)."/qwpseo-front.php");
	}else{
		require_once(dirname(__FILE__)."/qwpseo-admin.php");
	}
}
add_action('qtranslate_init_language','qwpseo_init_language');

?>
