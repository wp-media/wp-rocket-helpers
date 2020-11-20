# WP Rocket | Remove HTML Expires from .htaccess rules

Removes WP Rocket’s HTML expires rules from .htaccess.
Upon activation, this helper will remove the following lines from our expires ruels: 

   `# Your document html`
  ` ExpiresByType text/html        "access plus 0 seconds"`

These lines will be added back when the plugin is deactivated. 

Last tested with:
- WP Rocket 3.7.5
- WordPress 5.5.3
