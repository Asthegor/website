<?php
if ($_SERVER['HTTP_HOST'] == 'lacombed.mywhc.ca')
{
    header("Location: https://www.lacombedominique.com" . $_SERVER['REQUEST_URI'], true, 301);
    exit();
}

session_start();
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'FR';
}

header('Content-Type: text/html; charset=utf-8');

require( __DIR__ . '/config.php');
require( __DIR__ . '/autoload.php');


$mainController = new MainController($_GET);
$controller = $mainController->createController();
if ($controller) {
    $controller->executeAction();
}
?>