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
		case 'post-new.php':
			if($q_config['editor_mode'] == QTX_EDITOR_MODE_SINGLGE){
				add_filter( 'get_post_metadata', 'qwpseo_get_post_metadata', 5, 4);
				//add_filter( 'option_blogname', 'qtranxf_useCurrentLanguageIfNotFoundShowEmpty');
			}

			//to prevent the effect of 'strip_tags' in function 'retrieve_sitename' in '/wp-content/plugins/wordpress-seo/inc/class-wpseo-replace-vars.php'
			add_filter( 'option_blogname', 'qwpseo_encode_swirly');
			add_filter( 'option_blogdescription', 'qwpseo_encode_swirly');

			//to make "Page Analysis" work in Single Language Mode
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
	printf(__('%sNotes from %s'.PHP_EOL), '<h3>', 'qTranslate&#8209;X</h3>');
	echo '<p>'.PHP_EOL;
	echo __('In addition to main XML Sitemap, you may also view sitemaps for each individual language:').PHP_EOL;
	echo '<ul>'.PHP_EOL;
	$sitemap_index_url = qtranxf_convertURL(get_option('home').'/sitemap_index.xml', $q_config['default_language'], true);
	$url = home_url('i18n-index-sitemap.xml');
	$rb = '';
	foreach($q_config['enabled_languages'] as $lang){
		$href = qtranxf_convertURL($url,$lang,true,true);
		$u = $q_config['default_language'] == $lang ? qtranxf_convertURL($url,$lang,true,false) : $href;
		echo '<li>'.$q_config['language_name'][$lang].' ('.$lang.', '.$q_config['locale'][$lang].'): <a href="'.$href.'" target="_blank">'.$u.'</a></li>'.PHP_EOL;
		$rb .= 'Sitemap: '.$u.PHP_EOL;
	}
	echo '</ul><br />'.PHP_EOL;
	printf(__('It is advisable to append the site\'s "%s" with the list of index sitemaps separated by language'),'/robots.txt');
	$nmaps = count($q_config['enabled_languages'])+1;
	echo '<br /><textarea class="widefat" rows="'.$nmaps.'" name="robots-sitemaps" readonly="readonly">'.$rb.'</textarea>'.PHP_EOL;
	//echo '<pre>'.$rb.'</pre>'.PHP_EOL;
	echo '<br />or with this single entry of flat multilingual index sitemap<br /><textarea class="widefat" rows="2" name="robots-sitemap" readonly="readonly">Sitemap: '.$sitemap_index_url.'</textarea>'.PHP_EOL;
	echo '<br />Do not combine two sets together, since they both equally cover all languages in all pages as defined by Yoast configuration.';
	echo '</p>'.PHP_EOL;
}
add_action( 'wpseo_xmlsitemaps_config', 'qwpseo_xmlsitemaps_config' );

/**
 * Change encoding of $value to swirly breckets, '{'.
 * @since 1.1
*/
function qwpseo_encode_swirly($value)
{
	//qtranxf_dbg_log('qwpseo_encode_swirly: $value: ',$value);
	$value = preg_replace('#\[:([a-z]{2}|)\]#i','{:$1}',$value);
	return $value;
}

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
