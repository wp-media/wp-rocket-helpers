# WP Rocket | Multiple Config Files

Useful for cases where there are multiple URLs sharing the same filebase and multiple config files are needed.

📝  Manual code edit required before use!

Replace the example provided in line 27, **$extra_url[]**, with the real URLs for which you need to generate the config files.
You can also add new URL as needed, one per line: 

	$extra_url[] = 'another-url.com';
	$extra_url[] = 'and-another-url.com';
	$extra_url[] = 'and-yet-another-url.com';

Documentation:
* [Multiple configuration files for WP Rocket](https://docs.wp-rocket.me/article/1649-multiple-configuration-files-for-wp-rocket)