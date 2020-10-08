<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Projets</h1>
<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
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
        <label>Framework/Engin</label>
        <select name="framework" required>
            <option value=""></option>
            <?php
            $fm = new FrameworksModel();
            $fmlist = $fm->getList();
            foreach ($fmlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= $viewModel['id_Framework'] == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?= isset($viewModel['title_fr']) ? urldecode($viewModel['title_fr']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description courte française</label>
        <input type="text" name="desc_fr" value="<?= isset($viewModel['desc_fr']) ? urldecode($viewModel['desc_fr']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="6" cols="150" name="description_fr"  required><?= isset($viewModel['description_fr']) ? urldecode($viewModel['description_fr']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) ? urldecode($viewModel['title_en']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description courte anglaise</label>
        <input type="text" name="desc_en" value="<?= isset($viewModel['desc_en']) ? urldecode($viewModel['desc_en']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="6" cols="150" name="description_en"  required><?= isset($viewModel['description_en']) ? urldecode($viewModel['description_en']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Site web</label>
        <input type="text" name="website" value="<?= isset($viewModel['website']) ? urldecode($viewModel['website']) : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="dateproject" value="<?= isset($viewModel['first_date_project']) ? $viewModel['first_date_project'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Numéro de version</label>
        <input type="text" name="num_version" value="<?= isset($viewModel['num_version']) ? $viewModel['num_version'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de la version</label>
        <input type="date" name="date_version" value="<?= isset($viewModel['date_version']) ? $viewModel['date_version'] : ''; ?>" />
    </div>
    <div class="form-group">
        <?php
        if (isset($viewModel['id']))
        {
            $project = new ProjectsModel();
            $image = $project->getImage($viewModel['id']);
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
        <input type="file" name="projectimage" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>projects">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'projects/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
