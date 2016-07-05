/* executed for
 /wp-admin/term.php
*/
jQuery(document).ready(
function($){

	var qtx = qTranslateConfig.js.get_qtx();

	var h = qtx.hasContentHook('description');
	if(!h)
		return;

	var d = $('#edittag').find('#description');
	if(!d.length)
			return;

	//Yoast will delete this field in 
	var contents = qtranxj_split(d.val());
	h.contentField.value = contents[qTranslateConfig.activeLanguage];
	for(var lang in h.fields){
		h.fields[lang].value = contents[lang];
	}
	d.val(h.contentField.value);
});
