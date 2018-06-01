<?php
foreach ($viewModel as $item)
{
    ?>
    <div class="summary">
        <a href="<?= ROOT_URL.$item['destination']; ?>">
            <h1><?= $item['title_'.strtolower($_SESSION['language'])]; ?></h1>
        </a>
    </div>
    <?php
}
?>
