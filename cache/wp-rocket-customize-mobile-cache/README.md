# WP Rocket | Customize Mobile Cache options

Disables **Separate Cache files for Mobile devices** by default and also **Optimize Critical Images** and **Lazy Render Content** as separate cache for mobile devices is a requirement by these optimizations.

⚠️ You can also disable the **Mobile Cache** option. 
Keep in mind that doing this will prevent mobile devices from receiving cached and optimized pages. 

📝 To Disable **Mobile Cache** please uncomment line 35, change it from:

    // $options['cache_mobile'] = 0;
    
to

    $options['cache_mobile'] = 0;

**To reverse the changes,** simply deactivate the this helper plugin. 

Documentation:
* [Mobile cache](https://docs.wp-rocket.me/article/708-mobile-cache)
* [Optimize Critical Images](https://docs.wp-rocket.me/article/1816-optimize-critical-images)
* [Lazy Render Content](https://docs.wp-rocket.me/article/1835-lazy-render-content)

To be used with:
* Any setup where you want to disable the Separate Cache Files for mobile devices, or the Mobile Cache altogheter. 

Last tested with:
* WP Rocket 3.17
* WordPress 6.6.2




