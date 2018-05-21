<h1>Contenu de la page principale</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?php echo $viewModel['id']; ?>" readonly />
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?php echo isset($viewModel['title_fr']) ? $viewModel['title_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?php echo isset($viewModel['title_en']) ? $viewModel['title_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Page de destination</label>
        <input type="text" name="destination" value="<?php echo isset($viewModel['destination']) ? $viewModel['destination'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Ordre d'affichage</label>
        <input type="text" name="sortorder" value="<?php echo isset($viewModel['sortOrder']) ? $viewModel['sortOrder'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?php echo isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?php echo ROOT_MNGT; ?>content">Cancel</a><br>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?php echo ROOT_MNGT.'content/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
