
# WP Rocket | Preload Dynamic Cookie Values

Allows the preload of custom cookie values when using Dynamic Cookies

📝 **Manual code edit required before use!**

Edit the cookie name and values you want to preload on lines 49 - 53

If you want to preload the values of two different cookies, you can uncomment the 2nd set in the helper (lang):

	$cookies = [
		'currency' => [
			'usd',
			'eur',
		],
		'lang' => [
			'en',
			'es',
		], 
	];
	
The example above will preload two cookies: 

 - Cookie 1: **currency**
	 - with values **usd** and **eur**
- Cookie 2: **lang**
	 - with values **en** and **es**

Documentation:
* [Create Different Cache Files with Dynamic and Mandatory Cookies](https://docs.wp-rocket.me/article/1313-create-different-cache-files-with-dynamic-and-mandatory-cookies)

To be used with:
* any setup that uses preload and dynamic cookies.

Last tested with:
* WP Rocket 3.12.x
* WordPress 6.x
