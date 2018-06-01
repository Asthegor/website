<h1>Expérience</h1>
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
        <label>Titre français</label>
        <input type="text" name="title_fr" value="<?php echo isset($viewModel['title_fr']) ? $viewModel['title_fr'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Titre anglais</label>
        <input type="text" name="title_en" value="<?php echo isset($viewModel['title_en']) ? $viewModel['title_en'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Société</label>
        <select name="id_Company" required>
            <option value=""></option>
            <?php
            $cpym = new CompanyModel();
            $cpymlist = $cpym->getList();
            foreach ($cpymlist as $item)
            {
                ?>
                <option value="<?php echo $item['id']; ?>" <?php echo $viewModel['id_Company'] == $item['id'] ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Ville</label>
        <select name="id_City" required>
            <option value=""></option>
            <?php
            $citym = new CityModel();
            $citymlist = $citym->getList();
            foreach ($citymlist as $item)
            {
                ?>
                <option value="<?php echo $item['id']; ?>" <?php echo $viewModel['id_City'] == $item['id'] ? 'selected' : ''; ?>><?php echo $item['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Date de début</label>
        <input type="date" name="date_start" value="<?php echo isset($viewModel['date_start']) ? $viewModel['date_start'] : ''; ?>" required />
    </div>
    <div class="form-group">
        <label>Date de fin</label>
        <input type="date" name="date_end" value="<?php echo isset($viewModel['date_end']) ? $viewModel['date_end'] : ''; ?>" />
    </div>
    <div class="form-group">
        <label>Description française</label>
        <textarea rows="6" cols="150" name="content_fr"><?php echo isset($viewModel['content_fr']) ? $viewModel['content_fr'] : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Description anglaise</label>
        <textarea rows="6" cols="150" name="content_en"><?php echo isset($viewModel['content_en']) ? $viewModel['content_en'] : ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Visible</label>
        <input type="checkbox" name="bVisible" value="1" <?php echo isset($viewModel['bVisible']) && $viewModel['bVisible'] ? 'checked' : ''; ?> />
    </div>
    <input class="btn btn-primary" name="submit" type="submit" value="Submit" />
    <a class="btn btn-danger" href="<?php echo ROOT_MNGT; ?>resume">Cancel</a>
    <?php if (isset($viewModel['id']))
    {
        ?>
        <a class="btn btn-danger" href="<?php echo ROOT_MNGT.'resume/delete/'.$viewModel['id']; ?>">Delete</a><br>
        <?php
    }
    ?>
</form>
