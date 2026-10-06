<?php
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$lm = new LabelsModel();
$prevlbl = $lm->getLabelByRef('previous');
$nextlbl = $lm->getLabelByRef('next');
$prjlbl = $lm->getLabelByRef('projects');
$pm = new ProjectModel();
$previous_slug = $pm->GetPrevSlug($get['action']);
$next_slug = $pm->GetNextSlug($get['action']);
?>
<div id="prev-next-bar" style="text-align: center;">
  <?php
  if ($previous_slug <> '')
  {
  ?>
    <a class="prev-next-item prev-item" href="<?= ROOT_URL.'project/'.$previous_slug; ?>"><?= $prevlbl ?></a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item prev-item-disable"><?= $prevlbl ?></span>
    <?php
  }
  ?>
  <a class="prev-next-item proj-item-inline" href="<?= ROOT_URL.'projects'; ?>"><?= $prjlbl ?></a>
  <?php
  if ($next_slug <> '')
  {
    ?>
    <a class="prev-next-item next-item" href="<?= ROOT_URL.'project/'.$next_slug; ?>"><?= $nextlbl ?></a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item next-item-disable"><?= $nextlbl ?></span>
    <?php
  }
  ?>
</div>
