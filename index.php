<?php
session_start();
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'FR';
}
header('Content-Type: text/html; charset=utf-8');
require 'config.php';


Profiling::StartChrono();

$mainController = new MainController($_GET);
$controller = $mainController->createController();
if ($controller) {
    $controller->executeAction();
}
Profiling::EndChrono();
Profiling::DisplayResults();
?>