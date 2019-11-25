<?php
/**
 * Process the request and set the response body
 *
 * Each API Snippet contains the logic for that particular
 * API call. It does NOT need to set the $output or return
 * anything. The "ProcessAPI" snippet handles returning
 * the result.
 * 
 * @param {string} greeting Expected query parameter
 *
 */

// Set the response
$quickapi->setResponse(true, [
	"result" => $params['greeting'] . " world!!"
]);