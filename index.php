<?php
session_start();
if(!isset($_SESSION['language']))
{
    $_SESSION['language'] = 'FR';
}
header('Content-Type: text/html; charset=utf-8');

require('config.php');

require('classes/Messages.php');
require('classes/MainController.php');
require('classes/Controller.php');
require('classes/Model.php');

require('controllers/home.php');
require('controllers/projects.php');
require('controllers/project.php');
require('controllers/experiences.php');

require('models/configs.php');
require('models/home.php');
require('models/navbar.php');
require('models/language.php');
require('models/projects.php');
require('models/project.php');
require('models/experiences.php');

$mainController = new MainController($_GET);
$controller = $mainController->createController();
if($controller)
{
    $controller->executeAction();
}
?>