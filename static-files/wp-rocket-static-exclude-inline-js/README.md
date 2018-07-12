# Exclude Inline JS From Combine

Exclude specified inline JS from WP Rocket JS combine. 

📝 **Manual code edit required before use!**

Look for line that starts with `$pattern[]` and replace `excludethis` with a unique string in the inline js that you wish to exclude. WP Rocket will search for this string in the inline JS to decide if it should be excluded or not. 

Documentation:
* [Exclude Inline JS From Combine](#)

To be used with:
* any setup, where "Combine JavaScript files" is enabled.

Last tested with:
* WP Rocket 3.1.x
* WordPress 4.9.x
