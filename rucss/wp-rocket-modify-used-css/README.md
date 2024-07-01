# WP Rocket | Modify the Used CSS

Allows for a variety of modifications to the Used CSS, including excluding external and inline CSS, and adding and filtering content in the Used CSS.

How to use it:

📝 **MANUAL CODE EDIT REQUIRED BEFORE USE. HANDLE WITH CARE!**

There is a config section at the beginning that needs to be configured based on what you would like this helper to do. Please use the specific instructions for each function located in the config section, but here is an overview:

* `rocket_rucss_external_exclusions` - Excludes specific CSS files from being removed by RUCSS by targeting the path of the file.

* `rocket_rucss_inline_content_exclusions` - Excludes inline CSS within specific &lt;style&gt; elements by targeting specific CSS selectors.

* `rocket_rucss_inline_atts_exclusions` - Excludes inline CSS within specific &lt;style&gt; elements by targeting specific attributes applied to a &lt;style&gt; element.

* `rocket_rucss_skip_styles_with_attr` - Removes all styles entirely from either external CSS files or &lt;style&gt; elements with target attribute.

* `prepend_css` - Add the specified styles at the BEGINNING of the Used CSS.

* `append_css` - Add the specified styles at the END of the Used CSS.

* `filter_css` - Allows target CSS to be removed from the Used CSS and replaced with the specified new CSS.<br><br>

All of the config sections are commented out by default, so to use any of them, uncomment them (remove the 2 // at the beginning of the lines), and customize as needed.

More than one of the sections can be used at the same time. For example, you can both exclude an external CSS file and filter the content of the Used CSS if needed.<br><br>

**Documentation:**<br>
* [Troubleshoot Remove Unused CSS display issues](https://docs.wp-rocket.me/article/1718-troubleshoot-remove-unused-css-issues)<br>
* [Prevent CSS files from being removed by Remove Unused CSS](https://docs.wp-rocket.me/article/1714-prevent-css-files-from-being-removed-by-remove-unused-css)<br>
* [Prevent inline styles from being removed by Remove Unused CSS](https://docs.wp-rocket.me/article/1694-prevent-inline-styles-from-being-removed-by-remove-unused-css)<br><br>

**To be used with**
* Any setup that requires special customization of the Used CSS.<br><br>

**Last tested with:**

* WP Rocket 3.16.x
* WordPress 6.5.x