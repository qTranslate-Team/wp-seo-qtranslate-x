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
	global $pagenow, $q_config;
	switch($pagenow){
		case 'edit.php':
			add_filter( 'wpseo_title', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
			add_filter( 'wpseo_meta', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
			add_filter( 'wpseo_metadesc', 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage');
		break;
		case 'post.php':
			if($q_config['editor_mode'] == QTX_EDITOR_MODE_SINGLGE){
				add_filter( 'get_post_metadata', 'qwpseo_get_post_metadata', 5, 4);
				//add_filter( 'option_blogname', 'qwpseo_option_blogname');
				add_filter( 'option_blogname', 'qtranxf_useCurrentLanguageIfNotFoundShowEmpty');
			}
			add_filter( 'wpseo_pre_analysis_post_content', 'qtranxf_useCurrentLanguageIfNotFoundShowEmpty');
		break;
	}
}
qwpseo_admin_filters();

function qwpseo_get_post_metadata($original_value, $object_id, $meta_key = '', $single = false)
{
	global $q_config;
	if(empty($meta_key)){
		//very ugly hack
		$trace = debug_backtrace();
		//qtranxf_dbg_log('qwpseo_get_post_metadata: $trace: ',$trace);
		//qtranxf_dbg_log('qwpseo_get_post_metadata: $trace[6][args][0]: ',$trace[6]['args'][0]);
		//qtranxf_dbg_log('qwpseo_get_post_metadata: $trace[7][function]: ',$trace[7]['function']);
		if( isset($trace[7]['function']) && $trace[7]['function'] === 'calculate_results' &&
				isset($trace[6]['args'][0]) && $trace[6]['args'][0] === 'focuskw'
		){
			//qtranxf_dbg_log('qwpseo_get_post_metadata: $object_id: ',$object_id);
			//qtranxf_dbg_log('qwpseo_get_post_metadata: $single: ',$single);
			$key = WPSEO_Meta::$meta_prefix . 'focuskw';
			$focuskw = get_metadata('post',$object_id,$key,true);
			//qtranxf_dbg_log('qwpseo_get_post_metadata: $focuskw: ',$focuskw);
			$focuskw = qtranxf_use_language($q_config['language'],$focuskw);
			return array( $key => array($focuskw));
		}
	}
	return $original_value;
}

/**
 * adds single-language sitemap links to the Yoast configuration page for XML Sitemaps.
*/
function qwpseo_xmlsitemaps_config()
{
	global $q_config;
	$options = get_option( 'wpseo_xml' );
	//qtranxf_dbg_log('qwpseo_xmlsitemaps_config: $options: ',$options);
	if(empty($options['enablexmlsitemap'])) return;
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
function qwpseo_option_blogname($value)
{
	global $q_config, $wp_current_filter;
	qtranxf_dbg_log('qwpseo_option_blogname: $value: ',$value);
	return $value;
}

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
