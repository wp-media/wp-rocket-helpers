# WP Rocket | Exclude Files from Cache Busting

Excludes CSS/JS files from being served as static files by WP Rocket.

📝&#160;&#160;**Manual code edit required before use!**

When the _Remove query string_ option is enabled, WP Rocket generates a new file from each CSS or JS file, encoding the version number from the query string `?ver=` into the new file name. This plugin lets you exclude file URIs from that process.

Replace `/wp-content/themes/example-theme/example.css` with the file path you’d like to exclude.

Documentation:
* [Exclude files from static resources option](http://docs.wp-rocket.me/article/923-exclude-files-from-static-resources-option)

To be used with:
* any setup where the “Remove query string” option conflicts, e.g. due to relative paths within CSS files

Last tested with:
* WP Rocket 2.9.x
* WordPress 4.7.x
