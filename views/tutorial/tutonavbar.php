<div id="prev-next-bar">
  <?php
  if ($viewModel['id_Previous'])
  {
  ?>
    <a class="prev-next-item prev-item" href="<?= ROOT_URL.'tutorial/display/'.$viewModel['id_Previous']; ?>">Précédent</a>
    <?php
  }
  else
  {
    ?>
    <span class="prev-next-item prev-item-disable">Précédent</span>
    <?php
  }
  ?>
  <a class="prev-next-item proj-item-inline" href="<?= ROOT_URL.'tutorials'; ?>">Tutoriels</a>
  <?php
  if ($viewModel['id_Next'])
  {
    ?>
    <a class="prev-next-item next-item" href="<?= ROOT_URL.'tutorial/display/'.$viewModel['id_Next']; ?>">Suivant</a>
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
