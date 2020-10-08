<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Framework / Engin</h1>
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
        <label>Nom</label>
        <input type="text" name="name" value="<?= isset($viewModel['name']) ? $viewModel['name'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Langage de programmation</label>
        <select class="form-select" name="proglanguage" style="width: 60%;" required>
            <option value=""></option>
            <?php
            $plm = new ProgLanguageModel();
            $plmlist = $plm->getList();
            foreach ($plmlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= $viewModel['id_ProgLanguage'] == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= ROOT_MNGT; ?>proglanguage/add">Ajout</a>
    </div>
    <div class="form-group">
        <label>Ordre d'affichage</label>
        <input type="text" name="sortOrder" value="<?= isset($viewModel['sortOrder']) ? $viewModel['sortOrder'] : ''; ?>"/>
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>frameworks">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'frameworks/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
