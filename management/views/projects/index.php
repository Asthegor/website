<?php
require_once('views/projectnavbar/projectnavbar.php');
$prjm = new ProjectsModel();
?>
<h1>Projets</h1>
<p>Nombre de projets : <?= $prjm->getNbProjects(); ?><br>
Nombre de projets affichés : <?= $prjm->getNbActiveProjects(); ?>
</p>
<h3><a href="<?= ROOT_MNGT.'projects/add'; ?>">Nouveau projet</a></h3>
<div class="navbar-index">
  <table style="width:100%; text-align: center; border-collapse: collapse;">
    <tr>
      <th style="width:04%;">Id</th>
      <th style="width:23%;">Titre français</th>
      <th style="width:23%;">Titre anglais</th>
      <th style="width:12%;">Framework</th>
      <th style="width:12%;">Date de création</th>
      <th style="width:12%;">Version</th>
      <th style="width:04%;">Nb vues</th>
      <th style="width:05%;">Visible</th>
      <th style="width:05%;"></th>
    </tr>
  </table>
  <?php
  foreach ($viewModel as $item)
  {
  ?>
    <div style="display: inline-block; width:100%">
      <a href="<?= ROOT_MNGT.'projects/update/'.$item['id']; ?>">
        <table style="width:100%; border-collapse: collapse;">
          <tr>
            <td style="width:04%;"><?= $item['id']; ?></td>
            <td style="width:23%;"><?= urldecode($item['title_fr']); ?></td>
            <td style="width:23%;"><?= urldecode($item['title_en']); ?></td>
            <td style="width:12%;"><?= $item['framework']; ?></td>
            <td style="width:12%;"><?= $item['first_date_project']; ?></td>
            <td style="width:12%;"><?= $item['version']; ?></td>
            <td style="width:04%;"><?= $item['nbViews']; ?></td>
            <td style="width:05%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
            <td style="width:05%;">
              <a href="<?= ROOT_MNGT.'devlog/add/'.$item['id']; ?>">
                <img src="<?= ROOT_URL.'assets/images/Log file.png' ?>" alt="Nouveau DevLog" width="24">
              </a>
            </td>
          </tr>
        </table>
      </a>
    </div>
  <?php
  }
  ?>
</div>
<br>
