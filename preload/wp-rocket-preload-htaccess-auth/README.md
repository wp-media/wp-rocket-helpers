# WP Rocket | HTACCESS Authorization For Preload

Adds the .htaccess username and password to the preload request so that WP Rocket can preload pages that are password protected. 

🚧 **ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**
📝 **Manual code edit required before use!**

Set `WPROCKETHELPERS_HTACCESS_USERNAME` as your .htaccess username and `WPROCKETHELPERS_HTACCESS_PASSWORD` as your .htaccess password. 
Hint: Search for `EDIT_ME` in the source code. 

For preload to work, `wp-cron.php` should be whitelisted from .htaccess authorization as well. Please refer doc for more info. 

Documentation:
* [{Docs title here}]({Docs URL here})

To be used with:
* any setup that uses preload when the website is password protected by .htaccess authorization. 

Last tested with:
* WP Rocket 3.2.x
* WordPress 5.0.x
