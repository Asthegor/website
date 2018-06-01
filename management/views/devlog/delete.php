<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>DevLog</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement "<?= $viewModel['title_fr'].' ('.$viewModel['title_en'].')'; ?>" ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?= $viewModel['id']; ?>" />
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?= ROOT_MNGT.'devlog'; ?>" defaultValue />
</form>