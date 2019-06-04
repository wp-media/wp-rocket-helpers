# WP Rocket | Disable WP Rocket Features For Specific Mobile Pages

Disables WP Rocket page cache file generation and optimization features for mobile devices only on specific pages.

🚧&#160;&#160;**ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**

In the 32nd line of the code please add desired pages to the is_page condition. You can also add another condition to catch correct part of your WordPress site.

If you want to disable only generation of caching files, please comment out 58th line of code.
If you want to disable only optimization features, please comment out 55th line of code.


To be used with:
* any setup when Mobile Cache with separate cache files is active

Last tested with:
* WP Rocket 3.3.3.1
* WordPress 5.2.1
