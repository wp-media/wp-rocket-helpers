
# WP Rocket | Exclude specific elements from Automatic Lazy Rendering

Allows to exclude specific elements from the Automatic Lazy Rendering optimization

Edit **line 27**, replace `id="main-footer"` with the HTML of the element you'd like to exclude from Automatic Lazy Rendering 
 This filter matches HTML, so you have to use a portion of the HTML you want to exclude.
 If you want to exclude more elements you can uncomment and duplicate line 28: 
 $exclusions[] = 'class="popup-builder"';


Documentation:
* [Automatic Lazy Rendering](https://docs.wp-rocket.me/article/1835-automatic-lazy-rendering)

To be used with:
* Any setup where you want to exclude elements from Automatic Lazy Rendering.

Last tested with:
* WP Rocket 3.17
* WordPress 6.6.2