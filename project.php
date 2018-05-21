<?php
include('views/header.php');
?>
<?php
if (!isset($_GET['projectid']) && !is_numeric($_GET['projectid']))
{
  header('Location: index.php');
}
$projectid = intval($_GET['projectid']);
include('functions/prj_functions.php');
$previous = get_ProjectPreviousId($prj_bdd, $projectid);
$next = get_ProjectNextId($prj_bdd, $projectid);
?>
<div id="prev-next-bar">
  <?php
  if ($previous['id']) :
  ?>
    <a class="prev-next-item prev-item" href="?projectid=<?php echo $previous['id']; ?>">Précédent</a>
  <?php
  else :
  ?>
    <span class="prev-next-item prev-item-disable">Précédent</span>
  <?php
  endif;
  ?>
  <a class="prev-next-item proj-item-inline" href="projects.php">Projets</a>
  <?php
  if ($next['id']) :
  ?>
    <a class="prev-next-item next-item" href="?projectid=<?php echo $next['id']; ?>">Suivant</a>
  <?php
  else :
  ?>
    <span class="prev-next-item next-item-disable">Suivant</span>
  <?php
  endif;
  ?>
</div>
<div class="project">
  <?php
  $project = get_ProjectInfos($prj_bdd, $projectid);
  $title = $_SESSION['language'] == 'FR' ? $project['title_fr'] : $project['title_en'];
  ?>
  <div id="project-image">
    <image width="200" height="250" src="data:image/jpeg;base64,<?php echo $project['image']; ?>" alt="<?php echo $title; ?>"/>
  </div>
  <h1><?php echo $title; ?></h1>
  <div class="project-inline">
    <h2 class="project-inline-label">Framework / Engin :</h2>
    <h2><?php echo $project['framework'].'/'.$project['proglanguage']; ?></h2>
  </div>
  <?php $version = get_LastProjectVersion($prj_bdd, $projectid); ?>
  <div class="project-inline">
    <h4 class="project-inline-label">Version actuelle :</h4>
    <h4><?php echo $version['num_version'].' ('.$version['date_version'].')'; ?></h4>
  </div>
  <div class="project-inline">
    <h3 class="project-inline-label">Projet initié le :</h3>
    <h3><?php echo $project['first_date_project'] ? $project['first_date_project'] : 'Indéterminé'; ?></h3>
  </div>
  <h2 class="project-inline-label">Description :</h2>
  <p><?php echo $_SESSION['language'] == 'FR' ? $project['description_fr'] : $project['description_en']; ?></p>
</div>

<?php
include('views/footer.php');
?>