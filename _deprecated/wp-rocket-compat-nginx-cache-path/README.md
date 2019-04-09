# WP Rocket | Define NGINX FastCGI cache path

Changes default NGINX FastCGI /var/run/nginx-cache path to the desired one

📝 **Manual code edit required before use!**

Make sure to replace the **/var/run/nginx-cache** with the correct absolute path to your NGINX FastCGI cache directory (fastcgi_cache_path)

**PROVIDING WRONG PATH MIGHT LEAD TO UNEXPECTED BEHAVIOUR**

Documentation:
* [NGINX FastCGI Cache Add-On](https://docs.wp-rocket.me/article/1143-nginx-fastcgi-cache-add-on)

To be used with:
NGINX environment with NGINX FastCGI cache and WP Rocket **NGINX FastCGI Cache add-on** activated 

Last tested with:
* WP Rocket 3.3
* WordPress 5.1.1
