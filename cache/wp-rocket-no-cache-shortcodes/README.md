# WP Rocket | Shortcode Based Cache Exclusions

Exclude posts from cache and optimizations based on shortcodes present at the post content.


📝&#160;&#160;**Manual code edit required before use!**

In some cases, when posts or pages contains a shortcode, it can be useful to have a way of excluding  them from cache and optimizations.
This helper plugin will allow you to do that: it will scan the post content and exclude it from the cache if it contains a specific string. 

Before using this helper plugin, you have to edit **line 37**, and replace `[shortcode` by the real shortcode you'd like to search for.

To be used with:
* any setup

Last tested with:
* WP Rocket 3.7
* WordPress 5.5
