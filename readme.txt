=== Yoast SEO & qTranslate-X ===
Developed by: qTranslate Team
Contributors: johnclause
Tags: multilingual, language, bilingual, i18n, l10n, multilanguage, translation, Yoast SEO
Requires at least: 4.0
Tested up to: 4.4
Stable tag: 1.1
License: GPLv3 or later
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QEXEK3HX8AR6U
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Enables multilingual framework for plugin "Yoast SEO".

== Description ==

Enables [qTranslate-X](https://wordpress.org/plugins/qtranslate-x/) multilingual framework for plugin [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/).

At least version 3.4.5 of [qTranslate-X](https://wordpress.org/plugins/qtranslate-x/) is required.

This plugin is currently a work in progress, please review the [Known Issues](https://wordpress.org/plugins/wp-seo-qtranslate-x/other_notes/) and report the features, which did not work for you.

The biggest issue is that "Page Analysis" has not yet been fully integarated, and it is disabled unless Single Language Editor Mode is in use, which can be set on "Advanced" tab of "Languages" configuration page: `/wp-admin/options-general.php?page=qtranslate-x#advanced`. If you have time and resources, please feel free to submit pool request to the plugin [repository at GitHub](https://github.com/qTranslate-Team/wp-seo-qtranslate-x/pulls) with the implementation of "Page Analysis" for other editor modes. However, it may not be possible without asking Yoast to put a few additional filters within ["Yoast SEO" plugin code](https://github.com/Yoast/wordpress-seo).

== Installation ==

Standard, as any other normal plugin hosted at WordPress.

Remeber to set "URL Modification Mode" in qTranslate-X configuration page `/wp-admin/options-general.php?page=qtranslate-x#general` to any mode other then "Query Mode", since "Query Mode" does not make much sense for SEO.

== Screenshots ==

Plugin does not have any configuration options, and no screenshots needed.

== Frequently Asked Questions ==

= How do I open a page with configuration options? = 

Plugin does not have any configuration options, simply activate it and it will enable the translation of relevant fields for Yoast SEO back- and front-end.

= Why "Page Analysis" are disabled? =

Yoast SEO "Page Analysis" is not yet integrated and is mostly disabled to prevent confusions. It is only experimentally enabled in Single Language Editor Mode, which can be set on "Advanced" tab of "Languages" configuration page, `/wp-admin/options-general.php?page=qtranslate-x#advanced`.

If you have time and resources, please feel free to submit pool request to the plugin [repository at GitHub](https://github.com/qTranslate-Team/wp-seo-qtranslate-x/pulls) with the implementation of "Page Analysis" for other editor modes. Unfortunately, it may not be possible without asking Yoast to put a few additional filters within "Yoast SEO" plugin code.

= Sitemaps suddenly stopped working showing 404 page? =

Most likely you deactivated "Yoast SEO" plugin and then activated it again. When XML Sitemaps are enabled on Yoast "XML Sitemaps" configuration page `/wp-admin/admin.php?page=wpseo_xml` and Yoast plugin is deactivated, it clears rewrite rules needed for sitemap to function. On next activation of Yoast plugin, sitemaps no longer function until their functionality is deactivated and then activated again on Yoast configuration page "XML Sitemaps".

= Something does not work right, is it me? =

Please, review section "[Known Issues](https://wordpress.org/plugins/wp-seo-qtranslate-x/other_notes/)".

== Upgrade Notice ==

No need for an Upgrade Notice.

== Changelog ==

= 1.1 =
* Enhancement: multilingual sitemaps, require qTranslate-X 3.4.5: [Issue #1](https://github.com/qTranslate-Team/wp-seo-qtranslate-x/issues/1).
* Enhancement: moved to the new [integration](https://qtranslatexteam.wordpress.com/integration/) way using i18n-config.json file. You have to deactivate/activate plugin when updating. Normal WP update would be sufficient, but if you simply override the files, then you will miss the plugin integaration configuration.
* Enhancement: A few more fields are made multilingual.
* Fix: "Page Analysis" is disabled unlesss Single Language Editor Mode is in use. "Page Analysis" is not currently integrated in any other Editor Mode.

= 1.0.2 =
* Improvement: encoding of `yoast_wpseo_metadesc` and `yoast_wpseo_focuskw` is changed to '{' to deal with imperfections of Yoast java script.

= 1.0.1 =
* Improvement: added multilingual fields on `edit-tags.php` page.

= 1.0 =
* Initial release

== Known Issues ==

* Yoast SEO "Page Analysis" is not yet integrated and is mostly disabled to prevent confusions. It is only experimentally enabled in Single Language Editor Mode, which can be set on "Advanced" tab of "Languages" configuration page, `/wp-admin/options-general.php?page=qtranslate-x#advanced`. If you have time and resources, please feel free to submit pool request to the plugin [repository at GitHub](https://github.com/qTranslate-Team/wp-seo-qtranslate-x/pulls) with the implementation of "Page Analysis" for other editor modes. Unfortunately, it may not be possible without asking Yoast to put a few additional filters within "Yoast SEO" plugin code.
* [plugin Yoast SEO issue] When XML Sitemaps are enabled on Yoast configuration page `/wp-admin/admin.php?page=wpseo_xml` and Yoast plugin is deactivated, it clears rewrite rules needed for sitemap to function. On next activation of Yoast plugin, sitemaps no longer function until their functionality is deactivated and then activated again on Yoast configuration page "XML Sitemaps".
* [Resolved in plugin version 1.0.2 under qTranslate-X 3.4.4] Field 'Meta description' is not coming back correctly after saving. In some configurations it works though. The nature of conflict is not yet known. You would need to keep this field empty, if you are affected.
* [not really an issue] Sitemaps do not work quite right in Query URL Modification Mode. Query Mode is not supposed to be used for SEO.
