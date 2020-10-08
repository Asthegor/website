<h1>Contenu de la page principale</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php if (isset($viewModel['id']))
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
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?= isset($viewModel['title_fr']) ? urldecode($viewModel['title_fr']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) ? urldecode($viewModel['title_en']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Résumé français</label>
        <input type="text" name="short_desc_fr" value="<?= isset($viewModel['short_desc_fr']) ? urldecode($viewModel['short_desc_fr']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Résumé anglais</label>
        <input type="text" name="short_desc_en" value="<?= isset($viewModel['short_desc_en']) ? urldecode($viewModel['short_desc_en']) : ''; ?>" required />
    </div>

    <div class="form-group">
        <label>Page de destination</label>
        <input type="text" name="destination" value="<?= isset($viewModel['destination']) ? urldecode($viewModel['destination']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Ordre d'affichage</label>
        <input type="text" name="sortorder" value="<?= isset($viewModel['sortOrder']) ? $viewModel['sortOrder'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>content">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'content/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
