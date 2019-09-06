# WP Rocket | Ignore Query Strings

Define query strings that should use the same set of cache.

📝 **Manual code edit required before use!**

You can add new parameter by editing or copying existing line and changing its name in brackets (new_query_string).
To prevent WP Rocket from caching specific parameter, uncomment 30th line of code and change value (utm_source) to the desired one.
If you want WP Rocket stop serving cache for more parameters, simply copy the 30th line and change the value.  

Documentation: [Customize Query String Caching](https://docs.wp-rocket.me/article/1281-customize-query-string-caching)

To be used with:
Any setup

Last tested with:
* WP Rocket {3.4-alpha1}
* WordPress {5.2.2}
