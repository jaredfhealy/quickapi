<?php
// If the auth is false, a 403 response is returned
$auth = false;

// Check for a token matching the system property
if ($authToken === $modx->getOption('quickapi_x-api-key')) {
    // Add any additional logic as needed for your authorization
    
    // Set the final auth result
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