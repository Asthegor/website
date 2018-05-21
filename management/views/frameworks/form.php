<h1>Framework / Engin</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?php echo $viewModel['id']; ?>" readonly />
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <label>Nom</label>
        <input type="text" name="name" value="<?php echo isset($viewModel['name']) ? $viewModel['name'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Langage de programmation</label>
        <select name="proglanguage" required>
            <option value=""></option>
            <?php
            $plm = new ProgLanguageModel();
            $plmlist = $plm->getList();
            foreach ($plmlist as $item)
            {
                ?>
                <option value="<?php echo $item['id']; ?>" <?php echo $viewModel['id_ProgLanguage'] == $item['id'] ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?php echo ROOT_MNGT; ?>proglanguage/add">Ajout</a>
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?php echo isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?php echo ROOT_MNGT; ?>frameworks">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?php echo ROOT_MNGT.'frameworks/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
