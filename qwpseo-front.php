<?php
if(!defined('ABSPATH'))exit;

/* moved to i18n-config.json
function qwpseo_add_filters_front() {
	$use_filters = array(
		//'wpseo_opengraph_title' => 20,//comes already translated
		//'wpseo_metakey' => 20, //deprecated
		//'wpseo_metakeywords' => 20,//comes already translated
		'wpseo_title' => 20,
		'wpseo_meta' => 20,
		'wpseo_metadesc' => 20,
		'wpseo_replacements' => 20
	);

	foreach ( $use_filters as $name => $priority ) {
		add_filter( $name, 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage', $priority );
	}
}
qwpseo_add_filters_front();
*/

// sitemaps handling
/**
 * Remove duplicated images and translates image attributes.
 * @since 1.0.3
*/
function qwpseo_sitemap_urlimages( $images, $id )
{
	global $q_config;
	$lang = $q_config['language'];
	//qtranxf_dbg_log('qwpseo_sitemap_urlimages('.$id.'): $images: ',$images);
	$srcs = array();
	foreach($images as $k => $image){
		$src = $image['src'];
		if(isset($srcs[$src])){
			unset($images[$k]);
		}else{
			$srcs[$src] = $image;
			foreach($image as $p => $txt){
				if($p == 'src') continue;
				$images[$k][$p] = qtranxf_use($lang,$txt,false,true);
			}
		}
	}
	return $images;
}
add_filter( 'wpseo_sitemap_urlimages', 'qwpseo_sitemap_urlimages', 999, 2);

/**
 * Generate top level index for hierarchical sitemaps.
 * @since 1.0.3
*/
function qwpseo_sitemap_index( $sm )
{
	global $q_config, $wpseo_sitemaps;
	if(isset($q_config['sitemap-type'])) return '';
	//qtranxf_dbg_log('qwpseo_sitemap_index: $wpseo_sitemaps: ', $wpseo_sitemaps);
	ob_start();
	$wpseo_sitemaps->output();
	$content = ob_get_contents();
	ob_end_clean();
	//qtranxf_dbg_log('qwpseo_sitemap_index: $content: ', $content);
	$matches;
	$lastmod = '';
	$p = 0;
	$sitemaps = array();
	while(($p = strpos($content,'<sitemap>',$p))!==false){
		if(($e = strpos($content,'</sitemap>',$p)) !== false){
			$len = $e - $p + strlen('</sitemap>');
			$s = substr($content, $p, $len);
			//qtranxf_dbg_log('qwpseo_sitemap_index: $s: ', $s);
			$p += $len;
			$sitemaps[] = $s;
			if(preg_match('!<lastmod>\\s*([^\\s<]+)\\s*</lastmod>!s',$s,$matches)){
				if(empty($lastmod) || strcmp($lastmod,$matches[1])<0) $lastmod = $matches[1];
			}
		}else{
			$p += strlen('<sitemap>');
		}
	}
	if(preg_match('/<sitemapindex[^>]*>/',$content,$matches))
		$sm = $matches[0];
	else
		$sm = '';
	//qtranxf_dbg_log('qwpseo_sitemap_index: $sitemapindex: ', $sm);
	$wpseo_sitemaps->set_sitemap($sm);
	$url = home_url('i18n-index-sitemap.xml');
	$sm = '';
	foreach($q_config['enabled_languages'] as $lang){
		$sm .= '<sitemap>'.PHP_EOL;
		$sm .= '<loc>'.esc_url(qtranxf_convertURL($url,$lang,true,true)).'</loc>'.PHP_EOL;
		if(!empty($lastmod)) $sm .= '<lastmod>'.$lastmod.'</lastmod>'.PHP_EOL;
		$sm .= '</sitemap>'.PHP_EOL;
	}
	//qtranxf_dbg_log('qwpseo_sitemap_index: $sm: ', $sm);
	return $sm;
}

/*
 * Adds other language sitemaps.
function qwpseo_sitemap_index( $sm )
{
	global $q_config, $wpseo_sitemaps;
	if(isset($q_config['sitemap-type'])) return;
	//qtranxf_dbg_log('qwpseo_sitemap_index: $wpseo_sitemaps: ', $wpseo_sitemaps);
	ob_start();
	$wpseo_sitemaps->output();
	$content = ob_get_contents();
	ob_end_clean();
	//qtranxf_dbg_log('qwpseo_sitemap_index: $content: ', $content);
	$p = 0;
	$sitemaps = array();
	while(($p = strpos($content,'<sitemap>',$p))!==false){
		if(($e = strpos($content,'</sitemap>',$p)) !== false){
			$len = $e - $p + strlen('</sitemap>');
			$s = substr($content, $p, $len);
			//qtranxf_dbg_log('qwpseo_sitemap_index: $s: ', $s);
			$p += $len;
			$sitemaps[] = $s;
		}else{
			$p += strlen('<sitemap>');
		}
	}
	$sm = '';
	foreach($q_config['enabled_languages'] as $lang){
		//if($lang == $q_config['default_language']) continue;
		if($lang == $q_config['language']) continue;
		//$sm .= preg_replace('!<loc>(.*)/([^/]+)</loc>!','<loc>$1/'.$lang.'-$2</loc>',$s);
		foreach($sitemaps as $s){
			if(preg_match('!<loc>([^<]+)</loc>!',$s,$matches)){
				$loc = $matches[1];
				$sm .= preg_replace('!<loc>([^<]+)</loc>!','<loc>'.qtranxf_convertURL($loc,$lang).'</loc>',$s);
			}
		}
	}
	//qtranxf_dbg_log('qwpseo_sitemap_index: $sm: ', $sm);
	return $sm;
}
*/
add_filter( 'wpseo_sitemap_index', 'qwpseo_sitemap_index');

/**
 * Translates $p->post_content to make image lookup work correctly later.
*/
function qwpseo_enable_xml_sitemap_post_url( $loc, $p ){
	global $q_config;
	$lang = $q_config['language'];
	//qtranxf_dbg_log('qwpseo_enable_xml_sitemap_post_url: $sm: ', $p);
	$p->post_content = qtranxf_use_language($lang,$p->post_content,false,true);
	return $loc;
}
add_filter( 'wpseo_xml_sitemap_post_url', 'qwpseo_enable_xml_sitemap_post_url', 5, 2);

/**
 * Has to be disabled for now, unless we ask Yoast to add a filter to alter cache key name depending on active language.
 * @since 1.0.3
*/
function qwpseo_enable_xml_sitemap_transient_caching( $caching ){ return false; }
add_filter( 'wpseo_enable_xml_sitemap_transient_caching', 'qwpseo_enable_xml_sitemap_transient_caching' );

/**
 * 
 * @since 1.0.3
*/
function qwpseo_build_sitemap_post_type( $type )
{
	global $q_config;
	//$lang = $q_config['language'];
	if($type == 'i18n-index'){
		$q_config['sitemap-type'] = $type;
		return 1;//root map for single language
	}
	//qtranxf_dbg_log('qwpseo_build_sitemap_post_type: $type: ', $type);
	//$matches = array();
	//if(preg_match('!([^-]+)-([^-]+)!',$type,$matches)){
	//	//qtranxf_dbg_log('qwpseo_build_sitemap_post_type: $matches: ', $matches);
	//	$q_config['language'] = $matches[1];
	//	$type = $matches[2];
	//}
	return $type;
}
add_filter( 'wpseo_build_sitemap_post_type', 'qwpseo_build_sitemap_post_type', 5);

/*
function qwpseo_sitemap_entry( $url, $post_type, $p )
{
	//qtranxf_dbg_log('qwpseo_sitemap_entry: $post_type: '.$post_type.'; $url: ', $url);
	global $q_config;
	//qtranxf_dbg_log('qwpseo_sitemap_entry: $p: ', $p);
	$urls = array();
	foreach($q_config['enabled_languages'] as $lang){
		$urls[$lang] = $url;
		$urls[$lang]['loc'] = qtranxf_convertURL($url['loc'],$lang);
		if(isset($url['images'])){
			foreach($url['images'] as $k => $img){
				foreach($img as $p => $txt){
					if($p == 'src') continue;
					$urls[$lang]['images'][$k][$p] = qtranxf_use($lang,$txt,false,true);
				}
			}
		}
	}
	//qtranxf_dbg_log('qwpseo_sitemap_entry: $urls: ', $urls);
	$url['urls'] = $urls;
	return $url;
}
//add_filter( 'wpseo_sitemap_entry', 'qwpseo_sitemap_entry', 999, 3 );

function qwpseo_test_filter( $arg )
{
	//qtranxf_dbg_log('qwpseo_test_filter: $arg: ', $arg);
	return $arg;
}
add_filter( 'wpseo_opengraph_title', 'qwpseo_test_filter');
add_filter( 'wpseo_metakeywords', 'qwpseo_test_filter');
add_filter( 'wpseo_title', 'qwpseo_test_filter');
add_filter( 'wpseo_meta', 'qwpseo_test_filter');
add_filter( 'wpseo_metadesc', 'qwpseo_test_filter');
add_filter( 'wpseo_replacements', 'qwpseo_test_filter');
*/
