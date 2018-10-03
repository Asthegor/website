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
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css" />
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="<?= ROOT_URL; ?>assets/jquery/jquery.flip.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Comfortaa|Courgette" rel="stylesheet">
  <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/logo/logo_48x48.png" type="image/x-icon"/>
</head>

<body>
  <header>
    <img src="<?= ROOT_URL; ?>assets/images/logo/logo_textonly_475x150.png"/>
    <h1 id="maintitle"><?= ConfigModel::getConfig('MAIN_TITLE_'.$language); ?></h1>

</header>

  <?php
  include('views/main/navbar.php');
  ?>
