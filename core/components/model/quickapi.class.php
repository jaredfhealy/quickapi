<?php

class QuickApi
{
    /** @var modX $modx */
    public $modx;
	
	/* Public Vars */
	public $service = "Unknown";
	public $method;
	public $pathArr;
	public $paramsArr;
	public $bodyArr;
    
    /**
	 * @var array Placeholder response array
	 */
	public $response = [
		"success" => false,
		"message" => "Default Message: API Not found"
	];

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/quickapi/';
        $assetsUrl = MODX_ASSETS_URL . 'components/quickapi/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('quickapi', $this->config['modelPath']);
        $this->modx->lexicon->load('quickapi:default');
    }
    
    /**
	 * Set response variables for JSON output placeholders
	 *
	 * @param string $varName The array key to set
	 * @param any    $value   The value to set on that array key
	 */
	public function setResponseValue($varName, $value) 
	{
		$this->response[$varName] = $value;
	}
	
	/**
	 * Set specific response body
	 * 
	 * @param string  $msg   Optional message to send
	 * @param array   $props Optional, additional values to set on the response
	 * @param intiger $code  Optional HTTP response code to utilize
	 */
	public function setResponse($success = true, $props = [], $msg = "", $code = 200) 
	{
		// Set the success flag and message
		$this->response['success'] = $success;
		$this->response['message'] = $msg;
		
		// Merge the additional properties
		$this->response = array_merge_recursive($this->response, $props);
		$this->log(json_encode($this->response));
		
		// Set the response code
		http_response_code($code);
	}
	
	/**
	 * Return the response body as a JSON string
     *
     * @return string JSON response body
	 */
	public function getResponse() 
	{
		// If success is still false and code is 200
		if (!$this->response['success'] && http_response_code() === 200) {
			// Set the api name
			$this->response['message'] = "Api".$this->service." not found";
			
			// Default to a 404 in this case
			http_response_code(404);
		}
		
		// Return the json encoded string of the response array
		return json_encode($this->response);
	}
	
	/**
	 * Check the permissions
	 */
	public function checkPermissions()
	{
		// Default return
		$authorized = false;
		
		// Attempt to run an auth snippet
		$snippetAuth = $this->modx->runSnippet('ApiAuthorized', [
			"quickapi" => $this,
			"authToken" => $_SERVER['HTTP_X_API_KEY'],
			"hostname" => $_SERVER['HTTP_HOST'],
			"ipAddress" => $_SERVER['REMOTE_ADDR'],
			"method" => $this->method,
			"body" => $this->bodyArr,
			"path" => $this->pathArr,
			"params" => $this->paramsArr
		]);
		
		// If snippetAuth returns true, update authorized
		if ($snippetAuth === true) {
			$authorized = true;
		}
		
		// Return the result
		return $authorized;
	}
	
	/**
     * Send either to the unauthorized page or exit out with a 401
     */
    public function sendUnauthorized() 
	{
        http_response_code(403);
		@session_write_close();
		exit(0);
    }
	
	/**
	 * Get all parameters needed to pass to the api snippets
	 *
	 */
	public function prepare() 
	{
		// Get the needed parameters
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->pathArr = isset($_REQUEST['_quickapi']) ? explode("/", $_REQUEST['_quickapi']) : "";
		$this->bodyArr = json_decode(file_get_contents('php://input'), true);
		$this->paramsArr = [];
		foreach ($_GET as $key => $value) {
			if ($key !== '_api') {
				$this->paramsArr[$key] = $value;
			}
		}
		
		// Determine the snippet to run based on the first path parameter
		$this->service = $this->pathArr[0];
		if (strpos($this->service, '_') !== FALSE) {
			// Convert from some_function to SomeFunction
			$svcArr = explode("_", $this->service);
			foreach ($svcArr as $key => $value) {
				$svcArr[$key] = ucwords($value);
			}
			$this->service = implode("", $svcArr);
		}
		else {
			$this->service = ucfirst($this->service);
		}
		
		// Remove the service/function from the array if there is more than 1
		if (count($this->pathArr) > 0) {
			array_shift($this->pathArr);
		}
		else {
			$this->pathArr = [];
		}
	}
	
	/**
	 * Determines the correct processing function to call, processes the
	 * request and returns the JSON response/result.
	 *
	 */
	public function process() 
	{
		// Execute the snippet prefixed with 'Api'
		$this->log("About to try the snippet: Api".$this->service);
		try {
			$this->log("Snippet: Api".$this->service);
			$this->modx->runSnippet("Api".$this->service, [
				"quickapi" => $this,
				"method" => $this->method,
				"body" => $this->bodyArr,
				"path" => $this->pathArr,
				"params" => $this->paramsArr
			]);
		}
		catch (Exception $e) {
			// Set a 500 response and error message
			http_response_code(500);
			$this->setResponse('message', "Fatal exception: " . $e->getMessage());
		}
		
		// Return the response
		return $this->getResponse();
	}
	
	/**
	 * Private logging function
	 * 
	 * @param string $msg Message to log
	 * @return void
	 */
	public function log($msg, $level = 'error')
	{
		$levelMap = [
			'error' => modX::LOG_LEVEL_ERROR,
			"info" => modX::LOG_LEVEL_INFO,
			"debug" => modX::LOG_LEVEL_DEBUG
		];
		$this->modx->log($levelMap[$level], $msg);
	}
}