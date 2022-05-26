# WP Rocket | Set Mandatory Cookie

Adds a **Mandatory Cookie** to prevent the cache from being delivered until that cookie is set. 

Documentation:

 - [Create Different Cache Files with Dynamic and Mandatory
   Cookies](https://docs.wp-rocket.me/article/1313-create-different-cache-files-with-dynamic-and-mandatory-cookies)

📝 **Manual code edit required before use!**

Before you activate the plugin:
 - Replace the placeholder value `your-cookie-name-here` in line 29
   with the cookie name you want to use. The cache won't be delivered
   until that cookie is set in the visitor's browser. You can add more cookies as needed, by duplicating that line.

To be used with:
 - any setup where a specific cookie needs to be set before delivering the cached files

Last tested with:
* WP Rocket 3.11.x
* WordPress 6.x
