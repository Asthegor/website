<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Projets</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement "<?= urldecode($viewModel['title_fr']).' ('.urldecode($viewModel['title_en']).')'; ?>" ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?= $viewModel['id']; ?>" />
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?= ROOT_MNGT.'resume'; ?>" defaultValue />
</form>