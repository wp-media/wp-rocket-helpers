# WP Rocket Updates Recovery

WP Rocket Updates Recovery asks WP Rocket's licensing server for updates when the main
WP Rocket plugin is installed but not loaded. It does not include or execute any
WP Rocket file, so a new, deactivated, or Recovery Mode-paused copy can still
receive its licensed update offer through WordPress's normal Plugins screen.

## Installation

### Must-use plugin (recommended for recovery)

Copy `wp-rocket-updates-recovery.php` directly into `wp-content/mu-plugins/`.
Create that directory if it does not exist. WordPress only auto-loads PHP files
at the root of `mu-plugins`, so do not leave the file inside a nested directory.

### Normal plugin

Zip this directory, upload it from **Plugins > Add New > Upload Plugin**, and
activate it. A normal plugin works when WP Rocket is inactive, but an MU plugin
is more reliable for Recovery Mode scenarios.

## Behavior

- Updates Recovery is inert whenever WP Rocket successfully defines
  `WP_ROCKET_VERSION`; WP Rocket then owns its update checks.
- It reads the installed version from WP Rocket's plugin header without loading
  the plugin.
- It reads license details from `WP_ROCKET_KEY` and `WP_ROCKET_EMAIL`, from the
  existing `wp_rocket_settings` option, or from a new WP Rocket download's
  generated `licence-data.php`. The license file is parsed as text and never
  executed.
- It attaches WP Rocket's license-bearing User-Agent to both the version check
  and the separate package-download request made by WordPress.
- It finds WP Rocket by its plugin header if the `wp-rocket` folder was renamed.
  On the Plugins screen it displays a red notice with a nonce-protected action
  that restores the folder name. The action requires WP Rocket to already be
  inactive and refuses ambiguous paths, non-direct plugin directories, and an
  existing destination.
- Successful API responses are cached for 12 hours. Transport errors are cached
  for one hour and HTTP errors for two hours.
- Visiting `plugins.php?rocket_force_update=1` as a user allowed to update
  plugins clears both update caches and forces a fresh request.
- Activating Updates Recovery redirects the activating administrator once to that
  forced-check URL, so the integration is tested immediately.
- WP Rocket's metadata row ends with a bold **Check Available Updates Now** link
  that runs the same forced check.
- An expired license can produce an update offer with no downloadable package,
  matching WP Rocket's own behavior.

## Limitations

The WP Rocket update endpoint, User-Agent format, and response format are private
implementation details and may change in future WP Rocket releases. If WP Rocket
fatals before WordPress Recovery Mode can provide an admin session, deactivate it
through the filesystem or database before using the Plugins screen.
