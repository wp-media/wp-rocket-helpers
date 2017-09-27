# WP Rocket | VG Wort Pixel

Disables LazyLoad for VG Wort tracking pixels.

Notes:
* __Will work only for tracking pixels added as images to post content (HTML) directly; will not work for images added to theme templates; not tested with any of the available [VG Wort plugins](https://de.wordpress.org/plugins/tags/vg-wort/).__ Authors of those plugins are encouraged to use this plugin as a boilerplate for making their plugins compatible with LazyLoad.
* Uses [`the_content` hook](https://developer.wordpress.org/reference/hooks/the_content/), thus will work only for content that gets displayed through [`the_content()` function](https://developer.wordpress.org/reference/functions/the_content/). This should cover 99% of all themes. However, if your content gets displayed via [`get_the_content()`](https://developer.wordpress.org/reference/functions/get_the_content/) instead, this plugin will not work for you.
* Currently applies to any content, no matter of post type, or post template. If you want it applied only on single post views, customise with [conditional tags](https://developer.wordpress.org/themes/basics/conditional-tags/) inside of function `wp_rocket__vg_wort_pixel()`.
* Not tested with images applied via shortcodes.

Documentation:
* [Disabling LazyLoad on specific images](http://docs.wp-rocket.me/article/15-disabling-lazy-load-on-specific-images)

To be used with:
* any setup where LazyLoad is active and post content contains a [VG Wort](http://www.vgwort.de/) tracking pixel (“Zählpixel”)

Last tested with:
* WP Rocket 2.10.x
* WordPress 4.8.x
