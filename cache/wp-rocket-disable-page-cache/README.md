# WP Rocket | Disable Page Cache

<br>By default, this helper plugin disables cache for all pages while allowing WP Rocket's other optimizations to still be applied.

However, it can also be configured to disable either cache only or cache & optimizations just for specific pages. To do this, change the `disable_cache_for_all` value to false.

Then adjust the remaining configurations using the `disable_cache_only` or `disable_cache_and_opts` options, depending on what you need to do. There are notes in the helper plugin explaining how to use each option.

Leave all configurations you're not using commented out.

**See documentation for more detailed info:**<br>
[Disable page caching](https://docs.wp-rocket.me/article/61-disable-page-caching)<br><br>

<br>

📝 **Edit only the following items within the `$disable_configs` array after the `// EDIT HERE` comment:**<br><br>

`disable_only_if_logged_in` - When set to `true`, this helper will only apply for logged-in page views (so User Cache must be enabled).

<br>

`disable_cache_for_all` - When set to `true` (default), this helper will exclude all pages from cache while allowing WP Rocket's other optimizations to still be applied.

<br>

`disable_by_path` - Disable pages based on path(s).

<br>

`disable_by_page_id` - Disable pages based on page ID(s).

<br>

`disable_by_regex` - Disable pages using custom regex(es).

<br>

`disable_by_category` - Disable pages under target categories.

<br>

`disable_by_shortcode` - Disable pages that use target shortcodes (specifiy the tag name).

<br>

`disable_by_condition` - Disable for pages based on various conditions. Don't add anything new to this config. Just uncomment the one(s) you want to use.

<br><br>



Last tested with **WP Rocket 3.16.4** and **WordPress 6.6.x**