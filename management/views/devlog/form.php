<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>DevLog</h1>
<p><a href="<?= ROOT_MNGT; ?>images/add" target="_blank">Ajout d'images</a></p>
<br>
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
        $idProject = 0;
    }
    ?>
    <div class="form-group">
        <label>Projet associé</label>
        <select name="id_Project" required>
            <option value=""></option>
            <?php
            $pm = new ProjectsModel();
            $pmlist = $pm->getList("DESC");
            foreach ($pmlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= $idProject == $item['id'] ? 'selected' : ''; ?>><?= urldecode($item['title_fr']); ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="date_creation" value="<?= isset($viewModel['date_creation']) ? $viewModel['date_creation'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Durée de la session</label>
        <select name="session_hours" style="width:50px;">
            <?php
            $hours = date('H', strtotime(isset($viewModel['session_time']) ? $viewModel['session_time'] : 0));
            for($i = 0; $i < 24; $i++)
            {
                ?>
                <option value="<?= $i; ?>" <?= $i == $hours ? 'selected' : '' ?>><?= $i; ?></option>
                <?php
            }
            ?>
        </select>
        <select name="session_minutes" style="width:50px;">
            <?php
            $minutes = date('i', strtotime(isset($viewModel['session_time']) ? $viewModel['session_time'] : 0));
            for($i = 0; $i < 60; $i++)
            {
                ?>
                <option value="<?= $i; ?>" <?= $i == $minutes ? 'selected' : '' ?>><?= $i; ?></option>
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
        <label>Description française</label>
        <textarea class="noiframe" rows="10" cols="150" name="description_fr" required><?= isset($viewModel['description_fr']) ? urldecode($viewModel['description_fr']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?= isset($viewModel['title_en']) && $viewModel['title_en'] != $viewModel['title_fr'] ? urldecode($viewModel['title_en']) : ''; ?>"/>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea class="noiframe" rows="4" cols="150" name="description_en"><?= isset($viewModel['description_en']) && $viewModel['description_en'] != $viewModel['description_fr'] ? urldecode($viewModel['description_en']) : ''; ?></textarea>
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
