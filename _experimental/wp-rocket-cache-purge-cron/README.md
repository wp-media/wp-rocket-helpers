# NOT A PLUGIN! DON’T INSTALL THIS IN YOUR WORDPRESS!
_ZIP file not provided on purpose._

Cron script to clear the cache and run a cache preload.

🚧 **ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**
📝 **Manual code edit required before use!**

Edit `WPROCKETHELPERS_WP_LOAD_FILE` to reflect the absolute path to wp-load.php from wherever on your server you run this script.

This script does the following:

- Checks WP Rocket is active on the website. If so:
   - Clears the cache.
   - Checks if sitemap preload is configured.
   - If so, runs a sitemap preload; otherwise calls the preload bot.
- Checks if the website is a multisite network.
- If so, iterates over each site in the network, and performs the steps above.

Documentation:
* [How to clear cache via cron job](http://docs.wp-rocket.me/article/494-how-to-clear-cache-via-cron-job)

To be used with:
* any setup where the cache should be cleared and preloaded with a custom cron job rather than wp-cron

Last tested with:
* WP Rocket 2.11.x
* WordPress 4.9.x
