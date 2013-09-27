<?php


function listdir_by_date($path) {
	$filearray = array();
	foreach (glob($path . "/*") as $filename) {
		$file_array[filectime($filename)] = basename($filename);
	}
	krsort($file_array);
	return $file_array;
}

if (isset($_GET['key'])) {
	$key = $_GET['key'];
	$data = "";

	if ($key == '*') {
		$data = listdir_by_date('pastes');
	} else  {
		$file = 'pastes/' . $key;
		if (file_exists($file)) {
			$data = file_get_contents($file);
		}
	}
	echo json_encode(array('data' => $data));
} else {
	$key = str_replace(array('/', '.', ':'), "_", $_SERVER['HTTP_TITLE']);
	$data = file_get_contents("php://input");
	file_put_contents('pastes/' . $key, $data);
	echo json_encode(array('key' => $key));
}

?>
