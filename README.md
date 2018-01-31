# Helper Plugins v2.0 working draft

## Should we deprecate these?

This one addresses installs prior to v2.7 with with Varnish:
- [wp-rocket-varnish-cache-purge](https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-varnish-cache-purge)

These are probably irrelevant since the new minify lib in 2.11?
- [wp-rocket-events-calendar-unminify](https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-events-calendar-unminify)
- [wp-rocket-fix-400-minification](https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-fix-400-minification)

## Proposed new repo structure

We seem to have quickly outgrown the days where we had so few plugins that they could be dumped in one list, without a consistent naming pattern, and still be found easily.

**How about we add a rudimentary, (hopefully) intuitive level of subfolders, and harmonise plugin names?**

Here’s a proposal (current names in brackets):

```
wp-rocket-helpers
┃
┣ cache
┃ ┃
┃ ┣ wp-rocket-cache-domain-ending             (wp-rocket-domain-ending-length)
┃ ┣ wp-rocket-cache-donotcachepage            (wp-rocket-override-donotcachepage)
┃ ┣ wp-rocket-cache-dynamic-cookie
┃ ┣ wp-rocket-cache-feed
┃ ┣ wp-rocket-cache-purge-urls                (wp-rocket-purge-custom-post-urls)
┃ ┣ wp-rocket-cache-search-results
┃ ┣ wp-rocket-no-cache                        (wp-rocket-disable-cache)
┃ ┣ wp-rocket-no-cache-auto-purge             (wp-rocket-disable-cache-clear)
┃ ┣ wp-rocket-no-cache-for-admins
┃ ┗ wp-rocket-no-cache-urls-regexes           (wp-rocket-regex-exclusions)
┃
┣ compatibility
┃ ┃
┃ ┣ wp-rocket-compat-cookie-notice            (wp-rocket-cookie-notice-integration)
┃ ┣ wp-rocket-compat-dreampress               (wp-rocket-for-dreampress)
┃ ┣ wp-rocket-compat-edd-cart-widget          (wp-rocket-edd-cookie)
┃ ┣ wp-rocket-compat-essential-grid           (wp-rocket-unlazyload-essential-grid)
┃ ┣ wp-rocket-compat-leadpages                (wp-rocket-unlazyload-leadpages)
┃ ┣ wp-rocket-compat-premium-seo-pack         (wp-rocket-unload-psp-styles)
┃ ┣ wp-rocket-compat-varnish-ip               (wp-rocket-varnish-ip)
┃ ┣ wp-rocket-compat-vg-wort-pixel            (wp-rocket-vg-wort-pixel)
┃ ┣ wp-rocket-compat-wc-product-images        (wp-rocket-unlazyload-wc-products)
┃ ┗ wp-rocket-comapt-yith-wc-recently-viewed  (wp-rocket-yith-woocommerce-recently-viewed-products)
┃
┣ htaccess
┃ ┃
┃ ┣ wp-rocket-htaccess-fonts-no-cors          (wp-rocket-htaccess-fonts-no-cors)
┃ ┣ wp-rocket-htaccess-https                  (wp-rocket-https-redirect)
┃ ┣ wp-rocket-htaccess-no-gzip                (wp-rocket-unforce-gzip)
┃ ┣ wp-rocket-htaccess-nonwww-www             (wp-rocket-nonwww-www-redirect)
┃ ┣ wp-rocket-htaccess-nonwww-www-https
┃ ┣ wp-rocket-htaccess-remove-rewrites        (wp-rocket-remove-rewrite-rules)
┃ ┣ wp-rocket-htaccess-trailing-slash         (wp-rocket-enforce-trailing-slash)
┃ ┣ wp-rocket-htaccess-www-nonwww             (wp-rocket-www-nonwww-redirect)
┃ ┗ wp-rocket-htaccess-www-nonwww-https
┃
┣ lazyload
┃ ┃
┃ ┗ wp-rocket-lazyload-threshold
┃
┣ static-files
┃ ┃
┃ ┣ wp-rocket-static-exclude-defer-js         (wp-rocket-exclude-from-defer-js)
┃ ┣ wp-rocket-static-exclude-dynamic-files    (wp-rocket-exclude-dynamic-files)
┃ ┣ wp-rocket-static-exclude-opt-css          (wp-rocket-exclude-from-async-css)
┃ ┣ wp-rocket-static-exclude-query-string     (wp-rocket-exclude-from-cache-busting)
┃ ┣ wp-rocket-static-external-js              (wp-rocket-external-js)
┃ ┗ wp-rocket-static-mobile-no-opt-css
┃
┣ various
┃ ┃
┃ ┣ wp-rocket-custom-preload-intervals
┃ ┣ wp-rocket-debug-helper
┃ ┣ wp-rocket-footer-insert-js                (wp-rocket-js-footer-hack)
┃ ┣ wp-rocket-meta-charset                    (wp-rocket-meta-charset-hack)
┃ ┣ wp-rocket-reset-white-label
┃ ┣ wp-rocket-settings-access
┃ ┗ wp-rocket-tmp-dir
┃
┣ .gitignore
┣ how-to-download-zip.gif
┣ LICENSE
┗ README.md
```
