# WP Rocket Helpers
This repository hosts a number of plugins that target specific use cases for WP Rocket.

WP Rocket is known to be straight-forward and easy to use. However, sometimes a specific use case might require to alter its functionality.

The plugins in this repository provide solutions for some of the more common use cases that still seem too “edge case” to be included as options in WP Rocket’s user interface.

## 📋 TL;DR
> - Helper Plugins, like WP Rocket, require PHP 5.4+.
> - Helper Plugins by design don’t have version numbers, because we don’t maintain them on a regular basis.
> - Helper Plugins provide a sustainable way to customize WP Rocket’s behaviour, because they’re easier to spot than code snippets hidden in functions.php.
> - 🚀 **All plugins from this repository require [WP Rocket](https://wp-rocket.me/) to be up and running on your WordPress site.** If you don’t use WP Rocket on your WordPress site, don’t install any of these plugins.
> - ☝️ **Test before use!** We don’t maintain all of these helper plugins actively at all times; some may target older versions of WP Rocket, or of other plugins. Some may even become outdated over time.

## Table of contents

1. [General notes](#1-general-notes)
   - [What are Helper Plugins?](#11-what-are-helper-plugins)
   - [Whom are Helper Plugins for?](#12-whom-are-helper-plugins-for)
   - [What are Helper Plugins not?](#13-what-are-helper-plugins-not)
2. [Minimum requirements](#2-minimum-requirements)
3. [How to use](#3-how-to-use)
   - [Installation](#31-installation)
   - [Support](#32-support)
4. [Naming conventions](#4-naming-conventions)
   - [Namespaces and functions](#41-namespaces-and-functions)
   - [Naming placeholder URLs, domains, values](#42-naming-placeholder-urls-domains-values)
5. [License](#5-license)
6. [Questions?](#6-questions)
7. [Helper plugin index](#7-helper-plugin-index)

---

## 1. General notes
### 1.1. What are Helper Plugins?
We use the term _“Helper Plugin”_ to describe a simple WordPress plugin that customizes the behaviour of WP Rocket in some sort of way.

A Helper Plugin usually consists of 1 single PHP file, wrapped in a folder, downloadable and installable as a regular ZIP.

> 💡 **The main idea of Helper Plugins is easy-to-spot customizations.**<br>
> Other than code snippets dumped into functions.php files, customizations that come wrapped in a little plugin can be spotted at a glance.

### 1.2. Whom are Helper Plugins for?
Helper Plugins are for all types of WP Rocket users:

* People who just know how to upload a WordPress plugin
* Technically well-versed site owners
* Experienced developers
* Our own support crew

#### WP Rocket users
If you don’t write code on a daily basis, you may want to [contact our support team](https://wp-rocket.me/support/) before using any of these plugins. (That is, unless you had contacted us already, and we sent you here.)

#### Developers
For developers and other code-savvy folk, many of WP Rocket’s functions, filters and action hooks used in these plugins are documented in our [developer docs](http://docs.wp-rocket.me/collection/86-codex).

### 1.3. What are Helper Plugins not?
**Helper Plugins are not works of elaborate software development.**
They are certainly not [OOP](https://en.wikipedia.org/wiki/Object-oriented_programming), nor even class-based—just simple, procedural functions.

**Helper Plugins are not versioned, changelogged, or maintained in the usual sense.**
We don’t guarantee that all Helper Plugins work with all WP Rocket versions at all times; however, when a Helper Plugin gets published, or updated, it usually sports a basic _“Last tested with”_ section in the README file.

## 2. Minimum requirements
Helper Plugins fall under the same minimum requirements as WP Rocket: **PHP 5.4** or greater, and **WordPress 3.1** or greater at the moment of this writing (early 2018).

## 3. How to use

- Each sub-folder in this repository contains at least 1 PHP file and 1 ZIP file.
- PHP files are for code-savvy people to take a look at what the plugin does.
- The ZIP file is the one you can download and install in WordPress.

> 💡 **Need help with downloading?**<br>
> Here’s an [animated GIF](/how-to-download-zip.gif) on how to download one of the ZIP files from this repository._

### 3.1. Installation

- Download one of the ZIP files from this repository.
- Don’t unpack it! If your browser unpacks it automatically (can happen e.g. with Safari), you will have to re-ZIP it before proceeding.
- Install the ZIP file through your WordPress admin interface: Go to _Plugins→Add&#160;new→Upload_, upload the ZIP file and activate the plugin.

### 3.2. Support
Support for WP Rocket is our business.&#160;🙂 <br>
**Got a valid license for WP Rocket?** Feel free to use our dedicated [support form](https://wp-rocket.me/support/)!<br>
**Don’t own a valid license?** You can get one [right here](https://wp-rocket.me/pricing/)!

## 4. Naming conventions
> 💡 **Folder names help grouping a folder in a list of other folders.**<br>
> That’s why folder names for these Helper Plugins start with a `wp-rocket`- prefix, followed by feature and action keywords.

While file lists are not always sorted by name, it’s the default sort on GitHub and in many FTP clients.

Inside the WordPress plugin folder, a Helper Plugin should be listed next to WP Rocket itself, so a user or support agent can easily spot it.

In this GitHub repository, plugins that address the same feature (cache, lazyload, .htaccess rewrites …) are listed in groups, thus making it easier to skim the repo for a specific plugin.

### 4.1. Namespaces and functions
> 💡 **We use PHP namespaces to improve readability.**<br>
> Replacing verbose function prefixes with a PHP namespace can make actual function names more comprehensive, and our code remains easy to read.

It’s easy to over-engineer naming conventions, so we stick to a pragmatic rule of thumb when in doubt:

1. Namespaces should be unique and consistent.
2. Function names should be descriptive.

We rely on one consistent namespace for all Helper Plugins, and descriptive subnamespaces for each plugin:

```php
namespace WP_Rocket\Helpers\{subnamespace(s)}
```

Or more specifically:

```php
namespace WP_Rocket\Helpers\{feature}\{what_this_plugin_does}
```

Example:
```php
namespace WP_Rocket\Helpers\cache\no_cache_for_admins;

function handle_cache_for_admins() {
    // Handle caching for logged-in administrators.
}
add_action( 'init', __NAMESPACE__ . '\handle_cache_for_admins' );
```

### 4.2. Naming placeholder URLs, domains, values
There is one domain on the internet for the sole purpose of _“illustrative examples in documents”_: [example.com](https://example.com/)

You can safely use it as anything you want:

```
https://example.com
http://example.com
https://sub-domain.example.com
person@example.com
ftp.example.com
```

> 💡 **Placeholders must be replaced!**<br>
> Whenever you see `example.com` in the code of a Helper Plugin, make sure you replace it with a custom value before you activate the plugin!

## 5. License

All plugins in this repository, like WordPress and WP Rocket, are licensed under [GNU General Public License v2 or later](/LICENSE).

## 6. Questions?

Shoot us a message at: [wp-rocket.me/contact/](https://wp-rocket.me/contact/?nocache)

## 7. Helper plugin index

The helpers are grouped by feature. Each name links to its folder, where you can review the code, read any plugin-specific instructions, and download the ZIP file when one is provided.

> [!IMPORTANT]
> Review and customize each helper before use, test it on a staging site, and confirm compatibility with your versions of WordPress, WP Rocket, and any related plugins. Items in **Experimental** may require advanced setup; items in **Deprecated** are retained for reference and should not be used on current installations.


### Cache

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Add Custom Cache Query Strings](cache/wp-rocket-add-custom-cache-query-strings/) | Adds custom query strings to WP Rocket's cache list that would normally be ignored. |
| [WP Rocket \| Common Cache For Logged-in Users](cache/wp-rocket-cache-common-cache-loggedin/) | Uses one shared cache for all logged-in users instead of creating a user-specific cache; logged-out users keep a separate cache. |
| [WP Rocket \| Domain Ending Length](cache/wp-rocket-cache-domain-ending/) | Sets a custom length for TLD endings to pass WP Rocket’s domain validation. |
| [WP Rocket \| Force Page Caching](cache/wp-rocket-cache-donotcachepage/) | Ensures caching even when <code>DONOTCACHEPAGE</code> is set. |
| [WP Rocket \| Cache Dynamic Cookie](cache/wp-rocket-cache-dynamic-cookie/) | Adds a dedicated dynamic cache for a defined cookie ID. |
| [WP Rocket \| Cache Feed](cache/wp-rocket-cache-feed/) | Enables WP Rocket caching for WordPress RSS feeds. |
| [WP Rocket \| Ignore Query Strings](cache/wp-rocket-cache-ignore-query-strings/) | Defines query strings that should share the same cached page. |
| [WP Rocket \| Set a Mandatory Cookie](cache/wp-rocket-cache-mandatory-cookie/) | Adds a mandatory cookie to WP Rocket config. |
| [WP Rocket \| Manipulate buffer](cache/wp-rocket-cache-manipulate-buffer/) | Searches the output buffer for configured strings and replaces them with custom values. |
| [WP Rocket \| Remove Custom Post URLs from purge](cache/wp-rocket-cache-no-purge-urls/) | Removes a custom set of URLs from WP Rocket’s automatic cache purging when a post is updated. |
| [WP Rocket \| Toolbar Clear Cache Link](cache/wp-rocket-cache-purge-toolbar-link/) | Adds a “Clear cache” link to the toolbar for users who can publish posts. |
| [WP Rocket \| Purge Custom Post URLs](cache/wp-rocket-cache-purge-urls/) | Purges a custom set of URLs in addition to WP Rocket’s automatic cache purge when a post is updated. |
| [WP Rocket \| Cache WP Rest API](cache/wp-rocket-cache-rest-api/) | Forces WP Rocket to cache WordPress REST API responses. |
| [WP Rocket \| Cache Status Resync](cache/wp-rocket-cache-resync/) | Synchronizes the cache table with the cache directory after each automatic cache purge. |
| [WP Rocket \| Cache Search Results](cache/wp-rocket-cache-search-results/) | Enables caching for search result pages. |
| [WP Rocket \| Enable SSL Cache](cache/wp-rocket-cache-ssl/) | Enables SSL cache so that WP Rocket caches pages with SSL. |
| [WP Rocket \| Set Tablets As Mobile](cache/wp-rocket-cache-tablet/) | Treats tablets as mobile devices instead of desktop devices. Useful for themes that rely on <code>wp_is_mobile()</code>. |
| [WP Rocket \| Customize Mobile Cache options](cache/wp-rocket-customize-mobile-cache/) | Customizes WP Rocket’s default mobile-cache settings. |
| [WP Rocket \| Disable Page Cache](cache/wp-rocket-disable-page-cache/) | Disables page caching and, optionally, other optimizations. |
| [WP Rocket \| Disable URL Validation](cache/wp-rocket-disable-url-validation/) | Disables WP Rocket's URL validation to allow caching of invalid taxonomy pages. |
| [WP Rocket \| Logging cache clearing](cache/wp-rocket-logging-cache-clearing/) | Logs full and partial cache-clearing events. |
| [WP Rocket \| Disable Page Caching](cache/wp-rocket-no-cache/) | Disables WP Rocket’s page cache while preserving other optimization features. |
| [WP Rocket \| Disable Cache Clearing](cache/wp-rocket-no-cache-auto-purge/) | Disables all of WP Rocket’s automatic cache clearing. |
| [WP Rocket \| Disable Cache Clearing When Slug Change](cache/wp-rocket-no-cache-auto-purge-slug-change/) | Disables WP Rocket’s automatic cache clearing when a page or post slug changes. |
| [WP Rocket \| No Cache for Admins](cache/wp-rocket-no-cache-for-admins/) | Disables WP Rocket caching and optimizations for logged-in administrators. |
| [WP Rocket \| Disable Page Caching for Attachment Pages](cache/wp-rocket-no-cache-for-attachments/) | Disables WP Rocket’s page cache file generation on WordPress Attachment pages while preserving other optimization features. |
| [WP Rocket \| Disable Cache for Posts under a Category](cache/wp-rocket-no-cache-for-category/) | Disables caching and optimizations for posts in a specific category. |
| [WP Rocket \| Disable Page Caching For Specific Pages or Posts](cache/wp-rocket-no-cache-for-page/) | Disables WP Rocket’s page cache file generation on specific pages while preserving other optimization features. |
| [WP Rocket \| Disable Page Caching For Logged-In Users](cache/wp-rocket-no-cache-logged-in/) | Disables WP Rocket’s page cache for logged-in users (User Cache) while preserving other optimization features. |
| [WP Rocket \| Disable Cache Clearing On Widget Update](cache/wp-rocket-no-cache-purge-widget-update/) | Disables WP Rocket cache clearing when a widget is updated. |
| [WP Rocket \| Shortcode based cache exclusions](cache/wp-rocket-no-cache-shortcodes/) | Excludes posts from caching and optimization when their content contains configured shortcodes. |
| [WP Rocket \| Disable Cache and Optimizations on specific pages](cache/wp-rocket-no-cache-slugs/) | Uses slugs to disable WP Rocket caching and optimizations on specific pages or posts. |
| [WP Rocket \| Regex Exclusions](cache/wp-rocket-no-cache-urls-regexes/) | Adds custom cache exclusions based on real Regular Expressions. |
| [WP Rocket \| Disable Page Caching with exception URLs](cache/wp-rocket-no-cache-with-exception-urls/) | Disables WP Rocket’s page cache while preserving other optimization features on all pages except for the selected URLs. |
| [WP Rocket \| Set Dynamic and Mandatory Cookies](cache/wp-rocket-set-dynamic-and-mandatory-cookies/) | Adds mandatory and dynamic cookies to WP Rocket’s configuration. |
| [WP Rocket \| Taxonomy Cache Override](cache/wp-rocket-taxonomy-cache-override/) | Removes WP Rocket's taxonomy validation filters to allow caching of invalid taxonomy pages. |
| [WP Rocket \| Clean related translations (WPML)](cache/wp-rocket-wpml-clean-related-translations/) | Clears the cache of related translations and their categories when updating a post, page, product or any other specified post type to keep the translations in sync. |

### Compatibility

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| EDD Cookie Cache](compatibility/wp-rocket-compat-edd-cart-widget/) | Sets a custom cookie for WP Rocket to generate cache files from, in order to keep the EDD cart widget in sync. |
| [WP Rocket \| No LazyLoad for Essential Grid](compatibility/wp-rocket-compat-essential-grid/) | Disables WP Rocket’s LazyLoad feature on pages with <a href="https://www.themepunch.com/portfolio/essential-grid-wordpress-plugin/">Essential Grid</a>. |
| [WP Rocket \| No LazyLoad for iframes on LeadPages](compatibility/wp-rocket-compat-leadpages/) | Disables LazyLoad for iframes/videos on LeadPages. |
| [WP Rocket \| Varnish IP](compatibility/wp-rocket-compat-varnish-ip/) | Sets a custom Varnish IP to sync WP Rocket’s cache with. |
| [WP Rocket \| Varnish IP with Proxy](compatibility/wp-rocket-compat-varnish-ip-proxy/) | Sets a custom Varnish IP and host name to sync WP Rocket’s cache with when using a proxy. |
| [WP Rocket \| VG Wort Pixel](compatibility/wp-rocket-compat-vg-wort-pixel/) | Disables LazyLoad for VG Wort tracking pixels. |
| [WP Rocket \| Deactivate WooCommerce Refresh Cart Fragments Cache](compatibility/wp-rocket-compat-wc-cart-fragments/) | Disables WP Rocket’s cache for WooCommerce cart-fragment refreshes. |
| [WP Rocket \| Clean Post Cache after WooCommerce Order](compatibility/wp-rocket-compat-wc-order-clean-cache/) | Cleans the cache for each product ordered after a WooCommerce order has been completed. |
| [WP Rocket \| No LazyLoad for WooCommerce Product Images](compatibility/wp-rocket-compat-wc-product-images/) | Disables LazyLoad on WooCommerce main shop page, product category pages, product tag pages, and single product pages. |
| [WP Rocket \| WooCommerce Recently Viewed Products Widget Integration](compatibility/wp-rocket-compat-wc-recently-viewed-widget/) | Adds a dedicated cache based on each value of the <code>woocommerce_recently_viewed</code> cookie. |
| [WP Rocket \| YITH WooCommerce Recently Viewed Products Integration](compatibility/wp-rocket-compat-yith-wc-recently-viewed/) | Adds a dedicated cache based on each value of the <code>yith_wrvp_products_list</code> cookie. |
| [WP Rocket \| Exclude Files from Async CSS](compatibility/wp-rocket-static-exclude-opt-css-generatepress-woocommerce/) | Excludes GeneratePress WooCommerce CSS files from Optimize CSS Delivery. |
| [WP Rocket \| Varnish Customize Parameters](compatibility/wp-rocket-varnish-config/) | Sets a custom Varnish IP and host name to sync WP Rocket’s cache with. |

### <code>.htaccess</code>

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Change Expires](htaccess/wp-rocket-htaccess-change-expires/wp-rocket-htaccess-change-expires/) | Changes the browser-cache expiration values set by WP Rocket. |
| [WP Rocket \| Change RSS Expires](htaccess/wp-rocket-htaccess-change-rss-expires/) | Disables the browser caching for RSS. |
| [WP Rocket \| Add Compressed Assets htaccess rules](htaccess/wp-rocket-htaccess-compressed-assets-rules/) | Adds compressed-asset rewrite rules to the <code>.htaccess</code> file. |
| [WP Rocket \| Add custom htaccess rules](htaccess/wp-rocket-htaccess-custom-rules/) | Adds custom rules to the <code>.htaccess</code> file. |
| [WP Rocket \| Add custom htaccess rules to set no-store on HTML](htaccess/wp-rocket-htaccess-custom-rules-no-store-html/) | Adds <code>no-store</code> rules for HTML to prevent logged-in and logged-out cache conflicts. |
| [WP Rocket \| No CORS for Fonts](htaccess/wp-rocket-htaccess-fonts-no-cors/) | Prevents WP Rocket from automatically adding CORS rules for web fonts to the .htaccess file. |
| [WP Rocket \| Redirect HTTP to HTTPS](htaccess/wp-rocket-htaccess-https/) | Adds rules to the .htaccess file in order to always redirect HTTP requests to HTTPS. |
| [WP Rocket \| Remove HTML Expires from .htaccess rules](htaccess/wp-rocket-htaccess-no-expires-html/) | Removes HTML expiration directives from WP Rocket’s <code>.htaccess</code> rules. |
| [WP Rocket \| No GZIP compression](htaccess/wp-rocket-htaccess-no-gzip/) | Removes GZIP-related .htaccess rules. |
| [WP Rocket \| Redirect non-www to www](htaccess/wp-rocket-htaccess-nonwww-www/) | Redirects traffic from non-www to www URLs. |
| [WP Rocket \| Remove All .htacces Rules](htaccess/wp-rocket-htaccess-remove-all/) | Removes all of WP Rocket’s rules from .htaccess (e.g. in order to fix an error 500). |
| [WP Rocket \| Remove Charset Rules](htaccess/wp-rocket-htaccess-remove-charset/) | Removes the Charset Rules block of WP Rocket from .htaccess. |
| [WP Rocket \| Remove ETag](htaccess/wp-rocket-htaccess-remove-etag/) | Prevents ETag directives from being added to <code>.htaccess</code>. |
| [WP Rocket \| Remove expires headers](htaccess/wp-rocket-htaccess-remove-expires/) | Removes Rocket’s expire headers rules from .htaccess. |
| [WP Rocket \| Remove GZIP (mod_deflate) rules](htaccess/wp-rocket-htaccess-remove-gzip/) | Removes WP Rocket’s GZIP rules from .htaccess. |
| [WP Rocket \| Remove Rewrite Rules](htaccess/wp-rocket-htaccess-remove-rewrites/) | Removes Rewrite Rules block of WP Rocket from .htaccess. |
| [WP Rocket \| Remove Trailing Slash from URLs](htaccess/wp-rocket-htaccess-remove-trailing-slash/) | Removes Trailing Slash from URLs. |
| [WP Rocket \| Remove X-Powered-By: WP Rocket from headers](htaccess/wp-rocket-htaccess-remove-x-powered-by/) | This helper plugin removes WP Rocket’s x-powered-by signature from the response headers. |
| [WP Rocket \| Enforce Trailing Slash on URLs](htaccess/wp-rocket-htaccess-trailing-slash/) | Enforces Trailing Slash on URLs. |
| [WP Rocket \| Enforce Trailing Slash on multisite](htaccess/wp-rocket-htaccess-trailing-slash-multisite/) | Enforces Trailing Slash on URLs. |
| [WP Rocket \| Redirect www to non-www](htaccess/wp-rocket-htaccess-www-nonwww/) | Redirects traffic from www to non-www URLs. |
| [WP Rocket \| No .htaccess](htaccess/wp-rocket-no-htaccess/) | Completely disables WP Rocket’s use of <code>.htaccess</code>. |

### LazyLoad

| Name | Description / use case |
| --- | --- |
| [WP Rocket - Custom LazyLoad Placeholder](lazyload/wp-rocket-custom-lazyload-placeholder/) | Replaces the WP Rocket LazyLoad placeholder with a transparent 1x1 GIF. |
| [WP Rocket \| Enable Native Lazyload](lazyload/wp-rocket-enable-native-lazyload/) | Enables the application of native lazyload. |
| [WP Rocket \| Exclude images from LazyLoad per page](lazyload/wp-rocket-exclude-images-from-lazyload-per-page/) | Disables LazyLoad for selected images on specific pages. |
| [WP Rocket \| Exclude X first images from Lazy Load by Attribute](lazyload/wp-rocket-exclude-x-first-images-by-attribute/) | Excludes the first configured number of matching images from LazyLoad based on an attribute. |
| [WP Rocket \| No LazyLoad for Custom Image Classes](lazyload/wp-rocket-lazyload-disable-class/) | Disables LazyLoad for images classes specified in this plugin. |
| [WP Rocket \| No LazyLoad for Custom Image Sources](lazyload/wp-rocket-lazyload-disable-src/) | Disables LazyLoad for image sources specified in this plugin. |
| [WP Rocket \| LazyLoad Threshold](lazyload/wp-rocket-lazyload-threshold/) | Defines a custom loading threshold for lazy-loaded images. |
| [WP Rocket \| YouTube Preview Image Resolution](lazyload/wp-rocket-lazyload-youtube-preview-image/) | Customizes the resolution of the YouTube preview image for videos. |
| [WP Rocket \| No LazyLoad](lazyload/wp-rocket-no-lazyload/) | Disables LazyLoad for specified page types. |
| [WP Rocket \| Disable LazyLoad on Background Images](lazyload/wp-rocket-no-lazyload-background-images/) | Disables WP Rocket LazyLoad on background images. |
| [WP Rocket \| No LazyLoad for Mobile Devices (Mobile Cache only)](lazyload/wp-rocket-no-lazyload-mobile-cache/) | Disables LazyLoad for mobile devices when Mobile Cache with separate cache files is active. |
| [WP Rocket \| No LazyLoad for Mobile Devices](lazyload/wp-rocket-no-lazyload-mobile-no-cache/) | Disables LazyLoad for mobile devices when Separate Cache for Mobile devices option is active. |
| [WP Rocket \| No LazyLoad On Search Results](lazyload/wp-rocket-no-lazyload-search-results/) | Disables LazyLoad on search result pages. |
| [WP Rocket \| Use Only Native Lazyload](lazyload/wp-rocket-use-only-native-lazyload/) | Makes all images use native lazyload. |

### Preload

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Custom cURL Timeout For Preload Requests](preload/wp-rocket-custom-preload-curl-timeout/) | Increases the cURL timeout for preload requests from the default five seconds. |
| [WP Rocket \| Customize Preload Links Config](preload/wp-rocket-customize-preload-links-config/) | Excludes specific URL patterns and image or file extensions from Preload Links. |
| [WP Rocket \| Clear Preload Errors](preload/wp-rocket-preload-clear-errors/) | Deletes the transient that stores preload errors on activation. |
| [WP Rocket \| Preload Customize Sitemap](preload/wp-rocket-preload-customize-sitemaps/) | Customizes preload by modifying the sitemaps WP Rocket uses. |
| [WP Rocket \| Preload dynamic cookie values](preload/wp-rocket-preload-dynamic-cookies/) | Allows the preload of custom cookie values when using Dynamic Cookies. |
| [WP Rocket \| HTACCESS Authorization For Preload](preload/wp-rocket-preload-htaccess-auth/) | Adds the .htaccess username and password to the preload request so that WP Rocket can preload pages that are password protected. |
| [WP Rocket \| Preload Sitemap Control](preload/wp-rocket-preload-sitemap-control/) | Controls preload by adding or removing sitemaps from WP Rocket’s list. |
| [WP Rocket \| Only preload URLs in a sitemap](preload/wp-rocket-preload-sitemap-lock/) | Restricts preload to URLs present in a specific sitemap. |

### Priority Elements

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Exclude elements from Automatic Lazy Rendering](priority-elements/automatic-lazy-rendering/wp-rocket-automatic-lazy-rendering-exclude/) | Excludes specific elements from Automatic Lazy Rendering. |
| [WP Rocket \| Automatic Lazy Rendering Parameters](priority-elements/automatic-lazy-rendering/wp-rocket-automatic-lazy-rendering-parameters/) | Customizes the parameters used by Automatic Lazy Rendering. |
| [WP Rocket \| Disable Automatic Lazy Rendering](priority-elements/automatic-lazy-rendering/wp-rocket-disable-automatic-lazy-rendering/) | Disables Automatic Lazy Rendering. |
| [WP Rocket \| Critical Images Parameters](priority-elements/critical-images/wp-rocket-critical-images-parameters/) | Customizes the parameters used by Optimize Critical Images. |
| [WP Rocket \| Disable Critical Images Optimization](priority-elements/critical-images/wp-rocket-disable-critical-images-optimization/) | Disables Optimize Critical Images. |
| [WP Rocket \| Disable Preconnect to external domains](priority-elements/preconnect-external-domains/wp-rocket-disable-preconnect-external-domains/) | Disables WP Rocket's Preconnect to external domains. |
| [WP Rocket \| Exclude Fonts from Preload Fonts](priority-elements/preload-fonts/wp-rocket-preload-fonts-exclude/) | Excludes specific fonts from Font Preload with the <code>rocket_preload_fonts_excluded_fonts</code> filter. |
| [WP Rocket \| Clear Priority Elements of Specific Pages](priority-elements/wp-rocket-clear-priority-elements-specific-pages/) | Clears Priority Elements of specific pages when specified actions occur. |
| [WP Rocket \| Disable Priority Elements](priority-elements/wp-rocket-disable-priority-elements/) | Disables the Priority Elements optimizations, which includes Automatic Lazy Rendering, Optimize Critical Images, and Preconnect to External Domains. |

### Remove Unused CSS

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Clear the Used CSS of Related Posts](rucss/clear-related-used-css/) | Clears the Used CSS of related posts, after a post has been updated. |
| [WP Rocket \| Conditionally Disable Remove Unused CSS](rucss/wp-rocket-conditionally-disable-remove-unused-css/) | Disables Remove Unused CSS for groups of pages based on their URL slugs. |
| [WP Rocket \| Disable automatic RUCSS IP safelist on Wordfence](rucss/wp-rocket-disable-automatic-rucss-ip-safelist-on-wordfence/) | Stops WP Rocket from automatically adding Remove Unused CSS service IPs to the Wordfence allowlist. |
| [WP Rocket \| Disable Used CSS Fonts Preload](rucss/wp-rocket-disable-used-css-font-preload/) | Disables the preloading of fonts found in the used CSS. |
| [WP Rocket \| Logging cron periodicity](rucss/wp-rocket-log-cron-periodicity/) | Logs WP-Cron recurrence intervals for debugging. |
| [WP Rocket \| Modify the Used CSS](rucss/wp-rocket-modify-used-css/) | Allows various modifications to the contents of the Used CSS generated by Remove Unused CSS. |
| [WP Rocket \| Reduce failed RUCSS jobs clearing interval](rucss/wp-rocket-reduce-failed-rucss-jobs-clearing-interval/) | Temporary fix only. Reduce failed RUCSS jobs clearing interval for cases that require less than the default 3 days. |
| [WP Rocket \| Clear the Used CSS of related posts and taxonomies](rucss/wp-rocket-rucss-clean-related/) | Clears the Used CSS of related posts and categories after a post has been updated. |
| [WP Rocket - RUCSS Debugger](rucss/wp-rocket-rucss-debugger/) | A debugging tool for Remove Unused CSS. |
| [WP Rocket \| Fix encoded characters in the Used CSS](rucss/wp-rocket-rucss-fix-encoding/) | Allows filtering the contents of the Used CSS generated by Remove Unused CSS. |
| [WP Rocket \| RUCSS Set Minimum Acceptable Size](rucss/wp-rocket-rucss-minimum-css-size/) | Rejects Used CSS below a configurable minimum size to help prevent broken layouts. |

### CSS and JavaScript optimization

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Change Delay JS Execution Script](static-files/wp-rocket-change-delay-js-execution-script/) | Change the Delay JavaScript Execution Feature's Script. |
| [WP Rocket \| Change Google fonts display attribute](static-files/wp-rocket-change-google-fonts-swap/) | Changes Google fonts' "display" attribute. |
| [WP Rocket \| Disable Google Font Optimization](static-files/wp-rocket-disable-google-font-optimization/) | Disable Google Font Optimization in WP Rocket. |
| [WP Rocket \| Exclude Post Types and Taxonomies from CPCSS generation](static-files/wp-rocket-exclude-cpt-taxonomy-opt-css/) | Exclude Post Types and Taxonomies from the Optimize CSS Delivery feature. |
| [WP Rocket \| Exclude Uploaded Elementor CSS from CPCSS](static-files/wp-rocket-exclude_elementor_uploaded_css/) | Excludes all CSS files in the uploads/elementor/css by elementor from CPCSS. |
| [WP Rocket \| Disable Remove Unused CSS For Specific Pages or Posts](static-files/wp-rocket-no-rucss-for-page/) | Disables WP Rocket’s Remove Unused CSS feature on specific pages. |
| [WP Rocket \| Change CPCSS sample URLs](static-files/wp-rocket-static-change-cpcss-sample-urls/) | Change CPCSS URL we use to build CPCSS for each post type. |
| [WP Rocket \| CPCSS Debug Helper](static-files/wp-rocket-static-cpcss-debug-helper/) | A WordPress plugin helping debug in CPCSS. |
| [WP Rocket \| Desktop version of Critical CSS on Mobile](static-files/wp-rocket-static-desktop-opt-css-mobile/) | Uses desktop Critical CSS on mobile when separate mobile cache files are enabled. |
| [WP Rocket \| Exclude Scripts from Defer JS](static-files/wp-rocket-static-exclude-defer-js/) | Exclude scripts from the defer JS option. |
| [WP Rocket \| Exclude JS scripts from Delay JS only at some URLs](static-files/wp-rocket-static-exclude-delay-js-per-url/) | Exclude JavaScript files from Delay JS only on specific pages instead of excluding them globally. |
| [WP Rocket \| Exclude from Static File Creation](static-files/wp-rocket-static-exclude-dynamic-files/) | Excludes CSS/JS generated dynamically by a PHP script from being served as static files by WP Rocket. |
| [WP Rocket \| Exclude Inline JS From Combine](static-files/wp-rocket-static-exclude-inline-js/) | Exclude specified inline JS from WP Rocket JS combine. |
| [WP Rocket \| Exclude Files from Async CSS](static-files/wp-rocket-static-exclude-opt-css/) | Exclude files from Optimize CSS Delivery option. |
| [WP Rocket \| Exclude Folders from Async CSS](static-files/wp-rocket-static-exclude-opt-css-folders/) | Excludes all CSS files in the specified folders and subfolders from CPCSS. |
| [WP Rocket \| Exclude Files from Cache Busting](static-files/wp-rocket-static-exclude-query-string/) | Excludes CSS/JS files from being served as static files by WP Rocket. |
| [WP Rocket \| External JS Hosts](static-files/wp-rocket-static-external-js/) | Prevents external JavaScript calls from being moved to the top of the document during WP Rocket’s minification process. |
| [WP Rocket \| No Auto-generated Critical CSS](static-files/wp-rocket-static-no-auto-critical-css/) | Disable automatic generation of critical CSS when Optimize CSS Delivery is enabled. |
| [WP Rocket \| No Optimized CSS Delivery on Desktop](static-files/wp-rocket-static-no-opt-css-desktop/) | Disables optimized CSS delivery for desktop devices. |
| [WP Rocket \| No Optimized CSS Delivery on Mobile](static-files/wp-rocket-static-no-opt-css-mobile/) | Disables optimized CSS delivery for mobile devices. |

### Various

| Name | Description / use case |
| --- | --- |
| [RocketCDN \| Set API key for RocketCDN plugin](various/rocketcdn-set-api-key-for-rocketcdn-plugin/) | Set API key to website owner. |
| [WP Rocket \| Add WebP Target Attribute](various/wp-rocket-add-webp-target-attributes/) | Extends the attributes where WP Rocket does the WebP replacement. |
| [WP Rocket \| Change Parameters](various/wp-rocket-change-parameters/) | Reduce the CPU usage by changing the default Preload and RUCSS parameters. |
| [WP Rocket \| Conditionally toggle options](various/wp-rocket-conditionally-toggle-options/) | Toggle WP Rocket options based on specific conditions. |
| [WP Rocket \| Debug Helper](various/wp-rocket-debug-helper/) | Checks for various constants, filters, and per-page cache options, prints their values as an HTML comment in the footer of the HTML source code. |
| [WP Rocket \| Disable automatic dynamic lists updates](various/wp-rocket-disable-auto-list-updates/) | Disables WP Rocket’s updates of dynamic lists while preserving the possibility of manual update. |
| [WP Rocket \| Disable CDN URLs on HTTPS pages](various/wp-rocket-disable-cdn-on-https/) | Prevents rewriting of URLs in HTTPS pages with CDN URLs. |
| [WP Rocket \| Disable Meta Generator tag](various/wp-rocket-disable-meta-generator/) | Disables the Meta generator in WP Rocket. |
| [WP Rocket \| Disable WP Rocket's Emoji optimization](various/wp-rocket-emoji/) | This helper plugin will disable WP Rocket's emoji optimization. This means your website will use the Emoji file from WordPress.org instead of the default Emoji from vistor's browser. |
| [WP Rocket \| Exclude Custom Image Sources from Image Dimensions](various/wp-rocket-exclude-src-from-image-dimensions/) | Disables Image Dimensions for image sources specified in this plugin. |
| [WP Rocket \| Export WP Rocket Settings](various/wp-rocket-export-settings/) | Allows you to export WP Rocket settings when WP Rocket cannot be activated. |
| [WP Rocket \| Filter WP_Query Args](various/wp-rocket-filter-wp_query-args/) | Removes filters from WP_Query arguments used by <code>rocket_url_to_postid()</code> to prevent third-party query modifications from causing incorrect URL-to-post resolution. |
| [WP Rocket - License Manager](various/wp-rocket-license-manager/) | Safely switch your license email and API Key preserving the current plugin settings. |
| [WP Rocket \| Image Dimensions for &lt;picture&gt; and external images](various/wp-rocket-media-image-dimensions-picture-external-images/) | Controls Add Missing Image Dimensions for <code>&lt;picture&gt;</code> elements and external images. |
| [WP Rocket \| Multiple Config Files](various/wp-rocket-multiple-config-files/) | Useful for cases where there are multiple URLs sharing the same filebase and multiple config files are needed. |
| [WP Rocket \| Disable WP Rocket Features For Specific Mobile Pages](various/wp-rocket-no-features-for-mobile-page/) | Disables WP Rocket on specific mobile pages when Mobile Cache with separate cache files is active. |
| [WP Rocket \| Remove Plugin Conflict Warning](various/wp-rocket-remove-plugin-conflict-warning/) | Remove the admin notice that warns about plugins that might conflict with WP Rocket. |
| [WP Rocket \| Remove Toolbar Menu](various/wp-rocket-remove-toolbar-menu/) | Removes the WP Rocket menu from the WordPress toolbar (admin bar). |
| [WP Rocket \| Reset White Label](various/wp-rocket-reset-white-label/) | Resets White Label options to default values. |
| [WP Rocket \| Settings Access](various/wp-rocket-settings-access/) | Allows access to WP Rocket’s settings for other user roles than Administrators. |
| [WP Rocket \| Disable SSL Certificate Validation](various/wp-rocket-sslverify-off/) | Disable SSL Certificate Validation for wp_remote_get requests in WP Rocket by setting sslverify to false. |
| [WP Rocket \| TMP Directory](various/wp-rocket-tmp-dir/) | Sets a custom tmp directory for WP Rocket. |
| [WP Rocket - Update Notification Recovery](various/wp-rocket-update-notification-recovery/) | Recovers WP Rocket update notifications and licensed downloads on single-site and Multisite installations. |
| [WP Rocket – Update Recovery Helper](various/wp-rocket-update-recovery/) | Prevents the fatal error in WP Rocket 3.23.2.1 and WordPress 7.1, allowing to re-enable WP Rocket and update it to the latest version. |
| [WP Rocket \| Choose Version Rollback](various/wp-rocket-version-rollback/) | Allows choosing a specific version for WP Rocket rollback via a settings page. |
| [WP Rocket Helper: Exclude highlight from delay JS.](various/wpr-helper-delayjs-highlight/) | Exclude code highlight from delay JS. |

### Experimental

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Cache Purge Cron Script](_experimental/wp-rocket-cache-purge-cron/) | Standalone cron script that clears and preloads WP Rocket’s cache, including across a multisite network; it is not an installable WordPress plugin. |
| [WP Rocket \| Optimize WooCommerce Cart, Checkout, Account](_experimental/wp-rocket-compat-wc-optimize/) | Disables page caching for WooCommerce cart, checkout, and account pages, but keeps other optimization features applicable. |

### Deprecated

| Name | Description / use case |
| --- | --- |
| [WP Rocket \| Custom Cache Folders](_deprecated/wp-rocket-cache-custom-folders/) | Use custom folder for WP Rocket cache files. |
| [WP Rocket Helper Plugin \| Cookie Notice Integration](_deprecated/wp-rocket-compat-cookie-notice/) | Adds compatibility with Cookie Notice by dFactory to WP Rocket. |
| [WP Rocket for DreamPress](_deprecated/wp-rocket-compat-dreampress/) | Compatibility add-on for WP Rocket on DreamPress. |
| [WP Rocket \| Define NGINX FastCGI cache path](_deprecated/wp-rocket-compat-nginx-cache-path/) | Changes default NGINX FastCGI /var/run/nginx-cache path to the desired one. |
| [WP Rocket \| Unload PSP Styles](_deprecated/wp-rocket-compat-premium-seo-pack/) | Premium SEO Pack (PSP) loads styles and scripts on all WordPress admin pages which makes WP Rocket’s settings page unusable. This helper plugin unloads PSP styles just on WP Rocket’s settings page. |
| [WP Rocket \| Critical Images Parameters](_deprecated/wp-rocket-critical-images-parameters/) | Customize the parameters applied to Critical Images optimizations. |
| [WP Rocket \| Events Calendar Unminify](_deprecated/wp-rocket-events-calendar-unminify/) | Programmatically deactivates minification for events posts, events archives, events taxonomy pages, and posts/pages containing events shortcodes. |
| [WP Rocket \| Fix Minification Error 400](_deprecated/wp-rocket-fix-400-minification/) | Fixes rare appearance of an error 400 (Bad Request) when minification is enabled. |
| [WP Rocket \| Insert JS into Footer](_deprecated/wp-rocket-footer-insert-js/) | Injects a custom JavaScript tag before closing body tag. |
| [WP Rocket \| Meta Charset](_deprecated/wp-rocket-meta-charset/) | Moves the <code>&lt;meta charset></code> tag back to the top of <code>&lt;head></code>. |
| [WP Rocket \| Preload mobile cache](_deprecated/wp-rocket-preload-mobile-cache/) | Will preload the mobile cache instead of the desktop cache. |
| [WP Rocket \| Varnish Cache Purging](_deprecated/wp-rocket-varnish-cache-purge/) | Forces Varnish cache purging with WP Rocket 2.6.8 to 2.6.16. |
