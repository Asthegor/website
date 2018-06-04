<?php
require_once('views/projectnavbar/projectnavbar.php');

$title = 'Version';
$recordTitle = $viewModel['num_version'].' ('.$viewModel['date_version'].')';
$returnPage = 'version';

require('views/deleteform.php');
?>