<h1>Version</h1>
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
        <label>Project associé</label>
        <input type="hidden" name="id_Project" value="<?= $viewModel['id_Project']; ?>" />
        <input type="text" name="project" value="<?= $viewModel['project']; ?>" readonly />
    </div>
    <div class="form-group">
        <label>Numéro de version</label>
        <input type="text" name="num_version" value="<?= isset($viewModel['num_version']) ? $viewModel['num_version'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Date de la version</label>
        <input type="date" name="date_version" value="<?= isset($viewModel['date_version']) ? $viewModel['date_version'] : ''; ?>"/>
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?= ROOT_MNGT; ?>version">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'version/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
