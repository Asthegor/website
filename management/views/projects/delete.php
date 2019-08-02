<?php
require_once('views/projectnavbar/projectnavbar.php');

$title = 'Projets';
$recordTitle = $viewModel['title_fr'].' ('.$viewModel['title_en'].')';
$returnPage = 'projects';

require('views/deleteform.php');
?>
