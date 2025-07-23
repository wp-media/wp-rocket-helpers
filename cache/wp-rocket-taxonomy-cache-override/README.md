# WP Rocket | Taxonomy Cache Override  
  
This helper removes WP Rocket's taxonomy validation filters to allow caching of invalid taxonomy pages that would normally be excluded from caching.  
  
⚠️&#160;&#160;**Use with caution - this bypasses WP Rocket's built-in taxonomy validation**  
  
## How it works  
  
This plugin hooks into WP Rocket's container system and removes two critical taxonomy validation filters:  
  
1. **`rocket_buffer` filter**: Removes the `stop_optimizations_for_not_valid_taxonomy_pages` method that returns empty HTML for invalid taxonomy pages  
2. **`do_rocket_generate_caching_files` action**: Removes the `disable_cache_on_not_valid_taxonomy_pages` method that prevents cache file generation   
  
The plugin waits for the `wp_rocket_loaded` action to ensure WP Rocket's container is fully initialized before attempting to modify the TaxonomySubscriber.   
  
## What gets cached  
  
By default, WP Rocket's TaxonomySubscriber prevents caching of taxonomy pages where the current URL doesn't match the canonical term link. This includes:  
  
- Category pages with additional path segments  
- Tag pages with invalid URL structures    
- Custom taxonomy pages with non-canonical URLs  
- Taxonomy pages with pagination that don't match expected patterns  
  
With this plugin active, these pages will be cached normally instead of being excluded.  
  
## Technical details  
  
The plugin accesses WP Rocket's dependency injection container through the `rocket_container` filter and retrieves the `taxonomy_subscriber` service. It then removes the problematic hooks using WordPress's `remove_filter()` and `remove_action()` functions.  
  
## Use cases  
  
- Sites with custom taxonomy URL structures that don't match WordPress defaults  
- Multilingual sites where taxonomy URLs are modified by translation plugins  
- Sites with custom rewrite rules affecting taxonomy page URLs  

## Installation  
  
1. Upload the plugin file to your `/wp-content/plugins/` directory  
2. Activate the plugin through the 'Plugins' menu in WordPress  
3. No configuration needed - the plugin works automatically  
  
## Compatibility  
⚠️&#160;&#160; **Not compatible with the latest WP Rocket version 3.19.2 and above !**

This plugin is designed to work with WP Rocket's internal architecture and may need updates if WP Rocket's TaxonomySubscriber implementation changes.  
  
Last tested with:  
* WP Rocket 3.16+  
* WordPress 6.0+
