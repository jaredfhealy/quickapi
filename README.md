# QuickApi Summary
This is a simple Extra for Modx Revolution that adds an API methodology. This plugin makes it quick and easy to create API endpoints for single page applications (SPA), or for client side dymaic behavior or validation.

This Extra is not intended to be a replacement for the MODX REST Api. The existing API documentation can be found here: https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/developing-rest-servers. It is more robust, but also has more of a learning curve and is better for simple CRUD interactions with xPDO objects, both custom (myObject) and existing (modResource).

QuickApi keeps you in the platform and allows you to easily use snippets as your API endpoints with a single resource acting as your router for any path beginning with /api/ or your specified path.

**Note**: This Extra is designed to work with friendly URLs.

# Instructions
Below are the details to get up and running. The included snippet ApiHelloWorld is an example API endpoint.

## Install the QuikApi Extra
Install through the Extras installer in your MODX instance. See documentation here: https://docs.modx.com/revolution/2.x/administering-your-site/installing-a-package  

## Update your rewrite rules. If you would like to use something other than "/api/" as your path root, update it in the rewirite rules.
1. NGINX
   * rewrite ^/api/(.*)$ /quickapi-process?_quickapi=$1&$args;
2. Apache .htaccess
   * RewriteRule ^/api/(.*)$ /quickapi-process?_quickapi=$1
   
## Review the ApiAuthorized Snippet
This snippet handles the initial authorization of all QuickApi calls. You could check the service and method here and respond accordingly. This snippet has access to the same properties/variables as all the snippets called by QuickApi. See below for the full list.

1. Example specific authorization
   ```php
   <?php
   // Get the service translated from /api/my_endpoint
   if ($api->service === 'MyEndpoint' && $method === 'POST') {
     // If they are not an App Admin
     if (!$modx->user->isMember('AppAdmins')) {
       $auth = false;
     }
   }
   
   ```
## Create a Snippet Endpoint

1. Example (Accessed at): POST /api/validate_email/some.email@example.com
   * Snippet Name (Interpreted from endpoint URL): ApiValidateEmail
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
   
# Snippet Variables Available
Each Snippet receives the below properties which can be used within your snippet to determine what process needs to occur and to set the appropriate response.

* $api - Instance of: quickapi.class.php
* $method - HTTP method
* $body - Associative array converted from JSON body if present
* $path - Simple array of path segments after the service/snippet name
  * Example: The path "/hello_world/world/12" creates array ["world","12"]
* $params - Associative array of query parameters