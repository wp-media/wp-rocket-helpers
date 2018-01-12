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
Note: Minify HTML is dynamically disabled, so this debug notice can be displayed.

## Constants

- constant WP_CACHE is: TRUE
- constant DONOTCACHEPAGE is: not defined
- constant DONOTMINIFY is: not defined
- constant DONOTMINIFYCSS is: not defined
- constant DONOTMINIFYJS is: not defined

## Filters
Note: Filter `rocket_override_donotcachepage` gets set by WP Rocket core in certain environments.)

- filter do_rocket_generate_caching_files is: not set
- filter rocket_override_donotcachepage is: default ('rocket_override_donotcachepage_on_thrive_leads')

## Cache Options metabox
Note: You’re viewing post ID #1

- This post is not excluded from caching via “Never cache this page”, or “Never cache (URL)”
- Cache option lazyload: unchanged
- Cache option lazyload_iframes: unchanged
- Cache option minify_html: unchanged
  (Remember: Minify HTML is dynamically disabled, so this debug notice can be displayed.)
- Cache option minify_css: unchanged
- Cache option minify_js: unchanged
- Cache option cdn: unchanged
- Cache option async_css: unchanged
- Cache option defer_all_js: unchanged


####################################################
-->
```

To be used with:
* any setup

Last tested with:
* WP Rocket 2.11.x
* WordPress 4.9.x
