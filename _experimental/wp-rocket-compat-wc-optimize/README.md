# WP Rocket | Optimize WooCommerce Cart, Checkout, Account

Disables page caching for WooCommerce cart, checkout, and account pages, but keeps other optimization features applicable.

🚧**ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**

Edit lines 27 to 29 to match the URLs these to match the WooCommerce URLs. The helper assumes these:

	$uris_to_remove = [
		'/checkout',
		'/cart',
		'/my-account',
	];


For **multilingual** sites, you can add more as needed, example: 

	$uris_to_remove = [
	'/checkout',
	'/cart',
	'/my-account',
	'/pagar',
	'/carrito',
	'/mi-cuenta',
	];



**To be used with:**
* WooCommerce

**Last tested with:**
* WooCommerce 8.x
* WP Rocket 3.x
* WordPress 6.x
