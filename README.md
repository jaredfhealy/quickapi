# QuickApi Summary
This is a simple Extra for Modx Revolution that adds an API methodology. This plugin makes it quick and easy to create API endpoints for single page applications (SPA), or for client side dymaic behavior or validation.

It is not intended to be a replacement for the Modx built REST Api. The existing API documentation can be found here: https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/developing-rest-servers. It is more robust, but also has more of a learning curve.

QuickApi keeps you in the platform and allows you to easily use snippets as your API endpoints with a single resource acting as your router for any path beginning with /quickapi/.

**Note**: This Extra is designed to work with friendly URLs.

## Instructions
1. Install the QuikApi Extra
2. Update your rewrite rules for NGINX or Apache
   * rewrite ^/quickapi/(.*)$ /quickapi?_quickapi=$1&$args;
3. Review the ApiAuthorized snippet and update logic as needed to
   handle permissions.
4. Create a Snippet for each of your endpoints.
   * Example: POST /api/validate_email/some.email@example.com
   * Snippet Name: ApiValidateEmail
   * Snippet Script:
   ```php
   <?php
   if ($method === 'POST' && $path[0] === 'some.email@example.com') {
     $quickapi->setResponse(true, ['result' => 'validated]);
   }
   ```
   
   * Response body returned:
   ```json
   {
     "success": true,
     "message": "",
     "result": "validated"
   }
   ```
   
## Snippet Parameters (scriptProperties)
Each Snippet receives the below properties which can be used within your snippet to determine what process needs to occur and to set the appropriate response.
* $api - Instance of: quickapi.class.php
* $method - HTTP method
* $body - Associative array converted from JSON body if present
* $path - Simple array of path segments after the service/snippet name
  * Example: The path "/hello_world/world/12" creates array ["world","12"]
* $params - Associative array of query parameters