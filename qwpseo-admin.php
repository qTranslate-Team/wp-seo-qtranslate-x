<?php
if(!defined('ABSPATH'))exit;

/* moved to i18n-config.xml 
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
	$fields['wpseo_metakey'] = array();
	$fields['wpseo_canonical'] = array();

	$page_config['forms']['edittag'] = $f;
	$page_configs[] = $page_config;
	}

	return $page_configs;
}
*/

function qwpseo_admin_filters()
{
	global $pagenow;
	switch($pagenow){
		case 'edit.php':
			add_filter( 'wpseo_title', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
			add_filter( 'wpseo_meta', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
			add_filter( 'wpseo_metadesc', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
		break;
		case 'post.php':
			add_filter( 'wpseo_pre_analysis_post_content', 'qtranxf_useCurrentLanguageIfNotFoundShowEmpty');
		break;
	}
}
qwpseo_admin_filters();

function qwpseo_use_page_analysis($a){ return false; }
add_filter( 'wpseo_use_page_analysis', 'qwpseo_use_page_analysis' );

function qwpseo_xmlsitemaps_config()
{
	global $q_config;
	echo '<p>';
	echo __('In addition to main XML Sitemap, you may also view sitemaps for each individual language:').PHP_EOL;
	echo '<ul>'.PHP_EOL;
	$url = home_url('i18n-index-sitemap.xml');
	foreach($q_config['enabled_languages'] as $lang){
		$u = qtranxf_convertURL($url,$lang,true);
		echo '<li><a href="'.$u.'" target="_blank">'.$u.'</a>&nbsp;-&nbsp;'.$q_config['language_name'][$lang].' ('.$lang.')</li>'.PHP_EOL;
	}
	echo '</ul></p>'.PHP_EOL;
}
add_action( 'wpseo_xmlsitemaps_config', 'qwpseo_xmlsitemaps_config' );

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
