# WP Rocket | Change Preload Parameters

Reduce the CPU usage by changing the default Preload parameters (batch size, interval, pause between requests)


📝&#160;&#160;**Manual code edit required before use!**

Change: 
-  1) BATCH SIZE: Line 28. Is the number of URLs that will be processed on each run. 45 is the default, this helper sets it to 30 URLs. Setting a lower value can help the server to work on fewer requests at a time.

-  2) CRON INTERVAL: Line 45. Set the desired cron interval in seconds. It is the pause that will be applied between batches processing. By setting a higher value (default is 60 seconds), the server will have more time to rest between processing batches. The helper sets the value to 120 seconds.

-  3) DELAY BETWEEN REQUESTS: Line 63. This is the pause between each request. A higher delay will reduce the CPU usage. Default is 0.5 seconds (500000 microseconds) the helper sets it to 0.6 seconds. You can use a value in seconds.

Documentation:
* [Change Preload Parameters](https://docs.wp-rocket.me/article/1715-customize-preload-parameters)
* [High CPU usage](https://docs.wp-rocket.me/article/48-high-cpu-usage#preload)

To be used with:
* Any setup where “Preload” is enabled and it causes high CPU usage

Last tested with:
* WP Rocket 3.12.3
* WordPress 6.x
