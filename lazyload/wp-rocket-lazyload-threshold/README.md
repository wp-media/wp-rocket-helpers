# WP Rocket | LazyLoad Threshold

Define a custom threshold value for lazy-loaded images.

📝&#160;&#160;**Manual code edit required before use!**

Edit `WPROCKETHELPERS_LL_CUSTOM_THRESHOLD` to define your own threshold.

_The threshold parameter defines the space in px below the browser viewport where the LazyLoad script would start to load images._

_The default threshold of 300 means that when an (empty) image container gets scrolled up to a position of 300 px below the viewport, the script starts loading that image._

_For pages with larger images it can make sense to define a larger threshold, according to the average image height._

Documentation:
* [Adjust LazyLoad Threshold](http://docs.wp-rocket.me/article/1032-adjust-lazyload-threshold)

Requires:
* WP Rocket 2.11.0 or greater

To be used with:
* any setup where LazyLoad for images is enabled

Last tested with:
* WP Rocket 2.11.x
* WordPress 4.9.x
