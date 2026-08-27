# WP Rocket - License Manager

You can use this helper plugin for safely changing WP Rocket license information (Email and/or API Key) preserving your current WP Rocket settings after the change. 

It automatically installs a tiny early-loading bootstrap in the WordPress mu-plugins directory; you do not need to install or manage the MU file yourself.

## Installation

1. In WordPress, open **Plugins > Add New Plugin > Upload Plugin**.
2. Upload the wp-rocket-license-manager.zip file.
3. Activate **WP Rocket - License Manager**.
4. Open **Settings > WP Rocket License**.
5. Enter the new API key and account email, then select **Validate and change license**. You can change only the API Key if needed

The same settings page is also available from **WP Rocket > License Manager** at the bottom of WP Rocket's top admin-bar menu.

The settings screen detects and prepopulates WP Rocket's current account email. The field remains editable so a user can switch to a different account.

Activation automatically copies the bundled bootstrap to:

    wp-content/mu-plugins/wp-rocket-license-manager-bootstrap.php

If WordPress cannot create or write that file, activation stops with an
actionable permissions error instead of enabling a partially working plugin.

## Safety behavior

- The complete wp_rocket_settings array is read before validation.
- Proposed credentials are supplied through temporary WP Rocket option filters,
  so invalid credentials never replace the existing option.
- On success, only consumer_key, consumer_email, secret_key, and license can be
  merged into the saved WP Rocket settings.
- If validation or saving fails, the previous credentials and settings remain
  in place.
- The validated bootstrap credentials are stored in the non-autoloaded
  wprlm_credentials option.
- The admin action requires the manage_options capability and a valid nonce.
- Deactivation removes the generated MU bootstrap but leaves WP Rocket's
  validated database settings intact.
- Uninstall removes both the generated bootstrap and the helper option.

The account change is permanent once validation succeeds. Deactivating or deleting this helper does not restore the previous account because the new validated credentials have also been saved in WP Rocket's own settings.

Important: If WP_ROCKET_KEY or WP_ROCKET_EMAIL is defined in wp-config.php or by another MU plugin, this helper detects them and shows a warning. remove those definitions before using this manager to change the credentials. WP Rocket's bundled licence-data.php is handled automatically after successful validation.