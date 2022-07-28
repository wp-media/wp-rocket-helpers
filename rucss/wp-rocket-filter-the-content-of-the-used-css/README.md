# WP Rocket | Filter the content of the Used CSS

Filter the content of Used CSS to add or remove style when needed.

How to use it: 

***Search and replace***
- Edit line 34 str_replace() function.
- Change `old` to the value to replace. Change `new` with the replacement value.
- To replace multiple inline css declarations, copy the entire line into a new line for each style declaration you want you replace.

***Prepend CSS to the Used CSS***
- Replace line 41's value with the desired style to prepend.

***Append CSS to the Used CSS***
- Replace line 49's value with the desired style to append.

Once the changes added, clear WP Rocket's cache.

Last tested with:
* WP Rocket 3.11.x
* WordPress 5.9.x