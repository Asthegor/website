<?php
foreach ($viewModel as $link)
{
  ?>
  <div class="others">
    <a href="<?= $link['destination']; ?>" target="_blank">
        <h2><?= urldecode($link['title']); ?></h2>
        <p><?= urldecode($link['short_desc']); ?></p>
      </a>
    </div>
  <?php
}
?>