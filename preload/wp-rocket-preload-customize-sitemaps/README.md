# WP Rocket | Customize Preload Sitemap 

Customize WP Rocket's preload by modifying the sitemaps to be used

📝  **Manual code edit required before use!**

This helper allows you to do 3 different customizations. 


**1)  Preload ONLY these sitemap(s)**
Use this if you need to preload URLs in custom sitemaps *replacing* the automatic sitemaps detection.

📝  Edit the line 24 and add the URL of your sitemap:

       'https://example.com/page-sitemap.xml', // duplicate this line you want to add more sitemaps

You can duplicate this line to add more sitemaps, like this: 

       'https://example.com/page-sitemap.xml', // duplicate this line you want to add more sitemaps
       'https://example.com/page-sitemap.xml', // duplicate this line you want to add more sitemaps


 **2) Preload ADDITIONAL sitemap(s)**
 Used this to ensure specific sitemaps are *included* in *ADDITION* to the compatible sitemaps

📝  You will need to do the following edits:
	
    - Comment line 28
	
    - Uncomment lines 35 and 43
	
    - Edit line 38  and add the URL of your sitemap:

    $sitemaps[] = 'https://domain.com/wp-content/files/custom-sitemap.xml';  // duplicate this line you want to add more sitemaps
    
 - You can  add more sitemaps by duplicating the above line


 **3) Customize Preload Priority sitemap(s)**
 You can change Preload order to run on URLs according to their *id* instead of their *modified* value.
 
📝  Uncomment lines 49 and 53


**Upon Activation this helper will:**
- empty the cache table: wpr_rocket_cache
- clear the cache, 
- reactivate the preload so the sitemaps are parsed again


**To be used with any setup where you want to:**
- Change WP Rocket's automatic sitemap detection to use a specific set of sitemaps instead.
- Prioritize some URLs of your website. 

Last tested with:
* WP Rocket 3.15.x
* WordPress 6.x.x