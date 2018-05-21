<?php
  include('functions/config.php');
  include('functions/web_functions.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="author" content="LACOMBE Dominique">
  <meta name="description" content="LACOMBE Dominique's portfolio">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript,PHP,C#,C++,VB,HP,AssetManager,Games,jeux,programming">
  <title>LACOMBE Dominique | Portfolio</title>
  <link rel="stylesheet" href="assets/css/styles.css"></link>
</head>

<body>
  <div class="header">
    <img src="assets/images/logo/logo_textonly_475x150.png"/>
    <h1>Portfolio de LACOMBE Dominique</h1>
  </div>

  <?php
  if (isset($_GET['language']))
  {
    if ($_GET['language'] != $_SESSION['language'])
    {
      $_SESSION['language'] = $_GET['language'];
    }
  }
  include('views/navbar.php');
  ?>
