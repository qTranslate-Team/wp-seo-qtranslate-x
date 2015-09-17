=== Yoast SEO & qTranslate-X ===
Developed by: qTranslate Team
Contributors: johnclause
Tags: multilingual, language, bilingual, i18n, l10n, multilanguage, translation, Yoast SEO
Requires at least: 4.0
Tested up to: 4.4
Stable tag: 1.0.2
License: GPLv3 or later
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QEXEK3HX8AR6U
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Enables multilingual framework for plugin "Yoast SEO".

== Description ==

Enables [qTranslate-X](https://wordpress.org/plugins/qtranslate-x/) multilingual framework for plugin [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/).

At least version 3.4 of [qTranslate-X](https://wordpress.org/plugins/qtranslate-x/) is required.

This plugin is currently a work in progress, please review the [Known Issues](https://wordpress.org/plugins/wp-seo-qtranslate-x/other_notes/) and report the features, which did not work for you.

== Installation ==

Standard, as any other normal plugin hosted at WordPress.

== Screenshots ==

Plugin does not have any configuration options, and no screenshots needed.

== Frequently Asked Questions ==

= How do I open a page with configuration options? = 

Plugin does not have any configuration options, simply activate it and it will enable the translation of relevant fields for Yoast SEO back- and front-end.

== Upgrade Notice ==

No need for Upgrade Notice.

== Changelog ==

= 1.0.2 =
* Improvement: encoding of `yoast_wpseo_metadesc` and `yoast_wpseo_focuskw` is changed to '{' to deal with imperfections of Yoast java script.

= 1.0.1 =
* Improvement: added multilingual fields on `edit-tags.php` page.

= 1.0 =
* Initial release

== Known Issues ==

* Yoast SEO Page Analysis does not work correctly.
* [Resolved in plugin version 1.0.2 under qTranslate-X 3.4.4] Field 'Meta description' is not coming back correctly after saving. In some configurations it works though. The nature of conflict is not yet known. You would need to keep this field empty, if you are affected.
