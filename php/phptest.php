<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 25.07.2016
 * Time: 13:59
 */

// set the output content type as xml
header('Content-Type: text/json');

// create the response array
$response = array(
	'books' => array(
		array(
			'title' => "AJAX and PHP: Building Modern Web Applications, 2nd Ed",
			'isbn' => '978-1904817726'
		)
	)
);

// json-encode the array
echo json_encode($response);

?>