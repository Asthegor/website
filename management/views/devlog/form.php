<h1>DevLog</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php
    if (isset($viewModel['id']))
    {
        ?>
        <div class="form-group">
            <label>ID</label>
            <input type="text" name="id" value="<?php echo $viewModel['id']; ?>" readonly />
        </div>
        <?php
        $idProject = $viewModel['id_Project'];
    }
    else if (isset($_GET['id']))
    {
        $idProject = $_GET['id'];
    }
    else
    {
        $idProject = false;
    }
    ?>
    <div class="form-group">
        <label>Projet associé</label>
        <?php
        if($idProject)
        {
            ?>
            <input type="hidden" name="id_Project" value="<?php echo $viewModel['id_Project']; ?>" />
            <input type="text" name="project" value="<?php echo $viewModel['project']; ?>" readonly />
            <?php
        }
        else
        {
            ?>
            <select name="id_Project" required>
                <option value=""></option>
                <?php
                $pm = new ProjectsModel();
                $pmlist = $pm->getList();
                foreach ($pmlist as $item)
                {
                    ?>
                    <option value="<?php echo $item['id']; ?>" <?php echo $idProject == $item['id'] ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        ?>
    </div>
    <div class="form-group">
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?php echo isset($viewModel['title_fr']) ? $viewModel['title_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?php echo isset($viewModel['title_en']) ? $viewModel['title_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <input type="text" name="description_fr" value="<?php echo isset($viewModel['description_fr']) ? $viewModel['description_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <input type="text" name="description_en" value="<?php echo isset($viewModel['description_en']) ? $viewModel['description_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="date_creation" value="<?php echo isset($viewModel['date_creation']) ? $viewModel['date_creation'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?php echo isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?php echo ROOT_MNGT; ?>devlog">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?php echo ROOT_MNGT.'devlog/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
