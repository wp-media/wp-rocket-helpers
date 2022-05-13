# WP Rocket | Conditionally Disable Remove Unused CSS

Disable WP Rocket Remove Unused CSS for groups of pages, based on their URLs slugs


Documentation:
* [Conditionally Disable Remove Unused CSS](https://docs.wp-rocket.me/article/1695-conditionally-disable-remove-unused-css)

* [Conditionally toggle options](https://docs.wp-rocket.me/article/1561-programmatically-toggle-wp-rocket-options-under-specific-conditions)

How to use it: 
* Edit line 32, change `/product` by a portion of the URL where you'd like disable RUCSS:
	`strpos( $url, '/product' ) !== false || `
* To exclude multiple groups of URLs, you can duplicate line 32 as many times as needed. Each if condition should be followed by the `||` operator, except the last one. There is an example commented and ready to use in lines 36/47 
* Clear WP Rocket's cache.


To be used with:
* WP Rocket 3.11 and newer

Last tested with:
* WP Rocket 3.11
* WordPress 5.9