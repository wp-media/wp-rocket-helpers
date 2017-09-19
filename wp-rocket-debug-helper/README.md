# WP Rocket | Debug Helper

Checks for various constants, filters, and per-page cache options, prints their values as an HTML comment in the footer of the HTML source code.

## How to use
- Once you have installed and activated the plugin, clear the cache.
- Open any page of your website in an anonymous browser window (where you are not a logged-in WordPress user).
- Switch to source view in your browser.
- Look for an HTML comment starting with `WP ROCKET DEBUG` towards the bottom of the source code view.

## Default output in HTML source view

```
<!--
####################################################
## WP ROCKET DEBUG ##
(HTML minification disabled "on the fly" by this helper plugin.)

## Constants

- constant WP_CACHE is true
- constant DONOTCACHEPAGE is not defined
- constant DONOTMINIFY is not defined
- constant DONOTMINIFYCSS is true
- constant DONOTMINIFYJS is true

## Filters

- filter do_rocket_generate_caching_files is true

## Per-page cache options:


- Cache option rocket_post_nocache: handled through do_rocket_generate_caching_files filter as listed above
- Cache option minify_html on this page is false
- Cache option minify_css on this page is false
- Cache option minify_js on this page is false
- Cache option cdn on this page is false
- Cache option async_css on this page is false
- Cache option defer_all_js on this page is false

####################################################
-->
```

To be used with:
* any setup

Last tested with:
* WP Rocket 2.10.x
* WordPress 4.9.x
