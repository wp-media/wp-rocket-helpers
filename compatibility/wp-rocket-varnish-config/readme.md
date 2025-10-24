
# WP Rocket | Varnish customize IP & Host

  

This helper plugin allows you to **customize the IP, host, scheme, and request arguments** used by WP Rocket when purging the Varnish cache.



Useful when your site uses a **reverse proxy**, **load balancer**, or **external Varnish instance**, and WP Rocket needs to send purge requests to a specific IP, hostname, or port.



##  Configuration

Open the helper file and edit the following sections to match your setup.

### 1. Define custom Varnish IPs


```php

$ips[] =  '127.0.0.1:80';

```

  

- In line 28: Add one or more IPs (with optional port).
- Example:

```php

$ips[] =  '192.168.0.5:6081';
$ips[] =  '10.0.0.15';

```

### 2. Define custom hostname

  
```php

$custom_host  =  'example.com';

```

 

- In line 42: Replace `example.com` with your public domain.
- This ensures purge requests use the correct host header when going through a proxy.


### 3. Define purge scheme

  
```php

return  'http'; // or 'https'

```

  

- In line 59: Set to `'https'` if your Varnish listens on a secure port.

  

### 4. Customize purge request arguments

  

```php

$args['method'] =  'PURGE'; // or 'BAN'
$args['blocking'] =  false;
$args['redirection'] =  0;
$args['headers']['X-Debug'] =  'WP-Rocket-Varnish-Helper';
```

  

In lines 70 to 80: You can modify:

-  **method**: PURGE (default) or BAN
-  **blocking**: `true` if you want WP Rocket to wait for the response
-  **headers**: add or override custom HTTP headers

  

## Use cases



This helper is ideal if:

- You use **Varnish behind a proxy** and WP Rocket purges the wrong IP or host.
- You want to **target a specific internal Varnish address**.
- You need to **switch to a different purge method** (like `BAN`).
- You want to **add debugging headers** or tweak the purge request behavior.
  

## Tested with

-  **WP Rocket:** 3.20.x
-  **WordPress:** 6.8.x

