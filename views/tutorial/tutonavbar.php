<?php
$lm = new LabelsModel();
$prevlbl = $lm->getLabelByRef('previous');
$nextlbl = $lm->getLabelByRef('next');
$tutolbl = $lm->getLabelByRef('tutorials');
?>
<div id="prev-next-bar" style="text-align: center;">
  <?php
  if ($viewModel['id_Previous'])
  {
  ?>
    <a class="prev-next-item prev-item" href="<?= ROOT_URL.'tutorial/display/'.$viewModel['id_Previous']; ?>"><?= $prevlbl ?></a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item prev-item-disable"><?= $prevlbl ?></span>
    <?php
  }
  ?>
  <a class="prev-next-item proj-item-inline" href="<?= ROOT_URL.'tutorials'; ?>"><?= $tutolbl ?></a>
  <?php
  if ($viewModel['id_Next'])
  {
    ?>
    <a class="prev-next-item next-item" href="<?= ROOT_URL.'tutorial/display/'.$viewModel['id_Next']; ?>"><?= $nextlbl ?></a>
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
