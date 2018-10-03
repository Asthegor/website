<div id="background1">
<img src="<?= ROOT_URL; ?>assets/images/backgrounds/background2.jpg"/>
</div>
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
