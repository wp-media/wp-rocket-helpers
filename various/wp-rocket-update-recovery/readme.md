# WP Rocket – Update Recovery Helper

This temporary helper plugin allows WP Rocket **3.23.2.1** to be safely re-enabled on **WordPress 7.1** so it can be updated to the latest version.

## When to use it

Use this helper if WP Rocket **3.23.2.1** is currently disabled because activating it causes a fatal error.

**Do not uninstall WP Rocket**, as uninstalling it may remove your existing WP Rocket settings.

## Instructions

1. Make sure **WP Rocket is deactivated**.

2. Install the **WP Rocket – Update Recovery Helper**:

   * Go to **Plugins → Add Plugin → Upload Plugin**.
   * Select the helper ZIP file.
   * Click **Install Now**.
   * Click **Activate Plugin**.

3. You should see the following message:

   > **WP Rocket temporary fix is active.**
   > You can now safely activate WP Rocket.

4. Click **Activate WP Rocket**.

   The helper will activate WP Rocket and automatically take you to the Plugins page while forcing a fresh check for WP Rocket updates.

5. Find the available WP Rocket update and click **Update now**.

   Make sure WP Rocket is updated to **version 3.23.2.2 or later**.

6. Once WP Rocket has been successfully updated, **deactivate and delete WP Rocket – Update Recovery Helper**.

## If you can't deactivate WP Rocket from WP Admin

If the fatal error prevents you from accessing WP Admin:

1. Connect to the site using **FTP/SFTP or your hosting File Manager**.
2. Go to `/wp-content/plugins/`.
3. Rename the `wp-rocket` folder to `wp-rocket-old`.
4. Open the **Plugins** page in WordPress. WordPress will detect that WP Rocket is unavailable and deactivate it.
5. Rename `wp-rocket-old` back to `wp-rocket`.
6. Follow the instructions above to install the **WP Rocket – Update Recovery Helper**.

Your existing WP Rocket settings will remain in place throughout this process.
