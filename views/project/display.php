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
  <div id="projet-desc">
    <h1><?= urldecode($viewModel['title']); ?></h1>
    <div class="project-inline">
      <h4 class="project-inline-label">Framework / Engin :</h4>
      <h4><?= urldecode($viewModel['framework']); ?></h4>
    </div>
    <?php //$version = get_LastProjectVersion($prj_bdd, $projectid); ?>
    <div class="project-inline">
      <p >Version actuelle :</p>
      <p><?php // echo $viewModel['version']; ?></p>
    </div>
    <div class="project-inline">
      <h4 class="project-inline-label">Projet initié le :</h4>
      <h4><?= !is_null($viewModel['first_date_project']) ? $viewModel['first_date_project'] : 'Indéterminé'; ?></h4>
    </div>
    <h4 class="project-inline-label">Description :</h4>
    <p><?= urldecode($_SESSION['language'] == 'EN' ? $viewModel['description_en'] : $viewModel['description_fr']); ?></p>
  </div>
</div>
