<?php
session_start();
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'FR';
}
header('Content-Type: text/html; charset=utf-8');

require 'config.php';

Profiling::StartChrono();

$mainController = new MainController($_GET);

Profiling::StartChrono('CreateController');

$controller = $mainController->createController();

Profiling::EndChrono('CreateController');

if ($controller) {
    $controller->executeAction();
}
Profiling::EndChrono();
Profiling::DisplayResults();
