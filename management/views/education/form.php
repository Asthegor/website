<h1>Education</h1>
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
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
        <label>Institution (français)</label>
        <input type="text" name="institution_fr" value="<?= isset($viewModel['institution_fr']) ? urldecode($viewModel['institution_fr']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Institution (anglais)</label>
        <input type="text" name="institution_en" value="<?= isset($viewModel['institution_en']) ? urldecode($viewModel['institution_en']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="6" cols="150" name="description_fr"  required><?= isset($viewModel['description_fr']) ? urldecode($viewModel['description_fr']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="6" cols="150" name="description_en"  required><?= isset($viewModel['description_en']) ? urldecode($viewModel['description_en']) : ''; ?></textarea>
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
        <label>Lien vers le diplôme</label>
        <input type="text" name="link_diploma" value="<?= isset($viewModel['link_diploma']) ? urldecode($viewModel['link_diploma']) : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?= isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>education">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'education/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
