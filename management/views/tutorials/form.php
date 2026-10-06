<h1>Tutoriel</h1>
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
        <label>Titre</label>
        <input type="text" name="title" value="<?= isset($viewModel['title']) ? urldecode($viewModel['title']) : ''; ?>" required />
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
                <option value="<?= $item['id']; ?>" <?= isset($viewModel['id_ProgLanguage']) && $viewModel['id_ProgLanguage'] == $item['id'] ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
        <a href="<?= ROOT_MNGT; ?>proglanguage/add">Ajout</a>
    </div>
    <div class="form-group">
        <label>Description abrégée</label>
        <input type="text" name="short_desc" value="<?= isset($viewModel['short_desc']) ? urldecode($viewModel['short_desc']) : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Contenu</label>
        <textarea class="noiframe" rows="40" cols="150" name="content"  required><?= isset($viewModel['content']) ? urldecode($viewModel['content']) : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Tutoriel précédent</label>
        <input type="text" name="previous_tuto" value="<?= isset($viewModel['previous_tuto']) ? $viewModel['previous_tuto'] : ''; ?>"/>
    </div>
    <div class="form-group">
        <label>Tutoriel suivant</label>
        <input type="text" name="next_tuto" value="<?= isset($viewModel['next_tuto']) ? $viewModel['next_tuto'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de création</label>
        <input type="text" name="date_creation" value="<?= isset($viewModel['date_creation']) ? $viewModel['date_creation'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="text" name="bVisible" value="<?= isset($viewModel['bVisible']) ? $viewModel['bVisible'] : ''; ?>"/>
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-warning" href="<?= ROOT_MNGT; ?>tutorials">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?= ROOT_MNGT.'tutorials/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
<br>
