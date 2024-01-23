# WP Rocket | Fix encoded characters in the Used CSS

In some cases the Used CSS contains encoded characters, so for example a space " " will be replaced by a "%20" and this causes layout errors. This helper decodes the encoded characters in the Used CSS fixing the issue.

Current replacements: 
```$css = str_replace('%20', ' ', $css);
$css = str_replace('%7B', '{', $css);
$css = str_replace('%7D', '}', $css);
$css = str_replace('%3E', '>', $css);
$css = str_replace('%3c', '>', $css);
$css = str_replace(' ', ' ', $css);```


How to use it: 
* Check to see if there are more encoded elements, you can search for % in the wpr-usedcss inline style.
* Tweak and onstall the helper
* Clear WP Rocket's cache
 

Last tested with:
* WP Rocket 3.15.x
* WordPress 6.4.x
