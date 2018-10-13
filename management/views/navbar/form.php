<h1>Barre de navigation</h1>
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
        <input type="text" name="title_fr" value="<?= isset($viewModel['title_fr']) ? $viewModel['title_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) ? $viewModel['title_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Page de destination</label>
        <input type="text" name="destination" value="<?= isset($viewModel['destination']) ? $viewModel['destination'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Ordre d'affichage</label>
        <input type="text" name="sortorder" value="<?= isset($viewModel['sortOrder']) ? $viewModel['sortOrder'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Est une page ?</label>
        <input type="checkbox" name="bPage" value="1" <?= isset($viewModel['bPage']) && $viewModel['bPage'] ? 'checked' : ''; ?> />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>navbar">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'navbar/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
