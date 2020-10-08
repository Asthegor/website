<?php
if(!isset($_SESSION['language'])) $_SESSION['language'] = 'FR';
$language = $_SESSION['language'];
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta name="author" content="LACOMBE Dominique">
  <meta name="description" content="LACOMBE Dominique's website">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript,PHP,C#,C++,VB,HP,AssetManager,Games,jeux,programming">
  <title>LACOMBE Dominique | Website</title>
  <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/favicon.png" type="image/x-icon"/>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa|Courgette">
  <link href="https://fonts.googleapis.com/css?family=Courgette&display=swap" rel="stylesheet">

  <script src="<?= ROOT_URL; ?>assets/jquery/jquery-2.1.4.min.js"></script>
  <script src="<?= ROOT_URL; ?>assets/jquery/jquery.flip.min.js"></script>
  <script src="<?= ROOT_URL; ?>assets/jquery/jquery-ui.min.js"></script>

  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/js/styles/railscasts.css">
  <script src="<?= ROOT_URL; ?>assets/js/highlight.pack.js"></script>
  <script>hljs.initHighlightingOnLoad();</script>
  
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css" />

</head>

<body>

