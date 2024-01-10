# WP Rocket | Filter WP_Query Args

This helper plugin will prevent issues caused by filters inside our rocket_url_to_postid() function. Uses our new filter, `rocket_url_to_postid_query_args` setting `suppress_filters` to true.

Documentation:
* [Add a new filter to change WP_Query args while getting post ID from the url](https://github.com/wp-media/wp-rocket/pull/6345)

Last tested with:
* WP Rocket 3.15.7
* WordPress 6.4.2
