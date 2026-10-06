<?php
$codeLangue = $_SESSION['language'] == 'EN' ? 'en_EN' : 'fr_FR';
$cvName = 'LACOMBE_Dominique_CV_'.$_SESSION['language'].'.pdf';
?>
<div class="resume-page">
    <div class="resume-download">
        <a class="btn btn-warning" href="download.php?file=<?= $cvName ?>" 
           style="background-color:orange;border-color:orange;">
            <?= $codeLangue == 'fr_FR' ? 'Télécharger mon CV' : 'Download my resume'; ?>
        </a>
    </div>

    <section>
        <h1 class="resume__identity"><?= $identity['lastname'] ?> <?= $identity['firstname'] ?></h1>
        <h2></h2>
    </section>

    <?= urldecode($profile['content']) ?>

    <section>
        <h2><?= $viewModelTitles[0]['title'] ?></h2>
        <?php
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, $codeLangue);
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
            $dateendsup = $dateend;
            $interval = date_diff($datestart, $dateend);
            if ($interval->d > 15) $interval->m = $interval->m + 1;
            if ($interval->m > 11)
            {
                $interval->y = $interval->y + 1;
                $interval->m = $interval->m - 12;
            }
            $duree = '';
            if ($interval->y) $duree .= $interval->y.($_SESSION['language'] == 'EN' ? ' years ' : ' ans ');
            if ($interval->m) $duree .= $interval->m.($_SESSION['language'] == 'EN' ? ' months' : ' mois');
            $shortperiod = $datestart->format('m-Y').' - '.$dateend->format('m-Y');
            $formatter = new IntlDateFormatter(
                $codeLangue,                    // 'fr_FR' ou 'en_EN'
                IntlDateFormatter::NONE,
                IntlDateFormatter::NONE,
                null,
                null,
                'MMMM yyyy'
                );
            
        
            $period = ucwords($formatter->format($datestart)) .' - ' . ucwords($formatter->format($dateend));;
            if ($bCurrent)
            {
                $shortperiod = ($_SESSION['language'] == 'EN' ? 'Actual position ' : 'Poste actuel ');
                $period = $shortperiod;
            }
            $title = ' ('.$duree.') : '.$experience['title'].' - '.urldecode($experience['company'].', '.$experience['city']);
            ?>
            <article class="resume-entry">
                <h3><?= urldecode($experience['title']); ?></h3>
                <h4><?= urldecode($experience['company'].' - '.$experience['city']); ?></h4>
                <h5><?= $period.' ('.$duree.')'; ?></h5>
                <?= cleanRichText(urldecode($experience['content'])); ?>
            </article>
            <?php
        }
        ?>
    </section> <!-- Section Expériences -->
    <section>
        <h2><?= $viewModelTitles[1]['title'] ?></h2>
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
        <article>
            <h4><?= urldecode($title); ?></h4>
            <!--<h4><?= "" //urldecode($education['title']); ?></h4>-->
            <h5><?= $period; ?></h5>
            <?= urldecode($education['description']); ?>
            <?php
            $diploma = urldecode($education['link_diploma']);
            if ($diploma <> "")
            {
                ?>
                <a href="<?= $diploma; ?>" target="_blank">
                <?php
                if (pathinfo($diploma, PATHINFO_EXTENSION) <> "pdf")
                {
                    ?>
                    <img height="100" width="150" src="<?= $diploma; ?>" alt="<?= urldecode($title); ?>"/>
                    <?php
                }
                else
                {
                    echo urldecode($diploma);
                }
                ?>
                </a>
                <?php
            }
            ?>
        </article>
        <?php
    }
    ?>
    </section> <!-- Section Scolarité -->
</div><!-- /.resume-page -->
<?php
function CleanRichText(string $html): string {
    // Supprime les <p> vides ou contenant uniquement &nbsp; / espaces
    $html = preg_replace('/<p>(\s|&nbsp;)*<\/p>/i', '', $html);
    // Supprime les <br> orphelins en fin de contenu
    $html = preg_replace('/(<br\s*\/?>\s*)+$/i', '', trim($html));
    return $html;
}
?>
