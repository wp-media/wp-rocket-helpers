
# WP Rocket | Exclude Fonts from Preload Fonts

This helper plugin lets you exclude specific fonts from being preloaded by WP Rocket's Fonts Preload optimization: [WP Rocket: Preload Fonts](https://docs.wp-rocket.me/article/1317-preload-fonts)

📝&#160;&#160;**Manual code edit required before use!**


**How to use**

To define the fonts you want to exclude:

1. Open the plugin file.
2. Find this section:

```php
// START editing — add full or partial font filenames to exclude as in the examples below
// $exclusions[] = 'OpenSans.woff2';
// $exclusions[] = 'my-font-subset.woff';
// END editing
```
You can uncomment one of the examples or add one, per font you want to exclude:

     $exclusions[] = 'your-font-file.woff2'; 

3. Save the file, zip it
4. Upload the plugin to your WordPress site and activate it   
5. Clear the Priority Elements, WP Rocket will automatically apply the exclusions on the regeneration.

**To undo the changes**
1. Just deactivate the plugin from the Plugins menu. The exclusions will no longer apply.
2. Clear the Priority Elements again

**Last tested with**
* WP Rocket 3.19
* WordPress 6.8