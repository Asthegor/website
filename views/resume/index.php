<h2><?= $viewModelTitles[0]['title'] ?></h2>
<div id="accordionExp">
<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, $_SESSION['language'] == 'EN' ? "en_EN" : "fr_FR");
foreach ($viewModelExperience as $experience)
{
    // Récupération du mois + année de date_start et date_end (si non vide)
    $datestart = new DateTime($experience['date_start']);
    $dateend = new DateTime();
    $bCurrent = true;
    if ($experience['date_end'])
    {
        $dateend = new DateTime($experience['date_end']);
        $bCurrent = false;
    }
    $interval = date_diff($datestart, $dateend);
    $duree = '';
    if ($interval->y) $duree .= $interval->y.($_SESSION['language'] == 'EN' ? ' years ' : ' ans ');
    if ($interval->m) $duree .= $interval->m.($_SESSION['language'] == 'EN' ? ' months' : ' mois');
    $shortperiod = $datestart->format('m-Y').' - '.$dateend->format('m-Y');
    $period = ucwords (utf8_encode(strftime("%B %Y",$datestart->getTimestamp())).' - '.utf8_encode(strftime("%B %Y",$dateend->getTimestamp())));
    if ($bCurrent)
    {
        $shortperiod = ($_SESSION['language'] == 'EN' ? 'Actual position ' : 'Poste actuel ');
        $period = $shortperiod;
    }
    $title = $shortperiod.' ('.$duree.') : '.$experience['title'].' - '.urldecode($experience['company'].', '.$experience['city']);
    ?>
    <h2><?= urldecode($title); ?></h2>
    <div>
        <h2><?= urldecode($experience['title']); ?></h2>
        <h4><?= urldecode($experience['company'].' - '.$experience['city']); ?></h4>
        <h5><i><?= $period.' ('.$duree.')'; ?></i></h5>
        <p><?= urldecode($experience['content']); ?></p>
    </div>
    <?php
}
?>
</div>
<h2><?= $viewModelTitles[1]['title'] ?></h2>
<div id="accordionEducation">
<?php
foreach ($viewModelEducation as $education)
{
    // Récupération du mois + année de date_start et date_end (si non vide)
    $datestart = new DateTime($education['date_start']);
    $dateend = new DateTime();
    $bCurrent = true;
    if ($education['date_end'])
    {
        $dateend = new DateTime($education['date_end']);
        $bCurrent = false;
    }
    $shortperiod = $datestart->format('m-Y').' - '.$dateend->format('m-Y');
    $period = ucwords (utf8_encode(strftime("%B %Y",$datestart->getTimestamp())).' - '.utf8_encode(strftime("%B %Y",$dateend->getTimestamp())));
    if ($bCurrent)
    {
        $shortperiod = ($_SESSION['language'] == 'EN' ? 'Ongoing training ' : 'Formation en cours ');
        $period = $shortperiod;
    }
    $title = $shortperiod.' : '.urldecode($education['title']).' - '.$education['institution'];
    ?>
    <h2><?= urldecode($title); ?></h2>
    <div>
        <h4><?= urldecode($education['title']); ?></h4>
        <h5><i><?= $period; ?></i></h5>
        <p><?= urldecode($education['description']); ?></p>
        <a href="<?= urldecode($education['link_diploma']); ?>" target="_blank">
            <img height="100" width="150" src="<?= urldecode($education['link_diploma']); ?>" alt="<?= urldecode($title); ?>"/>
        </a>
    </div >
    <?php
}
?>
</div>

<script>
    $( "#accordionExp" ).accordion({active: true,collapsible: true});
    $( "#accordionExp div" ).css("height","auto");
    $( "#accordionEducation" ).accordion({active: true,collapsible: true});
    $( "#accordionEducation div" ).css("height","auto");
</script>