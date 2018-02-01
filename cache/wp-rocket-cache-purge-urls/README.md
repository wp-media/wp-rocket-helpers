# WP Rocket | Purge Custom Post URLs

Purges a custom set of URLs additional to WP Rocket’s automatic cache purging when a post is updated.

🚧&#160;&#160;**ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**

📝&#160;&#160;**Manual code edit required before use!**

## Add custom URLs to be purged when post gets updated
You can add your custom URLs that you want purged whenever the post gets updated.

For example, there could be a page displaying a custom category query.
Such a query template would not be covered by WP Rocket’s default procedure for smart post cache purging. You would have to manually add the URL of said page to the set of URLs to be purged upon a post update.

## Add a custom condition for posts
This is optional in case you would like to control which sort of posts the further code of this plugin should get applied to.

As an example we have added a condition that would make the custom set of URLs defined later in the plugin only be purged from cache if the post that gets updated belongs to a specific category with the slug `example-category`.

To be used with:
* any setup

Last tested with:
* WP Rocket 2.8.x
* WordPress 4.6.x
