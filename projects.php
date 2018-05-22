<?php
include('views/header.php');
?>
<div>
  <?php
  include('functions/prj_functions.php');
  $frameworks = get_AllFrameworks($prj_bdd);
  while ($framework = mysqli_fetch_assoc($frameworks))
  {
    $projects = get_ProjectsByFrameworkId($prj_bdd, $framework['frameworkid']);
    if(!$projects->num_rows) // pas de projets associés au framework
      continue;
    ?>
    <h2><?php echo $framework['proglanguage'].' / '.$framework['framework']; ?></h2>
    <?php
    while ($project = mysqli_fetch_assoc($projects))
    {
      ?>
      <div class="project-summary">
        <?php $uniqueId = $project['id'].$project['title']; ?>
        <form id="<?php echo $uniqueId; ?>" action="project.php" method="GET">
          <input type="hidden" name="projectid" value="<?php echo $project['id']; ?>" />
        </form>
        <button class="project-btn" onclick="document.getElementById('<?php echo $uniqueId; ?>').submit()">
            <img src="data:image/jpeg;base64,<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>"/>
          <h4><?php echo $project['title']; ?></h4>
        </button>
      </section><!-- project-summary -->
      <?php
    }
  }
  ?>
</div>
<?php
include('views/footer.php');
?>
