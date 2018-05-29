<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Société</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement "<?php echo $viewModel['name']; ?>" ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?php echo ROOT_MNGT.'company'; ?>" defaultValue />
</form>