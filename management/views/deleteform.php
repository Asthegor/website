<h1><?= $title; ?></h1>
<p>&Ecirc;tes-vous s&ucirc;r de vouloir d&eacute;truire l'enregistrement "<?= $recordTitle; ?>" ?</p>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id" value="<?= $viewModel['id']; ?>" />
    <input class="btn btn-primary btn-danger" type="submit" name="todelete" value="Oui" style="width:50%;"/>
    <input class="btn btn-primary" type="submit" name="no" value="Non" formaction="<?= ROOT_MNGT.$returnPage; ?>" style="width:50%;" defaultValue />
</form>