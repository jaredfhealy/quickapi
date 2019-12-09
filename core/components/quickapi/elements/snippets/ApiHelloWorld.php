<?php
/**
 * Process the request and set the response body
 *
 * Each API Snippet contains the logic for that particular
 * API call. It does NOT need to set the $output or return
 * anything. The "QuickApi" snippet handles returning
 * the result.
 * 
 * @param {string} greeting Expected query parameter
 *
 */

// Set the response using the set response function
// Accepts prameters: ($success = true, $props = [], $msg = "", $code = 200)
$quickapi->setResponse(true, [
    "result" => $params['greeting'] . " world!!"
]);

// Use the setResponseValue function to add to the response array
$quickapi->setResponseValue('somekey', 'Some Value to send back in the api response');