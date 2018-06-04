<?php
require_once('views/resumenavbar/resumenavbar.php');

$title = 'Expériences';
$recordTitle = urldecode($viewModel['title_fr']).' ('.urldecode($viewModel['title_en']).')';
$returnPage = 'resume';

require('views/deleteform.php');
?>