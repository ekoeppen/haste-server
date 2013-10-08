<?php


function listdir_by_date($path) {
	$filearray = array();
	foreach (glob($path . "/*") as $filename) {
		$file_array[filectime($filename)] = basename($filename);
	}
	krsort($file_array);
	return $file_array;
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
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
} else if ($method == 'DELETE') {
	$key = str_replace(array('/', '.', ':', '?', '+'), "_", $_GET['key']);
	$data = "";

	$file = 'pastes/' . $key;
	if (file_exists($file)) {
		$data = $file;
		unlink($file);
	}
	echo json_encode(array('data' => $data));
} else if ($method == 'POST') {
	$key = str_replace(array('/', '.', ':', '?', '+'), "_", $_SERVER['HTTP_TITLE']);
	$data = file_get_contents("php://input");
	file_put_contents('pastes/' . $key, $data);
	echo json_encode(array('key' => $key));
}

?>
