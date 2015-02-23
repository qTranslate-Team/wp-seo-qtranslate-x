<?php
if(!defined('ABSPATH'))exit;

add_filter('qtranslate_load_admin_page_config','qwpseo_add_admin_page_config');
function qwpseo_add_admin_page_config($page_configs)
{
	$page_config = array();
	$page_config['pages'] = array( 'post.php' => '' );
	//$page_config['anchors'] = array( 'titlediv' );

	$page_config['forms'] = array();

	$f = array();
	$f['form'] = array( 'id' => 'post' );//identify the form which input fields described below belong to

	$f['fields'] = array();
	$fields = &$f['fields']; // shorthand

	$fields[] = array( 'id' => 'yoast_wpseo_title' );
	$fields[] = array( 'id' => 'yoast_wpseo_focuskw' );
	$fields[] = array( 'id' => 'yoast_wpseo_metadesc' );
	$fields[] = array( 'id' => 'wpseosnippet_title', 'encode' => 'display' );

	$page_config['forms'][] = $f;
	$page_configs[] = $page_config;

	return $page_configs;
}
?>
