# WP Rocket | RUCSS Set Minimum Acceptable Size

With this helper you can use the rocket_min_rucss_size filter to set the minimum size of Used CSS that is acceptable. 150 is the default.
Some examples of limits: 
 
     2kb  = 2000
     4kb  = 4000
     8kb  = 8000
     10kb = 10000
     12kb = 12000
     14kb = 14000


How to use it: 
 * Use Postman to see the size of the usedCSS, is at the very bottom as `shakedCSS_size` The size in in bytes. So for example, if the shakedCSS_size is 131827 this equals 132KB, this is the "good size".
 * Copy and paste the used css from a broken URL on a tool as https://www.javainuse.com/bytesize. This is the "bad size".
 *  The "bad" size should much lower than the "good" size, and this will give you the limit you have to set at rucss_min_css_size.
 * Tweak and install the helper: 
     *  Edit line 41, change `10000` with the minimum size. 
* Clear Remove Unused CSS

Last tested with:
* WP Rocket 3.15.x
* WordPress 6.4.x
