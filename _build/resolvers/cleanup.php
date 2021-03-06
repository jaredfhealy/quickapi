<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
	$modx =& $transport->xpdo;

	// Query for the created content type
	$type = $modx->getObject('modContentType', ['name' => 'REST-Like']);

	// If we have a type
	if ($type) {
		// Get the quickapi resource
		$resource = $modx->getObject('modResource', ['alias' => 'quickapi-process']);

		// If we have a resource
		if ($resource) {
			// Update the content type
			$resource->set('content_type', $type->get('id'));
			$resource->save();
		}
	}
}

return true;