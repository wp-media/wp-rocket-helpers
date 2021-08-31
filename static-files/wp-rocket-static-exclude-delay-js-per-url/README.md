# WP Rocket | Exclude JS scripts from Delay JS only at some URLs

This helper will allow you exclude JavaScript files from Delay JS only on specific pages instead of excluding them globally.

📝&#160;&#160;**Manual editing required before use**

# STEP #1: Add the slugs of the URLs where you'd like to apply the exclusions
On line 30, change the slugs ("first-slug") to the pages where you want to apply the exclusions only.
These are the URLs where the scripts from step 2 won't be delayed. You can add more slugs as needed.


# STEP #2: Add the scripts you need to exclude from Delay JS
Starting from line 60, add the scripts that need to be loaded right away ONLY on the above URLs. 
To add multiple scripts you can duplicate these lines as many times as needed.



Documentation:
* [Exclude JS scripts from Delay JS only at some URLs](https://docs.wp-rocket.me/article/1645-exclude-js-scripts-from-delay-js-only-at-some-urls)

To be used with:
* Any setup where you can Delay Javascript files globally, but you need to exclude some scripts only on some pages. For example, when you have a slideshow on 2 or 3 pages, a modal in one page, etc  

Last tested with:
* WP Rocket 3.9.2.x
* WordPress 5.8
