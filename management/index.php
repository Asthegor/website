<?php
session_start();

header('Content-Type: text/html; charset=utf-8');

require('config.php');

require('classes/Messages.php');
require('classes/Management.php');
require('classes/Controller.php');
require('classes/Model.php');

require('controllers/users.php');
require('controllers/home.php');
require('controllers/navbar.php');
require('controllers/content.php');
require('controllers/projects.php');
require('controllers/proglanguage.php');
require('controllers/framework.php');
require('controllers/devlog.php');
require('controllers/version.php');

require('controllers/resume.php');
require('controllers/tutorials.php');


require('models/users.php');
require('models/home.php');
require('models/navbar.php');
require('models/content.php');
require('models/projects.php');
require('models/proglanguage.php');
require('models/framework.php');
require('models/devlog.php');
require('models/version.php');
require('models/config.php');

require('models/tutorials.php');
require('models/resume.php');


$management = new Management($_GET);

$controller = $management->createController();

if($controller)
{
    $controller->executeAction();
}
?>