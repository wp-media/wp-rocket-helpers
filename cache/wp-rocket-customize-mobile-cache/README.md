# WP Rocket | Customize Mobile Cache options

Disables **Separate Cache files for Mobile devices** by default, and allows disabling the **Mobile Cache** option altogheter, enabled by default after WP Rocket 3.16

After installation, the helper will automatically disable  **Separate Cache files for Mobile devices** only.

⚠️ You can also disable the **Mobile Cache** option, but keep in mind that doing this will prevent mobile devices from receiving cached and optimized pages. 

📝 If you want to proceed with this change, please edit line 37
Change it from:

    $options['cache_mobile'] = 1; 
    
to

    $options['cache_mobile'] = 0;

**To reverse the changes,** simple deactivate the this helper plugin. 

Documentation:
* [Mobile cache](https://docs.wp-rocket.me/article/708-mobile-cache)

To be used with:
* Any setup where you want to disable the Separate Cache Files for mobile devices, or the Mobile Cache altogheter. 

Last tested with:
* WP Rocket 3.16
* WordPress 6.5.3




