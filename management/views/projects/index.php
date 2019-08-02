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
  <table class="border" style="width:100%; text-align: center; border-collapse: collapse;">
    <tr class="border">
      <th class="border" style="width:4%;">Id</th>
      <th class="border" style="width:23%;">Titre français</th>
      <th class="border" style="width:23%;">Titre anglais</th>
      <th class="border" style="width:16%;">Framework</th>
      <th class="border" style="width:12%;">Date de création</th>
      <th class="border" style="width:12%;">Version</th>
      <th class="border" style="width:5%;">Visible</th>
      <th class="border" style="width:5%;"></th>
    </tr>
  </table>
  <?php
  foreach ($viewModel as $item)
  {
  ?>
    <div style="display: inline-block; width:100%">
      <a href="<?= ROOT_MNGT.'projects/update/'.$item['id']; ?>">
        <table class="border" style="width:100%; border-collapse: collapse;">
          <tr class="border">
            <td class="border" style="width:4%;"><?= $item['id']; ?></td>
            <td class="border" style="width:23%;"><?= urldecode($item['title_fr']); ?></td>
            <td class="border" style="width:23%;"><?= urldecode($item['title_en']); ?></td>
            <td class="border" style="width:16%;"><?= $item['framework']; ?></td>
            <td class="border" style="width:12%;"><?= $item['first_date_project']; ?></td>
            <td class="border" style="width:12%;"><?= $item['version']; ?></td>
            <td class="border" style="width:5%;"><?= $item['bVisible'] ? 'Oui' : 'Non'; ?></td>
            <td class="border" style="width:5%;">
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
