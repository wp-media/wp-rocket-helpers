# WP Rocket | Regex Exclusions

Adds custom cache exclusions based on real Regular Expressions.

🚧&#160;&#160;**ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**

📝&#160;&#160;**Manual code edit required before use!**

The WP Rocket plugin settings page cache exclusion field for URLs only supports simple Regular Expressions like `/(.*)` as a wildcard. RegExes with question marks such as `/(.*?\/)` get stripped by URL validation.

Regexes should target only the path of pages (not the protocol or domain) and must start with a / in order to work correctly.

To be used with:
* any setup

Last tested with:
* WP Rocket 3.18.x
* WordPress 6.7.x
