<div id="background1">
<img src="<?= ROOT_URL; ?>assets/images/backgrounds/background2.jpg"/>
<h1 id="maintitle"><?= ConfigModel::getConfig('MAIN_TITLE_'.$_SESSION['language']); ?></h1>
</div>
<script>
$(function(){
    $(".flip").flip({
        trigger: 'hover'
    });
});
</script>
<?php
foreach ($viewModel as $item)
{
    ?>
    <a class="content" href="<?= ROOT_URL.$item['destination']; ?>">
        <div class="flip">  
            <div class="summary front">
                <h1><?= $item['title_'.strtolower($_SESSION['language'])]; ?></h1>
            </div>
            <div class="summary back">
                <p><?= urldecode($item['desc_'.strtolower($_SESSION['language'])]); ?></p>
            </div>
        </div>
    </a>
    <?php
}
?>

