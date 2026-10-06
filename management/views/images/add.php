<h1>Nouvelle image</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label>Répertoire</label>
        <select name="directory">
            <option value=""></option>
            <?php
            $img = new ImagesModel();
            $imgdir = $img->GetImageDirectories();
            foreach ($imgdir as $dir)
            {
                ?>
                <option value="<?= basename($dir); ?>"><?= basename($dir); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div>
        <input type="file" name="upfile" id="upfile">
    </div>
    <br>
    <br>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>images">Cancel</a>
</form>
