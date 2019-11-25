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
2. Update your rewrite rules for NGINX or Apache
   - rewrite ^/quickapi/(.*)$ /quickapi?_quickapi=$1&$args;
3. Review the ApiAuthorized snippet and update logic as needed to
   handle permissions.
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
$api - quickapi.class.php instance
$method - HTTP method
$body - Associative array converted from JSON body if present
$path - Simple array of path segments after the service/snippet name
     (Ex: "/hello_world/wold/12" creates array ["world","12"] )
$params - Associative array of query parameters