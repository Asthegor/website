<h1>Projets</h1>
<form enctype="multipart/form-data" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
        <label>Framework/Engin</label>
        <select name="framework" required>
            <option value=""></option>
            <?php
            $fm = new FrameworksModel();
            $fmlist = $fm->getList();
            foreach ($fmlist as $item)
            {
                ?>
                <option value="<?php echo $item['id']; ?>" <?php echo $viewModel['id_FrameworkEngine'] == $item['id'] ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Titre</label>
        <input type="text" name="title" value="<?php echo isset($viewModel['title']) ? $viewModel['title'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="6" cols="150" name="description_fr"  required><?php echo isset($viewModel['description_fr']) ? $viewModel['description_fr'] : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="6" cols="150" name="description_en"  required><?php echo isset($viewModel['description_en']) ? $viewModel['description_en'] : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="dateproject" value="<?php echo isset($viewModel['first_date_project']) ? $viewModel['first_date_project'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Numéro de version</label>
        <input type="text" name="num_version" value="<?php echo isset($viewModel['num_version']) ? $viewModel['num_version'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Date de la version</label>
        <input type="date" name="date_version" value="<?php echo isset($viewModel['date_version']) ? $viewModel['date_version'] : ''; ?>" />
    </div>
    <div class="form-group">
        <?php
        if (isset($viewModel['id']))
        {
            $project = new ProjectsModel();
            $image = $project->getImage($viewModel['id']);
            ?>
            <img src="data:image/jpeg;base64,<?php echo $image['img_blob']; ?>" alt="<?php echo $image['name']; ?>">
            <?php
        }
        else
        {
            ?>
            <label>Image</label>
            <?php
        }
        ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="255000" />
        <input type="file" name="projectimage" />
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?php echo isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?php echo ROOT_MNGT; ?>projects">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?php echo ROOT_MNGT.'projects/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
