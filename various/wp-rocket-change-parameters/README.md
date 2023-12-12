# WP Rocket | Change Parameters

Change "Preload" and "Remove Unused CSS" parameters to lower values, in order to reduce the CPU usage caused by these features on some servers.

This helper can also be used to speed up the "Preload" and "Remove Unused CSS" processes on strong servers.

📝&#160;&#160;**Manual code edit required before use!**

Change: 

- 1) PRELOAD BATCH SIZE: Line 28. Is the number of URLs that will be processed on each run. 45 is the default, this helper sets it to 25 URLs. Setting a lower value can help the server to work on fewer requests at a time.

- 2) PRELOAD CRON INTERVAL: Line 46. Set the desired cron interval in seconds. It is the pause that will be applied between batches processing. By setting a higher value (default is 60 seconds), the server will have more time to rest between processing batches. The helper sets the value to 120 seconds.

- 3) PRELOAD DELAY BETWEEN REQUESTS: Line 63. This is the pause between each request. A higher delay will reduce the CPU usage. Default is 0.5 seconds (500000 microseconds) the helper sets it to 1 second. You can use a value in seconds.

- 4) RUCSS BATCH SIZE: Line 86, to set the batch size. It is the number of URLs that will be processed on each run. 100 is the default, this helper sets it to 25 URLs. Setting a lower value can help the server to work on fewer requests at a time.

- 5) RUCSS CRON INTERVAL: Line 120, to set the desired cron interval in seconds. It is the pause that will be applied between batches processing. By setting a higher value (default is 60 seconds), the server will have more time to rest between processing batches. The helper sets the value to 120 seconds.


Documentation:
* [Change Preload Parameters](https://docs.wp-rocket.me/article/1715-customize-preload-parameters)
* [Change Remove Unused CSS Parameters](https://docs.wp-rocket.me/article/1691-customize-remove-unused-css-parameters)
* [High CPU usage](https://docs.wp-rocket.me/article/48-high-cpu-usage#remove-unused-css)

To be used with:
* Any setup where "Remove Unused CSS" or "Preload" are enabled and causing high CPU usage

Last tested with:
* WP Rocket 3.15.*
* WordPress 6.x
