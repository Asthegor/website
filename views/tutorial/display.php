<?php
if (!isset($_GET['id']) && !is_numeric($_GET['id']))
{
  header('Location: '.ROOT_URL.'tutorials');
}
include_once(__DIR__.'/tutonavbar.php')
?>
<div class="tutorial">
    <h1><?= urldecode($viewModel['title']); ?></h1>
    <p>Créé le : <?= $viewModel['date_creation']; ?><br>Dernière mise à jour : <?= $viewModel['date_update']; ?></p>
    <br>
    <p><?= urldecode($viewModel['content']); ?></p>
  </div>
</div>
