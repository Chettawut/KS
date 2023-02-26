<?php
session_start(); 
if (!isset($_SESSION['loggedin'])) {
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'Session not found.'));
    die;
}
$path = dirname(__FILE__, 3);
//include('../../conn.php');
if (isset($_GET['path'])) {
    //Read the url
    $url = $_GET['path'];
    $full_path = $path.$url;
    //Clear the cache
    clearstatcache(); 
    //Check the file path exists or not
    if (file_exists($full_path)) {

        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
        header('Content-Length: ' . filesize($full_path));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($full_path, true);

        //Terminate from the script
        die();
    } else {
        http_response_code(400);
        echo json_encode(array('status' => '0', 'message' => 'File not exists.'));
        die;
    }
}else{
    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => 'File path is not defined.'));
    die;
} 
