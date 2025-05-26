# WP Rocket | Customize Preload Links Configuration  
  
This helper will allow you to customize the excludeUris, imageExt, and fileExt parameters from WP Rocket's Preload Links feature configuration.  
  
📝&#160;&#160;**Manual editing required before use**  
  
## STEP #1: Add custom URL patterns to exclude from Preload Links  
On line 27, modify the `$custom_exclusions` array to include the URL patterns you want to exclude from preload links.  
These patterns will prevent links matching them from being preloaded when users hover over them.  
  
Example patterns:  
- `/custom-path/` - Excludes all pages containing /custom-path/  
- `/api/` - Excludes all API endpoints  
  
## STEP #2: Add custom image file extensions  
On line 39, modify the `$custom_image_extensions` array to include additional image file extensions you want to exclude from preload links.
  
Example extensions:  
- `svg` - Scalable Vector Graphics  
- `ico` - Icon files  
- `heic` - High Efficiency Image Container  
  
## STEP #3: Add custom file extensions  
On line 51, modify the `$custom_file_extensions` array to include additional file extensions you want to exclude from preload links.
  
Example extensions:  
- `zip` - Archive files  
- `rar` - Archive files  
- `txt` - Text files  
- `csv` - Comma-separated values  
- `json` - JSON files  
  
You can add as many patterns/extensions as needed by adding more array entries.  
  
## How it works  
This plugin uses the `rocket_preload_links_config` filter to modify the configuration parameters that are passed to WP Rocket's preload links JavaScript. The customizations are appended to existing values, preserving all default functionality while adding your custom requirements.  

Default existing URI: `(?:.+/)?feed(?:/(?:.+/?)?)?$|/(?:.+/)?embed/|/checkout/??(.*)|/cart/?|/(index.php/)?(.*)wp-json(/.*|$)|/refer/|/go/|/recommend/|/recommends/`

Default existing image extensions: `jpg|jpeg|gif|png|tiff|bmp|webp|avif`

Default existing file extentions: `pdf|doc|docx|xls|xlsx|php|html|htm`

  
Documentation:  
* [Preload Links](https://docs.wp-rocket.me/article/1348-preload-links)  
  
To be used with:  
* Any setup where you need to exclude specific URL patterns from preloading links 
* Sites that use custom file types that need to exclude preloading links
* Sites with custom image formats or file types  
  
Last tested with:  
* WP Rocket 3.16.3  
* WordPress 6.8.1