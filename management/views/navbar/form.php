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
        <label>Résumé français</label>
        <input type="text" name="short_desc_fr" value="<?= isset($viewModel['short_desc_fr']) ? urldecode($viewModel['short_desc_fr']) : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Résumé anglais</label>
        <input type="text" name="short_desc_en" value="<?= isset($viewModel['short_desc_en']) ? urldecode($viewModel['short_desc_en']) : ''; ?>" />
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
        <label>Page</label>
        <input type='hidden' name="bPage" value="0" />
        <input type="checkbox" name="bPage" value="1" <?= (isset($viewModel['bPage']) && $viewModel['bPage']) ? 'checked' : ''; ?> />
    </div>
    <div class="form-group">
        <label>Menu</label>
        <input type='hidden' name="bInNavBar" value="0" />
        <input type="checkbox" name="bInNavBar" value="1" <?= (isset($viewModel['bInNavBar']) && $viewModel['bInNavBar']) ? 'checked' : ''; ?> />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type='hidden' name="bVisible" value="0" />
        <input type="checkbox" name="bVisible" value="1" <?= (isset($viewModel['bVisible']) && $viewModel['bVisible']) ? 'checked' : ''; ?> />
    </div>
    <div class="form-group">
        <?php
        if (isset($viewModel['id_Image']))
        {
            $imagesmodel = new ImagesModel();
            $image = $imagesmodel->getImage($viewModel['id_Image']);
            ?>
            <img src="data:image/jpeg;base64,<?= $image['img_blob']; ?>" alt="<?= $image['name']; ?>">
            <?php
        }
        else
        {
            ?>
            <label>Image</label>
            <?php
        }
        ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="255000" />
        <input type="file" name="itemimage" />
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
