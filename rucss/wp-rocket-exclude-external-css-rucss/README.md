
# WP Rocket | Exclude Inline Styles from Remove Unused CSS

Exclude **inline styles** from being removed by WP Rocket’s Remove Unused CSS optimizations.
By default, Remove Unused CSS will remove *every* stylesheet and inline styles after the optimization is applied. 
In some cases, you might want to preserve inline styles, and you can use this helper to achieve it.

Documentation:
* https://docs.wp-rocket.me/article/1694-prevent-inline-styles-from-being-removed-by-remove-unused-css

How to use it: 
* Choose one CSS selector from inside the `<style>` declaration, the more specific the better, this way only the inline style you want will be preserved.
* The full `<style>` block containing that declaration will be preserved in the HTML code.
* Edit line 28, change `'.yourSelector'` by the class you'd like to preserve:
    `$inline_exclusions[] = '.yourSelector';`
* To exclude multiple inline css declarations, copy the entire line into a new line for each style declaration you want you exclude.
* Clear WP Rocket's cache.

Last tested with:
* WP Rocket 3.11.x
* WordPress 5.9.x
