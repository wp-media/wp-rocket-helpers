# WP Rocket | Toolbar Clear Cache Link

Adds a “Clear cache” link to the toolbar for users who can publish posts.

You can edit `WPROCKETHELPERS_CACHE_PURGE_TOOLBAR_LINK_CAPACITY` to define the user role you want the new toolbar link to be displayed for. Default: `publish_posts` (Author)

Requires:
* PHP 5.4 or greater
* WP Rocket 3.0 or greater and less than WP Rocket 3.2.1.1. Does not work with WP Rocket 3.2.2 because of [53f90e3](https://github.com/wp-media/wp-rocket/commit/53f90e385b8ed8244ba45f041091e7ea3f372435)

To be used with:
* any setup where a “Clear cache” link should be available to non-admin users

Last tested with:
* WP Rocket 3.0.x
* WordPress 4.9.x
