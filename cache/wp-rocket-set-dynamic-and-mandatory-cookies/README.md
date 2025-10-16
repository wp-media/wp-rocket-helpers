
# WP Rocket | Set Dynamic and Mandatory Cookies

Adds **Mandatory** and/or **Dynamic** cookies to WP Rocket’s configuration.

- **Mandatory cookies** prevent the cache from being served until the specified cookie(s) exist in the visitor’s browser. (e.g. geolocation detection, language setting, etc)
- **Dynamic cookies** create separate cache files depending on the value of each specified cookie. (e.g. geolocation, currency, preferences).

📘 **Documentation:**  
[Create Different Cache Files with Dynamic and Mandatory Cookies](https://docs.wp-rocket.me/article/1313-create-different-cache-files-with-dynamic-and-mandatory-cookies)


## 📝 Manual code edit required before use!

Before activating the plugin, open the PHP file and scroll to the sections:

### **Mandatory Cookies**
At the top of the file, find:

```php
function add_mandatory_cookies( array $cookies ) {
    // Edit below: add one cookie name per line.
    $cookies[] = 'mandatory_cookie';
    return $cookies;
}
```

Replace `'mandatory_cookie'` with your own cookie name(s).  
You can add more cookies by duplicating the `$cookies[] = 'cookie_name';` line.

Comment this line if you don't need mandatory cookies.

### **Dynamic Cookies**
Then locate:

```php
function add_dynamic_cookies( array $cookies ) {
    // Edit below: add one cookie name per line.
    $cookies[] = 'dynamic_cookie';
    return $cookies;
}
```

Replace `'dynamic_cookie'` with your own cookie name(s).  
You can add multiple cookies in the same way.

Comment this line if you don't need dynamic cookies.


---

## Installation

1. Edit the plugin file as described above.  
2. zip it, and upload it to  **WP Admin -> Plugins**
4. Activate it.
   WP Rocket’s configuration and `.htaccess` rules will automatically regenerate.

---

### Last tested with:
- **WP Rocket:** 3.20.x  
- **WordPress:** 6.x
