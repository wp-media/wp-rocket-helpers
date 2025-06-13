
# WP Rocket | Exclude Fonts from Preload Fonts

This helper plugin lets you exclude specific fonts from being preloaded by WP Rocket's Fonts Preload optimization: [WP Rocket: Preload Fonts](https://docs.wp-rocket.me/article/1317-preload-fonts)

📝&#160;&#160;**Manual code edit required before use!**


**How to use**

To exclude fonts :

1. Open the plugin file.
2. If you want to **exclude fonts by filename**, find this section:

```php
// START editing — add full or partial font filenames to exclude
// $exclusions[] = 'OpenSans.woff2';
// $exclusions[] = 'my-font-subset.woff';
// END editing
```
You should add one line per font filename you want to exclude:

     $exclusions[] = 'your-font-file.woff2'; 

3. If you want to **manipulate the fonts by their extension**, find this section instead:

```php
// START editing
    
    // These are default extensions preloaded by WP Rocket.
    // To REMOVE you can comment these lines
    
    $extensions[] = 'woff2';
    $extensions[] = 'woff';
    $extensions[] = 'ttf';

    // To ADD you can uncomment these
    //$extensions[] = 'otf';
    //$extensions[] = 'eot';

    // END edit
```
You should comment the active extensions if you want to exclude them from preload, or add new lines if you want to preload more extensions.

To exclude: 

     //$extensions[] = 'ttf';

To add a new one:

     $extensions[] = 'otf'; 

4. Save the file, zip it
5. Upload the plugin to your WordPress site and activate it   
6. Clear the Priority Elements, WP Rocket will automatically apply the exclusions on the regeneration.




**To undo the changes**
1. Just deactivate the plugin from the Plugins menu. The exclusions will no longer apply.
2. Clear the Priority Elements again

**Last tested with**
* WP Rocket 3.19
* WordPress 6.8