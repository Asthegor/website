<?php
require_once('views/resumenavbar/resumenavbar.php');
?>
<h1>Expérience</h1>
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
        <label>Société</label>
        <select name="id_Company" required>
            <option value=""></option>
            <?php
            $cpym = new CompanyModel();
            $cpymlist = $cpym->getList();
            foreach ($cpymlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= $viewModel['id_Company'] == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Ville</label>
        <select name="id_City" required>
            <option value=""></option>
            <?php
            $citym = new CityModel();
            $citymlist = $citym->getList();
            foreach ($citymlist as $item)
            {
                ?>
                <option value="<?= $item['id']; ?>" <?= $viewModel['id_City'] == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="date_start" value="<?= isset($viewModel['date_start']) ? $viewModel['date_start'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Date de fin</label>
        <input type="date" name="date_end" value="<?= isset($viewModel['date_end']) ? $viewModel['date_end'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="6" cols="150" name="content_fr"><?= isset($viewModel['content_fr']) ? urldecode($viewModel['content_fr']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="6" cols="150" name="content_en"><?= isset($viewModel['content_en']) ? urldecode($viewModel['content_en']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>resume">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'resume/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
