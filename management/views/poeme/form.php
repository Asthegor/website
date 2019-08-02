<h1>Poème</h1>
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
        <label>Titre</label>
        <input type="text" name="title" value="<?= isset($viewModel['title']) ? urldecode($viewModel['title']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Contenu</label>
        <textarea rows="6" cols="150" name="content"  required><?= isset($viewModel['content']) ? urldecode($viewModel['content']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Date de création</label>
        <input type="date" name="date_creation" value="<?= isset($viewModel['date_creation']) ? $viewModel['date_creation'] : ''; ?>" required />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>poeme">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'poeme/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
