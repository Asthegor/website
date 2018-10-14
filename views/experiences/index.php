<div id="accordion">
<?php
foreach ($viewModel as $experience)
{
    date_default_timezone_set('Europe/Paris');
    // Récupération du mois + année de date_start et date_end (si non vide)
    $datestart = new DateTime($experience['date_start']);
    $dateend = new DateTime();
    $bCurrent = false;
    if ($experience['date_end'])
    {
        $dateend = new DateTime($experience['date_end']);
        $bCurrent = true;
    }
    $interval = date_diff($datestart, $dateend);
    $duree = '';
    if ($interval->y) $duree .= $interval->y.($_SESSION['language'] == 'EN' ? ' years ' : ' ans ');
    if ($interval->m) $duree .= $interval->m.($_SESSION['language'] == 'EN' ? ' months' : ' mois');

    $title = $datestart->format('m-Y').' - ';
    $title .= (!$bCurrent ? 'XX-XXXX' : $dateend->format('m-Y'));
    $title .= ' ('.$duree.') : '.$experience['title'];
    ?>
    <h2><?= urldecode($title); ?></h2>
    <div>
        <h4><?= urldecode($experience['company'].' - '.$experience['city']); ?></h4>
        <p><?= urldecode($experience['content']); ?></p>
    </div>
    <?php
}
?>
</div>
<script>
$( "#accordion" ).accordion({collapsible: true});
$( "#accordion div" ).css("height","auto");
</script>