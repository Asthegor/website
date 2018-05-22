<div id="prev-next-bar">
  <?php
  if ($viewModel['previous_id'])
  {
  ?>
    <a class="prev-next-item prev-item" href="<?php echo ROOT_URL.'project/display/'.$viewModel['previous_id']; ?>">Précédent</a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item prev-item-disable">Précédent</span>
    <?php
  }
  ?>
  <a class="prev-next-item proj-item-inline" href="<?php echo ROOT_URL.'projects'; ?>">Projets</a>
  <?php
  if ($viewModel['next_id'])
  {
    ?>
    <a class="prev-next-item next-item" href="<?php echo ROOT_URL.'project/display/'.$viewModel['next_id']; ?>">Suivant</a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item next-item-disable">Suivant</span>
    <?php
  }
  ?>
</div>
