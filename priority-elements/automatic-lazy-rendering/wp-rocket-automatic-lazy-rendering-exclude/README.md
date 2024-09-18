
# WP Rocket | Exclude specific elements from Automatic Lazy Rendering

Allows to exclude specific elements from the Automatic Lazy Rendering optimization

Edit **line 32**, replace `.site-footer` with the element you'd like to exclude from Automatic Lazy Rendering 
You can use IDs, Classes, etc. If you want to exclude more than one element, you can separate with comma: 

	.element1, #element2, svg {...
	
Documentation:
* [Automatic Lazy Rendering](https://docs.wp-rocket.me/article/1835-automatic-lazy-rendering)

To be used with:
* Any setup where you want to exclude elements from Automatic Lazy Rendering.

Last tested with:
* WP Rocket 3.17
* WordPress 6.6.2