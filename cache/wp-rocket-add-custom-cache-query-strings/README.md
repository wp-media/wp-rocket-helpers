# WP Rocket | Add Custom Cache Query Strings  
  
This helper allows you to add custom query strings to WP Rocket's cache list, enabling caching for specific GET parameters that would normally be ignored.  
  
📝&#160;&#160;**Manual editing required before use**  
  
## STEP #1: Add your custom query strings  
On line 28, modify the function to include the query strings you want to cache.  
  
Example query strings:  
- `custom_param` - Cache pages with ?custom_param=value  
- `attribute_%e9%a1%8f%e8%89%b2` - Cache product variations with non-latin characters   
  
You can add as many query strings as needed by adding more array entries:  
  
```php  
$query_strings[] = 'custom_param';  
$query_strings[] = 'product_id';  
$query_strings[] = 'color';  
```  
  
## How it works  
This plugin uses the `rocket_cache_query_strings` filter to add custom query strings to WP Rocket's cache configuration. The filter is processed by the `get_rocket_cache_query_string()` function, which retrieves the cached query strings and applies any custom additions through filters.  
  
When WP Rocket generates its configuration file, these query strings are included in the cache rules. The plugin also handles proper sanitization through WP Rocket's built-in sanitization system.  
  
The plugin automatically regenerates WP Rocket's configuration file when activated or deactivated to ensure the new query strings are properly applied to the caching system.  
  
Documentation:  
* [Caching Query Strings](https://docs.wp-rocket.me/article/971-caching-query-strings)  
  
To be used with:  
* E-commerce sites with product variations using query parameters  
* Sites with custom filtering systems using GET parameters    
* Multilingual sites using query string language switching  
* Any setup requiring specific query parameters to be cached  
  
Last tested with:  
* WP Rocket 3.16.3  
* WordPress 6.8.1