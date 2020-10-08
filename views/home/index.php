<div id="background1">
  <img src="<?= ROOT_URL; ?>assets/images/background_1404x750.jpg"/>
  <a href="<?= ROOT_URL.'views/language.php'; ?>" style="position: fixed;">
    <?php
    $lm = new LanguageModel();
    $lmres = $lm->getImage($_SESSION['language']);
    $imgsrc = 'data:image/jpeg;base64,'.base64_encode($lmres['image']);
    ?>
    <img src="<?= $imgsrc; ?>" alt="<?= $_SESSION['language']; ?>" width="32" height="24"/>
  </a>
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
    <a class="content" href="<?= urldecode($item['destination']); ?>">
        <div class="flip">  
            <div class="summary front">
                <h1><?= urldecode($item['title']); ?></h1>
            </div>
            <div class="summary back">
                <p><?= urldecode($item['short_desc']); ?></p>
            </div>
        </div>
    </a>
    <?php
}
?>

