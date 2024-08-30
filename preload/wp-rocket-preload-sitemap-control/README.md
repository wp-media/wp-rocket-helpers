# WP Rocket | Customize Preload Sitemap 

Customize WP Rocket's preload by modifying the sitemaps to be used.

Related Doc https://docs.wp-rocket.me/article/1723-customize-preload-sitemaps-and-priority

<br>

📝  **Manual code edit required before use!**

<br>

This helper allows you to customize Preload with the following configurations:

<br>

**1) Preload only specified sitemap(s) or add additional sitemap(s) to Preload.**

📝 Set `'use_only_specified_sitemaps'` to `true` if you only want to Preload the sitemaps you specify. Set it to `false` if you would like the sitemaps you specify to be preloaded in addition to other sitemaps already used by your site. 

<br>

 **2) Preload only pages contained in your sitemaps**

📝 Set `'preload_only_pages_in_sitemaps'` to `true` if only pages that are listed in your sitemaps should be preloaded. If you set this to false, then pages not found in any sitemaps will be added to the cache Preload table when visited and cached, meaning they'll also be preloaded in future Preloads.

📝  **This option uses a transient stored in your database. If your site has a very large number of pages or uses an internationalized domain that translates to a high number of characters, this option may halt preloading. If you notice this happens, either disable this option, or try using fewer sitemaps or sitemaps with fewer links.**

<br>

 **3) Customize Preload Order**

📝 Set `'preload_by_last_modified'` to `true` to have pages be preloaded in order from oldest cached page to newest. Set this value to `false` if you want pages to be preloaded in the order they appear in the sitemaps.

<br>

 **4) Add Custom Sitemaps**

📝 Use `'sites'` to specify the domain of your site and each sitemap that should be added. For a single site setup, use exactly the following format. Replace the `https://www.example1.com` domain with the actual domain for your site, and specify the correct names for your sitemaps:

````
'sites' = [

  'https://www.example1.com' => [
    'https://www.example1.com/custom-sitemap-1.xml',
    'https://www.example1.com/custom-sitemap-2.xml',
  ],
];
````
<br>

📝 **MULTISITE** - If you use a multisite setup, use the following format to specify each of the sites on your network and the sitemaps for each (copy and paste as many new blocks of code as needed for each site):

````
'sites' = [

  'https://www.example1.com' => [
    'https://www.example1.com/custom-sitemap-1.xml',
    'https://www.example1.com/custom-sitemap-2.xml',
  ],

  'https://www.example2.com' => [
    'https://www.example2.com/custom-sitemap-1.xml',
    'https://www.example2.com/custom-sitemap-2.xml',
  ],
];
````
<br>

++++++++++++++++++++++++++++

<br>

**⚠️ Upon Activation this helper will:**
- Clear related transient (`rocket_custom_sitemap_pages`) if set.
- Empty the cache table: `wpr_rocket_cache`
- Clear the cache 
- Deactivate and reactivate Preload so the sitemaps are parsed again

<br>

**⚠️ Upon Deactivation this helper will:**
- Clear related transient (`rocket_custom_sitemap_pages`) if set.
- Unhook any sitemap changes related to `rocket_sitemap_preload_list`
- Deactivate and reactivate Preload so the sitemaps are parsed again

<br>

**⚠️ For Multisite setups, this helper plugin should be activated for each subsite individually and should not be network activated.**

<br>

**To be used with any setup where you want to:**
- Change WP Rocket's automatic sitemap detection to either add additional sitemaps or use a specific set of sitemaps instead.
- Prioritize some URLs of your website for Preload. 

<br>

Last tested with:
* WP Rocket 3.16.x
* WordPress 6.x.x
