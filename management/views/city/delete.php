<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Ville</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement "<?php echo $viewModel['name_fr'].' ('.$viewModel['name_en'].')'; ?>" ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?php echo ROOT_MNGT.'city'; ?>" defaultValue />
</form>