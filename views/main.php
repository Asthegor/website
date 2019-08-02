<?php
include_once(__DIR__.'/header.php');

if (get_class($this) !== 'Home')
{
  ?>
  <header>
    <a href="<?= ROOT_URL; ?>">
      <img src="<?= ROOT_URL; ?>assets/images/logo.png" alt="Logo LACOMBE Dominique">
    </a>
  </header>
  <?php
  include_once(__DIR__.'/navbar.php');
}
?>
  <main role="main" class="container">
    <?php 
    Messages::display();
    ?>
    <?php
    require($view);
    ?>
  </main>
<?php
include_once(__DIR__.'/footer.php');
?>