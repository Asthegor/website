<div id="accordion">
<?php
function get_days_for_previous_month($current_month, $current_year) {
  $previous_month = $current_month - 1;
  if($current_month == 1) {
    $current_year = $current_year - 1; //going from January to previous December
    $previous_month = 12;
  }
  if($previous_month == 11 || $previous_month == 9 || $previous_month == 6 || $previous_month == 4) {
    return 30;
  }
  else if($previous_month == 2) {
    if(($current_year % 4) == 0) { //remainder 0 for leap years
      return 29;
    }
    else {
      return 28;
    }
  }
  else {
    return 31;
  }
}
function get_interval($older, $newer) {
  $Y1 = $older->format('Y');
  $Y2 = $newer->format('Y');
  $Y = $Y2 - $Y1;

  $m1 = $older->format('m');
  $m2 = $newer->format('m');
  $m = $m2 - $m1;

  $d1 = $older->format('d');
  $d2 = $newer->format('d');
  $d = $d2 - $d1;

  $H1 = $older->format('H');
  $H2 = $newer->format('H');
  $H = $H2 - $H1;

  $i1 = $older->format('i');
  $i2 = $newer->format('i');
  $i = $i2 - $i1;

  $s1 = $older->format('s');
  $s2 = $newer->format('s');
  $s = $s2 - $s1;

  if($s < 0) {
    $i = $i -1;
    $s = $s + 60;
  }
  if($i < 0) {
    $H = $H - 1;
    $i = $i + 60;
  }
  if($H < 0) {
    $d = $d - 1;
    $H = $H + 24;
  }
  if($d < 0) {
    $m = $m - 1;
    $d = $d + get_days_for_previous_month($m2, $Y2);
  }
  if($m < 0) {
    $Y = $Y - 1;
    $m = $m + 12;
  }
  $d = mktime(0, 0, 0, $m, 1, $Y);
  return $d;
}

foreach ($viewModel as $experience)
{
    date_default_timezone_set('Europe/Paris');
    // Récupération du mois + année de date_start et date_end (si non vide)
    $datestart = new DateTime($experience['date_start']);
    $dateend = new DateTime();
    $bCurrent = true;
    if ($experience['date_end'])
    {
        $dateend = new DateTime($experience['date_end']);
        $dateend = 
        $bCurrent = false;
    }
    //$interval = date_diff($datestart, $dateend);
    $interval = get_interval($datestart, $dateend);
    $duree = '';
    if ($interval->y) $duree .= $interval->y.($_SESSION['language'] == 'EN' ? ' years ' : ' ans ');
    if ($interval->m) $duree .= $interval->m.($_SESSION['language'] == 'EN' ? ' months2' : ' mois2');

    $title = $datestart->format('m-Y').' - ';
    $title .= ($bCurrent ? 'XX-XXXX' : $dateend->format());
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