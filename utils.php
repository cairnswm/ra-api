<?php

function my_json_decode($s) {
    $s = str_replace(
        array('"',  "'"),
        array('\"', '"'),
        $s
    );
	$s = preg_replace('/(\w+):/i', '"\1":', $s);
	$s = str_replace(
        array('\"'),
        array('"'),
        $s
    );
	//echo $s;
	//var_dump(json_decode($s));
    return json_decode($s);
}

function getParam($name, $default = null) {
	global $postdata;
	if (isset($_GET[$name])) { return $_GET[$name]; }
	if (isset($_POST[$name])) { return $_POST[$name]; }
	if (isset($postdata) && isset($postdata[$name])) { return $postdata[$name]; }
	return $default;
}

function retrieveJsonPostData()
{
	// get the raw POST data
	$rawData = file_get_contents("php://input");
	// this returns null if not valid json
	return json_decode($rawData, true);
}

// Load POST/PUT parameters into common structure 
function getParameters($method)
{
	// PUT variables set in php://input - note the Content-Type must be correct (x-www-form-urlencoded)
	// POST variables in $_POST
	$input = null;
	// Load Parameters into generic variable
	switch ($method) {
	case 'PUT':
	case 'DELETE':
	    $put_data = file_get_contents('php://input');
		parse_str($put_data, $post_vars);
		$input = $post_vars; break;
	case 'POST':
		$contenttype = $_SERVER["CONTENT_TYPE"];
		// if application json content
		if ($contenttype == "application/json")
		{
			//echo "json";
			$put_data = file_get_contents('php://input');
			//parse_str($put_data, $post_vars);
			//echo "PutData".$put_data;
			$post_vars = my_json_decode($put_data, true);
			$input = (array) $post_vars;
		}
		else // if form data
		{
			//echo "Post"; var_dump($_POST);
			$input = $_POST;
		}
		 break;
	}
	return $input;
}

?>