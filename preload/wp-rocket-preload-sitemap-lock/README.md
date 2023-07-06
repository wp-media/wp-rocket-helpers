
# WP Rocket | Only preload URLs in a sitemap

Instruct WP Rocket's preload to only use the URLs present in a specific sitemap. Any extra URL won't be preloaded. 

📝  **Manual code edit required before use!**

Edit line 20 and add the URL of your sitemap inde the **$my_custom_sitemap** variable

	$my_custom_sitemap = 'https://www.example.com/sitemap_index.xml';

To be used with any setup where you want to:
- limit the preload funcitonality to a specific set of URLs provided in a sitemap, 
- avoid URLs visited by users from being added into the cache table, and subsequently preloaded

Last tested with:
* WP Rocket 3.14.x
* WordPress 6.x.x

