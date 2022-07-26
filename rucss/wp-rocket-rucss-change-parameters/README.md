# WP Rocket | Change Remove Unused CSS Parameters

Change the number of URLs per batch, and the CRON interval of Remove Unused CSS to reduce the CPU usage caused by this feature on some servers .

📝&#160;&#160;**Manual code edit required before use!**

Change: 
- Line 26, to set the batch size. It is the number of URLs that will be processed on each run. 100 is the default, this helper sets it to 50 URLs. Setting a lower value can help the server to work on fewer requests at a time.

- Line 46, to set the desired cron interval in seconds. It is the pause that will be applied between batches processing. By setting a higher value (default is 60 seconds), the server will have more time to rest between processing batches. The helper sets the value to 120 seconds.


Documentation:
* [Change Remove Unused CSS Parameters](https://docs.wp-rocket.me/article/1691-customize-remove-unused-css-parameters)
* [High CPU usage](https://docs.wp-rocket.me/article/48-high-cpu-usage#remove-unused-css)

To be used with:
* Any setup where “Remove Unused CSS” is enabled and it causes high CPU usage

Last tested with:
* WP Rocket 3.11.0.1
* WordPress 5.9.x
