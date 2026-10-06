<?php 
session_start();
require(__DIR__ . '/autoload.php');
require(__DIR__ . '/config.php');

$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

if (!empty($get['file'])) {
    $downloads_folder = __DIR__ . '/files/';
    $filename = basename($get['file']); // protection contre ../
    $filepath = $downloads_folder . $filename;

    // Interdire certains fichiers sensibles
    $forbidden = ['php', 'ini', 'htaccess'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), $forbidden)) {
        exit('Fichier non autorisé.');
    }

    if (file_exists($filepath) && is_file($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        Messages::setMsg("Fichier ".$filename." non trouvé !", 'error');
        header("Location: ./index.php");
        exit;
    }
} else {
    header("Location: ./index.php");
    exit;
}
?>
