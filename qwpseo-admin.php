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
	$f['fields'] = array();
	$fields = &$f['fields']; // shorthand

	$fields['yoast_wpseo_title'] = array();
	$fields['yoast_wpseo_focuskw'] = array();
	$fields['yoast_wpseo_metadesc'] = array('encode' => '{' );
	$fields['yoast_wpseo_metakeywords'] = array();
	$fields['wpseosnippet_title'] = array('encode' => 'display' );

	$page_config['forms']['post'] = $f;
	$page_configs[] = $page_config;
	}

	{
	$page_config = array();
	$page_config['pages'] = array( 'edit-tags.php' => 'action=edit' );

	$page_config['forms'] = array();

	$f = array();
	$f['fields'] = array();
	$fields = &$f['fields']; // shorthand

	$fields['wpseo_title'] = array();
	$fields['wpseo_desc'] = array();
	$fields['wpseo_metakey'] = array();//'encode' => '{');
	$fields['wpseo_canonical'] = array();

	$page_config['forms']['edittag'] = $f;
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
