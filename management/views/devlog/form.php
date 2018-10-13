<h1>DevLog</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php
    if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?= $viewModel['id']; ?>" readonly />
        </div>
        <?php
        $idProject = $viewModel['id_Project'];
    }
    else if (isset($_GET['id']))
    {
        $idProject = $_GET['id'];
    }
    else
    {
        $idProject = false;
    }
    ?>
    <div class="form-group">
        <label>Projet associé</label>
        <?php
        if($idProject)
        {
            ?>
            <input type="hidden" name="id_Project" value="<?= $viewModel['id_Project']; ?>" />
            <input type="text" name="project" value="<?= $viewModel['project']; ?>" readonly />
            <?php
        }
        else
        {
            ?>
            <select name="id_Project" required>
                <option value=""></option>
                <?php
                $pm = new ProjectsModel();
                $pmlist = $pm->getList();
                foreach ($pmlist as $item)
                {
                    ?>
                    <option value="<?= $item['id']; ?>" <?= $idProject == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        ?>
    </div>
    <div class="form-group">
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?= isset($viewModel['title_fr']) ? $viewModel['title_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) ? $viewModel['title_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="4" cols="150" name="description_fr" value="<?= isset($viewModel['description_fr']) ? $viewModel['description_fr'] : ''; ?>" required></textarea>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="4" cols="150" name="description_en" value="<?= isset($viewModel['description_en']) ? $viewModel['description_en'] : ''; ?>" required></textarea>
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="date_creation" value="<?= isset($viewModel['date_creation']) ? $viewModel['date_creation'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>devlog">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'devlog/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
