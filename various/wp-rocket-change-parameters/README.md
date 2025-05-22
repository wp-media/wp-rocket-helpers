# WP Rocket | Change Parameters

Change "Preload" and "Remove Unused CSS" parameters to lower values, in order to reduce the CPU usage caused by these features on some servers.

This helper can also be used to speed up the "Preload" and "Remove Unused CSS" processes on strong servers.

📝&#160;&#160;**Possible manual code edit required before use if you need to apply custom parameters!**

This plugin changes: 

<br>

- PRELOAD MAXIMUM BATCH SIZE - `rocket_preload_cache_pending_jobs_cron_rows_count` 
  - Sets maximum number of URLs that will be processed on each run. 45 is the default, this helper sets it to 25 URLs. 
  - Setting a lower value can help the server to process fewer pages at a time.

<br>

- PRELOAD MINIMUM BATCH SIZE - `rocket_preload_cache_min_in_progress_jobs_count`
  - Sets minimum number of URLs to preload in each batch, 5 is the default, this helper sets it to 3 URLs.
  - Setting a lower value can help the server to process fewer pages at a time.

<br>

- PRELOAD CRON INTERVAL - `rocket_preload_pending_jobs_cron_interval`
  - Sets the desired cron interval in seconds. 60 seconds is the default, this helper sets it to 120 seconds.
  - It is the pause that will be applied between batches processing. By setting a higher value, the server will have more time to rest between processing batches.

<br>

- PRELOAD DELAY BETWEEN REQUESTS - `rocket_preload_delay_between_requests`
  - Sets the pause between each request. Default is 0.5 seconds (500000 microseconds), this helper sets it to 1 second.
  - Use a value in seconds, this helper will convert it to microseconds.
  - A higher delay can reduce CPU usage.

<br>

- RUCSS BATCH SIZE - `rocket_saas_pending_jobs_cron_rows_count`
  - Sets the number of URLs that will be processed on each run. 100 is the default, this helper sets it to 25 URLs.
  - Setting a lower value can reduce CPU usage.

<br>

- RUCSS CRON INTERVAL - `rocket_saas_pending_jobs_cron_interval`
  - Sets the desired cron interval in seconds. Default is 60, this helper sets it to 120 seconds.
  - It is the pause that will be applied between processing batches. 
  - Setting a higher value allows the server to have more time to rest between processing batches.

<br>

Documentation:
* [Change Preload Parameters](https://docs.wp-rocket.me/article/1715-customize-preload-parameters)
* [Change Remove Unused CSS Parameters](https://docs.wp-rocket.me/article/1691-customize-remove-unused-css-parameters)
* [High CPU usage](https://docs.wp-rocket.me/article/48-high-cpu-usage#remove-unused-css)

<br>

To be used with:
* Any setup where "Remove Unused CSS" or "Preload" are enabled and causing high CPU usage.

<br>

Last tested with:
* WP Rocket 3.16.x
* WordPress 6.5.x
