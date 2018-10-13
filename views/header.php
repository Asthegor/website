<?php
Profiling::StartChrono('Header_Session');
if(!isset($_SESSION['language'])) $_SESSION['language'] = 'FR';
$language = $_SESSION['language'];
Profiling::EndChrono('Header_Session');
?>
<!DOCTYPE html>
<html>
<?php Profiling::StartChrono('Header_head'); ?>
<head>
  <meta charset="UTF-8">
  <meta name="author" content="LACOMBE Dominique">
  <meta name="description" content="LACOMBE Dominique's portfolio">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript,PHP,C#,C++,VB,HP,AssetManager,Games,jeux,programming">
  <title>LACOMBE Dominique | Portfolio</title>
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/bootstrap.css" />
 
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="<?= ROOT_URL; ?>assets/jquery/jquery.flip.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Comfortaa|Courgette" rel="stylesheet">
  <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/logo/logo_48x48.png" type="image/x-icon"/>
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<?php Profiling::EndChrono('Header_head'); ?>

<body>
<?php Profiling::StartChrono('Body_Header'); ?>
  <header>
    <a href="<?= ROOT_URL; ?>"><img src="<?= ROOT_URL; ?>assets/images/logo/logo_textonly_475x150.png"/></a>
  </header>
  <?php Profiling::EndChrono('Body_Header'); ?>

  <?php
  Profiling::StartChrono('Header_navbar');
  include_once(__DIR__.'/navbar.php');
  Profiling::EndChrono('Header_navbar');
  ?>
