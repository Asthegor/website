<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Management</title>
    <link rel="stylesheet" href="<?= ROOT_URL; ?>assets/css/styles.css"></link>
    <link rel="shortcut icon" href="<?= ROOT_URL; ?>assets/images/logo/logo_48x48.png" type="image/x-icon"/>
</head>
<body>
  <?php if (isset($_SESSION['is_logged_in'])) : ?>
    <ul class="nav-bar">
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>">Home</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>navbar">Menu</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>content">Contenu</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>projects">Projets</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>resume">Expériences</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>education">Scolarité</a></li>
      <li class="nav-item"><a href="<?= ROOT_MNGT; ?>configs">Configuration</a></li>
      <li class="nav-item"><a id="nav-item-site" href="<?= ROOT_URL; ?>" target="_blank">Voir sur le site</a></li>
      <li id="nav-item-last-child" class="nav-item"><a href="<?= ROOT_MNGT; ?>users/logout">Logout</a></li>
    </ul>
  <?php endif; ?>
  <main role="main" class="container">
    <?php Messages::display(); ?>
    <?php require($view); ?>
  </main>
</body>
</html>