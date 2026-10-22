# WP Rocket | RUCSS Debugger

A debugging utility for monitoring and managing WP Rocket Remove Unused CSS jobs.

The plugin adds a page at **WordPress Admin Dashboard → Tools → RUCSS Debugger**.

## Features

- View all Remove Unused CSS jobs and their current status.
- View counters for Completed, Pending, In-Progress, To Submit, and Failed jobs.
- Search jobs by URL, job ID, or status.
- Regenerate Used CSS for an individual URL.
- Run WP-Cron manually.
- **Retry Pending jobs:** shown only when Pending jobs exist; changes all `pending` jobs to `to-submit` so WP Rocket can submit them again.
- **Retry Failed jobs:** shown only when Failed jobs exist; clears stale job IDs, queue names, retry counts, error information, and retry timestamps, then changes all `failed` jobs to `to-submit`.
- **Reset all Used CSS jobs:** clears the entire `{prefix}_wpr_rucss_used_css` table. Job records will be recreated when preload runs or pages are visited.

## Important

Create a current database backup before using **Reset all Used CSS jobs**. The existing job records are cleared immediately, then recreated as preload runs or pages are visited.

The bulk maintenance actions require an administrator with the `install_plugins` capability. Each action is protected by a WordPress nonce and displays a confirmation prompt.

## Installation

1. Upload `wp-rocket-rucss-debugger.zip` from **Plugins → Add New → Upload Plugin**.
2. Activate **WP Rocket - RUCSS Debugger**.
3. Open **Tools → RUCSS Debugger**.

## Documentation

- [Remove Unused CSS](https://docs.wp-rocket.me/article/1529-remove-unused-css)
- [Troubleshoot Used CSS generation issues](https://docs.wp-rocket.me/article/1719-troubleshoot-used-css-generation-issues)

## Compatibility

- Helper version: 1.2.2
- Designed for WP Rocket 3.23.x
