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
    <div class="framework-summary">
      <button type="button" class="framework-btn"><h2><?php echo $framework['language'].' / '.$framework['framework']; ?></h2></button>
      <div class="projects-summary">
        <?php
        while ($project = mysqli_fetch_assoc($projects))
        {
        ?>
          <div class="project-summary">
            <?php $uniqueId = $project['id'].$project['name']; ?>
            <form id="<?php echo $uniqueId; ?>" action="project.php" method="GET">
              <input type="hidden" name="projectid" value="<?php echo $project['id']; ?>" />
            </form>
            <button type="button" onclick="document.getElementById('<?php echo $uniqueId; ?>').submit()">
              <?php
              if ($project['image'] != null)
              {
              ?>
                <image width="200" height="250" src="data:image/jpeg;base64,<?php echo base64_encode($project['image']); ?>" alt="<?php echo $project['name']; ?>"/>
              <?php
              }
              ?>
              <h4><?php echo $project['name']; ?></h4>
            </button>
          </div><!-- project-summary -->
        <?php
        }
        ?>
      </div><!-- projects-summary -->
    </div><!-- framework-summary -->
  <?php
  }
  ?>
</div>
<script>
var btnFramework = document.getElementsByClassName("framework-btn");
for (var i = 0; i < btnFramework.length; i++)
{
  btnFramework[i].addEventListener("click",
    function()
    {
      this.nextElementSibling.style.display = this.nextElementSibling.style.display === "block" ? "none" : "block";
      var btns = document.getElementsByClassName("framework-btn");
      for (var i = 0; i < btns.length; i++)
      {
        if (this !== btns[i])
        {
          btns[i].nextElementSibling.style.display = "none";
        }
      }
    });
}
</script>
<?php
include('views/footer.php');
?>
