<h1>Pays</h1>
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
        <label>Nom français</label>
        <input type="text" name="name_fr" value="<?= isset($viewModel['name_fr']) ? $viewModel['name_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Nom anglais</label>
        <input type="text" name="name_en" value="<?= isset($viewModel['name_en']) ? $viewModel['name_en'] : ''; ?>" required />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>country">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'country/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
