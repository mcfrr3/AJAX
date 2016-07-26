<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 26.07.2016
 * Time: 14:24
 */

$uploaddir = './uploads/';
$file = $uploaddir . basename($_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
	$result = 1;
}else{
	$result = 0;
}

sleep(10);
echo $result;

?>