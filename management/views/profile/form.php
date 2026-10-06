<h1>Profil</h1>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php
    if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?= $viewModel['id']; ?>" readonly />
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <label>Contenu française</label>
        <textarea class="noiframe" rows="6" cols="150" name="content_fr" required><?= isset($viewModel['content_fr']) ? urldecode($viewModel['content_fr']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Contenu anglaise</label>
        <textarea class="noiframe" rows="6" cols="150" name="content_en"><?= isset($viewModel['content_en']) ? urldecode($viewModel['content_en']) : ''; ?></textarea>
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>resume">Cancel</a>
</form>
