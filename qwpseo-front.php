<?php
if(!defined('ABSPATH'))exit;

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
 * Adds other language sitemaps.
 * @since 1.0.3
*/
function qwpseo_sitemap_index( $sm )
{
	global $q_config, $wpseo_sitemaps;
	//qtranxf_dbg_log('qwpseo_sitemap_index: $wpseo_sitemaps: ', $wpseo_sitemaps);
	ob_start();
	$wpseo_sitemaps->output();
	$content = ob_get_contents();
	ob_end_clean();
	//qtranxf_dbg_log('qwpseo_sitemap_index: $content: ', $content);
	$sm = '';
	$p = 0;
	while(($p = strpos($content,'<sitemap>',$p))!==false){
		if(($e = strpos($content,'</sitemap>',$p)) !== false){
			$len = $e - $p + strlen('</sitemap>');
			$s = substr($content, $p, $len);
			//qtranxf_dbg_log('qwpseo_sitemap_index: $s: ', $s);
			foreach($q_config['enabled_languages'] as $lang){
				//if($lang == $q_config['default_language']) continue;
				if($lang == $q_config['language']) continue;
				//$sm .= preg_replace('!<loc>(.*)/([^/]+)</loc>!','<loc>$1/'.$lang.'-$2</loc>',$s);
				if(preg_match('!<loc>([^<]+)</loc>!',$s,$matches)){
					$loc = $matches[1];
					$sm .= preg_replace('!<loc>([^<]+)</loc>!','<loc>'.qtranxf_convertURL($loc,$lang).'</loc>',$s);
				}
			}
			$p += $len;
		}else{
			$p += strlen('<sitemap>');
		}
	}
	//qtranxf_dbg_log('qwpseo_sitemap_index: $sm: ', $sm);
	return $sm;
}
add_filter( 'wpseo_sitemap_index', 'qwpseo_sitemap_index');

/**
 * Has to be disabled for now, unless we ask Yoast to filter cache key to make it depend on active language.
 * @since 1.0.3
*/
function qwpseo_enable_xml_sitemap_transient_caching( $caching ){ return false; }
add_filter( 'wpseo_enable_xml_sitemap_transient_caching', 'qwpseo_enable_xml_sitemap_transient_caching' );

/*
function qwpseo_build_sitemap_post_type( $type )
{
	global $q_config;
	//qtranxf_dbg_log('qwpseo_build_sitemap_post_type: $type: ', $type);
	$matches = array();
	if(preg_match('!([^-]+)-([^-]+)!',$type,$matches)){
		//qtranxf_dbg_log('qwpseo_build_sitemap_post_type: $matches: ', $matches);
		$q_config['language'] = $matches[1];
		$type = $matches[2];
	}
	return $type;
}
add_filter( 'wpseo_build_sitemap_post_type', 'qwpseo_build_sitemap_post_type', 5);

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
