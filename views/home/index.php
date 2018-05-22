<?php
foreach ($viewModel as $item)
{
    ?>
    <div class="summary">
        <a href="<?php echo ROOT_URL.$item['destination']; ?>">
            <h1><?php echo $item['title_'.strtolower($_SESSION['language'])]; ?></h1>
        </a>
    </div>
    <?php
}
?>
