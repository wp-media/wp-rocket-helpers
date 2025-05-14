# WP Rocket | Exclude images from LazyLoad per page

Using this helper plugin lets you disable Lazyload for specific images on selected pages (by page slug), while still having the image lazyloaded on other pages.

**MANUAL EDITING REQUIRED BEFORE USE**

Uncomment line 29, and add the slug(s) of the page(s) where you want to disable lazyloading for specific image(s) item per line as shown on the example.
Uncomment the extra line, or add them manually.

Uncomment line 52, and add the filename (or partial path) of the image(s) you want to exclude from lazyload on the page(s) target pages.
You can duplicate the line to add multiple images.


**To EXCLUDE IMAGES BASED ON OTHER CONDITIONS**

You can replace or extend the conditions in line 39 and 40 to target different type of pages. For example:
```php
|| is_front_page() //Exclude on the homepage
|| is_category()  //Exclude on category archive pages
```
Combine multiple conditions as needed to match your specific use case.

Documentation:
* [Disable LazyLoad on specific images](https://docs.wp-rocket.me/article/15-disable-lazy-load-on-specific-images)
* [LazyLoad for images](https://docs.wp-rocket.me/article/1141-lazyload-for-images)

To be used:
* When certain images on specific pages needs to be excluded from lazyload while still keeping the image lazyloaded on other pages.


Last tested with:
* WP Rocket 3.18.3
* WordPress 6.7.2
