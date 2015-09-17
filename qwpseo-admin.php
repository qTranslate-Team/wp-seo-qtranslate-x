<?php
if(!defined('ABSPATH'))exit;

add_filter('qtranslate_load_admin_page_config','qwpseo_add_admin_page_config');//obsolete
//add_filter('i18n_admin_config','qwpseo_add_admin_page_config');// should be used instead
function qwpseo_add_admin_page_config($page_configs)
{
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
	$fields[] = array( 'id' => 'yoast_wpseo_metadesc', 'encode' => '{' );
	$fields[] = array( 'id' => 'wpseosnippet_title', 'encode' => 'display' );

	$page_config['forms'][] = $f;
	$page_configs[] = $page_config;
	}

	{
	$page_config = array();
	$page_config['pages'] = array( 'edit-tags.php' => 'action=edit' );
	//$page_config['anchors'] = array( 'titlediv' );

	$page_config['forms'] = array();

	$f = array();
	$f['form'] = array( 'id' => 'edittag' );//identify the form which input fields described below belong to

	$f['fields'] = array();
	$fields = &$f['fields']; // shorthand

	$fields[] = array( 'id' => 'wpseo_title' );
	$fields[] = array( 'id' => 'wpseo_desc' );
	$fields[] = array( 'id' => 'wpseo_canonical' );

	$page_config['forms'][] = $f;
	$page_configs[] = $page_config;
	}

	return $page_configs;
}

function qwpseo_admin_filters()
{
	global $pagenow;
	if($pagenow != 'edit.php') return;
	//if( strpos($_SERVER['QUERY_STRING'],'post_type=post')===FALSE && strpos($_SERVER['QUERY_STRING'],'post_type=page')===FALSE) return;
	add_filter( 'wpseo_title', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
	add_filter( 'wpseo_meta', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
	add_filter( 'wpseo_metadesc', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
	//focus keywords are still not translated
}
qwpseo_admin_filters();

/*
function qwpseo_manage_custom_column($column)
{
	switch($column){
		case 'SEO Title':
		case 'Meta Desc.':
		case 'Focus KW':
		default: break;
	}
}
add_filter('manage_posts_custom_column', 'qwpseo_manage_custom_column');
add_filter('manage_pages_custom_column', 'qwpseo_manage_custom_column');
*/
