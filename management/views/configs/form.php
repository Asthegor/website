<h1>Données de configuration</h1>
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
        <label>Donnée</label>
        <input type="text" name="data" value="<?= isset($viewModel['data']) ? $viewModel['data'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Valeur</label>
        <input type="text" name="value" value="<?= isset($viewModel['value']) ? $viewModel['value'] : ''; ?>" required />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>configs">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'configs/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
