# WP Rocket | EDD Cookie Cache

Generates dedicated cache sets based on product selection in order to keep the EDD cart widget in sync.

Basic functionality:
* Sets a custom cookie `wp_rocket_edd`, value reflects visitor’s product selection.
* Generates dedicated cache set based on cookie value:
   * When a visitor selects product option #`1`, all following page visits are cached with the cart widget reflecting that exact product selection.
   * When a visitor selects product option #`2`, following page visits are cached with cart widget reflecting #`2`, and so on.
   * Later visitors with the same product selection see cached files with the cart widget reflecting their selections, based on the dedicated cookie from this plugin.

To be used with:
* [Easy Digital Downloads (EDD)](https://wordpress.org/plugins/easy-digital-downloads/)

Last tested with:
* Easy Digital Downloads 2.6.x
* WP Rocket 2.8.x
* WordPress 4.6.x
