<?php
if (!is_array($viewModel))
{
    returnToPage("home");
    return;
}
//include_once(__DIR__.'/tutonavbar.php')
?>
<div id="google_translate_element"></div>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'fr', layout: google.translate.TranslateElement.FloatPosition.TOP_RIGHT}, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<div class="tutorial">
    <h1><?= urldecode($viewModel['title']); ?></h1>
    <p>Créé le : <?= $viewModel['date_creation']; ?><br>Dernière mise à jour : <?= $viewModel['date_update']; ?></p>
    <br>
    <p><?= urldecode($viewModel['content']); ?></p>
  </div>
</div>
