<?php
if(!isset($_SESSION['language'])) $_SESSION['language'] = 'FR';
$language = $_SESSION['language'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="author" content="LACOMBE Dominique">
  <meta name="description" content="LACOMBE Dominique's portfolio">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript,PHP,C#,C++,VB,HP,AssetManager,Games,jeux,programming">
  <title>LACOMBE Dominique | Portfolio</title>
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css"></link>
  <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/logo/logo_48x48.png" type="image/x-icon"/>
</head>

<body>
  <div class="header">
    <img src="<?= ROOT_URL; ?>assets/images/logo/logo_textonly_475x150.png"/>
    <h1><?= ConfigModel::getConfig('MAIN_TITLE_'.$language); ?></h1>
    <h3 style="width: 100%; text-align: center;">
      <a href="mailto:lacombe.dominique@outlook.fr"><?= ConfigModel::getConfig('CONTACT_'.$language); ?></a>
    </h3>
  </div>

  <?php
  include('views/main/navbar.php');
  ?>
