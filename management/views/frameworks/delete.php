<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Framework / Engin</h1>
Êtes-vous sûr de vouloir détruire l'enregistrement <?php echo $viewModel['name'].' ('.$viewModel['proglanguage'].')'; ?> ?
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="submit" name="todelete" value="Oui" />
    <input type="submit" name="no" value="Non" formaction="<?php echo ROOT_MNGT.'frameworks'; ?>" defaultValue />
</form>