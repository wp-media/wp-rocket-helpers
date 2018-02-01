# WP Rocket Helpers
This repository hosts a number of plugins that target specific use cases for WP Rocket.

WP Rocket is known to be straight-forward and easy to use. However, sometimes a specific use case might require to alter its functionality.

The plugins in this repository provide solutions for some of the more common use cases that still seem too “edge case” to be included as options in WP Rocket’s user interface.

## 📋 TL;DR
> - Helper Plugins, like WP Rocket, require PHP 5.3+.
> - Helper Plugins by design don’t have version numbers, because we don’t maintain them on a regular basis.
> - Helper Plugins provide a sustainable way to customize WP Rocket’s behaviour, because they’re easier to spot than code snippets hidden in functions.php.
> - 🚀 **All plugins from this repository require [WP Rocket](https://wp-rocket.me/) to be up and running on your WordPress site.** If you don’t use WP Rocket on your WordPress site, don’t install any of these plugins.
> - ☝️ **Test before use!** We don’t maintain all of these helper plugins actively at all times; some may target older versions of WP Rocket, or of other plugins. Some may even become outdated over time.

## Table of contents

1.[General notes](#1-general-notes)
   - [What are Helper Plugins?](#11-what-are-helper-plugins)
   - [Whom are Helper Plugins for?](#12-whom-are-helper-plugins-for)
   - [What are Helper Plugins not?](#13-what-are-helper-plugins-not)
* [Minimum requirements](#2-minimum-requirements)
* [How to use](#3-how-to-use)
   - [Installation](#31-installtion)
   - [Support](#32-support)
* [Naming conventions](#4-naming-conventions)
   - [Namespaces and functions](#41-namespaces-and-functions)
   - [Naming placeholder URLs, domains, values](#42-naming-placeholder-urls-domains-values)
* [License](#5-license)
* [Questions?](#6-questions)

---

## 1. General notes
### 1.1. What are Helper Plugins?
We use the term _“Helper Plugin”_ to describe a simple WordPress plugin that customizes the behaviour of WP Rocket in some sort of way.

A Helper Plugin usually consists of 1 single PHP file, wrapped in a folder, downloadable and installable as a regular ZIP.

> 💡 **The main idea of Helper Plugins is easy-to-spot customizations.**<br>
> Other than code snippets dumped into functions.php files, customizations that come wrapped in a little plugin can be spotted at a glance.

### 1.2. Whom are Helper Plugins for?
Helper Plugins are for all types of WP Rocket users:

* People who just know how to upload a WordPress plugin
* Technically well-versed site owners
* Experienced developers
* Our own support crew

#### WP Rocket users
If you don’t write code on a daily basis, you may want to [contact our support team](https://wp-rocket.me/support/) before using any of these plugins. (That is, unless you had contacted us already, and we sent you here.)

#### Developers
For developers and other code-savvy folk, many of WP Rocket’s functions, filters and action hooks used in these plugins are documented in our [developer docs](http://docs.wp-rocket.me/collection/86-codex).

### 1.3. What are Helper Plugins not?
**Helper Plugins are not works of elaborate software development.**
They are certainly not [OOP](https://en.wikipedia.org/wiki/Object-oriented_programming), nor even class-based—just simple, procedural functions.

**Helper Plugins are not versioned, changelogged, or maintained in the usual sense.**
We don’t guarantee that all Helper Plugins work with all WP Rocket versions at all times; however, when a Helper Plugin gets published, or updated, it usually sports a basic _“Last tested with”_ section in the README file.

## 2. Minimum requirements
Helper Plugins fall under the same minimum requirements as WP Rocket: **PHP 5.3* or greater, and **WordPress 4.1** or greater at the moment of this writing (early 2018).

## 3. How to use

- Each sub-folder in this repository contains at least 1 PHP file and 1 ZIP file.
- PHP files are for code-savvy people to take a look at what the plugin does.
- The ZIP file is the one you can download and install in WordPress.

> 💡 **Need help with downloading?**<br>
> Here’s an [animated GIF](/how-to-download-zip.gif) on how to download one of the ZIP files from this repository._

### 3.1. Installation

- Download one of the ZIP files from this repository.
- Don’t unpack it! If your browser unpacks it automatically (can happen e.g. with Safari), you will have to re-ZIP it before proceeding.
- Install the ZIP file through your WordPress admin interface: Go to _Plugins→Add&#160;new→Upload_, upload the ZIP file and activate the plugin.

### 3.2. Support
Support for WP Rocket is our business.&#160;🙂 <br>
**Got a valid license for WP Rocket?** Feel free to use our dedicated [support form](https://wp-rocket.me/support/)!<br>
**Don’t own a valid license?** You can get one [right here](https://wp-rocket.me/pricing/)!

## 4. Naming conventions
> 💡 **Folder names help grouping a folder in a list of other folders.**<br>
> That’s why folder names for these Helper Plugins start with a `wp-rocket`- prefix, followed by feature and action keywords.

While file lists are not always sorted by name, it’s the default sort on GitHub and in many FTP clients.

Inside the WordPress plugin folder, a Helper Plugin should be listed next to WP Rocket itself, so a user or support agent can easily spot it.

In this GitHub repository, plugins that address the same feature (cache, lazyload, .htaccess rewrites …) are listed in groups, thus making it easier to skim the repo for a specific plugin.

### 4.1. Namespaces and functions
> 💡 **We use PHP namespaces to improve readability.**<br>
> Replacing verbose function prefixes with a PHP namespace can make actual function names more comprehensive, and our code remains easy to read.

It’s easy to over-engineer naming conventions, so we stick to a pragmatic rule of thumb when in doubt:

1. Namespaces should be unique and consistent.
2. Function names should be descriptive.

We rely on one consistent namespace for all Helper Plugins, and descriptive subnamespaces for each plugin:

```php
namespace WP_Rocket\Helpers\{subnamespace(s)}
```

Or more specifically:

```php
namespace WP_Rocket\Helpers\{feature}\{what_this_plugin_does}
```

Example:
```php
namespace WP_Rocket\Helpers\cache\no_cache_for_admins;

function handle_cache_for_admins() {
    // Handle caching for logged-in administrators.
}
add_action( 'init', __NAMESPACE__ . '\handle_cache_for_admins' );
```

### 4.2. Naming placeholder URLs, domains, values
There is one domain on the internet for the sole purpose of _“illustrative examples in documents”_: [example.com](https://example.com/)

You can safely use it as anything you want:

```
https://example.com
http://example.com
https://sub-domain.example.com
person@example.com
ftp.example.com
```

> 💡 **Placeholders must be replaced!**<br>
> Whenever you see `example.com` in the code of a Helper Plugin, make sure you replace it with a custom value before you activate the plugin!

## 5. License

All plugins in this repository, like WordPress and WP Rocket, are licensed under [GNU General Public License v2 or later](/LICENSE).

## 6. Questions?

Shoot us a message at: [wp-rocket.me/contact/](https://wp-rocket.me/contact/?nocache)
