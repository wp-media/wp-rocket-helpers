
# WP Rocket | Exclude CSS files from Remove Unused CSS

Exclude **CSS files** from being removed by WP Rocket’s Remove Unused CSS optimizations.
By default, Remove Unused CSS will remove *every* CSS file from the HTML styles after the optimization is applied. 
In some cases, you might need to preserve CSS files, and you can use this helper to achieve it.

Documentation:
* https://docs.wp-rocket.me/article/1694-prevent-inline-styles-from-being-removed-by-remove-unused-css

How to use it: 
* Copy the path of the CSS file you want to preserve, for example: `/wp-content/plugins/plugin-name/css/my-specific-file.css`
* Edit line 29, change `'/wp-content/plugins/plugin-name/css/file.css'` by the class you'd like to preserve:
    `$external_exclusions[] = '/wp-content/plugins/plugin-name/css/my-specific-file.css';`
* To exclude multiple CSS files, copy the entire line into a new line for each file you want you exclude.
* Install the plugin, and Clear WP Rocket's cache.

Last tested with:
* WP Rocket 3.11.x
* WordPress 9.x
