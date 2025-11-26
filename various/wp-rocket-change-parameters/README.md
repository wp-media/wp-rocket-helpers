# WP Rocket | Change Parameters

Change "Preload" and "Remove Unused CSS" parameters to lower values, in order to reduce the CPU usage caused by these features on some servers.
This helper can also be used to speed up the "Preload" and "Remove Unused CSS" processes on strong servers.

> [!Important]
> POSSIBLE MANUAL CODE EDIT REQUIRED BEFORE USE IF YOU NEED TO APPLY CUSTOM PARAMETERS. HANDLE WITH CARE!<br><br>
> There is a config section at the beginning of the `wp-rocket-change-parameters.php` file that has configurable options. The Parameters are already reduced by default, this way we can install it on your site without any changes. But if you need to further customize it, you can modify each option.<br><br>
> To customize and use this helper, please follow the detailed instructions below related to each option as needed:

<br>

<h2>rocket_preload_cache_pending_jobs_cron_rows_count</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/Yqqi7RLMYMaR"><br>

- PRELOAD MAXIMUM BATCH SIZE
  - Change maximum number of URLs that will be processed on each run. 45 is the default, this helper sets it to 25 URLs. 
  - Setting a lower value can help the server to work on fewer requests at a time.

<br>

<h2>rocket_preload_cache_min_in_progress_jobs_count</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/2AhM7DIxqUhV"><br>

- PRELOAD MINIMUM BATCH SIZE
  - Sets minimum number of URLs to preload in each batch, 5 is the default, this helper sets it to 3 URLs.
  - Setting a lower value can help the server to process fewer requests at a time.

<br>

<h2>rocket_preload_pending_jobs_cron_interval</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/reVEAn4qayYW"><br>

- PRELOAD CRON INTERVAL
  - Sets the desired cron interval in seconds. 60 seconds is the default, this helper sets it to 120 seconds.
  - It is the pause that will be applied between batches processing. By setting a higher value, the server will have more time to rest between processing batches.

<br>

<h2>rocket_preload_delay_between_requests</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/BVLElkYbF4fW"><br>

- PRELOAD DELAY BETWEEN REQUESTS 
  - Sets the pause between each request made to same URL. 
  - For example, for Separate cache files for mobile devices.
  - Default is 0.5 seconds (500000 microseconds), this helper sets it to 1 second.
  - Use a value in seconds, this helper will convert it to microseconds.
  - A higher delay can reduce CPU usage.

<br>

<h2>rocket_saas_pending_jobs_cron_rows_count</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/NVy5CRDfF8gn"><br>

- RUCSS BATCH SIZE
  - Sets the batch size of URLs that will be processed on each run. 100 is the default, this helper sets it to 25 URLs.
  - Setting a lower value can help the server to work on fewer requests at a time and reduce CPU usage.

<br>

<h2>rocket_saas_pending_jobs_cron_interval</h2>

<img style="margin-top:0;margin-bottom:0;" src="https://prnt.sc/CNrtPFaVN94s"><br>

- RUCSS CRON INTERVAL
  - Sets the desired cron interval for pending jobs in seconds. Default is 60, this helper sets it to 120 seconds.
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
