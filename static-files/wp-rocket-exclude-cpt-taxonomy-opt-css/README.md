# WP Rocket | Exclude Post Types and Taxonomies from CPCSS generation

Exclude Post Types and Taxonomies from the Optimize CSS Delivery feature.

📝&#160;&#160;**Manual code edit required before use!**

When using Post Types and taxonomies which aren't set as _public_ you should exclude them from the CPCSS generation.

If you want to exclude only a Post Type, please comment out the following line, like this:
```
//add_filter( 'rocket_cpcss_excluded_taxonomies',  __NAMESPACE__ . '\wp_rocket_exclude_CPCSS_taxonomies');
```

If you want to exclude only a Taxonomy, please comment out the following line, like this:
```
add_filter( 'rocket_cpcss_excluded_post_types',  __NAMESPACE__ . '\wp_rocket_exclude_CPCSS_CPT');
```
