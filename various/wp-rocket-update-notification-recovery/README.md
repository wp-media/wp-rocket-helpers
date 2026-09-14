# WP Rocket Update Notification Recovery

WP Rocket Update Notification Recovery asks WP Rocket's licensing server for
updates when the main WP Rocket plugin is installed but not loaded. It supports
both single-site WordPress and Multisite networks where WP Rocket is inactive
everywhere or inactive on the main site. It does not include or execute any WP
Rocket file.

## Installation

### Must-use plugin (recommended for recovery)

Copy `wp-rocket-update-notification-recovery.php` directly into `wp-content/mu-plugins/`.
Create that directory if it does not exist. WordPress only auto-loads PHP files
at the root of `mu-plugins`, so do not leave the file inside a nested directory.

### Normal plugin

Zip this directory, upload it from **Plugins > Add New > Upload Plugin**, and
activate it. A normal plugin works when WP Rocket is inactive, but an MU plugin
is more reliable for Recovery Mode scenarios.

On Multisite, install and **Network Activate** this recovery helper. WP Rocket
itself should remain activated separately on each subsite and should not be
network activated.

## Behavior

- Update Notification Recovery is inert whenever WP Rocket successfully defines
  `WP_ROCKET_VERSION` in the current request; WP Rocket then owns that update
  check.
- It reads the installed version from WP Rocket's plugin header without loading
  the plugin.
- It reads license details from `WP_ROCKET_KEY` and `WP_ROCKET_EMAIL`, from the
  existing `wp_rocket_settings` option, or from a new WP Rocket download's
  generated `licence-data.php`. The license file is parsed as text and never
  executed.
- On Multisite, the shared `licence-data.php` is the authoritative license
  source. The helper checks the main site and the first configured subsite URL,
  stopping at the first valid response. Per-site settings are used only when the
  shared license file is unavailable.
- It remembers which site URL authenticated the update so the package download
  uses the same context from Network Admin.
- It attaches WP Rocket's license-bearing User-Agent to both the version check
  and the separate package-download request made by WordPress.
- It finds WP Rocket by its plugin header if the `wp-rocket` folder was renamed.
  On the Plugins screen it displays a red notice with a nonce-protected action
  that restores the folder name. The action requires WP Rocket to already be
  inactive everywhere and refuses ambiguous paths, non-direct plugin
  directories, an existing destination, and any Multisite network where WP
  Rocket is still active on a subsite.
- Successful API responses are cached for 12 hours. Transport errors are cached
  for one hour and HTTP errors for two hours.
- Visiting `plugins.php?rocket_force_update=1` as a user allowed to update
  plugins clears both update caches and forces a fresh request. On Multisite,
  the helper's link targets **Network Admin > Plugins**.
- Activating Update Notification Recovery redirects the activating administrator
  once to that forced-check URL, so the integration is tested immediately.
- WP Rocket's metadata row ends with a bold **Check Available Updates Now** link
  that runs the same forced check.
- An expired license can produce an update offer with no downloadable package,
  matching WP Rocket's own behavior.

## Limitations

The WP Rocket update endpoint, User-Agent format, and response format are private
implementation details and may change in future WP Rocket releases. If WP Rocket
fatals before WordPress Recovery Mode can provide an admin session, deactivate it
through the filesystem or database before using the Plugins screen.

This version assumes one WP Rocket license per Multisite network. Networks with
different license keys for different mapped top-level domains are outside its
supported model.
