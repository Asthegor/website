<?php
if (!isset($_GET['id']) && !is_numeric($_GET['id']))
{
  header('Location: '.ROOT_URL.'projects');
}
require('views/projnavbar.php')
?>
<div class="project">
  <div id="project-image">
    <image width="200" height="250" src="data:image/jpeg;base64,<?= $viewModel['img_blob']; ?>" alt="<?= urldecode($viewModel['title']); ?>"/>
  </div>
  <h1><?= urldecode($viewModel['title']); ?></h1>
  <div class="project-inline">
    <h2 class="project-inline-label">Framework / Engin :</h2>
    <h2><?= urldecode($viewModel['framework']); ?></h2>
  </div>
  <?php //$version = get_LastProjectVersion($prj_bdd, $projectid); ?>
  <div class="project-inline">
    <h4 class="project-inline-label">Version actuelle :</h4>
    <h4><?php // echo $viewModel['version']; ?></h4>
  </div>
  <div class="project-inline">
    <h3 class="project-inline-label">Projet initié le :</h3>
    <h3><?= !is_null($viewModel['first_date_project']) ? $viewModel['first_date_project'] : 'Indéterminé'; ?></h3>
  </div>
  <h2 class="project-inline-label">Description :</h2>
  <p><?= urldecode($_SESSION['language'] == 'EN' ? $viewModel['description_en'] : $viewModel['description_fr']); ?></p>
</div>
