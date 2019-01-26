# WP Rocket | Disable SSL Certificate Validation

Disable SSL Certificate Validation for wp_remote_get requests in WP Rocket by setting sslverify to false. 

Documentation:
* [Preload is slow, or some pages are not preloaded at all](https://docs.wp-rocket.me/article/1065-sitemap-preload-is-slow-or-some-pages-are-not-preloaded-at-all)
* [Resolving problems with license validation](https://docs.wp-rocket.me/article/100-resolving-problems-with-license-validation)

To be used with:
* Any setup where preload or license validation fails with `cURL error 60: SSL certificate problem` and similar. 

Last tested with:
* WP Rocket 3.2.x
* WordPress 5.0.x
