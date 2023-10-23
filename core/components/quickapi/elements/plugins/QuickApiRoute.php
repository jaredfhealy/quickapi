<?php
/**
 * @var modX $modx
 * @var array $scriptProperties
 */

// Don't process for manager
if ($modx->context->key == 'mgr') return;

// Get the event name and process
$event = $modx->event->name;
if ($event == 'OnMODXInit') {
    // Check for the rewrite query prameter, and get the value
    $rAlias = $modx->getOption('request_param_alias', null, 'q');
    $identifier = isset ($_REQUEST[$rAlias]) ? $_REQUEST[$rAlias] : $identifier;
    
    // Get the path root property
    $pathRoot = $modx->getOption('quickapi.path_root', null, 'api/');
        
    // Multi Context Mode    
    preg_match('/^((en|de)\/)?/i', $identifier, $baseUrl);
    $aliasPrefix = $baseUrl[0];

    // If the identifier starts with the path root
    if (substr($identifier, 0, strlen($aliasPrefix . $pathRoot)) == $aliasPrefix . $pathRoot) {
        // Override the request alias
        $_REQUEST[$rAlias] = $aliasPrefix . 'quickapi-process';
        $_REQUEST['_quickapi'] = str_replace($aliasPrefix . 'api/', '', $identifier);
    }
}
