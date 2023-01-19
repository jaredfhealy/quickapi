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
    
    // If the identifier starts with the path root
    if (substr($identifier, 0, strlen($pathRoot)) === $pathRoot) {
        // Override the request alias
        $_REQUEST[$rAlias] = "quickapi-process";
        $_REQUEST['_quickapi'] = str_replace('api/', '', $identifier);
    }
}
