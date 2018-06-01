<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Ville</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement "<?= $viewModel['name_fr'].' ('.$viewModel['name_fr'].')'; ?>" ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?= ROOT_MNGT.'country'; ?>" defaultValue />
</form>