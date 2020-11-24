# QuickApi Summary
This is a simple Extra for Modx Revolution that adds an API methodology. This plugin makes it quick and easy to create API endpoints for single page applications (SPA), or for client side dynamic behavior or validation.

This Extra is not intended to be a replacement for the MODX REST Api. The existing REST documentation can be found here: https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/developing-rest-servers. It is more robust, but also has more of a learning curve and is better for simple CRUD interactions with xPDO objects, both custom (myObject) and existing (modResource).

QuickApi keeps you in the platform and allows you to easily use snippets as your API endpoints with a single resource acting as your router for any path beginning with /api/ or your specified path.

**Note**: This Extra is designed to work with friendly URLs.

# Instructions
Below are the details to get up and running. The included snippet ApiHelloWorld is an example API endpoint.

## Install the QuikApi Extra
Install through the Extras installer in your MODX instance. See documentation here: https://docs.modx.com/revolution/2.x/administering-your-site/installing-a-package  

## Configure your API Path Root
Update the system setting "API Path Root" (`quickapi.path_root`). This is used in the Plugin to route requests to the correct resource, 'quickapi-process'. If you plan on using the default "api/" then no change is needed.

   
## Review the Default ApiAuthorized Snippet
This snippet handles the default authorization of all QuickApi calls. Authorization defaults to false and then is allowed by setting $auth to true for matching scenarios. See the ApiAuthorized snippet to see starting authorization using a header token, or by checking the logged in user.

The default configuration allows API calls for administrators or any logged user authenticated to the "web" context. If you want to allow a specific API for anyone, just add an authorization snippet as documented below.

If you need public APIs, endpoint specific authorization, or a different global authorzation check, you can override the Authorization. The following are checked in order and the first match is executed:
1. Check for endpoint specific authorization. This looks for a snippet with the below name format:
   * `/api/hello_world = ApiHelloWorldAuthorized`

1. Example specific authorization `/api/my_endpoint`
   * Snippet Name: "ApiMyEndpointAuthorized"
   ```php
   <?php
   // Only allow an App Admin
   if ($modx->user->isMember('AppAdmins')) {
     $auth = true;
   }
   ```

## Create a Snippet Endpoint
A standard MODX Snippet acts as the processor for the API endpoint/function. The available parameters are listed in the example ApiHelloWorld Snippet. Simply "Duplicate" the snippet, rename it and modify the code for your needs.

1. Example (Accessed at): POST /api/validate_email/some.email@example.com
   * Snippet Name (Interpreted from endpoint URL): ApiValidateEmail
   * Snippet Script:
   ```php
   <?php
   if ($method === 'POST' && $path[0] === 'some.email@example.com') {
     $quickapi->setResponse(true, ['result' => 'validated']);
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

* $quickapi - Instance of: quickapi.class.php
* $method - HTTP method
* $body - Associative array converted from JSON body if present
* $path - Simple array of path segments after the service/snippet name
  * Example: The path `/hello_world/world/12` creates array `["world","12"]`
* $params - Associative array of query parameters
