<?php


function listdir_by_date($path) {
	$filearray = array();
	foreach (glob($path . "/*") as $filename) {
		$file_array[filectime($filename)] = basename($filename);
	}
	krsort($file_array);
	return $file_array;
}

$key = $_GET['key'];
$data = "";

if ($key == '*') {
	$data = listdir_by_date('documents');
} else  {
	$file = 'documents/' . $key;
	if (file_exists($file)) {
		$data = file_get_contents($file);
	}
}
echo json_encode(array('data' => $data));

?>
