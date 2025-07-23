# WP Rocket | Disable URL Validation    
    
This helper disables WP Rocket's URL validation to allow caching of pages that would normally be excluded from caching due to URL validation checks.    
    
⚠️&#160;&#160;**Use with caution - this bypasses WP Rocket's built-in URL validation for all page types**    
    
## How it works    
    
This plugin uses WP Rocket's built-in `rocket_disable_url_validation` filter to disable URL validation globally. When this filter returns `true`, both taxonomy and post URL validation are bypassed.  
  
The filter affects two critical validation methods:    
    
1. **`disable_cache_on_not_valid_url()`**: Prevents cache file generation for invalid URLs  
2. **`stop_optimizations_for_not_valid_url()`**: Returns empty HTML for invalid URLs to skip optimizations  
  
## What gets cached    
    
By default, WP Rocket's URL validation prevents caching of pages where the current URL doesn't match the canonical link. This includes:    
    
**Taxonomy pages:**  
- Category pages with additional path segments    
- Tag pages with invalid URL structures      
- Custom taxonomy pages with non-canonical URLs    
- Taxonomy pages with pagination that don't match expected patterns    
  
**Post/Page URLs:**  
- Posts with non-canonical URL structures  
- Pages with additional query parameters  
- Singular pages that don't match their permalink structure  
  
With this plugin active, all these pages will be cached normally instead of being excluded.    
    
## Technical details    
    
The plugin leverages WP Rocket's `AbstractUrlValidation` class architecture. Both `TaxonomySubscriber` and `PostSubscriber` inherit from this class and automatically respect the `rocket_disable_url_validation` filter through the `is_disabled()` method.  

    
## Use cases    
    
- Sites with custom URL structures that don't match WordPress defaults    
- Multilingual sites where URLs are modified by translation plugins    
- Sites with custom rewrite rules affecting page URLs  
- E-commerce sites with complex product URL structures  
- Sites using custom post types with non-standard permalinks  
  
## Installation    
    
1. Upload the plugin file to your `/wp-content/plugins/` directory    
2. Activate the plugin through the 'Plugins' menu in WordPress    
3. No configuration needed - the plugin works automatically    
    
## Compatibility    
    
This plugin uses WP Rocket's official `rocket_disable_url_validation` filter, making it more stable and less likely to break with future updates.  
    
**Requirements:**  
* WP Rocket 3.19.2+ (when the filter was introduced)
* WordPress 5.8+    
* PHP 7.3+  
  
**Last tested with:**    
* WP Rocket 3.19.2+    
* WordPress 6.3+