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

/*
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

function qwpseo_sitemap_urlimages( $images, $id )
{
	//qtranxf_dbg_log('qwpseo_sitemap_urlimages('.$id.'): $images: ',$images);
	$srcs = array();
	foreach($images as $k => $image){
		$src = $image['src'];
		if(isset($srcs[$src])){
			unset($images[$k]);
		}else{
			$srcs[$src] = $image;
		}
	}
	return $images;
}
add_filter( 'wpseo_sitemap_urlimages', 'qwpseo_sitemap_urlimages', 999, 2);

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
add_filter( 'wpseo_sitemap_entry', 'qwpseo_sitemap_entry', 999, 3 );


/*
function qwpseo_sitemap_index( $sitemap )
{
	//qtranxf_dbg_log('qwpseo_sitemap_entry: $sitemap: ', $sitemap);
	return $sitemap;
}
add_filter( 'wpseo_sitemap_index', 'qwpseo_sitemap_index', 10 );
*/
?>
