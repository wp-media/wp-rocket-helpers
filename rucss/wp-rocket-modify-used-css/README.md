# WP Rocket | Modify the Used CSS

Allows for a variety of modifications to the Used CSS, including excluding external and inline CSS, and adding and filtering content in the Used CSS. Most often needed when normal safelisting won't resolve layout isssues.<br><br>

> [!Important]
> MANUAL CODE EDIT REQUIRED BEFORE USE. HANDLE WITH CARE!<br><br>
> There is a config section at the beginning of the `wp-rocket-modify-used-css.php` file that has configurable options. Example values are provided for each option to help illustrate how to use them, but they are all commented out, so the plugin does nothing by default.<br><br>
> To use one or more of the options, remove the comment (`//`) and apply the needed values. Follow the detailed instructions below related to each option in order to use this helper plugin as needed:

<br>
<h2>rocket_rucss_external_exclusions</h2>

**Excludes specific CSS files from being removed by RUCSS by matching the path of the file.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img924/1585/eHoj9e.png"><br>

* Replace `/wp-content/plugins/plugin-name/css/file.css` with the path of the CSS file you want to exclude.

* When this is applied to a CSS file:
  * The CSS file will be loaded on the page rather than being removed (Remove Unused CSS normally removes all external CSS files).
  * The Used CSS from that file will also still be included in the Used CSS.

* Uses loose partial matching, so if any part of the path of the file is matched, it will be excluded.

* Wildcards `(.*)` and other regex items do not work. Only use simple string values.

* To exclude multiple files, copy the entire line into a new line below, then modify the value as needed for each CSS file to exclude.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>rocket_rucss_inline_content_exclusions</h2>

**Excludes inline CSS in &lt;style&gt; element(s) by matching any CSS selector contained within.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img923/8136/Mb5X8B.png"><br>

* Replace `.targetSelector` with any CSS selector found within the &lt;style&gt; element you want to exclude.

* When this is applied to a &lt;style&gt; element:
  * The &lt;style&gt; element will remain within the page with all its CSS content rather than being removed (Remove Unused CSS normally removes the content of all &lt;style&gt; elements).
  * The Used CSS from the &lt;style&gt; element will also still be included in the Used CSS.

* Uses loose partial matching, so if any part of any selector in the &lt;style&gt; element is matched, it will be excluded.

* Wildcards `(.*)` and other regex items do not work. Only use simple string values.

* To exclude multiple &lt;style&gt; elements, copy the entire line into a new line below, then modify the value as needed for each &lt;style&gt; element to exclude.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>rocket_rucss_inline_atts_exclusions</h2>

**Excludes inline CSS in &lt;style&gt; element(s) by matching one of their HTML attributes and (optionally) values.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img924/1548/FLGB7a.png"><br>

* Replace one of the 3 example values to match with any HTML attribute applied to the &lt;style&gt; element you want to exclude. The 3 examples account for: 
  * Matching the &lt;style&gt; element containing an attribute regardless of what value is applied.
  * Matching the attribute and value if the HTML uses <b>double</b> quotes.
  * Matching the attribute and value if the HTML uses <b>single</b> quotes.

* When this is applied to a &lt;style&gt; element:
  * The &lt;style&gt; element will remain within the page with all its CSS content rather than being removed (Remove Unused CSS normally removes the content of all &lt;style&gt; elements).
  * The Used CSS from the &lt;style&gt; element will also still be included in the Used CSS.

* Uses loose partial matching, so if any part of the attribute="value" string is matched, the &lt;style&gt; element is excluded.

* Wildcards `(.*)` and other regex items do not work. Only use simple string values.

* To exclude multiple &lt;style&gt; elements, copy the entire line into a new line below, then modify the value as needed for each &lt;style&gt; element to exclude.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>rocket_rucss_skip_styles_with_attr</h2>

**Removes from pages entirely all styles contained within external CSS files or &lt;style&gt; elements by matching one of their attributes or attribute and value pairs.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img924/3425/N4T6E2.png"><br>

* Replace one of the 3 example values to match with any HTML attribute applied to the element you want to exclude. The 3 examples account for: 
  * Matching the &lt;style&gt; element containing an attribute regardless of what value is applied.
  * Matching the attribute and value if the HTML uses <b>double</b> quotes.
  * Matching the attribute and value if the HTML uses <b>single</b> quotes.

* When this is applied to CSS files or &lt;style&gt; elements:
  * Target external CSS files are removed from pages completely.
  * Target inline &lt;style&gt; elements are emptied, but the tags still remain in the HTML for potential compatibility reasons.
  * No styles from any target CSS file or &lt;style&gt; elements are added to the Used CSS.
  * It's as if the target CSS files or &lt;style&gt; elements are not applied to the page at all.

* However, if the same CSS file or &lt;style&gt; element is simultaneously targeted with this option and one of the first 3 options above:
  * The styles will remain applied to the page exactly as they were without RUCSS optimization.
  * The related styles will not be added to the Used CSS.
  * It is effectively as though the Remove Unused CSS does nothing at all with the target CSS files or &lt;style&gt; elements.

* Uses strict matching, so either the full attribute name or full attribute="value" pair must be used for matching.
  * Matching only part of the attribute or attribute and selector will not work.
  * Matching only the value will also not work.

* Wildcards `(.*)` and other regex items do not work. Only use simple string values.

* To skip multiple CSS files or &lt;style&gt; elements, copy the entire line into a new line below, then modify the value as needed for each CSS file or &lt;style&gt; element to exclude.

* The Used CSS must be cleared when using this option.



<br>

<h2>prepend_css</h2>

**Add the specified styles at the BEGINNING of the Used CSS.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img922/9038/bFa5kO.png"><br>

* Provide as a simple string whatever valid CSS you would like to add at the beginning of the Used CSS.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>append_css</h2>

**Add the specified styles at the END of the Used CSS.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img922/2955/3HiqKn.png"><br>

* Provide as a simple string whatever valid CSS you would like to add at the end of the Used CSS.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>filter_css</h2>

**Allows target CSS to be removed from the Used CSS and replaced with new CSS.**<br><br>
<img style="margin-top:0;margin-bottom:0;" src="https://imagizer.imageshack.com/a/img922/3041/KGvA7O.png"><br>

* The top line (the 'to-be-removed' value) will be removed from the Used CSS.
  * Should be a simple string value (regex values will not work).

* The middle line (=>) should just be uncommented and otherwise left as is.

* The last line ('to-be-inserted' value) is the new CSS that will replace what is removed by the top line.
  * Should be a simple string value.

* If you only want to remove some part of the Used CSS, specificy that in the top line and leave the last line as an empty string (delete everything between the quotes).

* To do multiple replacements, duplicate the entire 3 lines and paste below, then customize for the other replacements.

* Only cache needs cleared when using this option (no need to clear Used CSS).

<br>

<h2>Additional Info</h2>

<h3>Documentation:</h3>

* [Troubleshoot Remove Unused CSS display issues](https://docs.wp-rocket.me/article/1718-troubleshoot-remove-unused-css-issues)
* [Preserve certain CSS when using Remove Unused CSS](https://docs.wp-rocket.me/article/1831-preserve-certain-css-when-using-remove-unused-css)

<h3>To be used with**</h3>

* Any setup that requires special customization of the Used CSS.

<h3>Last tested with:</h3>

* WP Rocket 3.16.x
* WordPress 6.5.x