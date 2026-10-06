<h1>Labels</h1>
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
        <label>Référence</label>
        <input type="text" name="ref" value="<?= isset($viewModel['ref']) ? $viewModel['ref'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Texte français</label>
        <input type="text" name="value_fr" value="<?= isset($viewModel['value_fr']) ? $viewModel['value_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Texte anglais</label>
        <input type="text" name="value_en" value="<?= isset($viewModel['value_en']) ? $viewModel['value_en'] : ''; ?>" />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>configs">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'labels/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
