<?php
if(!defined('ABSPATH'))exit;

function qwpseo_add_filters_front() {
	$use_filters = array(
		'wpseo_title' => 20,
		'wpseo_meta' => 20,
		'wpseo_metadesc' => 20,
		'wpseo_replacements' => 20,
	);

	foreach ( $use_filters as $name => $priority ) {
		add_filter( $name, 'qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage', $priority );
	}
}
qwpseo_add_filters_front();

?>
