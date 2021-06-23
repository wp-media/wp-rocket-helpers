# WP Rocket | Exclude Folders from Async CSS

Excludes all CSS files in the specified folders and subfolders from CPCSS, it works like (.*), just add the folders you want to exclude.

Adding /wp-content/themes/example-theme will be like if you were excluding /wp-content/themes/example-theme/(.*)

📝&#160;&#160;**Manual code edit required before use!**

Documentation:
* [Exclude all CSS files in a folder / directory from Optimize CSS Delivery](https://docs.wp-rocket.me/article/1576-exclude-all-css-files-in-a-folder-directory-from-optimize-css-delivery)

To be used with:
* Any setup where files from specific folders are affecting the site either causing it to have broken layout or causing a FOUC, especially for dynamically generated css.

Last tested with:
* WP Rocket 3.9
* WordPress 5.6.x
