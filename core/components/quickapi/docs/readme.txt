--------------------
 QuickApi
--------------------
Author: Jared Healy
Website: Gearvy.com
--------------------

An API methodology Extra for MODX Revolution. This plugin
makes it quick and easy to create API endpoints for single
page applications (SPA), or for client side dymaic behavior
or validation.

** Note: This Extra is designed to work with friendly URLs

1. Install the QuikApi Extra
2. Update your rewrite rules for NGINX or Apache based on desired
   URI format. Replace "/api/" with "/myapi/" in the rewrite to match
   your preference.
   - rewrite ^/api/(.*)$ /quickapi?_quickapi=$1&$args;
   - RewriteRule ^/api/(.*)$ /quickapi-process?_quickapi=$1
3. Review the ApiAuthorized snippet. Create override MyApiAuthorized by
   Duplicating the snippet and naming the duplicate: MyApiAuthorized
   OR: You can create endpoint specific authorization by matching
   /api/hello_world to ApiHelloWorldAuthorized as your Snippet name
5. Create a Snippet for each of your endpoints.
   Example: POST /api/validate_email/some.email@example.com
   Snippet Name: ApiValidateEmail
   Snippet Script:
   <?php
   if ($method === 'POST' && $path[0] === 'some.email@example.com') {
     $quickapi->setResponse(true, ['result' => 'validated]);
   }
   
   Response body returned:
   Status 200
   {
     "success": true,
     "message": "",
     "result": "validated"
   }
   
Each Snippet receives the below properties:
-------------------------
$quickapi - quickapi.class.php instance
$method - HTTP method
$body - Associative array converted from JSON body if present
$path - Simple array of path segments after the service/snippet name
     (Ex: "/hello_world/wold/12" creates array ["world","12"] )
$params - Associative array of query parameters