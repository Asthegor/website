<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Versions</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php
    $projectid = '';
    if (isset($_POST['projectid']))
    {
        $projectid = $_POST['projectid'];
    }
    ?>
    <select name="projectid">
        <option value="">Tous les projets</option>
        <?php
        $vm = new VersionModel();
        $vmlist = $vm->getProjectList();
        foreach ($vmlist as $item)
        {
            ?>
            <option value="<?= $item['id']; ?>" <?= $item['id'] == $projectid ? 'selected' : ''; ?>><?= urldecode($item['title']); ?></option>
            <?php
        }
        ?>
    </select>
    <input name="filter" type="submit" value="Filtrer" />
</form>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Projet associé</th>
            <th style="width:15%;">Numero de version</th>
            <th style="width:15%;">Date de la version</th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <a href="<?= ROOT_MNGT.'version/update/'.$item['id']; ?>">
            <table style="width:100%;">
                <tr>
                    <td style="width:5%;"><?= $item['id']; ?></td>
                    <td style="width:15%;"><?= urldecode($item['project']); ?></td>
                    <td style="width:15%;"><?= $item['num_version']; ?></td>
                    <td style="width:15%;"><?= $item['date_version']; ?></td>
                </tr>
            </table>
        </a>
    <?php
    }
    ?>
</div>
