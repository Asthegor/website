<?php
require('views/main/header.php');
?>

  <main role="main" class="container">
    <?php Messages::display(); ?>
    <?php require($view); ?>
  </main>
<?php
require('views/main/footer.php');
?>