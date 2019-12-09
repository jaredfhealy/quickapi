<?php
// Default output
$output = [
    "success" => false,
    "message" => "Unable to process request"
];

$quickapi = $modx->getService('QuickApi', 'QuickApi', MODX_CORE_PATH . 'components/quickapi/model/quickapi/', $scriptProperties);
if ($quickapi) {
    // First prepare the properties
    $quickapi->prepare();
    
    // Make sure the user has the proper permissions, send the user a 403 error if not
    if (!$quickapi->checkPermissions()) {
        $quickapi->sendUnauthorized();
    }
    
    // Authorization succeeded
    else {
        // Process the api snippet
        $output = $quickapi->process();
    }
}
else {
    $output['message'] = "API Service Unavailable";
}

// Api class returns a string, check the type
if (!is_string($output)) {
    http_response_code(500);
    $output = json_encode($output);
}

return $output;