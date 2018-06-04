<?php
require_once('views/resumenavbar/resumenavbar.php');

$title = 'Ville';
$recordTitle = $viewModel['name_fr'].' ('.$viewModel['name_en'].')';
$returnPage = 'city';

require('views/deleteform.php');
?>