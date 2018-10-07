<?php
require_once('views/projectnavbar/projectnavbar.php');
?>
<h1>Projets</h1>
<p>Nombre de projets :
<?php
$prjm = new ProjectsModel();
echo $prjm->getNbProjects();
?>
</p>
<p>Nombre de projets affichés :
<?php 
echo $prjm->getNbActiveProjects();
?>
</p>
<h2><a href="<?= ROOT_MNGT.'projects/add'; ?>">Nouveau projet</a></h2>
<div class="navbar-index">
    <table style="width:100%; text-align: left;">
        <tr>
            <th style="width:5%;">Id</th>
            <th style="width:15%;">Titre</th>
            <th style="width:15%;">Framework/Engin</th>
            <th style="width:15%;">Date de création</th>
            <th style="width:15%;">Version</th>
            <th style="width:15%;">Visible</th>
            <th style="width:20%;"></th>
        </tr>
    </table>
    <?php
    foreach ($viewModel as $item)
    {
    ?>
        <div style="display: inline-block; width:100%">
            <a href="<?= ROOT_MNGT.'projects/update/'.$item['id']; ?>">
                <table style="width:80%;">
                    <tr>
                        <td style="width:5%;"><?= $item['id']; ?></td>
                        <td style="width:15%;"><?= urldecode($item['title']); ?></td>
                        <td style="width:15%;"><?= $item['framework']; ?></td>
                        <td style="width:15%;"><?= $item['first_date_project']; ?></td>
                        <td style="width:15%;"><?= $item['version']; ?></td>
                        <td style="width:15%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                </table>
            </a>
            <a style="width:20%;" href="<?= ROOT_MNGT.'devlog/add/'.$item['id']; ?>">Nouveau DevLog</a>
        </div>
    <?php
    }
    ?>
</div>
