<?php
$progLang = "";
foreach ($viewModel as $tutorial)
{
    $currProgLang = $tutorial['ProgLanguage'];
    echo $progLang == $currProgLang ? '' : '<h2>'.$currProgLang.'</h2>';
    ?>
    <a class="tutorial-list" href="<?= ROOT_URL.'tutorial/display/'.$tutorial['id']; ?>">
        <h5><?= urldecode($tutorial['title']); ?></h5>
    </a>
    <p><?= urldecode($tutorial['short_desc']); ?></p>
    <?php
    echo $progLang == $currProgLang ? '' : '<hr>';
    $progLang = $currProgLang;
}
?>