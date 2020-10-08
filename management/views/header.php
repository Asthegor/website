<?php
if ($_SERVER["REQUEST_URI"] == __FILE__)
  header('Location: '.ROOT_URL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="LACOMBE Dominique">
  <meta name="description" content="LACOMBE Dominique's Portfolio">
  <meta name="keywords" content="Lua,Love2D,Games,jeux,programming,gameengine,unity,html,css,php">
  <title>Lacombe Dominique's Portfolio</title>
  <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/favicon.png" type="image/x-icon"/>
  
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa|Courgette">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css" />

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
  <header style="width:100%">
    <img src="<?= ROOT_URL; ?>assets/images/logo.png"/>
  </header>
  <?php
  $fileName = basename($_SERVER['REQUEST_URI']);
  if (isset($_SESSION['is_logged_in'])) : ?>
    <ul class="nav-bar">
      <li class="nav-item"><a <?= ($fileName == '' || $fileName == 'home') ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>">Home</a></li>
      <li class="nav-item"><a <?= $fileName == 'navbar' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>navbar">Menu</a></li>
      <li class="nav-item"><a <?= $fileName == 'content' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>content">Contenu</a></li>
      <li class="nav-item"><a <?= $fileName == 'projects' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>projects">Projets</a></li>
      <li class="nav-item"><a <?= $fileName == 'resume' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>resume">Expériences</a></li>
      <li class="nav-item"><a <?= $fileName == 'education' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>education">Scolarité</a></li>
      <li class="nav-item"><a <?= $fileName == 'poeme' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>poeme">Poèmes</a></li>
      <li class="nav-item"><a <?= $fileName == 'configs' ? ' class="active" ' : '' ?> href="<?= ROOT_MNGT; ?>configs">Configurations</a></li>
      <li class="nav-item"><a id="nav-item-site" href="<?= ROOT_URL; ?>" target="_blank">Voir sur le site</a></li>
      <li id="nav-item-last-child" class="nav-item"><a href="<?= ROOT_MNGT; ?>users/logout">Logout</a></li>
    </ul>
    <br>
  <?php endif; ?>
