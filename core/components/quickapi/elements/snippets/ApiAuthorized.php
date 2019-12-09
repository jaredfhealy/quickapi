<?php
/**
 * Default authorization snippet
 * 
 * You can override this authorization script in two ways.
 * 1. Create an api specific authorization snippet using the naming convention:
 *    Api<MethodName>Authorized (/api/hello_world = ApiHelloWorldAuthorized)
 * 2. Create a generic override for all API calls. Duplicate the current
 *    ApiAuthorized script and name it MyApiAuthorized
 * 
 * These are attempted in sequence. If an api specific authorization snipppet is
 * present, that will be executed. Next it checks for MyApiAuthorized, and finally
 * runs the ApiAuthorized only if no other authorization snippet was found.
 * 
 */

// If the auth is false, a 403 response is returned
$auth = false;

// Check for a token matching the system property
if ($authToken === $modx->getOption('quickapi.x_api_key', ['quickapi'], "")) {
    // Set auth to allow
    $auth = true;
}
else {
    // Check if the user is authenticated as an admin
    if ($modx->user->isMember('Administrator') && $modx->user->get('sudo') === true) {
        $auth = true;
    }
    else if ($modx->user->isAuthenticated('web')) {
        // Validate web user api calls
        $auth = true;
    }
}

return $auth;